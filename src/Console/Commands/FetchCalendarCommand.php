<?php

namespace NextDeveloper\Agenda\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use NextDeveloper\Agenda\Database\Models\Calendars;
use NextDeveloper\Agenda\Services\Clients\Google\Calendar;
use NextDeveloper\IAM\Database\Models\LoginMechanisms;
use NextDeveloper\IAM\Database\Scopes\AuthorizationScope;

class FetchCalendarCommand extends Command
{
    /**
     * The login mechanism for Google
     */
    private const GOOGLE_LOGIN = 'GoogleLogin';

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
        $query = $this->getLatestMechanismsQuery(self::GOOGLE_LOGIN);

        // Apply user filter if specified
        if ($userId = $this->option('user')) {
            $query->where('iam_user_id', $userId);
        }

        $mechanisms = $query->get();

        if ($mechanisms->isEmpty()) {
            $this->warn('No users found with valid Google login mechanisms');
            return 0;
        }

        $progressBar = $this->output->createProgressBar($mechanisms->count());
        $progressBar->start();

        $count = 0;
        foreach ($mechanisms as $mechanism) {
            try {
                if ($this->processUserCalendars($mechanism)) {
                    $count++;
                }
            } catch (Exception $e) {
                Log::warning('[Agenda::Console/Command::User calendar fetch failed]', [
                    'user_id' => $mechanism->iam_user_id,
                    'error' => $e->getMessage(),
                ]);

                $this->error("Failed to fetch calendar for user {$mechanism->iam_user_id}");
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();

        Log::info('[Agenda::Console/Command::Calendar fetch completed]', [
            'total_users' => $mechanisms->count(),
            'successful_fetches' => $count,
        ]);

        return $count;
    }

    /**
     * Get query for latest Google login mechanisms
     *
     * @param string $mechanism
     * @return Builder
     */
    private function getLatestMechanismsQuery(string $mechanism)
    {
        return LoginMechanisms::withoutGlobalScope(AuthorizationScope::class)
            ->whereIn('id', function ($query) use ($mechanism) {
                $query->select(\DB::raw('MAX(id)'))
                    ->from('iam_login_mechanisms')
                    ->where('login_mechanism', $mechanism)
                    ->where('is_latest', true)
                    ->groupBy('iam_user_id');
            });
    }

    /**
     * Process calendars for a single user
     *
     * @param LoginMechanisms $mechanism
     * @return bool
     * @throws Exception
     */
    private function processUserCalendars(LoginMechanisms $mechanism): bool
    {
        $userScopes = $mechanism->login_data['scopes'] ?? [];
        $requiredScopes = config('agenda.google-scopes.calendar');

        // Check if user has any of the required calendar scopes
        $hasRequiredScopes = !empty(array_intersect($userScopes, $requiredScopes));

        if (!$hasRequiredScopes) {
            Log::info('[Agenda::Console/Command::Skipping user - missing required scope]', [
                'user_id'           => $mechanism->iam_user_id,
                'user_scopes'       => $userScopes,
                'required_scopes'   => $requiredScopes,
            ]);
            return false;
        }

        try {
            $service = new Calendar($mechanism->login_data['token']);
            $calendars = $service->getCalendars();

            if (empty($calendars)) {
                Log::info('[Agenda::Console/Command::No calendars found for user]', [
                    'user_id' => $mechanism->iam_user_id
                ]);
                return true; // Successfully processed, but no calendars found
            }

            foreach ($calendars as $calendarData) {
                $this->updateOrCreateCalendar($mechanism->iam_user_id, $calendarData);
            }

            Log::info('[Agenda::Console/Command::Calendars processed successfully]', [
                'user_id' => $mechanism->iam_user_id,
                'calendar_count' => count($calendars)
            ]);

            return true;
        } catch (Exception $e) {
            throw new Exception(
                "Failed to fetch calendar for user {$mechanism->iam_user_id}: {$e->getMessage()}",
                0,
                $e
            );
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