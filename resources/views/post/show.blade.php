<x-app-layout>
    <x-slot name="title">
        {{ $post->title }}
    </x-slot>

	@push('meta')
	<!-- Blog Post Meta Tags -->
	<meta property="og:title" content="{{ $post->title }}">
	<meta property="og:type" content="article" />
	<meta property="og:description" content="{{ $post->description }}">
	<meta property="og:image" content="{{ $post->featured_image }}">
	<meta property="og:url" content="{{ route('posts.show', ['post' => $post]) }}">
	@if($post->isPublished())
	<meta property="og:article:published_time" content="{{ $post->published_at }}">
	@endif
	@if(config('blog.showUpdatedAt'))
	<meta property="og:article:modified_time " content="{{ $post->updated_at }}">
	@endif
	<meta name="twitter:card" content="summary_large_image">
	<meta name="author" content="{{ $post->author->name }}">
	<meta name="description" content="{{ $post->description }}">
	@if(config('blog.withTags') && $post->tags)
	<meta name="keywords" itemprop="keywords" content="{{ implode(', ', $post->tags) }}">
	@endif
	@if(config('blog.contentLicense.enabled'))
	<meta itemprop="license" content="{{ config('blog.contentLicense.link') }}">
	@endif
	@endpush
	
    <div class="relative flex items-top justify-center sm:items-center py-4 sm:pt-0">
        <div class="max-w-5xl w-full mx-auto sm:px-6 lg:px-8 my-8 md:my-16">
            <article itemscope itemtype="http://schema.org/Article" class="bg-white rounded-lg shadow-md dark:bg-gray-800 py-4 px-6 dark:text-white">
				<meta itemprop="identifier" content="{{ $post->slug }}">
				<meta itemprop="url" content="{{ route('posts.show', $post) }}">
				<header role="doc-pageheader" class="mb-5">
					<table class="w-full">
						<thead>
							<tr>
								<th class="text-left">
									@if($post->isPublished())
									<h1 itemprop="headline" class="text-3xl font-bold">{{ $post->title }}</h1>
									@else
									<h1 class="text-3xl font-bold">
										<span class="opacity-75" title="This post has not yet been published">
											Draft: 
										</span>
										<i>{{ $post->title }}</i>
									</h1>
									@endif
								</th>
								<td class="text-right whitespace-nowrap align-top pt-2 pl-5 hidden sm:block">
									@can('update', $post)
									<a href="{{ route('posts.edit', $post) }}" class="my-2 mr-2 opacity-75 hover:opacity-100 transition-opacity">Edit Post</a>
									@endcan
								</td>
							</tr>
						</thead>
					</table>
					<div class="mt-2" aria-label="About the post" role="doc-introduction">
						<ul class="text-sm flex flex-row flex-wrap -mx-1 mt-1 mb-2">
							<li class="mx-1" name="author" itemprop="author" itemscope itemtype="http://schema.org/Person">
								<span class="opacity-75">
									Posted by
								</span>
								<x-link :href="route('posts.index', ['author' => $post->author])" rel="author" itemprop="url">
									<span itemprop="name">
										{{ $post->author->name }}
									</span>
								</x-link>
							</li>
							@if($post->isPublished())
							<li class="mx-1 opacity-75" name="published_time">
								<time datetime="{{ $post->published_at }}" itemprop="datePublished">{{ $post->published_at->format('Y-m-d g:ia') }}</time>.
							</li>
							@if(config('blog.showUpdatedAt') && $post->published_at !== $post->updated_at)
							<li class="mx-1 opacity-75" name="modified_time">
								Updated
								<time datetime="{{ $post->updated_at }}" itemprop="dateModified">{{ $post->updated_at->format('Y-m-d g:ia') }}</time>.
							</li>
							@endif
							@endif
							@if(config('blog.withTags') && $post->tags)
							<li class="mx-1" name="tags">
								<span class="opacity-75">
									{{ __('blog.Tags') }}:
								</span>
								<x-post-tags :tags="$post->tags" class="inline-flex" itemprop="keywords" :commaseparated="true"/>
							</li>
							@endif
							@if(config('analytics.enabled'))
							<li class="mx-1 opacity-75" name="view_count">
								<span itemprop="interactionStatistic" itemscope itemtype="http://schema.org/InteractionCounter">
									<meta itemprop="interactionType" content="http://schema.org/ViewAction"/>
									<span itemprop="userInteractionCount">{{ number_format($post->getViewCount()) }}</span>
								</span>
								views
							</li>
							@endif
						</ul>
					</div>
					@if($post->featured_image && basename($post->featured_image) != 'default.jpg')
						<figure class=" rounded-lg overflow-hidden" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
							<meta itemprop="url" content="{{ $post->featured_image }}">
							<img itemprop="image" src="{{ $post->featured_image }}" alt="Featured Image" class="post-header-image object-cover">
						</figure>
					@endif
				</header>
				
				<section itemprop="articleBody" class="prose dark:prose-invert max-w-none pb-3">
					{!! $markdown !!}
				</section>

				<footer>
					@if(config('blog.allowComments'))
				@if(config('blog.contentLicense.enabled'))
				<small class="mx-1" itemprop="license" itemscope itemtype="https://schema.org/CreativeWork">
					{{ __('This post is licensed under') }}
					<a href="{{ config('blog.contentLicense.link') }}" itemprop="url" rel="copyright noopener nofollow" target="_blank" title="View license text in new tab">
						<span itemprop="name">
							{{ config('blog.contentLicense.name') }}
						</span>
					</a>
				</small>
				@endif
				<section id="comments" class="border-t-2 dark:border-gray-600 mt-5 pt-5 pb-2">
					<h2 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">Comments</h2>
					@if($post->comments)
						<ul>
							@foreach ($post->comments as $comment)
							<li id="comment-{{ $comment->id }}" class="rounded-lg bg-gray-200 dark:bg-gray-700 p-4 my-4 relative group">
								<div>
									<a href="{{ route('posts.index', ['author' => $comment->user]) }}">
										<small class="opacity-75">&commat;</small>{{ $comment->user->name }}:
									</a>
									@if($comment->published_at != $comment->updated_at)
										<i class="text-xs opacity-75" title="This comment was last updated {{ $comment->updated_at }}">Edited</i>
									@endif
								</div>
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
						<div class="mt-5">
							<livewire:create-new-comment-form :post="$post">
						</div>
					@elseif(Gate::inspect('create', App\Models\Comment::class)->message() == "Your email must be verified to comment.")
						Please verify your email to comment. <x-link :href="route('verification.notice')">Resend email?</x-link>
					@endcan
					@guest
						<x-link :href="route('login')">Log in</x-link> 
						@if(Route::has('register'))
						or <x-link :href="route('register')">sign up</x-link>
						@endif
						to leave a comment! 
					@endguest
				</section>
				@endif
				</footer>
			</article>

			<div class="text-center dark:text-white mt-8 sm:hidden">
				@can('update', $post)
				<a href="{{ route('posts.edit', $post) }}" class="my-2 mr-2 opacity-75 hover:opacity-100 transition-opacity">Edit Post</a>
				@endcan
				<a href="/" class="opacity-75 hover:opacity-100 transition-opacity">Back to Home</a>
			</div>

        </div>
    </div>
</x-app-layout>