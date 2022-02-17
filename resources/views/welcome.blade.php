<x-app-layout>
    <div class="relative flex items-top justify-center sm:items-center py-4 sm:pt-0">
        <section class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div v-if="posts">
            @if($posts)
                <header class="text-center py-5 mt-5 mb-3">
                    <h1 class="text-3xl font-bold dark:text-white my-3">{{ config('app.name') }}</h1>
                    <h2 class="text-2xl font-medium dark:text-white">Latest Blog Posts</h2>
                </header>

                <livewire:latest-blog-posts />
            </div>
            @else
            <h2>There are no posts here!</h2>
            @endif
        </section>
    </div>
</x-app-layout>