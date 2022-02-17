<x-app-layout>
    <div class="relative flex items-top justify-center sm:items-center py-4 sm:pt-0">
        <div class="max-w-2xl w-full mx-auto sm:px-6 lg:px-8 my-16">
            <h1 class="text-3xl font-bold dark:text-white my-3">Update Blog Post</h1>
            <section class="bg-white rounded-lg shadow-md dark:bg-gray-800 py-4 px-6 dark:text-white">
				<livewire:edit-post-form :post="$post" />
			</section>
        </div>
    </div>
</x-app-layout>