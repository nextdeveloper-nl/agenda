<?php

namespace NextDeveloper\Agenda\Console\Commands;

use Illuminate\Console\Command;
use NextDeveloper\Agenda\Services\GoogleDataRetentionService;

/**
 * Manual deletion of everything synced from Google for ONE user (deletion requests handled by legal, or a
 * disconnect that has to be cleaned up right away). Same deletion the scheduled job runs 30 days after a disconnect.
 */
class DeleteGoogleDataCommand extends Command
{
    protected $signature = 'agenda:delete-google-data {--user= : Internal user ID (required)} {--include-contacts : Also delete the imported Google contacts} {--dry-run : Only count what would be deleted}';

    protected $description = 'Deletes the synced Google calendar events, attendees and (optionally) imported contacts of one user.';

    public function handle(): int
    {
        $userId = (int) $this->option('user');

        if ($userId <= 0) {
            $this->error('--user is required');

            return self::INVALID;
        }

        $result = GoogleDataRetentionService::purgeUser($userId, (bool) $this->option('include-contacts'), (bool) $this->option('dry-run'));

        $this->info(($this->option('dry-run') ? 'Would delete' : 'Deleted')
            . " events: {$result['events']}, attendees: {$result['attendees']}, contacts: {$result['contacts']}, calendars: {$result['calendars']} (user {$userId})");

        return self::SUCCESS;
    }
}
