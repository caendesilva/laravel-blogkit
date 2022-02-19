@props(['draft_id'])

@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css">
<script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>
<script>
	// Initiate the editor
	var easyMDE = new EasyMDE({
		autosave: {
			enabled: true,
			uniqueId: 'draft-' + '{{ $draft_id }}',
		},
		forceSync: true,
		{!! config('blog.easyMDE.toolbar')
			? "showIcons: ". json_encode(config('blog.easyMDE.toolbars')[config('blog.easyMDE.toolbar')])
			: null
		!!}
	});
</script>
@endpush