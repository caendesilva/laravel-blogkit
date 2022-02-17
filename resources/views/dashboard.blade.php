<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dark:text-white">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-5">
                <div class="p-6 bg-white dark:bg-gray-800">
                    You're logged in!
                </div>
            </div>

            @if (session('success'))
            <div class="bg-green-300 overflow-hidden shadow-sm sm:rounded-lg mb-5">
                <div class="py-3 px-4 text-green-900">
                    {{ session('success') }}
                </div>
            </div>
            @endif

            <section class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-5">
                <div class="p-6 bg-white dark:bg-gray-800">
                    <header class="flex flex-row justify-between items-center">
                        <h3 class="text-xl font-bold mb-5">Manage Posts</h3>
                        @can('create', App\Models\Post::class)
                        <x-button class="mb-5">
                            <a href="{{ route('post.create') }}">New Post</a>
                        </x-button>
                        @endcan
                    </header>

                    @if($posts)
                    <!-- Desktop Version -->
                    <div class="hidden sm:block">
                        <table class="w-full table-auto border-collapse border border-slate-500">
                            <thead>
                                <tr>
                                    <th class="bg-gray-100 dark:bg-gray-900 border border-slate-600 p-3">Author</th>
                                    <th class="bg-gray-100 dark:bg-gray-900 border border-slate-600 p-3">Title</th>
                                    <th class="bg-gray-100 dark:bg-gray-900 border border-slate-600 p-3">Date</th>
                                    <th class="bg-gray-100 dark:bg-gray-900 border border-slate-600 p-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray:700 dark:text-gray-300">
                                @foreach ($posts as $post)
                                <tr>
                                    <td class="dark:bg-slate-800 border border-slate-600 p-3 lg:py-2">
                                        <a href="{{ route('author', ['user' => $post->author]) }}" rel="author" class="hover:text-indigo-500">
                                            {{ $post->author->name }}
                                        </a>
                                    </td>
                                    <td class="dark:bg-slate-800 border border-slate-600 p-3 lg:py-2">
                                        <a href="{{ route('post.show', ['post' => $post]) }}" class="hover:text-indigo-500">
                                            {{ $post->title }}
                                        </a>
                                    </td>
                                    <td class="dark:bg-slate-800 border border-slate-600 p-3 lg:py-2">
                                        {{ $post->created_at->format('Y-m-d')}}
                                    </td>
                                    <td class="dark:bg-slate-800 border border-slate-600 p-3 lg:py-2 text-center">
                                        @can('update', $post)
                                        <a href="{{ route('post.edit', ['post' => $post]) }}">
                                            Edit
                                        </a>
                                        @endcan
                                        @can('delete', $post)
                                        <form action="{{ route('post.destroy', ['post' => $post]) }}" method="POST" class="inline ml-3" onSubmit="return confirm('Are you sure you want to delete this post?')">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit">Delete</button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Mobile Version -->
                    <div class="sm:hidden">
                        <table class="w-full table-auto">
                            @foreach ($posts as $post)
                            <tbody class="text-gray:700 dark:text-gray-300">
                                <tr>
                                    <th class="bg-gray-100 dark:bg-gray-900 border border-slate-600 p-3">Title</th>
                                    <th class="bg-gray-100 dark:bg-gray-900 border border-slate-600 p-3 lg:py-2 text-left">
                                        <a href="{{ route('post.show', ['post' => $post]) }}" class="hover:text-indigo-500">
                                            {{ $post->title }}
                                        </a>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="bg-gray-100 dark:bg-gray-900 border border-slate-600 p-3">Author</th>

                                    <td class="dark:bg-slate-800 border border-slate-600 p-3 lg:py-2">
                                        <a href="{{ route('author', ['user' => $post->author]) }}" rel="author" class="hover:text-indigo-500">
                                            {{ $post->author->name }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-gray-100 dark:bg-gray-900 border border-slate-600 p-3">Date</th>
                                    <td class="dark:bg-slate-800 border border-slate-600 p-3 lg:py-2">
                                        {{ $post->created_at->format('Y-m-d')}}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-gray-100 dark:bg-gray-900 border border-slate-600 p-3">Actions</th>
                                    <td class="dark:bg-slate-800 border border-slate-600 p-3 lg:py-2">
                                        @can('update', $post)
                                        <a href="{{ route('post.edit', ['post' => $post]) }}">
                                            Edit
                                        </a>
                                        @endcan
                                        @can('delete', $post)
                                        <form action="{{ route('post.destroy', ['post' => $post]) }}" method="POST" class="inline ml-3" onSubmit="return confirm('Are you sure you want to delete this post?')">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit">Delete</button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                                <!-- Spacer Row -->
                                <tr role="none">
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                            </tbody>
                            @endforeach
                        </table>
                    </div>
                    @endif
                </div>
            </section>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-5">
                <div class="p-6 bg-white dark:bg-gray-800">
                   <h3 class="text-xl font-bold mb-3">Manage Users</h3> 
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
