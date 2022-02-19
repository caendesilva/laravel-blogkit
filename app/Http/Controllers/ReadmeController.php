<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Support\Str;

class ReadmeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * Layout idea by unnawut
     * @see https://github.com/GrahamCampbell/Laravel-Markdown/issues/67#issuecomment-266642762
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        abort_unless(config('blog.readme'), 404);

        // Generate formatted HTML from markdown
        $markdown = config('blog.torchlight.enabled')
            ? Markdown::convertToHtml(file_get_contents(base_path() . '/README.md')) // If Torchlight is enabled use the Markdown package
            : Str::markdown(file_get_contents(base_path() . '/README.md')); // Otherwise use the built in GitHub markdown parser
        
        $torchlightUsed = config('blog.torchlight.enabled') === true // Check if Torchlight is enabled and if attribution is enabled. If it is not, we don't need to search the text.
            && config('blog.torchlight.attribution') === true
            && str_contains($markdown, '<!-- Syntax highlighted by torchlight.dev -->')
                ? true
                : false;

        return view('layouts.markdown', [
            'markdown' => $markdown,
            'torchlightUsed' => $torchlightUsed ?? false,
        ]);
    }
}
