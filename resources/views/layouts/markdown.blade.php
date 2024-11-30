<x-app-layout>
    <div class="relative flex items-top justify-center sm:items-center py-4 sm:pt-0">
        <div class="mx-auto sm:px-6 lg:px-8 my-16">
            <section class="bg-white rounded-lg shadow-md dark:bg-gray-800 p-6 dark:text-white">
				<div class="prose dark:prose-invert max-w-none">
					{!! $markdown !!}
				</div>
			</section>
        </div>
    </div>
</x-app-layout>