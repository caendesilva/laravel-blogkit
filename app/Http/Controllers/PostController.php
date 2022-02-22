<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Controllers\MarkdownConverter;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
    }
    
    /**
     * Display a listing of the resource with support for filters.
     * 
     * Does not include pagination at the moment.
     * 
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('filterByTag')) {
            return view('post.index', [
                'title' => 'Posts with '. __('blog.tag') .' ' . $request->get('filterByTag'),
                'filter' => 'Filtered by '. __('blog.tag') .' "' . $request->get('filterByTag') . '"',
                'posts' => Post::whereJsonContains('tags', $request->get('filterByTag'))->get(),
            ]);
        }

        if ($request->has('author')) {
            $author = User::findOrFail($request->get('author'));
    
            return view('post.index', [
                'title' => 'Posts by ' . $author->name,
                'filter' => 'Filtered by author ' . $author->name,
                'posts' => $author->posts,
            ]);
        }

        return view('post.index', [
            'posts' => Post::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', App\Models\Post::class);

        if (config('blog.easyMDE.enabled')) {
            if (!$request->has('draft_id')) {
                return redirect(route('posts.create', ['draft_id' => time()]));
            };
    
            return view('post.create', [
                'draft_id' => $request->get('draft_id'),
            ]);
        }

        return view('post.create');
    }

    /**
     * Store a new blog post.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        // The incoming request is valid and authorized...
    
        // Retrieve the validated input data...
        $validated = $request->validated();

        // Check if post has tags set, and serialize them to array
        if (isset($validated['tags'])) {
            $validated['tags'] = json_decode($validated['tags'], true);
        }

        // Create the post
        return (new CreatesNewPost)->store($request->user(), $validated);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $this->authorize('view', $post);

        // Generate formatted HTML from markdown
        $markdown = (new MarkdownConverter($post->body))->toHtml();

        return view('post.show', [
            'post' => $post,
            'markdown' => $markdown,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        
        if (config('blog.easyMDE.enabled')) {
            if (!$request->has('draft_id')) {
                return redirect(route('posts.edit', [
                    'post' => $post,
                    'draft_id' => time(),
                ]));
            };
    
            return view('post.edit', [
                'post' => $post,
                'draft_id' => $request->get('draft_id'),
            ]);
        }

        return view('post.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        // The incoming request is valid and authorized...
    
        // Retrieve the validated input data...
        $validated = $request->validated();

        // Check if post has tags set, and serialize them to array
        if (isset($validated['tags'])) {
            $validated['tags'] = json_decode($validated['tags'], true);
        }

        // Update the post
        $post->update($validated);

        return redirect()->route('posts.show', ['post' => $post]);
    }

    /**
     * Update the published_at date in the specified resource in storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function publish(Post $post)
    {
        $this->authorize('update', $post);

        $post->published_at = now();
        $post->save();
        return back()->with('success', 'Successfully Published Post!');
    }
    
    /**
     * Update the published_at date in the specified resource in storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function unpublish(Post $post)
    {
        $this->authorize('update', $post);

        $post->published_at = null;
        $post->save();
        return back()->with('success', 'Successfully Unpublished Post!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return back()->with('success', 'Successfully Deleted Post!');
    }
}
