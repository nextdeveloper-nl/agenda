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
            ->whereIn('code', self::SERVICE_IDS);

        // Apply user filter if specified
        if ($userId = $this->option('user')) {
            $query->where('iam_user_id', $userId);
        }

        $services = $query->get();

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

            $service = new Calendar($externalService->token);

            if ($service->isTokenExpired()) {
                $service->refreshToken($externalService->refresh_token);
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
                $this->updateOrCreateCalendar($externalService->iam_account_id, $calendarData);
            }

            StateHelper::setState(
                $externalService,
                'connection',
                'Calendars fetched successfully',
                StateHelper::STATE_SUCCESS
            );
        } catch (Exception $e) {

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
                'error' => $e->getTraceAsString(),
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
    private function updateOrCreateCalendar(string $iamAccountId, array $calendarData): void
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
            CalendarsService::create($calendarData);
        } else {
            CalendarsService::update($calendar->uuid, $calendarData);
        }
    }
}