<?php

namespace NextDeveloper\Agenda\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use NextDeveloper\Agenda\Database\Models\Calendars;
use NextDeveloper\Agenda\Services\Clients\Google\Calendar;
use NextDeveloper\Commons\Database\Models\ExternalServices;
use NextDeveloper\IAM\Database\Models\LoginMechanisms;
use NextDeveloper\IAM\Database\Scopes\AuthorizationScope;

class FetchCalendarsCommand extends Command
{

    private const SERVICE_IDS = ['google_calendar'];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'agenda:fetch-calendars {--user= : Specific user ID to fetch calendars for}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches Google calendars for users with valid Google login mechanisms';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        try {
            $this->info('Starting calendar fetch process...');

            $count = $this->fetchGoogleCalendars();

            $this->info("Successfully processed calendars for {$count} users");
            return 0;
        } catch (Exception $e) {
            $this->error("Calendar fetch failed: {$e->getMessage()}");
            Log::error('[Agenda::Console/Command::Calendar fetch failed]', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return 1;
        }
    }

    /**
     * Fetch Google calendars for users
     *
     * @return int Number of users processed
     */
    private function fetchGoogleCalendars(): int
    {
        $query = ExternalServices::query()
            ->withoutGlobalScopes()
            ->whereIn('code', self::SERVICE_IDS);

        // Apply user filter if specified
        if ($userId = $this->option('user')) {
            $query->where('iam_user_id', $userId);
        }

        $services = $query->get();

        if ($services->isEmpty()) {
            $this->warn('No users found with valid Google login mechanisms');
            return 0;
        }

        $progressBar = $this->output->createProgressBar($services->count());
        $progressBar->start();

        $count = 0;
        foreach ($services as $service) {
            try {
                if ($this->processUserCalendars($service)) {
                    $count++;
                }
            } catch (Exception $e) {
                Log::warning('[Agenda::Console/Command::User calendar fetch failed]', [
                    'id' => $service->id,
                    'error' => $e->getMessage(),
                ]);

                $this->error("Failed to fetch calendar for service ID {$service->id}: {$e->getMessage()}");
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();

        Log::info('[Agenda::Console/Command::Calendar fetch completed]', [
            'total_services' => $services->count(),
            'successful_fetches' => $count,
        ]);

        return $count;
    }

    /**
     * Process calendars for a single user
     *
     * @param ExternalServices $externalService
     * @return bool
     * @throws Exception
     */
    private function processUserCalendars(ExternalServices $externalService): bool
    {

        try {
            $service = new Calendar($externalService->token);
            $calendars = $service->getCalendars();

            if (empty($calendars)) {
                Log::info('[Agenda::Console/Command::No calendars found for service]', [
                    'service_id' => $externalService->id,
                ]);
                return true; // Successfully processed, but no calendars found
            }

            foreach ($calendars as $calendarData) {
                $this->updateOrCreateCalendar($externalService->iam_user_id, $calendarData);
            }

            Log::info('[Agenda::Console/Command::Calendars processed successfully]', [
                'user_id' => $externalService->iam_user_id,
                'calendar_count' => count($calendars)
            ]);

            return true;
        } catch (Exception $e) {
            throw new Exception("Failed to fetch calendar : {$e->getMessage()}",);
        }
    }

    /**
     * Update or create a calendar entry
     *
     * @param string $userId
     * @param array $calendarData
     * @return void
     */
    private function updateOrCreateCalendar(string $userId, array $calendarData): void
    {
        $calendarData = array_merge($calendarData, [
            'source'        => 'Google',
            'object_type'   => 'NextDeveloper\IAM\Database\Models\Users',
            'object_id'     => $userId,
            'iam_user_id'   => $userId,
        ]);

        $calendar = Calendars::withoutGlobalScopes()
            ->where('iam_user_id', $userId)
            ->where('calendar_key', $calendarData['calendar_key'])
            ->first();

        if (!$calendar) {
            Calendars::forceCreateQuietly($calendarData);
        } else {
            $calendar->updateQuietly($calendarData);
        }
    }
}