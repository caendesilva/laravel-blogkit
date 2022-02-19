<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use GrahamCampbell\Markdown\Facades\Markdown;
use App\Http\Requests\StorePostRequest;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('/', 301);
    }

    /**
     * Show all the posts by the specified author.
     *
     * @return \Illuminate\Http\Response
     */
    public function authorIndex(User $user)
    {
        return view('post.author-index', [
            'user' => $user,
            'posts' => $user->posts,
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
                'draft_id' => $request->get('draft_id')
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
        // The incoming request is valid...
    
        // Retrieve the validated input data...
        $validated = $request->validated();

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
        // Generate formatted HTML from markdown
        $markdown = config('blog.torchlight.enabled')
            ? Markdown::convertToHtml($post->body) // If Torchlight is enabled use the Markdown package
            : Str::markdown($post->body); // Otherwise use the built in GitHub markdown parser

        $torchlightUsed = config('blog.torchlight.enabled') === true // Check if Torchlight is enabled and if attribution is enabled. If it is not, we don't need to search the text.
            && config('blog.torchlight.attribution') === true
            && str_contains($markdown, '<!-- Syntax highlighted by torchlight.dev -->')
                ? true
                : false;

        return view('post.show', [
            'post' => $post,
            'markdown' => $markdown,
            'torchlightUsed' => $torchlightUsed ?? false,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        
        return view('post.edit', [
            'post' => $post
        ]);
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
