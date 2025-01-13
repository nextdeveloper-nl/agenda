<?php

namespace NextDeveloper\Agenda\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use NextDeveloper\Agenda\Database\Models\CalendarEvents;
use NextDeveloper\Agenda\Database\Models\CalendarEventAttendees;
use NextDeveloper\Agenda\Database\Models\Calendars;
use NextDeveloper\Agenda\Services\Clients\Google\Calendar;
use NextDeveloper\Commons\Database\Models\ExternalServices;
use NextDeveloper\IAM\Database\Models\LoginMechanisms;
use NextDeveloper\IAM\Database\Scopes\AuthorizationScope;

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
     * @return int
     */
    public function handle(): int
    {
        try {
            $this->info('Starting calendar events fetch process...');

            $count = $this->fetchGoogleCalendarEvents();

            $this->info("Successfully processed events from {$count} calendars");
            return 0;

        } catch (Exception $e) {
            $this->error("Calendar events fetch failed: {$e->getMessage()}");
            Log::error('[Agenda::Console/Command::Calendar events fetch failed]', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return 1;
        }
    }

    /**
     * Fetch events for all calendars
     *
     * @return int
     */
    private function fetchGoogleCalendarEvents(): int
    {
        $calendars = Calendars::withoutGlobalScopes()
            ->where('source', 'Google')
            ->where('sync_enabled', true)
            ->get();

        if ($calendars->isEmpty()) {
            $this->warn('No calendars found');
            return 0;
        }

        $progressBar = $this->output->createProgressBar($calendars->count());
        $progressBar->start();

        $count = 0;
        foreach ($calendars as $calendar) {
            try {
                if ($this->processCalendarEvents($calendar)) {
                    $count++;
                }
            } catch (Exception $e) {
                Log::warning('[Agenda::Console/Command::Calendar events fetch failed]', [
                    'calendar_id' => $calendar->id,
                    'user_id' => $calendar->iam_user_id,
                    'error' => $e->getMessage(),
                ]);

                $this->error("Failed to fetch events for calendar {$calendar->id}");
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();

        Log::info('[Agenda::Console/Command::Calendar events fetch completed]', [
            'total_calendars' => $calendars->count(),
            'successful_fetches' => $count,
        ]);

        return $count;
    }

    /**
     * Process events for a single calendar
     *
     * @param Calendars $calendar
     * @return bool
     * @throws Exception
     */
    private function processCalendarEvents(Calendars $calendar): bool
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
            return false;
        }

        try {
            $service = new Calendar($externalService->token);

            $events = $service->getEvents($calendar->calendar_key, [
                'singleEvents' => true,
                'orderBy' => 'startTime',
                'timeMin' => now()->subMonth()->format('c'), // ISO 8601 = Y-m-d\TH:i:sP
                'timeMax' => now()->addYear()->format('c'),
            ]);

            if (empty($events)) {
                Log::info('[Agenda::Console/Command::No events found for calendar]', [
                    'agenda_calendar_id' => $calendar->id,
                    'iam_user_id' => $calendar->iam_user_id,
                ]);
                return true; // Successfully processed, but no events found
            }

            foreach ($events as $eventData) {
                $this->updateOrCreateEvent($calendar, $eventData);
            }

            Log::info('[Agenda::Console/Command::Events processed successfully]', [
                'agenda_calendar_id' => $calendar->id,
                'iam_user_id' => $calendar->iam_user_id,
                'event_count' => count($events),
            ]);

            return true;

        } catch (Exception $e) {
            throw new Exception(
                "Failed to fetch events for calendar {$calendar->id}: {$e}",
                0,
                $e
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