<?php

namespace App\Http\Controllers;

use App\Models\Post;
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
        
        // If the user is an admin they can manage all posts
        if ($request->user()->is_admin) {
            $posts = Post::all();
        }

        // Otherwise if the user is an author we show their posts
        elseif ($request->user()->is_author) {
            $posts = $request->user()->posts;
        }

        // Return the view with the data we prepared
        return view('dashboard', [
            'posts' => $posts ?? false,
        ]);
    }
}
