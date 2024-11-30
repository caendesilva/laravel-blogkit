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

    /*
    |--------------------------------------------------------------------------
    | View Count Cache Duration
    |--------------------------------------------------------------------------
    |
    | The duration in minutes to cache post view counts. This helps reduce
    | database load while keeping view counts reasonably up to date.
    |
    */
    'view_count_cache_duration' => 3600, // 1 hour

    /*
    |--------------------------------------------------------------------------
    | Excluded Paths
    |--------------------------------------------------------------------------
    |
    | List of paths that should be excluded from analytics tracking.
    | Supports wildcards using * (e.g. 'api/*', 'admin/*').
    |
    */
    'excluded_paths' => [
        // Examples:
        // 'api/*',
        // 'admin/*',
        // 'health-check',
    ],

];
