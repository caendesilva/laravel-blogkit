<x-app-layout>
	@push('meta')
	<!-- Blog Post Meta Tags -->
	<meta property="og:title" content="{{ $post->title }}">
	<meta property="og:type" content="article" />
	<meta property="og:description" content="{{ $post->description }}">
	<meta property="og:image" content="{{ $post->featured_image }}">
	<meta property="og:url" content="{{ route('posts.show', ['post' => $post]) }}">
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

				@if(config('blog.allowComments'))
				<footer class="border-t-2 dark:border-gray-600 mt-8 pt-5 pb-2">
					<h2 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">Comments</h2>
					@if($post->comments)
						<ul>
							@foreach ($post->comments as $comment)
							<li id="comment-{{ $comment->id }}" class="rounded-lg bg-gray-200 dark:bg-gray-700 p-4 my-4 relative group">
								<a href="{{ route('author', $comment->user) }}">
									<small class="opacity-75">&commat;</small>{{ $comment->user->name }}:
								</a>
								<p class="ml-2 mt-2 pl-2 border-l-2 border-gray-300 dark:border-gray-600">
									{{-- Escape the content and replace newlines with line breaks --}}
									{!! nl2br(e($comment->content)) !!}
								</p>

								@can('delete', $comment)
								<form action="{{ route('comments.destroy', ['comment' => $comment]) }}" method="POST" class="absolute top-3 right-4" onSubmit="return confirm('Are you sure you want to delete this comment?')">
									@method('DELETE')
									@csrf
									@can('update', $comment)
									<a class="font-semibold dark:font-medium mr-2 invisible group-hover:visible opacity-0 group-hover:opacity-100 transition-opacity" href="{{ route('comments.edit', ['comment' => $comment]) }}">
										Edit
									</a>
									@endcan
									<button type="submit" class="font-semibold dark:font-medium text-red-600 dark:text-red-500 invisible group-hover:visible opacity-0 group-hover:opacity-100 transition-opacity">Delete</button>
								</form>
								@endcan
							</li>
							@endforeach
						</ul>
					@endif
					@can('create', App\Models\Comment::class)
						<div class="mt-3">
							<livewire:create-new-comment-form :post="$post">
						</div>
					@elseif(Gate::inspect('create', App\Models\Comment::class)->message() == "Your email must be verified to comment.")
						Please verify your email to comment. <x-link :href="route('verification.notice')">Resend email?</x-link>
					@endcan
					@guest
						<x-link :href="route('login')">Log in</x-link> or 
						<x-link :href="route('register')">sign up</x-link>
						to leave a comment! 
					@endguest
				</footer>
				@endif
			</article>

			<div class="text-center dark:text-white mt-8 sm:hidden">
				<a href="/" class="opacity-75 hover:opacity-100 transition-opacity">Back to Home</a>
			</div>

        </div>
    </div>
</x-app-layout>