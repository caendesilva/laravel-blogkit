@props(['commaseparated' => false])
<ul aria-label="The post has the following {{ __('blog.tags') }}" {{ $attributes->merge(['class' => 'flex flex-row flex-wrap -mx-1']) }}>
    @if($tags)
		@foreach ($tags as $tag)
			<li class="px-1 pb-1">
				<x-link title="{{ __('blog.posts_with_tag', ['tag' => $tag]) }}" :href="route('posts.index', ['filterByTag' => $tag])">
					{{ $tag }}{{ $commaseparated && !$loop->last ? ', ' : ''}}
				</x-link>
			</li>
		@endforeach
	@endif
</ul>