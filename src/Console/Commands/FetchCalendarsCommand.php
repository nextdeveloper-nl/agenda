<?php

namespace NextDeveloper\Agenda\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use NextDeveloper\Agenda\Database\Models\Calendars;
use NextDeveloper\Agenda\Services\CalendarsService;
use NextDeveloper\Agenda\Services\Clients\Google\Calendar;
use NextDeveloper\Commons\Database\Models\ExternalServices;
use NextDeveloper\Commons\Exceptions\NotAllowedException;
use NextDeveloper\Commons\Helpers\GoogleWorkspaceHelper;
use NextDeveloper\Commons\Helpers\StateHelper;
use NextDeveloper\IAM\Database\Models\LoginMechanisms;
use NextDeveloper\IAM\Database\Scopes\AuthorizationScope;
use NextDeveloper\IAM\Helpers\UserHelper;

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
     * @return void
     * @throws Exception
     */
    public function handle(): void
    {
        $this->info('Starting calendar fetch process...');

        $this->fetchGoogleCalendars();

        $this->info("Successfully processed calendars fetched");
    }

    /**
     * Fetch Google calendars for users
     *
     * @return void Number of users processed
     * @throws Exception
     */
    private function fetchGoogleCalendars()
    {
        $query = ExternalServices::query()
            ->withoutGlobalScopes()
            ->whereIn('code', array_merge(self::SERVICE_IDS, [GoogleWorkspaceHelper::CODE]))
            ->where('is_alive', true)
            ->whereNull('deleted_at');

        // Apply user filter if specified
        if ($userId = $this->option('user')) {
            $query->where('iam_user_id', $userId);
        }

        // Also pick up Workspace connections (code 'google_workspace') that were granted calendar.readonly.
        // google_workspace rows are filtered by granted scope; legacy google_calendar rows are kept as they were.
        $services = $query->get()->filter(function (ExternalServices $service) {
            return $service->code !== GoogleWorkspaceHelper::CODE
                || GoogleWorkspaceHelper::hasScope($service, GoogleWorkspaceHelper::SCOPE_CALENDAR_READONLY);
        })->values();

        if ($services->isEmpty()) {
            $this->warn('No users found with valid Google login mechanisms');
            return;
        }

        $progressBar = $this->output->createProgressBar($services->count());
        $progressBar->start();

        foreach ($services as $service) {
           $this->processUserCalendars($service);
           $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();

        Log::info('[Agenda::Console/Command::Calendar fetch completed]');
    }

    /**
     * Process calendars for a single user
     *
     * @param ExternalServices $externalService
     * @return void
     * @throws Exception
     */
    private function processUserCalendars(ExternalServices $externalService): void
    {

        try {

            UserHelper::setUserById($externalService->iam_user_id);
            UserHelper::setCurrentAccountById($externalService->iam_account_id);

            if ($externalService->code === GoogleWorkspaceHelper::CODE) {
                // Workspace tokens are refreshed and persisted by the helper (the client-side refresh is not saved).
                $token = GoogleWorkspaceHelper::freshEncryptedToken($externalService);

                if (!$token) {
                    StateHelper::setState(
                        $externalService,
                        'connection',
                        'Unable to refresh the Google token. Please reconnect your account.',
                        StateHelper::STATE_ERROR
                    );
                    return;
                }

                $service = new Calendar($token);
            } else {
                $service = new Calendar($externalService->token);

                if ($service->isTokenExpired()) {
                    $service->refreshToken($externalService->refresh_token);
                }
            }

            $calendars = $service->getCalendars();

            if (empty($calendars)) {

                StateHelper::setState(
                    $externalService,
                    'connection',
                    'No calendars found, please create a calendar first',
                    StateHelper::STATE_ERROR
                );

                return;
            }

            foreach ($calendars as $calendarData) {
                $this->updateOrCreateCalendar($externalService->iam_account_id, $calendarData, $externalService->configuration['calendar_sync_months_back'] ?? null);
            }

            StateHelper::setState(
                $externalService,
                'connection',
                'Calendars fetched successfully',
                StateHelper::STATE_SUCCESS
            );
        } catch (Exception $e) {
            // Google rejected the token (401) or access (403): flag the connection and email the owner once;
            // other errors are treated as transient
            if (in_array($e->getCode(), [401, 403], true) || preg_match('/"code":\s*(401|403)/', $e->getMessage())) {
                GoogleWorkspaceHelper::flagUnauthorized($externalService, 'calendar');
            }

            if ($e->getMessage()) {
                $error = json_decode($e->getMessage());
                if (json_last_error() === JSON_ERROR_NONE) {
                    StateHelper::setState(
                        $externalService,
                        'connection',
                        $error->error->message,
                        StateHelper::STATE_ERROR
                    );
                }
            }else
            {
                StateHelper::setState(
                    $externalService,
                    'connection',
                    'We are unable to connect to the service. Maybe your token is expired. Please reconnect your account.',
                    StateHelper::STATE_ERROR
                );
            }

            Log::warning('[Agenda::Console/Command::Calendar fetch failed]', [
                'iam_user_id' => $externalService->iam_user_id,
                'external_service_uuid' => $externalService->uuid,
                'service_code' => $externalService->code,
                // The Google error itself (it used to be missing: only the trace was logged)
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    /**
     * Update or create a calendar entry
     *
     * @param string $iamAccountId
     * @param array $calendarData
     * @return void
     * @throws NotAllowedException
     * @throws Exception
     */
    private function updateOrCreateCalendar(string $iamAccountId, array $calendarData, ?int $monthsBack = null): void
    {
        $calendarData = array_merge($calendarData, [
            'source'        => 'Google',
            'object_type'   => 'NextDeveloper\IAM\Database\Models\Users',
            'object_id'     => $iamAccountId,
        ]);

        $calendar = Calendars::withoutGlobalScopes()
            ->where('iam_account_id', $iamAccountId)
            ->where('calendar_key', $calendarData['calendar_key'])
            ->first();

        if (!$calendar) {
            // New calendars start syncing from the window the user chose (calendar_sync_months_back), if any
            if ($monthsBack !== null) {
                $calendarData['sync_start_date'] = now()->subMonths($monthsBack)->toDateString();
            }

            CalendarsService::create($calendarData);
        } else {
            CalendarsService::update($calendar->uuid, $calendarData);
        }
    }
}