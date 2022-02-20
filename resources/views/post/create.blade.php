<x-app-layout>
    <x-slot name="title">
        Create Post
    </x-slot>

    <div class="relative flex items-top justify-center sm:items-center py-4 sm:pt-0">
        <div class="max-w-5xl w-full mx-auto sm:px-6 lg:px-8 my-8 sm:my-16">
            <h1 class="text-3xl font-bold dark:text-white mb-8 sm:my-3 text-center sm:text-left">New Blog Post</h1>
            <section class="bg-white rounded-lg shadow-md dark:bg-gray-800 py-4 px-6 dark:text-white">
				<form action="{{ route('posts.store') }}" method="POST" class="text-gray-900">
                    @csrf

                    <fieldset>
                        <legend class="dark:text-white">Required Fields</legend>

                        <div class="mt-3">
                            <x-label for="title" :value="__('Title*')" />
                            <x-input id="title" name="title" :value="old('title')" type="text" class="block mt-1 w-full" maxlength="255" required autofocus placeholder="The post title"/>
                            @error('title') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-3">
                            <x-label for="body" :value="__('Body*')" />
                            <x-textarea id="body" name="body" class="block mt-1 w-full" placeholder="Main content of the post" rows="8">{{ old('body') }}</x-textarea>
                            @error('body') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>        
                
                        @if(config('blog.easyMDE.enabled'))
                        <x-markdown-editor :draft_id="$draft_id" />
                        @endif
                    </fieldset>
            
                    <fieldset>
                        <legend class="dark:text-white">Optional Fields</legend>

                        <div class="mt-3">
                            <x-label for="description" :value="__('Description')" />
                            <x-input id="description" name="description" :value="old('description')" type="text" class="block mt-1 w-full" maxlength="255" placeholder="The post excerpt"/>
                            @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                
                        <div class="mt-3">
                            <x-label for="featured_image" :value="__('Featured image URI')" />
                            <x-input id="featured_image" name="featured_image" :value="old('featured_image')" type="text" class="block mt-1 w-full" maxlength="255" placeholder="https://example.org/static/image.jpg"/>
                            @error('featured_image') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>

                        @if(config('blog.withTags'))
                        <livewire:tag-manager />
                        @endif
                    </fieldset>
            
                    <div class="flex items-center justify-end mt-4">
                        <x-button type="submit" class="ml-4">
                            {{ __('Save') }}
                        </x-button>
                    </div>
                </form>
			</section>
        </div>
    </div>
</x-app-layout>