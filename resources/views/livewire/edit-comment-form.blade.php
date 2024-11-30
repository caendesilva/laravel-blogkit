<div class="relative flex items-top justify-center sm:items-center py-4 sm:pt-0">
    <div class="max-w-2xl w-full mx-auto sm:px-6 lg:px-8 my-16">
        <h1 class="text-3xl font-bold dark:text-white my-3">Update Comment</h1>
        <section class="bg-white rounded-lg shadow-md dark:bg-gray-800 py-6 px-6 dark:text-white">
            <form wire:submit.prevent="save" class="text-gray-900">
                <x-textarea wire:model="content" class="w-full" placeholder="Update comment" rows="8" required maxlength="1024"></x-textarea>
                <div>@error('content') <span class="text-red-500">{{ $message }}</span> @enderror</div>
        
                <div class="flex items-center justify-end mt-4">
                    <x-button-secondary :href="route('posts.show', $comment->post) . '#comment-' . $this->comment->id">
                        Cancel
                    </x-button-secondary>
                    <x-button class="ml-4">
                        {{ __('Update') }}
                    </x-button>
                </div>
            </form>
        </section>
    </div>
</div>