<x-app-layout>
    <x-slot name="title">
        {{ $title ?? 'Posts' }}
    </x-slot>

    <div class="relative flex items-top justify-center sm:items-center py-4 sm:pt-0">
        <section class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($posts->count())
            <header class="text-center py-5 mt-5">
                <h1 class="text-2xl font-medium dark:text-white">
					Blog Posts
				</h1>
				@if(isset($filter))
                <h2 class="text-xl font-medium dark:text-white mt-3">{{ $filter }}</h2>
				@else
                <h2 class="text-xl font-medium dark:text-white mt-3">Showing All Posts</h2>
				@endif
            </header>

			<div class="flex flex-row flex-wrap justify-start">
				@foreach ($posts as $post)
					<x-post-card :post="$post" />
				@endforeach
			</div>
            @else
            <header class="text-center py-5 mt-5 mb-3">
                @if(isset($filter))
				<h2 class="text-2xl font-medium dark:text-white mb-3">No posts found! Try resetting your filters.</h2>
				<x-link :href="route('posts.index')">Clear Filters</x-link>
				@else
				<h2 class="text-2xl font-medium dark:text-white mb-3">No posts found!</h2>
				<x-link :href="route('home')">Go Home?</x-link>
				@endif
            </header>
            @endif
        </section>
    </div>
</x-app-layout>