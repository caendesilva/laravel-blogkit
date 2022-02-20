<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\MarkdownConverter;

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
        $markdown = (new MarkdownConverter(file_get_contents(base_path() . '/README.md')))->toHtml();

        // Set the page title
        View::share('title', 'Readme');

        return view('layouts.markdown', [
            'markdown' => $markdown,
        ]);
    }
}
