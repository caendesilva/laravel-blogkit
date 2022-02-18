<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EditCommentForm extends Component
{
    use AuthorizesRequests;

    public Comment $comment;

    protected $rules = [
        'comment.content' => 'required|string|max:1024',
    ];

    public function save()
    {
        $this->authorize('update', $this->comment);

        $this->validate();
 
        $this->comment->save();
        return redirect()->to(route('posts.show', ['post' => $this->comment->post]) . "#comment-" . $this->comment->id);
    }

    public function render()
    {
        return view('livewire.edit-comment-form');
    }
}
