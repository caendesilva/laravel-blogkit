<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * Get the user associated with the Comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Get the post associated with the Comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function post(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Post::class, 'id', 'post_id');
    }
}
