<?php

namespace App\Livewire;

use App\Models\Comment;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Layout;

class EditCommentForm extends Component
{
    use AuthorizesRequests;

    public Comment $comment;
    public string $content = '';

    public function mount()
    {
        $this->content = $this->comment->content;
    }

    protected $rules = [
        'content' => 'required|string|max:1024',
    ];

    public function save()
    {
        $this->authorize('update', $this->comment);

        $this->validate();
        
        $this->comment->content = $this->content;
        $this->comment->save();
        
        return redirect()->to(route('posts.show', ['post' => $this->comment->post]) . "#comment-" . $this->comment->id);
    }

    #[Layout('layouts.app')] 
    public function render()
    {
        return view('livewire.edit-comment-form');
    }
}
