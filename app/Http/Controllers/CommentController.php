<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Livewire\EditCommentForm;

class CommentController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * Thanks to s-patompong for the tip on how to call a livewire component from controller
     * @author https://github.com/s-patompong
     * @see https://github.com/livewire/livewire/discussions/2255#discussioncomment-1680285
     * 
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);
        
        $livewire = new EditCommentForm();

        $livewire->comment = $comment;

        return App::call([$livewire, '__invoke']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return back()->with('success', 'Successfully Deleted Comment!');
    }
}
