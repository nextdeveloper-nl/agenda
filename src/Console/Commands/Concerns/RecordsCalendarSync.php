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
     * The only error text that reaches the panel: Google's own error.message (when the exception is a Google API
     * error) or one of our fixed messages. Anything else (SQL, paths, internals) becomes a generic text; the raw
     * message stays in the server log.
     */
    protected function publicSyncError(string $message): string
    {
        $google = json_decode($message);

        if (is_object($google) && is_string($google->error->message ?? null)) {
            return $google->error->message;
        }

        foreach (['Unable to refresh the Google', 'No calendars found'] as $known) {
            if (str_starts_with($message, $known)) {
                return $message;
            }
        }

        return 'Sync failed, please retry';
    }

    /**
     * @param string      $part  'calendars' or 'events'
     * @param string|null $error null when this part succeeded
     */
    protected function recordCalendarSync(ExternalServices $service, string $part, ?string $error): void
    {
        $current = $service->fresh()->configuration['calendar_sync'] ?? [];
        $parts   = $current['parts'] ?? [];

        $parts[$part] = $error === null ? null : $this->publicSyncError($error);

        $firstError = collect($parts)->filter()->first();

        GoogleWorkspaceHelper::recordSync($service, 'calendar_sync', [
            'status'         => $firstError ? 'error' : 'success',
            'error'          => $firstError,
            'parts'          => $parts,
            'last_synced_at' => now()->toISOString(),
        ]);
    }
}
