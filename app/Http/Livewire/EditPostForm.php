<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EditPostForm extends Component
{
    use AuthorizesRequests;

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
    
    
    public function mount(Post $post)
    {
        $this->post = $post;
    }

    public function save()
    {
        $this->authorize('update', $this->post);

        $this->validate();

        $this->post->save();

        return redirect()->route('post.show', ['post' => $this->post]);
    }

    public function render()
    {
        return view('livewire.edit-post-form');
    }
}
