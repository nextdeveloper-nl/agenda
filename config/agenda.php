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
            'https://www.googleapis.com/auth/calendar',
            'https://www.googleapis.com/auth/calendar.events',
            'https://www.googleapis.com/auth/calendar.readonly',
        ],
    ],

    'schedule' => [
        'enabled'   => env('AGENDA_SCHEDULE_ENABLED', true),
        'cron'      => env('AGENDA_SCHEDULE_CRON', '*/10 * * * *'), // 10 minutes
    ],
];
