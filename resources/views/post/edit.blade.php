<x-app-layout>
    <x-slot name="title">
        Edit Post
    </x-slot>

    <div class="relative flex items-top justify-center sm:items-center py-4 sm:pt-0">
        <div class="max-w-5xl w-full mx-auto sm:px-6 lg:px-8 my-8 sm:my-16">
            @if($post->isFileBased())
            <div class="bg-red-300 overflow-hidden shadow-sm sm:rounded-lg mb-5">
                <div class="py-3 px-4 text-red-900">
                    Warning! This post was created using a markdown file. Changes made here may be overridden!
                </div>
            </div>
            @endif
            
            <h1 class="text-3xl font-bold dark:text-white mb-8 sm:my-3 text-center sm:text-left">Update Blog Post</h1>
            <section class="bg-white rounded-lg shadow-md dark:bg-gray-800 py-4 px-6 dark:text-white">
				<form action="{{ route('posts.update', $post) }}" method="POST" class="text-gray-900">
                    @method('PATCH')
                    @csrf
                    <fieldset>
                        <legend class="dark:text-white">Required Fields</legend>

                        <div class="mt-3">
                            <x-label for="title">
                                {{ __('Title*') }} <small>(Note that the slug will not change)</small>
                            </x-label>
                            <x-input id="title" name="title" :value="old('title') ?? $post->title" type="text" class="block mt-1 w-full" maxlength="255" required autofocus placeholder="The post title"/>
                            @error('title') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-3">
                            <x-label for="body" :value="__('Body*')" />
                            <x-textarea id="body" name="body" class="block mt-1 w-full" placeholder="Main content of the post" rows="8">{{ old('body') ?? $post->body }}</x-textarea>
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
                            <x-input id="description" name="description" :value="old('description') ?? $post->description" type="text" class="block mt-1 w-full" maxlength="255" placeholder="The post excerpt"/>
                            @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                
                        <div class="mt-3">
                            <x-label for="featured_image" :value="__('Featured image URI')" />
                            <x-input id="featured_image" name="featured_image" :value="old('featured_image') ?? $post->featured_image" type="text" class="block mt-1 w-full" maxlength="255" placeholder="https://example.org/static/image.jpg"/>
                            @error('featured_image') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="mt-3">
                            <x-label for="published_at" :value="__('When should the post be published?')" />
                            <div class="flex flex-row items-center">
                                <div>
                                    <x-input id="published_at" name="published_at" :value="optional($post->published_at)->format('Y-m-d\TH:i')" type="datetime-local" class="block mt-1 w-full" placeholder="{{ now() }}"/>
                                    @error('published_at') <span class="text-red-500">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            
                            <x-label for="published_at">
                                <small>You can also <button class="text-indigo-500 dark:text-indigo-300" title="Clear the input field" type="button" role="button" onclick="clearPublishedAtInput()">leave it blank</button> to save the post as a draft.</small>
                            </x-label>
                        </div>

                        @if(config('blog.withTags'))
                        <livewire:tag-manager :currenttags="$post->tags" />
                        @endif
                    </fieldset>

                    <div class="flex items-center justify-end mt-4 mb-2">
                        <div>
                            <div class="flex flex-row items-center">
                                <x-label class="cursor-pointer" for="is_draft" :value="__('Save as draft')" title="Saves the post without a publish date, making it hidden."/>
                                <x-input id="is_draft" name="is_draft" value="1" :checked="old('is_draft') || isset($post) && $post->published_at === null" type="checkbox" class="block mx-2 cursor-pointer" title="Press to toggle"/>
                            </div>
                            @error('is_draft') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <x-button type="submit" class="ml-4">
                            {{ __('Save') }}
                        </x-button>
                    </div>
                </form>
			</section>
        </div>
    </div>

    @push('scripts')
    <script>
        function clearPublishedAtInput() { 
            document.getElementById('published_at').value = null;
        }
    </script>
    @endpush
</x-app-layout>