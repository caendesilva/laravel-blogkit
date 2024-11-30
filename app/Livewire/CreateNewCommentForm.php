<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\Comment;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CreateNewCommentForm extends Component
{
    use AuthorizesRequests;
 
    public Post $post;

    public string $content = "";

    protected $rules = [
        'content' => 'required|string|max:1024',
    ];

    public function mount(Post $post)
    {
        $this->post = $post;
    }
    
    public function save()
    {
        $this->authorize('create', App\Models\Comment::class);

        $this->validate();
 
        $comment = new Comment;

        $comment->post_id = $this->post->id;
        $comment->user_id = Auth::id();

        $comment->content = $this->content;

        $comment->save();

        return redirect()->route('posts.show', ['post' => $this->post]);
    }

    public function render()
    {
        return view('livewire.create-new-comment-form');
    }
}
