<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\PageView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{

    /**
     * Display the view.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // Authorize the request
        if (!Gate::allows('access-dashboards')) {
            abort(403);
        }
        
        $data = [];
        
        // If the user is an admin they can manage all posts and users
        if ($request->user()->is_admin) {
            $data['posts'] = Post::all();
            $data['users'] = User::all();

            // If comments are enabled or if there are comments we load them
            if (config('blog.allowComments') || Comment::count()) {
                $data['comments'] = Comment::all();
            }

            // Add analytics data if enabled
            if (config('analytics.enabled')) {
                $pageViews = PageView::all();
                
                // Get traffic data for the last 30 days
                $thirtyDaysAgo = now()->subDays(30);
                $trafficData = PageView::where('created_at', '>=', $thirtyDaysAgo)
                    ->get()
                    ->groupBy(function ($view) {
                        return $view->created_at->format('Y-m-d');
                    });

                $data['analytics'] = [
                    'total_views' => $pageViews->count(),
                    'unique_visitors' => $pageViews->groupBy('anonymous_id')->count(),
                    'popular_pages' => PageView::select('page')
                        ->selectRaw('COUNT(*) as views')
                        ->selectRaw('COUNT(DISTINCT anonymous_id) as visitors')
                        ->groupBy('page')
                        ->orderByDesc('views')
                        ->limit(10)
                        ->get(),
                    'top_referrers' => PageView::whereNotNull('referrer')
                        ->where('referrer', 'not like', '?ref=%')
                        ->select('referrer')
                        ->selectRaw('COUNT(*) as views')
                        ->selectRaw('COUNT(DISTINCT anonymous_id) as visitors')
                        ->groupBy('referrer')
                        ->orderByDesc('views')
                        ->limit(10)
                        ->get(),
                    'top_refs' => PageView::where('referrer', 'like', '?ref=%')
                        ->select('referrer')
                        ->selectRaw('COUNT(*) as views')
                        ->selectRaw('COUNT(DISTINCT anonymous_id) as visitors')
                        ->groupBy('referrer')
                        ->orderByDesc('views')
                        ->limit(10)
                        ->get(),
                    'traffic_data' => [
                        'dates' => $trafficData->keys(),
                        'views' => $trafficData->map->count(),
                        'unique' => $trafficData->map(fn ($views) => $views->groupBy('anonymous_id')->count()),
                    ],
                ];
            }
        }
        // Otherwise if the user is an author we show their posts
        elseif ($request->user()->is_author) {
            $data['posts'] = $request->user()->posts;
        }

        // Return the view with the data we prepared
        return view('dashboard', $data);
    }
}
