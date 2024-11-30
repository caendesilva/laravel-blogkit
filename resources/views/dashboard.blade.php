<x-app-layout>
    <x-slot name="title">
        Dashboard
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dark:text-white">
            @if(session('success'))
            <div class="bg-green-300 overflow-hidden shadow-sm sm:rounded-lg mb-5">
                <div class="py-3 px-4 text-green-900">
                    {{ session('success') }}
                </div>
            </div>
            @endif

            @if(config('blog.demoMode'))
            <section class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-5 text-black dark:text-white">
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-1">App is in demo mode!</h3>
                    <strong>User created posts are hidden from the blog index and the database is reset every six hours.</strong>
                </div>
            </section>
            @endif

            @if($posts)
            <section class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-5">
                <div class="p-6 bg-white dark:bg-gray-800">
                    <header class="flex flex-row justify-between items-center">
                        <h3 class="text-xl font-bold mb-5">Manage Posts</h3>
                        @can('create', App\Models\Post::class)
                        <a href="{{ route('posts.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-100 border border-transparent rounded-md font-semibold text-xs text-white dark:text-black uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-300 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mb-5">New Post</a>
                        @endcan
                    </header>

                    @if($posts)
                    <!-- Desktop Version -->
                    <div class="hidden sm:block overflow-y-auto" style="max-height: 75vh;">
                        <table class="w-full table-auto border-collapse border border-slate-500">
                            <thead>
                                <tr>
                                    <x-th>Author</x-th>
                                    <x-th>Title</x-th>
                                    <x-th>Published</x-th>
                                    <x-th>Actions</x-th>
                                </tr>
                            </thead>
                            <tbody class="text-gray:700 dark:text-gray-300">
                                @foreach ($posts as $post)
                                <tr class="group">
                                    <x-td>
                                        <a href="{{ route('posts.index', ['author' => $post->author]) }}" rel="author" class="hover:text-indigo-500">
                                            {{ $post->author->name }}
                                        </a>
                                    </x-td>
                                    <x-td>
                                        <div class="overflow-hidden text-ellipsis">
                                            <a href="{{ route('posts.show', ['post' => $post]) }}" class="hover:text-indigo-500">
                                                {{ $post->title }}
                                            </a>
                                        </div>
                                    </x-td>
                                    <x-td>
                                        @if($post->isPublished())
                                        <span title="{{ $post->published_at }}">{{ $post->published_at->format('Y-m-d') }}</span>
                                        @else
                                        <span class="rounded-lg bg-gray-400 text-gray-900 px-2 py-1 text-xs uppercase font-bold" title="This post has not yet been published.">Draft</span>
                                        @can('update', $post)
                                        <form action="{{ route('posts.publish', ['post' => $post]) }}" method="POST" class="inline ml-2">
                                            @csrf
                                            <button type="submit" title="Click to publish the post" class="rounded-lg opacity-0 group-hover:opacity-100 transition-opacity bg-green-400 text-green-900 px-2 py-1 text-xs uppercase font-bold">Publish</button>
                                        </form>
                                        @endcan
                                        @endif
                                    </x-td>
                                    <x-td class="text-center">
                                        @can('update', $post)
                                        <a href="{{ route('posts.edit', ['post' => $post]) }}">
                                            Edit
                                        </a>
                                        @endcan
                                        @can('delete', $post)
                                        <form action="{{ route('posts.destroy', ['post' => $post]) }}" method="POST" class="inline ml-3" onSubmit="return confirm('Are you sure you want to delete this post?')">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit">Delete</button>
                                        </form>
                                        @endcan
                                    </x-td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Mobile Version -->
                    <div class="sm:hidden overflow-y-auto" style="max-height: 75vh;">
                        <table class="w-full table-auto">
                            @foreach ($posts as $post)
                            <tbody class="text-gray:700 dark:text-gray-300">
                                <tr>
                                    <x-th>Title</x-th>
                                    <x-th class="lg:py-2 text-left">
                                        <a href="{{ route('posts.show', ['post' => $post]) }}" class="hover:text-indigo-500">
                                            {{ $post->title }}
                                        </a>
                                    </x-th>
                                </tr>
                                <tr>
                                    <x-th>Author</x-th>

                                    <x-td>
                                        <a href="{{ route('posts.index', ['author' => $post->author]) }}" rel="author" class="hover:text-indigo-500">
                                            {{ $post->author->name }}
                                        </a>
                                    </x-td>
                                </tr>
                                <tr>
                                    <x-th>Published</x-th>
                                    <x-td>
                                        @if($post->isPublished())
                                        <span title="{{ $post->published_at }}">{{ $post->published_at->format('Y-m-d') }}</span>
                                        @else
                                        <span class="rounded-lg bg-gray-400 text-gray-900 px-2 py-1 text-xs uppercase font-bold" title="This post has not yet been published.">Draft</span>
                                        @can('update', $post)
                                        <form action="{{ route('posts.publish', ['post' => $post]) }}" method="POST" class="inline ml-2">
                                            @csrf
                                            <button type="submit" title="Click to publish the post" class="rounded-lg opacity-0 group-hover:opacity-100 transition-opacity bg-green-400 text-green-900 px-2 py-1 text-xs uppercase font-bold">Publish</button>
                                        </form>
                                        @endcan
                                        @endif
                                    </x-td>
                                </tr>
                                <tr>
                                    <x-th>Actions</x-th>
                                    <x-td>
                                        @can('update', $post)
                                        <a href="{{ route('posts.edit', ['post' => $post]) }}">
                                            Edit
                                        </a>
                                        @endcan
                                        @can('delete', $post)
                                        <form action="{{ route('posts.destroy', ['post' => $post]) }}" method="POST" class="inline ml-3" onSubmit="return confirm('Are you sure you want to delete this post?')">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit">Delete</button>
                                        </form>
                                        @endcan
                                    </x-td>
                                </tr>
                                <!-- Spacer Row -->
                                <tr role="none">
                                    <x-td colspan="2">&nbsp;</x-td>
                                </tr>
                            </tbody>
                            @endforeach
                        </table>
                    </div>
                    @endif
                </div>
            </section>
            @endif

            @if($users)
            <section class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg my-5 mt-10">
                <header class="bg-white dark:bg-gray-800">
                   <h3 class="text-xl font-bold mb-5">Manage Users</h3> 
                </header>

                <!-- Desktop Version -->
                <div class="hidden sm:block overflow-y-auto" style="max-height: 75vh;">
                    <table class="w-full table-auto border-collapse border border-slate-500">
                        <thead>
                            <tr>
                                <x-th>ID</x-th>
                                <x-th>Name</x-th>
                                <x-th>Email</x-th>
                                <x-th>Role</x-th>
                                <x-th>Actions</x-th>
                            </tr>
                        </thead>
                        <tbody class="text-gray:700 dark:text-gray-300">
                            @foreach ($users as $user)
                            <tr>
                                <x-td>
                                    <a href="{{ route('posts.index', ['author' => $user]) }}" rel="author" class="hover:text-indigo-500">
                                        <small class="opacity-75">#</small>{{ $user->id }}
                                    </a>
                                </x-td>
                                <x-td>
                                    <a href="{{ route('posts.index', ['author' => $user]) }}" rel="author" class="hover:text-indigo-500">
                                        {{ $user->name }}
                                    </a>
                                </x-td>
                                <x-td>
                                    {{ $user->email }}
                                    @if($user->email_verified_at)
                                        <span title="Email Verified">
                                            <!-- Icon by Google Material Icons (License: MIT) -->
                                            <svg class="fill-green-400 inline" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                                        </span>
                                    @endif
                                </x-td>
                                <x-td>
                                    <div class="flex flex-row flex-wrap">
                                        @if($user->is_admin)
                                        <span class="rounded-lg bg-orange-400 text-orange-900 px-2 py-1 text-xs uppercase font-bold m-1">Admin</span>                                    
                                        @endif
                                        @if($user->is_author)
                                        <span class="rounded-lg bg-blue-400 text-blue-900 px-2 py-1 text-xs uppercase font-bold m-1">Author</span>                                    
                                        @endif
                                        @if($user->is_banned)
                                        <span class="rounded-lg bg-red-400 text-red-900 px-2 py-1 text-xs uppercase font-bold m-1">Banned</span>                                    
                                        @endif
                                    </div>
                                </x-td>
                                <x-td class="text-center">
                                    <button onclick="openEditUserModal('{{ $user->id }}')">
                                        Manage
                                    </button>
                                </x-td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Mobile Version -->
                <div class="sm:hidden overflow-y-auto" style="max-height: 75vh;">
                    <table class="w-full table-auto">
                        @foreach ($posts as $post)
                        <tbody class="text-gray:700 dark:text-gray-300">
                            <tr>
                                <x-th>User</x-th>
                                <x-th class="lg:py-2 text-left">
                                    <a href="{{ route('posts.index', ['author' => $user]) }}" rel="author" class="hover:text-indigo-500">
                                        <small class="opacity-75">#</small>{{ $user->id }}
                                        {{ $user->name }}
                                    </a>
                                </x-th>
                            </tr>
                           
                            <tr>
                                <x-th>Email</x-th>
                                <x-td>
                                    <div class="break-all">
                                        {{ $user->email }}
                                        @if($user->email_verified_at)
                                            <span title="Email Verified">
                                                <!-- Icon by Google Material Icons (License: MIT) -->
                                                <svg class="fill-green-400 inline" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                                            </span>
                                        @endif
                                    </div>
                                </x-td>
                            </tr>
                            <tr>
                                <x-th>Role</x-th>
                                <x-td>
                                    <div class="flex flex-row flex-wrap">
                                        @if($user->is_admin)
                                        <span class="rounded-lg bg-orange-400 text-orange-900 px-2 py-1 text-xs uppercase font-bold m-1">Admin</span>                                    
                                        @endif
                                        @if($user->is_author)
                                        <span class="rounded-lg bg-blue-400 text-blue-900 px-2 py-1 text-xs uppercase font-bold m-1">Author</span>                                    
                                        @endif
                                        @if($user->is_banned)
                                        <span class="rounded-lg bg-red-400 text-red-900 px-2 py-1 text-xs uppercase font-bold m-1">Banned</span>                                    
                                        @endif
                                    </div>
                                </x-td>
                            </tr>
                            <tr>
                                <x-th>Actions</x-th>
                             
                                <x-td>
                                    <button onclick="openEditUserModal('{{ $user->id }}')">
                                        Manage
                                    </button>
                                </x-td>
                            </tr>
                            <!-- Spacer Row -->
                            <tr role="none">
                                <x-td colspan="2">&nbsp;</x-td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
            </section>



            
            @if($comments)
            <section class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg my-5 mt-10">
                <header class="bg-white dark:bg-gray-800">
                   <h3 class="text-xl font-bold mb-5">Manage Comments</h3> 
                </header>
                
                @if(!$comments->count())
                    There are no comments here.
                @else
                <!-- Desktop Version -->
                <div class="hidden sm:block overflow-y-auto" style="max-height: 75vh;">
                    <table class="w-full table-auto border-collapse border border-slate-500">
                        <thead>
                            <tr>
                                <x-th>User</x-th>
                                <x-th>Post</x-th>
                                <x-th>Comment</x-th>
                                <x-th>Actions</x-th>
                            </tr>
                        </thead>
                        <tbody class="text-gray:700 dark:text-gray-300">
                            @foreach ($comments as $comment)
                            <tr>
                                <x-td>
                                    <a href="{{ route('posts.index', ['author' => $comment->user]) }}" rel="author" class="hover:text-indigo-500">
                                        <small class="opacity-75">#</small>{{ $comment->user->id }}
                                        {{ $comment->user->name }}
                                    </a>
                                </x-td>
                                <x-td>
                                    <a href="{{ route('posts.show', $comment->post) }}" class="hover:text-indigo-500">
                                        <small class="opacity-75">#</small>{{ $comment->post->id }}
                                        {{ $comment->post->title }}
                                    </a>
                                </x-td>
                                <x-td>
                                    {{ $comment->content }}
                                </x-td>
                                <x-td class="text-center">
                                    <div class="flex justify-center">
                                        @can('update', $comment)
                                        <a class="mx-2" href="{{ route('comments.edit', ['comment' => $comment]) }}">
                                            Edit
                                        </a>
                                        @endcan
                                        @can('delete', $comment)
                                        <form class="mx-2" action="{{ route('comments.destroy', ['comment' => $comment]) }}" method="POST" onSubmit="return confirm('Are you sure you want to delete this comment?')">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit">Delete</button>
                                        </form>
                                        @endcan
                                    </div>
                                </x-td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Version -->
                <div class="sm:hidden overflow-y-auto" style="max-height: 75vh;">
                    <table class="w-full table-auto">
                        @foreach ($posts as $post)
                        <tbody class="text-gray:700 dark:text-gray-300">
                            <tr>
                                <x-th>User</x-th>
                                <x-td>
                                    <a href="{{ route('posts.index', ['author' => $comment->user]) }}" rel="author" class="hover:text-indigo-500">
                                        <small class="opacity-75">#</small>{{ $comment->user->id }}
                                        {{ $comment->user->name }}
                                    </a>
                                </x-td>
                            </tr>
                            <tr>
                                <x-th>Post</x-th>
                                <x-td>
                                    <a href="{{ route('posts.show', $comment->post) }}" class="hover:text-indigo-500">
                                        <small class="opacity-75">#</small>{{ $comment->post->id }}
                                        {{ $comment->post->title }}
                                    </a>
                                </x-td>
                            </tr>
                            <tr>
                                <x-th>Comment</x-th> 
                                <x-td>
                                    {{ $comment->content }}
                                </x-td>
                            </tr>
                            <tr>
                                <x-th>Actions</x-th>
                                <x-td>
                                    @can('update', $comment)
                                    <a href="{{ route('comments.edit', ['comment' => $comment]) }}">
                                        Edit
                                    </a>
                                    @endcan
                                    @can('delete', $comment)
                                    <form action="{{ route('comments.destroy', ['comment' => $comment]) }}" method="POST" onSubmit="return confirm('Are you sure you want to delete this comment?')">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit">Delete</button>
                                    </form>
                                    @endcan
                                </x-td>
                            </tr>
                            <!-- Spacer Row -->
                            <tr role="none">
                                <x-td colspan="2">&nbsp;</x-td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
                @endif
            </section>
            @endif

            @if(isset($analytics))
            <section class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg my-5">
                <div class="p-6">
                    <header class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold">Analytics Overview</h3>
                    </header>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                            <div class="text-2xl font-bold">{{ number_format($analytics['total_views']) }}</div>
                            <div class="text-gray-600 dark:text-gray-400">Total Page Views</div>
                        </div>
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                            <div class="text-2xl font-bold">{{ number_format($analytics['unique_visitors']) }}</div>
                            <div class="text-gray-600 dark:text-gray-400">Unique Visitors</div>
                        </div>
                    </div>

                    <!-- Traffic Chart -->
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold mb-2">Traffic (Last 30 Days)</h4>
                        <canvas id="trafficChart" height="200" style="max-height: 200px;"></canvas>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Popular Pages -->
                        <div>
                            <h4 class="text-lg font-semibold mb-2">Popular Pages</h4>
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr>
                                            <x-th>Page</x-th>
                                            <x-th>Visitors</x-th>
                                            <x-th>Views</x-th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($analytics['popular_pages'] as $page)
                                        <tr>
                                            <x-td>{{ $page->page }}</x-td>
                                            <x-td>{{ number_format($page->visitors) }}</x-td>
                                            <x-td>{{ number_format($page->views) }}</x-td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Top Referrers -->
                        <div x-data="{ activeTab: 'referrers' }">
                            <header class="flex space-x-2 mb-2">
                                <button @click="activeTab = 'referrers'" 
                                        :class="{ 'opacity-100 font-semibold': activeTab === 'referrers', 'opacity-50': activeTab !== 'referrers' }"
                                        class="text-lg">
                                    Referrers
                                </button>
                                <button @click="activeTab = 'refs'" 
                                        :class="{ 'opacity-100 font-semibold': activeTab === 'refs', 'opacity-50': activeTab !== 'refs' }"
                                        class="text-lg">
                                    Refs
                                </button>
                            </header>

                            <!-- Referrers Table -->
                            <div x-show="activeTab === 'referrers'" class="overflow-x-auto" x-cloak>
                                <table class="w-full">
                                    <thead>
                                        <tr>
                                            <x-th>Source</x-th>
                                            <x-th>Visitors</x-th>
                                            <x-th>Views</x-th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($analytics['top_referrers'] as $referrer)
                                        <tr>
                                            <x-td>{{ $referrer->referrer ?: 'Direct / Unknown' }}</x-td>
                                            <x-td>{{ number_format($referrer->visitors) }}</x-td>
                                            <x-td>{{ number_format($referrer->views) }}</x-td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Refs Table -->
                            <div x-show="activeTab === 'refs'" class="overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr>
                                            <x-th>Refs</x-th>
                                            <x-th>Visitors</x-th>
                                            <x-th>Views</x-th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($analytics['top_refs'] as $ref)
                                        <tr>
                                            <x-td>{{ Str::after($ref->referrer, '?ref=') }}</x-td>
                                            <x-td>{{ number_format($ref->visitors) }}</x-td>
                                            <x-td>{{ number_format($ref->views) }}</x-td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                const ctx = document.getElementById('trafficChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($analytics['traffic_data']['dates']),
                        datasets: [{
                            label: 'Page Views',
                            data: @json($analytics['traffic_data']['views']),
                            borderColor: 'rgb(59, 130, 246)',
                            tension: 0.1
                        }, {
                            label: 'Unique Visitors',
                            data: @json($analytics['traffic_data']['unique']),
                            borderColor: 'rgb(239, 68, 68)',
                            tension: 0.1
                        }]
                    },
                    options: {
                        responsive: true,
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
            @endpush
            @endif

            @push('scripts')
            <livewire:edit-user-form-modal />

            <script>
                /**
                 * Open the Livewire Edit User Modal
                 * 
                 * @param integer (user) id
                 */
                function openEditUserModal(id) {
                    Livewire.dispatch('openEditUserModal', { id: id });
                }
            </script>
            @endpush
            @endif
        </div>
    </div>
</x-app-layout>