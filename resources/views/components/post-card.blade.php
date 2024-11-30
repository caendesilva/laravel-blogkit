<article class="w-full sm:w-80 bg-white rounded-lg shadow-md dark:bg-gray-800 m-4 my-5 flex flex-col flex-grow">
    <header>
        <a href="{{ route('posts.show', $post) }}">
            <span class="rounded-t-lg featured-post-image" role="img" style="background-image: url('{{ $post->featured_image }}');" alt="Featured Image"></span>
        </a>
    </header>
    <div class="p-5 h-full flex flex-col">

        @if(config('blog.withTags') && config('blog.showTagsOnPostCard') && $post->tags)
            <x-post-tags :tags="$post->tags" class="text-xs" />
        @endif
                
        <a href="{{ route('posts.show', $post) }}">
            <h3 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white break-words">
                @if($post->isPublished())
                {{ $post->title }}
                @else
                <span class="opacity-75" title="This post has not yet been published">
                    Draft: 
                </span>
                <i>{{ $post->title }}</i>
                @endif
            </h3>
        </a>
        
        <p class="mb-3 text-sm font-normal text-gray-700 dark:text-gray-400 overflow-hidden text-ellipsis">
            By <x-link :href="route('posts.index', ['author' => $post->author])" rel="author">{{ $post->author->name }}</x-link>
            @if($post->isPublished())
            <span class="opacity-75" role="none">&bullet;</span>
            <time datetime="{{ $post->published_at }}" title="Published {{ $post->published_at }}">{{ $post->published_at->format('Y-m-d') }}</time>.
            @endif
            @if(config('blog.allowComments') || config('analytics.enabled'))
                <span class="inline float-right">
                    @if(config('analytics.enabled'))
                        <span class="{{ config('blog.allowComments') ? 'mr-2' : '' }}" role="none" aria-hidden="true" title="{{ number_format($post->getViewCount()) }} views">
                            <svg class="inline fill-gray-500 dark:text-gray-300" role="presentation" xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 0 24 24" width="18px"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                            {{ number_format($post->getViewCount()) }}
                        </span>
                    @endif

                    @if(config('blog.allowComments'))
                        <span class="sr-only">
                        The post has {{ $post->comments->count() }} comments.
                            <a href="{{ route('posts.show', $post) }}#comments">Go to post comment section</a>
                        </span>
                        
                        <a href="{{ route('posts.show', $post) }}#comments" role="none" aria-hidden="true" title="{{ $post->comments->count() }} comments">
                            <svg class="inline fill-gray-500 dark:text-gray-300" role="presentation" xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 0 24 24" width="18px" fill="#000000"><path d="M0 0h24v24H0z" fill="none"/><path d="M21.99 4c0-1.1-.89-2-1.99-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14l4 4-.01-18zM18 14H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/></svg>
                            {{ $post->comments->count() }}
                        </a>
                    @endif
                </span>
            @endif
        </p>

        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400 overflow-hidden text-ellipsis">
            {{ $post->description }}
        </p>

        <a href="{{ route('posts.show', $post) }}" class="mt-auto w-fit inline-flex items-center py-2 px-3 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            {{ __('Read more') }}
            <svg class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </a>
    </div>
</article>