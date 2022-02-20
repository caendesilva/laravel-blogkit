<div class="mt-3">
    <x-label for="tags" :value="__('blog.Tags')" />
    {{-- Add a new tag --}}
    <div class="flex">
        <x-input list="existingTags" id="addTag" name="addTag" wire:model="addTag" wire:keydown.enter.prevent="addTag" type="text" class="w-full sm:w-fit mt-1 mr-3 form-select" maxlength="16" placeholder="Add a {{ __('blog.tag') }}"/>
        <x-button type="button" class="mt-1" wire:click="addTag">Add</x-button>
    </div>
    <div class="mt-1">
        @if(strlen($addTag) > 8)
        <span class="dark:text-gray-300">
            Tip: Short {{ __('blog.tag') }} names are best!
        </span>
        @endif
        @error('addTag') <span class="text-red-500">{{ $message }}</span> @enderror
        @error('tags') <span class="text-red-500">{{ $message }}</span> @enderror
    </div>

    @if($existingTags)
    <datalist id="existingTags" label="Existing tags">
        @foreach ($existingTags as $tag)
            <option>{{ ucwords($tag) }}</option>
        @endforeach
    </datalist>
    @endif

    @if($tags)
    <div class="mt-2">
        <label for="tags" class="dark:text-white">Added {{ __('blog.tags') }}:</label>
        <div class="flex -mx-1">
            @foreach ($tagsArray as $tag)
            <span class="bg-gray-300 dark:bg-gray-500 dark:text-black px-2 py-1 m-1 rounded-lg text-sm">{{ $tag }}</span>
            @endforeach
        </div>
    </div>
    @endif

    {{-- The actual json input we submit --}}
    <input wire:model="tags" id="tags" name="tags" type="hidden">
</div>
