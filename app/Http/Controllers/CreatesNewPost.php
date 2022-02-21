<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CreatesNewPost extends Controller
{
    /**
     * Store a new blog post.
     * 
     * @param User $user
     * @param array $input
     * @return Illuminate\Http\Response
     */
    public function store(User $user, array $input)
    {
        $post = Post::forceCreate(
            array_merge($input, [
                'user_id' => $user->id,
                'slug' => $this->getUniqueSlug($input['title']),
            ])
        );

        return redirect()->route('posts.show', ['post' => $post]);
    }

    /**
     * Generate a unique slug. Thanks to iwconnect for the idea of using the post id as a modifier.
     * @see https://iwconnect.com/the-easiest-way-to-create-unique-slugs-for-blog-posts-in-laravel/ 
     * 
     * @param string $title
     * @return string
     */
    private function getUniqueSlug(string $title): string {
        $slug = Str::slug($title);
        if (in_array($slug, ["index", "create", "store", "show", "edit", "update", "destroy"])) {
            $slug = $slug . "-" . "post";
        }
        return (Post::where('slug', $slug)->count())
            ? $slug . "-" . Post::max('id') + 1 // Append the largest ID of posts + one.
            : $slug;
    }
}
