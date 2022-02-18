<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
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
        
        // If the user is an admin they can manage all posts and users
        if ($request->user()->is_admin) {
            $posts = Post::all();

            $users = User::all();

            // If comments are enabled or if there are comments we load them
            if (config('blog.allowComments') || Comment::count()) {
                $comments = Comment::all();
            }
        }

        // Otherwise if the user is an author we show their posts
        elseif ($request->user()->is_author) {
            $posts = $request->user()->posts;
        }

        // Return the view with the data we prepared
        return view('dashboard', [
            'posts' => $posts ?? false,
            'users' => $users ?? false,
            'comments' => $comments ?? false,
        ]);
    }
}
