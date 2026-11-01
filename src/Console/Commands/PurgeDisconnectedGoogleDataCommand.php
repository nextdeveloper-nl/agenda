<?php

namespace NextDeveloper\Agenda\Console\Commands;

use Illuminate\Console\Command;
use NextDeveloper\Agenda\Services\GoogleDataRetentionService;
use NextDeveloper\Commons\Database\Models\ExternalServices;
use NextDeveloper\Commons\Helpers\GoogleWorkspaceHelper;

/**
 * Deletes the synced Google data of users who disconnected Google more than 30 days ago.
 * Scheduled daily. Events and attendees always; imported contacts only while
 * agenda.google_retention.delete_contacts_on_disconnect is on. A user who has another Google connection that is
 * still alive is skipped (the data cannot be told apart per Google account).
 */
class PurgeDisconnectedGoogleDataCommand extends Command
{
    protected $signature = 'agenda:purge-disconnected-google-data {--days= : Days after the disconnect (default: agenda.google_retention.disconnect_days)} {--dry-run : Only count what would be deleted}';

    protected $description = 'Deletes synced Google data of users who disconnected Google more than 30 days ago.';

    public function handle(): int
    {
        $days            = (int) ($this->option('days') ?: config('agenda.google_retention.disconnect_days', 30));
        $includeContacts = (bool) config('agenda.google_retention.delete_contacts_on_disconnect', true);
        $dryRun          = (bool) $this->option('dry-run');

        $services = ExternalServices::withoutGlobalScopes()
            ->where('code', GoogleWorkspaceHelper::CODE)
            ->where('is_alive', false)
            ->get()
            ->filter(function (ExternalServices $service) use ($days) {
                $disconnectedAt = $service->configuration['disconnected_at'] ?? null;

                return $disconnectedAt
                    && now()->subDays($days)->gte($disconnectedAt)
                    // not handled yet: never deleted, or deleted before the latest disconnect
                    && (empty($service->configuration['data_deleted_at']) || $service->configuration['data_deleted_at'] < $disconnectedAt);
            });

        foreach ($services as $service) {
            // Any live Google connection of the user (Workspace or the legacy google_calendar one) keeps the data
            $stillConnected = ExternalServices::withoutGlobalScopes()
                ->whereIn('code', [GoogleWorkspaceHelper::CODE, 'google_calendar'])
                ->where('iam_user_id', $service->iam_user_id)
                ->where('is_alive', true)
                ->whereNull('deleted_at')
                ->exists();

            if ($stillConnected) {
                continue;
            }

            $result = GoogleDataRetentionService::purgeUser((int) $service->iam_user_id, $includeContacts, $dryRun, (int) $service->iam_account_id);

            if (!$dryRun) {
                // Marks this disconnect as handled so the job does not run again for it
                // Saved on the row that is already loaded: ExternalServicesService::update() looks the row up through
                // the authorization scope, which finds nothing in CLI/scheduler (no user context).
                $fresh                            = $service->fresh();
                $configuration                    = $fresh->configuration ?? [];
                $configuration['data_deleted_at'] = now()->toISOString();

                $fresh->configuration = $configuration;
                $fresh->saveQuietly();
            }

            $this->line("user {$service->iam_user_id}: events {$result['events']}, attendees {$result['attendees']}, contacts {$result['contacts']}, calendars {$result['calendars']}");
        }

        return self::SUCCESS;
    }
}
