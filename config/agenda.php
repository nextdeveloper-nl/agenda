<?php

return [
    'scopes'    =>  [
        'global' => [
            //  Dont do this here because it makes infinite loop with user object.
            '\NextDeveloper\IAM\Database\Scopes\AuthorizationScope',
            '\NextDeveloper\Commons\Database\GlobalScopes\LimitScope',
        ]
    ],

    'google-scopes' => [
        'calendar' => [
            // Read-only, aligned with the scopes declared in the Google Cloud console.
            'https://www.googleapis.com/auth/calendar.readonly',
        ],
    ],

    // Retention of data synced from Google (see GoogleDataRetentionService)
    'google_retention' => [
        // Synced calendar events that ended longer ago than this are deleted (future events never)
        'months'                           => env('AGENDA_GOOGLE_RETENTION_MONTHS', 36),
        // Days after a disconnect until the synced events/attendees (and contacts) are deleted
        'disconnect_days'                  => env('AGENDA_GOOGLE_DISCONNECT_DELETE_DAYS', 30),
        // Switch: also delete the imported Google contacts after a disconnect
        'delete_contacts_on_disconnect'    => env('AGENDA_DELETE_GOOGLE_CONTACTS_ON_DISCONNECT', true),
    ],

    'schedule' => [
        'enabled'   => env('AGENDA_SCHEDULE_ENABLED', true),
        'cron'      => env('AGENDA_SCHEDULE_CRON', '*/10 * * * *'), // 10 minutes
    ],
];
