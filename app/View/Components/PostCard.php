<?php

namespace App\View\Components;

use App\Models\Post;
use Illuminate\View\Component;

/**
 * Show a card preview of the Blog Post.
 * 
 * @see https://flowbite.com/docs/components/card/#card-with-image for Frontend source
 * @license MIT (Frontend Base Card)
 */
class PostCard extends Component
{
    /**
     * @var \App\Models\Post
     */
    public Post $post;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    /**
     * @param \App\Models\Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.post-card');
    }
}