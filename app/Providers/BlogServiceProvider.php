<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * The Blog Kit Service Provider
 */
class BlogServiceProvider extends ServiceProvider
{
    /**
     * The Starter Kit Version
     * 
     * Uses Semantic Versioning
     * @see https://semver.org/
     * 
     * @version 1.0.0-Dev
     */
    const BLOGKIT_VERSION = "1.0.0-Dev";

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
