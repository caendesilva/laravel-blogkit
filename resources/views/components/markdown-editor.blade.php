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
<style>
	/* Fix for overflow bug in EasyMDE */
	.EasyMDEContainer {
		overflow-x: auto!important;
		width: calc(100vw - 4rem)!important;
	}
	@media screen and (min-width: 640px) {
		.EasyMDEContainer {
			width: calc(100vw - 7rem)!important;
		}
	}
	@media screen and (min-width: 1024px) {
		.EasyMDEContainer {
			width: 912px!important;
		}
	}
</style>
@endpush