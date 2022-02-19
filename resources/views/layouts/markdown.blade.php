<x-app-layout>
    <div class="relative flex items-top justify-center sm:items-center py-4 sm:pt-0">
        <div class="mx-auto sm:px-6 lg:px-8 my-16">
            <section class="bg-white rounded-lg shadow-md dark:bg-gray-800 py-4 px-6 dark:text-white">
				<div @class([ 'prose dark:prose-invert', 'torchlight' => $torchlightUsed])>
					{!! $markdown !!}
					@if($torchlightUsed)
					<div class="mt-5">
						<i>Syntax highlighting provided by <x-link href="https://torchlight.dev/" rel="noopener nofollow">torchlight.dev</x-link></i>
					</div>
					@endif
				</div>
			</section>
        </div>
    </div>
</x-app-layout>