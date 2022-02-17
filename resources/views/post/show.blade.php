<x-app-layout>
    <div class="relative flex items-top justify-center sm:items-center py-4 sm:pt-0">
        <div class="max-w-5xl w-full mx-auto sm:px-6 lg:px-8 my-16">
            <article class="bg-white rounded-lg shadow-md dark:bg-gray-800 py-4 px-6 dark:text-white">
				<header class="mb-5">
					<div class="flex flex-row flex-wrap items-start justify-between">
						<h1 class="text-3xl font-bold mb-2">{{ $post->title }}</h1>
						<a href="/" class="my-2 opacity-75 hover:opacity-100 transition-opacity">Back to Home</a>
					</div>
					<div class="text-sm mb-3">
						<span class="opacity-75">Posted by</span>
						<a href="" rel="author">{{ $post->author->name }}</a>
						<span class="opacity-75">
							<time datetime="{{ $post->created_at }}">{{ $post->created_at->format('Y-m-d g:sa') }}</time>.
							@if($post->created_at !== $post->updated_at)
							Updated <time datetime="{{ $post->updated_at }}">{{ $post->updated_at->format('Y-m-d g:sa') }}</time>.
							@endif
						</span>
					</div>
					<p class="text-lg my-3">{{ $post->description }}</p>
					<figure>
						<span class="post-header-image rounded-lg" role="img" style="background-image: url('{{ $post->featured_image }}');" alt="Featured Image"></span>
					</figure>
				</header>
				
				<div class="prose dark:prose-invert">
					{!! Str::markdown($post->body) !!}
				</div>
			</article>
        </div>
    </div>
</x-app-layout>