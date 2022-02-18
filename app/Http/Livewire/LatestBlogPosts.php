<?php

namespace App\Http\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Post;

class LatestBlogPosts extends Component
{
    use WithPagination;

    public function render()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(12);

        // If we are in demo mode we only show the posts made by the factory.
        if (config('blog.demoMode')) {
            $posts = Post::where('id', '<=', 36)->orderBy('created_at', 'desc')->paginate(12);
        }
        
        return view('livewire.latest-blog-posts', [
            'posts' => $posts,
        ]);
    }
}
