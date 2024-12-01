<?php

namespace App\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Post;

class LatestBlogPosts extends Component
{
    use WithPagination;

    public $numberOfPaginatorsRendered = [];

    public function render()
    {
        $posts = Post::paginate(12);

        // If we are in demo mode we only show the posts made by the factory.
        if (config('blog.demoMode')) {
            $posts = Post::where('id', '<=', 36)->orderBy('published_at', 'desc')->paginate(12);
        }
        
        return view('livewire.latest-blog-posts', [
            'posts' => $posts,
        ]);
    }
}
