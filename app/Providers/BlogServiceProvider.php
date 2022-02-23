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
     * @version 1.1.0-Dev
     */
    const BLOGKIT_VERSION = "1.1.0-Dev";

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * If Torchlight syntax highlighting is enabled we hook into the Commonmark resolver to add the extension.
         */
        if (config('blog.torchlight.enabled')) {
            $this->callAfterResolving('markdown.environment', function ($environment) {
                $environment->addExtension(new \Torchlight\Commonmark\V2\TorchlightExtension());
            });
        }
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
