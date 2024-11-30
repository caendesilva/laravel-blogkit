<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Analytics Enabled
    |--------------------------------------------------------------------------
    |
    | This option controls whether the analytics feature is enabled.
    | You can disable analytics entirely by setting this to false.
    |
    */
    'enabled' => env('ANALYTICS_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Anonymization Salt
    |--------------------------------------------------------------------------
    |
    | This salt is used to anonymize visitor identifiers. It should be a unique
    | and secret string that ensures identifiers cannot be tracked across
    | other platforms, or by generating rainbow tables.
    |
    */
    'anonymization_salt' => env('ANALYTICS_SALT', null),
];
