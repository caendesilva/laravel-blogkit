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
        return view('livewire.latest-blog-posts', [
            'posts' => Post::paginate(12),
        ]);
    }
}
