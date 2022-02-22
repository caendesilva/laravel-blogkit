<?php
 
namespace App\Scopes;
 
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class PublishedScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        // If user is admin we don't want to remove published posts
		if (Auth::check() && Auth::user()->is_admin) {
			return;
		}
        
        // Apply the filter
        $builder->where('published_at', '<=', now());

        // If the user has posts we do a special case to make sure they can see their own posts
		if (Auth::check() && Auth::user()->is_author) {
            return $builder->orWhere('user_id', Auth::id());
        }
    }
}