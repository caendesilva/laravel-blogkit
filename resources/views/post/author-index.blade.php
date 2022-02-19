<x-app-layout>
    <x-slot name="title">
        Author {{ $user->name }}
    </x-slot>

    <div class="relative flex items-top justify-center sm:items-center py-4 sm:pt-0">
        <section class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($posts->count())
            <header class="text-center py-5 mt-5 mb-3">
                <h1 class="text-2xl font-medium dark:text-white">Latest Blog Posts by {{ $user->name }}</h1>
            </header>

			<div class="flex flex-row flex-wrap justify-start">
				@foreach ($posts as $post)
					<x-post-card :post="$post" />
				@endforeach
			</div>
            @else
            <header class="text-center py-5 mt-5 mb-3">
                <h2 class="text-2xl font-medium dark:text-white mb-3">This Author has no posts!</h2>

				<x-link :href="route('home')">Go Home?</x-link>
            </header>
            @endif
        </section>
    </div>
</x-app-layout>