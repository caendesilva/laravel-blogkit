<div>
    <form wire:submit.prevent="save" class="text-gray-900">
        <div class="mt-3">
            <x-label for="post.title" :value="__('Title')" />
            <x-input type="text" class="block mt-1 w-full" maxlength="255" readonly value="{{ $post->title }}"/>
        </div>

        <div class="mt-3">
            <x-label for="post.description" :value="__('Description')" />
            <x-input wire:model="post.description" type="text" class="block mt-1 w-full" maxlength="255" placeholder="The post excerpt"/>
            @error('post.description') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mt-3">
            <x-label for="post.featured_image" :value="__('Featured image URI')" />
            <x-input wire:model="post.featured_image" type="text" class="block mt-1 w-full" maxlength="255" placeholder="https://example.org/static/image.jpg"/>
            @error('post.featured_image') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mt-3">
            <x-label for="post.body" :value="__('Body*')" />
            <x-textarea wire:model="post.body" class="block mt-1 w-full" required placeholder="Main content of the post" rows="8"></x-textarea>
            @error('post.body') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-button class="ml-4">
                {{ __('Save') }}
            </x-button>
        </div>
    </form>
</div>
