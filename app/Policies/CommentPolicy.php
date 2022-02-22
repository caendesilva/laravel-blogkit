<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        if (!config('blog.allowComments')) {
            return Response::deny('Commenting is not allowed.');
        }

        if (config('blog.requireVerifiedEmailForComments') && !$user->hasVerifiedEmail()) {
            return Response::deny('Your email must be verified to comment.');
        }

        if ($user->is_admin == true) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Comment $comment)
    {
        if (!config('blog.allowComments')) {
            return Response::deny('Commenting is not allowed.');
        }

        if (config('blog.requireVerifiedEmailForComments') && !$user->hasVerifiedEmail()) {
            return Response::deny('Your email must be verified to comment.');
        }

        if ($user->is_admin == true) {
            return true;
        }

        return $user->id === $comment->user_id
            ? Response::allow()
            : Response::deny('You do not own this comment.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Comment $comment)
    {
        if ($user->is_admin == true) {
            return true;
        }
        
        return $user->id === $comment->user_id
            ? Response::allow()
            : Response::deny('You do not own this comment.');
    }
}
