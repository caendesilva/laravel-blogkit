<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PageView;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class AnalyticsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (! Config::get('analytics.enabled')) {
            return $response;
        }

        // Use the terminate method to execute code after the response is sent.
        app()->terminating(function () use ($request) {
            $path = $request->path();
            $excludedPaths = Config::get('analytics.excluded_paths', []);

            // Check if the current path matches any excluded paths
            foreach ($excludedPaths as $excludedPath) {
                if (str_is($excludedPath, $path)) {
                    return;
                }
            }

            PageView::fromRequest($request);
        });

        return $response;
    }
}
