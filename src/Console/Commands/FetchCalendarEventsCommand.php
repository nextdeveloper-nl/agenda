<?php

namespace NextDeveloper\Agenda\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use NextDeveloper\Agenda\Database\Models\AddressBooks;
use NextDeveloper\Agenda\Database\Models\CalendarEvents;
use NextDeveloper\Agenda\Database\Models\CalendarEventAttendees;
use NextDeveloper\Agenda\Database\Models\Calendars;
use NextDeveloper\Agenda\Database\Models\Contacts;
use NextDeveloper\Agenda\Services\AddressBooksService;
use NextDeveloper\Agenda\Services\CalendarEventAttendeesService;
use NextDeveloper\Agenda\Services\CalendarEventsService;
use NextDeveloper\Agenda\Services\CalendarsService;
use NextDeveloper\Agenda\Services\Clients\Google\Calendar;
use NextDeveloper\Agenda\Services\ContactsService;
use NextDeveloper\Commons\Database\Models\ExternalServices;
use NextDeveloper\Commons\Exceptions\NotAllowedException;
use NextDeveloper\Commons\Helpers\GoogleWorkspaceHelper;
use NextDeveloper\Commons\Helpers\StateHelper;
use NextDeveloper\IAM\Database\Models\LoginMechanisms;
use NextDeveloper\IAM\Database\Scopes\AuthorizationScope;
use NextDeveloper\IAM\Helpers\UserHelper;

class FetchCalendarEventsCommand extends Command
{
    /**
     * The login mechanism for Google
     */
    private const SERVICE_IDS = ['google_calendar'];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'agenda:fetch-calendar-events {--user= : Specific user ID to fetch events for}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches all events for all calendars';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->info('Starting calendar events fetch process...');

        $this->fetchGoogleCalendarEvents();

        $this->info("Successfully processed events from all calendars");

    }

    /**
     * Fetch events for all calendars
     *
     * @return void
     * @throws Exception
     */
    private function fetchGoogleCalendarEvents(): void
    {
        $calendars = Calendars::withoutGlobalScopes()
            ->where('source', 'Google')
            ->where('sync_enabled', true);

        // Apply user filter if specified (used by the on-demand Workspace sync)
        if ($userId = $this->option('user')) {
            $calendars->where('iam_user_id', $userId);
        }

        $calendars = $calendars->get();

        if ($calendars->isEmpty()) {
            $this->warn('No calendars found');
            return;
        }

        $progressBar = $this->output->createProgressBar($calendars->count());
        $progressBar->start();


        foreach ($calendars as $calendar) {
            $this->processCalendarEvents($calendar);
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();

        Log::info('[Agenda::Console/Command::Calendar events fetch completed]');

    }

    /**
     * Process events for a single calendar
     *
     * @param Calendars $calendar
     * @return void
     * @throws Exception
     */
    private function processCalendarEvents(Calendars $calendar): void
    {
        // Get user's login mechanism
        // Workspace connections count only when they were granted calendar.readonly.
        $externalService = ExternalServices::query()
            ->withoutGlobalScope(AuthorizationScope::class)
            ->where('iam_user_id', $calendar->iam_user_id)
            ->whereIn('code', array_merge(self::SERVICE_IDS, [GoogleWorkspaceHelper::CODE]))
            ->where('is_alive', true)
            ->get()
            ->filter(fn (ExternalServices $service) => $service->code !== GoogleWorkspaceHelper::CODE
                || GoogleWorkspaceHelper::hasScope($service, GoogleWorkspaceHelper::SCOPE_CALENDAR_READONLY))
            // Workspace connections first: the legacy google_calendar rows hold old tokens that Google often rejects
            ->sortBy(fn (ExternalServices $service) => $service->code === GoogleWorkspaceHelper::CODE ? 0 : 1)
            ->first();

        if (!$externalService) {
            Log::info('[Agenda::Console/Command::Skipping calendar - no valid service found]', [
                'calendar_id' => $calendar->id,
                'iam_user_id' => $calendar->iam_user_id,
            ]);
            return;
        }

        UserHelper::setUserById($externalService->iam_user_id);
        UserHelper::setCurrentAccountById($externalService->iam_account_id);

        try {
            if ($externalService->code === GoogleWorkspaceHelper::CODE) {
                // Workspace tokens are refreshed and persisted by the helper (the client-side refresh is not saved).
                $token = GoogleWorkspaceHelper::freshEncryptedToken($externalService);

                if (!$token) {
                    throw new Exception('Unable to refresh the Google Workspace token');
                }

                $service = new Calendar($token);
            } else {
                $service = new Calendar($externalService->token);

                if ($service->isTokenExpired()) {
                    $service->refreshToken($externalService->refresh_token);
                }
            }

            // Get calendar start date for syncing
            $startDateTime = $calendar->sync_start_date ? Carbon::parse($calendar->sync_start_date) : now()->subMonth();

            // If calendar was last synced after the start date, use the last sync date.
            // Only when a sync has happened: Carbon::lt(null) compares against "now", which made the first sync
            // start from now and skip the whole past window.
            if ($calendar->last_sync_at && $startDateTime->lt($calendar->last_sync_at)) {
                $startDateTime = $calendar->last_sync_at;
            }

            $events = $service->getEvents($calendar->calendar_key, [
                'singleEvents' => true,
                'orderBy' => 'startTime',
                'timeMin' => Carbon::parse($startDateTime)->format('c'),
                'timeMax' => now()->addYears(10)->format('c'),
            ]);

            if (empty($events)) {
                Log::info('[Agenda::Console/Command::No events found for calendar]', [
                    'agenda_calendar_id' => $calendar->id,
                    'iam_user_id' => $calendar->iam_user_id,
                ]);

                StateHelper::setState(
                    $calendar,
                    'connection',
                    'No events found for this calendar',
                    StateHelper::STATE_WARNING
                );

                GoogleWorkspaceHelper::clearUnauthorized($externalService);

                return; // Successfully processed, but no events found
            }

            foreach ($events as $eventData) {
                $this->updateOrCreateEvent($calendar, $eventData);
            }

            Log::info('[Agenda::Console/Command::Events processed successfully]', [
                'agenda_calendar_id' => $calendar->id,
                'iam_user_id' => $calendar->iam_user_id,
                'event_count' => count($events),
            ]);

            StateHelper::setState(
                $calendar,
                'connection',
                'Events fetched successfully',
                StateHelper::STATE_SUCCESS
            );

            // The token worked, so a previous 401 flag no longer applies
            GoogleWorkspaceHelper::clearUnauthorized($externalService);

            return;

        } catch (Exception $e) {
            // Google rejected the token (HTTP 401): flag the connection so the panel shows 'reconnect'
            // (401 invalid token, 403 access/scope no longer granted); other errors are treated as transient
            if ((in_array($e->getCode(), [401, 403], true) || preg_match('/"code":\s*(401|403)/', $e->getMessage()))
            // not when our own Google project is the problem (API disabled, quota): reconnecting cannot fix that
            && !preg_match('/accessNotConfigured|SERVICE_DISABLED|has not been used|rateLimitExceeded|quotaExceeded|userRateLimitExceeded/i', $e->getMessage())) {
                GoogleWorkspaceHelper::flagUnauthorized($externalService, 'calendar');
            }

            Log::error('[Agenda::Console/Command::Events fetch failed]', [
                'agenda_calendar_id' => $calendar->id,
                'iam_user_id' => $calendar->iam_user_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            StateHelper::setState(
                $calendar,
                'connection',
                'Failed to fetch events',
                StateHelper::STATE_ERROR,
                $e->getMessage()
            );
        }
    }

    /**
     * Update or create an event
     *
     * @param Calendars $calendar
     * @param array $eventData
     * @return void
     * @throws NotAllowedException
     * @throws Exception
     */
    private function updateOrCreateEvent(Calendars $calendar, array $eventData): void
    {
        $eventData = array_merge($eventData, [
            'agenda_calendar_id'    => $calendar->id,
            'iam_user_id'           => $calendar->iam_user_id,
        ]);

        $calendarEvent = CalendarEvents::withoutGlobalScopes()
            ->where('agenda_calendar_id', $calendar->id)
            ->where('external_event_id', $eventData['external_event_id'])
            ->first();

        if (!$calendarEvent) {
            $calendarEvent = CalendarEventsService::create($eventData);
        } else {
            CalendarEventsService::update($calendarEvent->uuid, $eventData);
        }

        $this->updateOrCreateEventAttendees($calendarEvent, $eventData['attendees']);

        $this->updateOrCreateCalendarContact($calendar->iam_user_id, $eventData['attendees']);

        CalendarsService::update($calendar->uuid, [
            'last_sync_status'  => 'success',
            'last_sync_at'      => now(),
        ]);
    }

    /**
     * Update or create event attendees
     *
     * @param CalendarEvents $calendarEvent
     * @param array $attendees
     * @return void
     * @throws NotAllowedException
     * @throws Exception
     */
    private function updateOrCreateEventAttendees(CalendarEvents $calendarEvent, array $attendees): void
    {
        foreach ($attendees as $attendee) {
            $attendeeData = array_merge($attendee, [
                'agenda_calendar_event_id' => $calendarEvent->id,
            ]);

            $attendeeModel = CalendarEventAttendees::withoutGlobalScopes()
                ->where('email', $attendee['email'])
                ->where('agenda_calendar_event_id', $calendarEvent->id)
                ->first();

            if (!$attendeeModel) {
                CalendarEventAttendeesService::create($attendeeData);
            } else {
                CalendarEventAttendeesService::update($attendeeModel->uuid, $attendeeData);
            }
        }
    }

    /**
     * Update or create a calendar contact
     *
     * @param string $iam_user_id
     * @param array $attendees
     * @return void
     * @throws Exception
     */
    private function updateOrCreateCalendarContact(string $iam_user_id, array $attendees): void
    {

        $addressBook = AddressBooks::withoutGlobalScopes()
            ->where('iam_user_id', $iam_user_id)
            ->where('name', 'Global Address Book')
            ->first();

        if (!$addressBook) {
            $addressBook = AddressBooksService::create([
                'name' => 'Global Address Book',
            ]);
        }

        foreach ($attendees as $attendee) {

            $calendarContact = Contacts::withoutGlobalScopes()
                ->where('email', $attendee['email'])
                ->where('iam_user_id', $iam_user_id)
                ->first();

            $data = [
                'email'                     => $attendee['email'],
                'name'                      => $attendee['name'],
                'agenda_address_book_id'    => $addressBook->id,
            ];

            if (!$calendarContact) {
                ContactsService::create($data);
            }else {
                ContactsService::update($calendarContact->uuid, $data);
            }
        }

    }
}