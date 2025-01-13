<?php

namespace NextDeveloper\Agenda\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use NextDeveloper\Agenda\Database\Models\CalendarEvents;
use NextDeveloper\Agenda\Database\Models\CalendarEventAttendees;
use NextDeveloper\Agenda\Database\Models\Calendars;
use NextDeveloper\Agenda\Services\Clients\Google\Calendar;
use NextDeveloper\Commons\Database\Models\ExternalServices;
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
    protected $signature = 'agenda:fetch-calendar-events';

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
            ->where('sync_enabled', true)
            ->get();

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
        $externalService = ExternalServices::query()
            ->withoutGlobalScope(AuthorizationScope::class)
            ->where('iam_user_id', $calendar->iam_user_id)
            ->whereIn('code', self::SERVICE_IDS)
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
            $service = new Calendar($externalService->token);

            if ($service->isTokenExpired()) {
                $service->refreshToken($externalService->refresh_token);
            }

            // Get calendar start date for syncing
            $startDateTime = $calendar->sync_start_date ? Carbon::parse($calendar->sync_start_date) : now();

            // If calendar was last synced after the start date, use the last sync date
            if ($startDateTime->lt($calendar->last_sync_at)) {
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

            return;

        } catch (Exception $e) {
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
            $calendarEvent = CalendarEvents::forceCreateQuietly([
                'agenda_calendar_id'    => $calendar->id,
                'external_event_id'     => $eventData['external_event_id'],
                'title'                 => $eventData['title'],
                'description'           => $eventData['description'],
                'location'              => $eventData['location'],
                'starts_at'             => $eventData['starts_at'],
                'ends_at'               => $eventData['ends_at'],
                'timezone'              => $eventData['timezone'],
                'is_all_day'            => $eventData['is_all_day'],
                'status'                => $eventData['status'],
                'meeting_link'          => $eventData['meeting_link'],
                'data'                  => $eventData['data'],
            ]);
        } else {
            $calendarEvent->updateQuietly($eventData);
        }

        $this->updateOrCreateEventAttendees($calendarEvent, $eventData['attendees']);

        $calendar->updateQuietly([
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
                CalendarEventAttendees::forceCreateQuietly($attendeeData);
            } else {
                $attendeeModel->updateQuietly($attendeeData);
            }
        }
    }
}