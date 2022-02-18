<article class="w-full sm:w-80 bg-white rounded-lg shadow-md dark:bg-gray-800 m-4 my-5 flex flex-col flex-grow">
    <header>
        <a href="{{ route('posts.show', $post) }}">
            <span class="rounded-t-lg featured-post-image" role="img" style="background-image: url('{{ $post->featured_image }}');" alt="Featured Image"></span>
        </a>
    </header>
    <div class="p-5 h-full flex flex-col">
        <a href="{{ route('posts.show', $post) }}">
            <h3 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                {{ $post->title }}
            </h3>
        </a>
        <p class="mb-3 text-sm font-normal text-gray-700 dark:text-gray-400 overflow-hidden text-ellipsis">
            By <x-link :href="route('author', $post->author)" rel="author">{{ $post->author->name }}</x-link>
            <span class="opacity-75" role="none">&bullet;</span>
            <time datetime="{{ $post->created_at }}">{{ $post->created_at->format('Y-m-d') }}</time>.
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