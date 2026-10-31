<?php

namespace NextDeveloper\Agenda\Console\Commands;

use Illuminate\Console\Command;
use NextDeveloper\Agenda\Services\GoogleDataRetentionService;

/**
 * Retention: deletes synced Google calendar events (and their attendees) that ended more than 36 months ago.
 * Future events are never deleted. Scheduled daily.
 */
class PurgeExpiredCalendarEventsCommand extends Command
{
    protected $signature = 'agenda:purge-expired-calendar-events {--months= : Retention in months (default: agenda.google_retention.months)} {--dry-run : Only count what would be deleted}';

    protected $description = 'Deletes synced Google calendar events and attendees that ended more than the retention period ago.';

    public function handle(): int
    {
        $months = (int) ($this->option('months') ?: config('agenda.google_retention.months', 36));
        $result = GoogleDataRetentionService::purgeExpiredEvents($months, (bool) $this->option('dry-run'));

        $this->info(($this->option('dry-run') ? 'Would delete' : 'Deleted') . " events: {$result['events']}, attendees: {$result['attendees']} (older than {$months} months)");

        return self::SUCCESS;
    }
}
