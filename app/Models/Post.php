<?php

namespace App\Models;

use App\Http\Controllers\MarkdownFileParser;
use App\Scopes\PublishedScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'body',
        'description',
        'featured_image',
        'tags',
        'published_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tags' => 'array',
        'published_at' => 'datetime',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
    
        // Order by latest posts by default, with draft posts first
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderByRaw('-published_at');
        });

        // Filter out posts that are not published
        static::addGlobalScope(new PublishedScope);
    }
    
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the model's Description. If one has not been set we return a truncated part of the body.
     * 
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function description(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return new Attribute(
            get: fn ($value) => empty($value)
                ? substr($this->body, 0, 255)
                : $value
        );
    }

    /**
     * Get the model's Featured Image. If one has not been set we return a default image.
     * 
     * Default Image by Picjumbo
     * @see https://picjumbo.com/tremendous-mountain-peak-krivan-in-high-tatras-slovakia/
     * 
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function featuredImage(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return new Attribute(
            get: fn ($value) => empty($value)
                ? asset('storage/default.jpg')
                : $value
        );
    }

    /**
     * Check if the post is published by comparing the published_at date with the current date. 
     * 
     * @return bool
     */
    public function isPublished(): bool
    {
        return ($this->published_at !== null) && $this->published_at->isPast();
    }

    /**
     * Check if the post was created using a markdown file. Used to show a warning in the editor that changes may be overridden if the file is changed.
     * 
     * @return bool
     */
    public function isFileBased(): bool
    {
        try {
            MarkdownFileParser::getQualifiedFilepath($this->slug);
            return true;
        } catch (\Throwable $th) {
            //
        }
        return false;
    }

    /**
     * Get the author associated with the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function author(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Get all of the comments for the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }
}
