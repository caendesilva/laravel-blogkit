<x-app-layout>
	@push('meta')
	<!-- Blog Post Meta Tags -->
	<meta property="og:title" content="{{ $post->title }}">
	<meta property="og:type" content="article" />
	<meta property="og:description" content="{{ $post->description }}">
	<meta property="og:image" content="{{ $post->featured_image }}">
	<meta property="og:url" content="{{ route('post.show', ['post' => $post]) }}">
	<meta property="og:article:published_time" content="{{ $post->created_at }}">
	<meta property="og:article:modified_time " content="{{ $post->updated_at }}">
	<meta name="twitter:card" content="summary_large_image">
	@endpush

    <div class="relative flex items-top justify-center sm:items-center py-4 sm:pt-0">
        <div class="max-w-5xl w-full mx-auto sm:px-6 lg:px-8 my-8 md:my-16">
            <article class="bg-white rounded-lg shadow-md dark:bg-gray-800 py-4 px-6 dark:text-white">
				<header class="mb-5">
					<table class="w-full">
						<thead>
							<tr>
								<th class="text-left">
									<h1 class="text-3xl font-bold mb-2">{{ $post->title }}</h1>
								</th>
								<td class="text-right whitespace-nowrap align-top pt-2 pl-5 hidden sm:block">
									<a href="/" class="my-2 opacity-75 hover:opacity-100 transition-opacity">Back to Home</a>
								</td>
							</tr>
						</thead>
					</table>
					<div class="text-sm mb-3">
						<span class="opacity-75">Posted by</span>
						<x-link :href="route('author', $post->author)" rel="author">{{ $post->author->name }}</x-link>
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

			<div class="text-center dark:text-white mt-8 sm:hidden">
				<a href="/" class="opacity-75 hover:opacity-100 transition-opacity">Back to Home</a>
			</div>

        </div>
    </div>
</x-app-layout>