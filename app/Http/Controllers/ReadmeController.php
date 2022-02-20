<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use GrahamCampbell\Markdown\Facades\Markdown;

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
        $markdown = Markdown::convertToHtml(file_get_contents(base_path() . '/README.md'));

        $torchlightUsed = config('blog.torchlight.enabled') === true // Check if Torchlight is enabled and if attribution is enabled. If it is not, we don't need to search the text.
            && config('blog.torchlight.attribution') === true
            && str_contains($markdown, '<!-- Syntax highlighted by torchlight.dev -->')
                ? true
                : false;

        // Set the page title
        View::share('title', 'Readme');

        return view('layouts.markdown', [
            'markdown' => $markdown,
            'torchlightUsed' => $torchlightUsed ?? false,
        ]);
    }
}
