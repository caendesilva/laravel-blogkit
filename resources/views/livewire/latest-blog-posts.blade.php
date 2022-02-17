<div>
    <div class="flex flex-row flex-wrap justify-start">
        @foreach ($posts as $post)
            <x-post-card :post="$post" />
        @endforeach
    </div>
    
    <footer class="my-3 mx-auto px-5">
        {{ $posts->links() }}
    </footer>
</div>