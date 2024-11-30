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
            PageView::fromRequest($request);
        });

        return $response;
    }
}
