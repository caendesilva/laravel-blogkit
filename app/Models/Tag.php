<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

/**
 * Return an Eloquent Collection of the dynamic tags
 */
class Tag
{
	/**
	 * Get all the tags
	 * 
	 * @return Illuminate\Support\Collection $tags
	 */
	public static function all()
	{
		$tags = DB::table('posts')->select('tags')->get()->pluck('tags');

		$tags = $tags->map(function ($item) {
			return json_decode($item);
		});

		$tags = $tags->flatten()->unique();

		return $tags;
	}
}
