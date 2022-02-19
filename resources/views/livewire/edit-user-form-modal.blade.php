<div>
    @if($show)
    <!-- Component by Flowbite https://flowbite.com/docs/components/modal/ - License MIT -->
    <div  id="editUserModal" role="dialog" aria-labelledby="editUserModalTitle" class="overflow-y-auto overflow-x-hidden fixed right-0 left-0 top-4 z-50 justify-center items-center h-modal md:h-full md:inset-0 flex">
        <div class="relative px-4 w-full max-w-2xl h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700" style="box-shadow: 0 0 100vw 100vw #00000080;">
                <!-- Modal header -->
                <div class="flex justify-between items-start p-5 rounded-t border-b dark:border-gray-600">
                    <h3 id="editUserModalTitle" class="text-xl font-semibold text-gray-900 lg:text-2xl dark:text-white">
                        Edit user <small class="opacity-75">#</small>{{ $user->id }} {{ $user->name }}
                    </h3>
                    <button title="Close dialog" wire:click="closeModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="editUserModal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6">
                    <form wire:submit.prevent="save" class="text-gray-900">
                        <fieldset>
                            <legend class="text-lg font-bold dark:text-white mb-3">Permissions:</legend>

                            <div>
                                <div class="flex flex-row">
                                    <x-label for="user.is_admin" :value="__('Is User Admin?')" />
                                    <x-input id="user.is_admin" type="checkbox" wire:model="user.is_admin" class="ml-2 cursor-pointer"/>
                                </div>
                                @error('user.is_admin') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>
                    
                            <div class="mt-3">
                                <div class="flex flex-row">
                                    <x-label for="user.is_author" :value="__('Is User Author?')" />
                                    <x-input id="user.is_author" type="checkbox" wire:model="user.is_author" class="ml-2 cursor-pointer"/>
                                </div>
                                @error('user.is_author') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>
                        </fieldset>
                    </form>
                
                    <fieldset class="mt-3">
                        <legend class="text-lg font-bold dark:text-white mb-3">Danger Zone:</legend>
                        @if(config('blog.bans'))
                        <div class="mb-2">
                            @if($user->is_banned)
                            <button type="button" wire:click="unbanUser" class="text-orange-700 dark:text-orange-500 font-medium disabled:opacity-75" wire:loading.attr="disabled">
                                Unban User
                            </button>
                            @else
                            <button type="button" wire:click="banUser" class="text-red-700 dark:text-red-500 font-medium disabled:opacity-75" wire:loading.attr="disabled">
                                Ban User
                            </button>
                            @endif
                        </div>
                        @endif
                        <form wire:submit.prevent="deleteUser">
                            <button onclick="return confirmUserDelete()" type="submit" class="text-red-700 dark:text-red-500 font-medium disabled:opacity-75" wire:loading.attr="disabled">
                                Delete User
                            </button>
                        </form>
                    </fieldset>

                    <div class="flex items-center justify-end mt-4">
                        <x-button-secondary type="button" wire:click="closeModal" data-modal-toggle="editUserModal" class="m-2">
                            Cancel
                        </x-button-secondary>
                        <x-button wire:click="save()" class="m-2">
                            Save
                        </x-button>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    @endif
    
    @push('scripts')
    <script>
        // Snippet by https://forum.laravel-livewire.com/u/shortbrownman
        document.onkeydown = function(e) {
            // If the user presses the escape key, close the modal
            if (e.keyCode == 27) {
                window.livewire.emit('closeModals')
            }
        };

        // Disable scrolling on the body when a modal is active.
        // Thanks to https://stackoverflow.com/users/5645843/kjdion84 for the idea of adding the width of the body, to prevent flicker
        Livewire.on('openEditUserModal', function () {
            let width = document.body.scrollWidth;
            document.body.classList.add('disable-scroll');
            document.body.style.width = width + 'px';

        })
        Livewire.on('modalClosed', function () {
            document.body.classList.remove('disable-scroll');
            document.body.style.width = 'auto';
        })
    </script>

    <script>
        function confirmUserDelete() {
            if (prompt('Are you sure you want to delete this user? It cannot be undone! Type "delete" to confirm.') == 'delete') {
                return true;
            } else {
		        alert('Canceled.');
                return false;
            }
            return false;
        }
    </script>
    @endpush
</div>