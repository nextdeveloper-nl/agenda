<?php

namespace NextDeveloper\Agenda\Console\Commands\Concerns;

use NextDeveloper\Commons\Database\Models\ExternalServices;
use NextDeveloper\Commons\Helpers\GoogleWorkspaceHelper;

/**
 * Records the real result of a calendar sync on the connection ('calendar_sync' in its configuration), which is what
 * GET /leo/integrations/google-workspace/sync-status shows. The calendar list and the events are fetched by two
 * commands, each owns one part; the status is 'error' as soon as one part failed.
 */
trait RecordsCalendarSync
{
    /**
     * @param string      $part  'calendars' or 'events'
     * @param string|null $error null when this part succeeded
     */
    protected function recordCalendarSync(ExternalServices $service, string $part, ?string $error): void
    {
        $current = $service->fresh()->configuration['calendar_sync'] ?? [];
        $parts   = $current['parts'] ?? [];

        $parts[$part] = $error;

        $firstError = collect($parts)->filter()->first();

        GoogleWorkspaceHelper::recordSync($service, 'calendar_sync', [
            'status'         => $firstError ? 'error' : 'success',
            'error'          => $firstError,
            'parts'          => $parts,
            'last_synced_at' => now()->toISOString(),
        ]);
    }
}
