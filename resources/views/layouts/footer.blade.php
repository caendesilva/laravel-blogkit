<!-- You will probably want to customize this component. -->

@props([
	'showCopyright' => true,
	'copyrightStart' => 2022,
	
	'showLicense' => true,
	'appLicense' => [
		'name' => 'MIT',
		'link' => 'https://opensource.org/licenses/MIT/'
	],
	
	'contentLicense' => [
		'name' => config('blog.contentLicense.name'),
		'link' => config('blog.contentLicense.link')
	],

	'showCredit' => true,

	'showGithub' => true,
	'github' => [
		'user' => 'caendesilva',
		'repo' => 'laravel-blogkit',
	],

	'showVersion' => true,
])

<footer class="w-full mt-auto p-5 pt-6 bg-gray-500 bg-opacity-10 text-gray-700 dark:text-gray-300 text-center">
	@if($showCopyright)
	<div class="mx-3">
		<small class="text-sm">
			Copyright &copy;
			{{ $copyrightStart != date('Y')
				? $copyrightStart . "-" . date('Y')
				: $copyrightStart
			}}
			{{ config('app.name') }}
		</small>
	</div>
	@endif
	
	@if($showLicense || $showVersion)
	<div class="mx-3">
		@if($showLicense)
		<small class="text-sm mx-1">
			@if($appLicense === $contentLicense)
			License: <x-link :href="$appLicense['link']" rel="license noopener noreferrer nofollow" class="dark:opacity-90 hover:opacity-100">{{ $appLicense['name'] }}</x-link>
			@else
			App License: <x-link :href="$appLicense['link']" rel="license noopener noreferrer nofollow" class="dark:opacity-90 hover:opacity-100">{{ $appLicense['name'] }}</x-link>
			&nbsp;
			Content License: <x-link :href="$contentLicense['link']" rel="license noopener noreferrer nofollow" class="dark:opacity-90 hover:opacity-100">{{ $contentLicense['name'] }}</x-link>
			@endif
		</small>
		@endif
		@if($showVersion)
		<small class="text-sm mx-1">
			App Version:
			v{{ \App\Providers\BlogServiceProvider::BLOGKIT_VERSION }}
		</small>
		@endif
	</div>
	@endif

	@if($showCredit)
	<p class="mt-3">
		This site was built using the free and open source
		<x-link href="https://github.com/caendesilva/laravel-blogkit/">Laravel Blog Starter Kit</x-link>!
	</p>
	@endif
	@if($showGithub)
	<div class="flex flex-wrap justify-center gh-buttons">
		<!-- Buttons forked by https://ghbtns.com/ (License: Apache 2) -->
		<!-- Feel free to remove or comment out the buttons you don't want! -->
		<style>.gh-buttons{padding:0;margin:0;overflow:hidden;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif;font-size:11px;font-weight:700;line-height:14px}.github-btn{height:20px;overflow:hidden}.gh-btn,.gh-count,.gh-ico{float:left}.gh-btn,.gh-count{padding:2px 5px 2px 4px;color:#333;text-decoration:none;white-space:nowrap;cursor:pointer;border-radius:3px}.gh-btn{background-color:#eee;background-image:-webkit-gradient(linear,left top,left bottom,color-stop(0,#fcfcfc),to(#eee));background-image:linear-gradient(to bottom,#fcfcfc 0,#eee 100%);background-repeat:no-repeat;border:1px solid #d5d5d5}.gh-btn:focus,.gh-btn:hover{text-decoration:none;background-color:#ddd;background-image:-webkit-gradient(linear,left top,left bottom,color-stop(0,#eee),to(#ddd));background-image:linear-gradient(to bottom,#eee 0,#ddd 100%);border-color:#ccc}.gh-btn:active{background-color:#dcdcdc;background-image:none;border-color:#b5b5b5;box-shadow:inset 0 2px 4px rgba(0,0,0,.15)}.gh-ico{width:14px;height:14px;margin-right:4px;background:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40' viewBox='12 12 40 40'%3e%3cpath fill='%23333' d='M32 13.4c-10.5 0-19 8.5-19 19 0 8.4 5.5 15.5 13 18 1 .2 1.3-.4 1.3-.9v-3.2c-5.3 1.1-6.4-2.6-6.4-2.6-.9-2.1-2.1-2.7-2.1-2.7-1.7-1.2.1-1.1.1-1.1 1.9.1 2.9 2 2.9 2 1.7 2.9 4.5 2.1 5.5 1.6.2-1.2.7-2.1 1.2-2.6-4.2-.5-8.7-2.1-8.7-9.4 0-2.1.7-3.7 2-5.1-.2-.5-.8-2.4.2-5 0 0 1.6-.5 5.2 2 1.5-.4 3.1-.7 4.8-.7 1.6 0 3.3.2 4.7.7 3.6-2.4 5.2-2 5.2-2 1 2.6.4 4.6.2 5 1.2 1.3 2 3 2 5.1 0 7.3-4.5 8.9-8.7 9.4.7.6 1.3 1.7 1.3 3.5v5.2c0 .5.4 1.1 1.3.9 7.5-2.6 13-9.7 13-18.1 0-10.5-8.5-19-19-19z'/%3e%3c/svg%3e") 0 0/100% 100% no-repeat}.gh-count{position:relative;display:none;margin-left:4px;background-color:#fafafa;border:1px solid #d4d4d4}.gh-count:focus,.gh-count:hover{color:#0366d6}.gh-count::after,.gh-count::before{position:absolute;display:inline-block;width:0;height:0;content:"";border-color:transparent;border-style:solid}.gh-count::before{top:50%;left:-3px;margin-top:-4px;border-width:4px 4px 4px 0;border-right-color:#fafafa}.gh-count::after{top:50%;left:-4px;z-index:-1;margin-top:-5px;border-width:5px 5px 5px 0;border-right-color:#d4d4d4}.github-btn-large{height:30px}.github-btn-large .gh-btn,.github-btn-large .gh-count{padding:3px 10px 3px 8px;font-size:16px;line-height:22px;border-radius:4px}.github-btn-large .gh-ico{width:20px;height:20px}.github-btn-large .gh-count{margin-left:6px}.github-btn-large .gh-count::before{left:-5px;margin-top:-6px;border-width:6px 6px 6px 0}.github-btn-large .gh-count::after{left:-6px;margin-top:-7px;border-width:7px 7px 7px 0}</style>
		<!-- Star -->
		<span class="my-3 mx-2 github-btn github-stargazers"><a class="gh-btn" href="https://github.com/{{ $github['user'] }}/{{ $github['repo'] }}" rel="noopener" target="_blank" aria-label="Star {{ $github['user'] }}/{{ $github['repo'] }} on GitHub"><span class="gh-ico" aria-hidden="true"></span> <span class="gh-text">Star</span> </a></span>
		<!-- Source Code -->
		<span class="my-3 mx-2 github-btn github-me"><a class="gh-btn" href="https://github.com/{{ $github['user'] }}/{{ $github['repo'] }}" rel="noopener" target="_blank" aria-label="Source Code on GitHub"><span class="gh-ico" aria-hidden="true"></span> <span class="gh-text">Source Code</span> </a></span>
		<!-- Follow -->
		<span class="my-3 mx-2 github-btn github-me"><a class="gh-btn" href="https://github.com/{{ $github['user'] }}" rel="noopener author" target="_blank" aria-label="Follow (at){{ $github['user'] }} on GitHub"><span class="gh-ico" aria-hidden="true"></span> <span class="gh-text">Follow &commat;{{ $github['user'] }}</span> </a></span>
	</div>
	@endif

	
</footer>