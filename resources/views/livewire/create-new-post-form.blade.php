<div>
    <form wire:submit.prevent="save" class="text-gray-900">
        <div class="mt-3">
            <x-label for="post.title" :value="__('Title*')" />
            <x-input wire:model.defer="post.title" type="text" class="block mt-1 w-full" maxlength="255" required autofocus placeholder="The post title"/>
            @error('post.title') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mt-3">
            <x-label for="post.description" :value="__('Description')" />
            <x-input wire:model.defer="post.description" type="text" class="block mt-1 w-full" maxlength="255" placeholder="The post excerpt"/>
            @error('post.description') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mt-3">
            <x-label for="post.featured_image" :value="__('Featured image URI')" />
            <x-input wire:model.defer="post.featured_image" type="text" class="block mt-1 w-full" maxlength="255" placeholder="https://example.org/static/image.jpg"/>
            @error('post.featured_image') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mt-3">
            <x-label for="content" :value="__('Body*')" />
            <x-textarea id="content" name="content" wire:model.defer="post.body" class="block mt-1 w-full" placeholder="Main content of the post" rows="8"></x-textarea>
            @error('post.body') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>        

        @push('scripts')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
        <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
        <style>
            .editor-toolbar {
                background-color: #fff;
                opacity: 0.9;
            }
        </style>
        <script>
            // Initiate the editor
            var simplemde = new SimpleMDE({
                autosave: {
                    enabled: true,
                    uniqueId: 'draft-' + '{{ $draft_id }}',
                },
                forceSync: true,
            });

            // Fixes bug where livewire does not recognize the input of the texteditor
            simplemde.codemirror.on("change", function(){
                var contentarea = document.getElementById("content");
                contentarea.dispatchEvent(new Event('input'));
            });
        </script>
        @endpush

        <div class="flex items-center justify-end mt-4">
            <x-button class="ml-4">
                {{ __('Save') }}
            </x-button>
        </div>
    </form>
</div>