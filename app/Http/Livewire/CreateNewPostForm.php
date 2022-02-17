<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CreateNewPostForm extends Component
{
    /**
     * The post instance.
     * 
     * @var \App\Models\Post
     */
    public \App\Models\Post $post;

    protected $rules = [
        'post.title' => 'required|string|max:255',
        'post.description' => 'nullable|string|max:255',
        'post.featured_image' => 'nullable|url|max:255',
        'post.body' => 'required|string',
    ];
    
    public function mount()
    {
        $this->post = new Post;
    }

    public function save()
    {
        // Authorize

        $this->validate();
 
        $this->post->user_id = Auth::id();
        $this->post->slug = $this->getUniqueSlug($this->post->title);

        $this->post->save();

        return redirect()->route('post.show', ['post' => $this->post]);
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
        return Post::where('slug', $slug)->count()
            ? $slug . "-" . $this->post->id
            : $slug;
    }

    public function render()
    {
        return view('livewire.create-new-post-form');
    }
}
