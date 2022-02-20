<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GrahamCampbell\Markdown\Facades\Markdown;

class MarkdownConverter extends Controller
{
    /**
     * @var string $markdown source
     */
    private string $markdown;

    /**
     * @var string $html generated
     */
    private string $html;

    /**
     * Construct the class.
     * 
     * @param string $markdown
     */
    public function __construct(string $markdown) {
        $this->markdown = $markdown;
    }

    /**
     * Generate the markdown.
     * 
     * @return string $html
     */
    public function toHtml()
    {
        $this->html = (string) Markdown::convertToHtml($this->markdown);

        if ($this->usesTorchlight()) {
            // Inject the torchlight class
            $this->html = str_replace('<pre>', '<pre class="torchlight">', $this->html);

            if ($this->useAttribution()) {
                // Inject markdown badge
                $this->html .= "\n\n" . '<i>'
                    . __('Syntax highlighting provided by')
                    . ' <a href="https://torchlight.dev/" rel="noopener nofollow">torchlight.dev</a></i>';
            }
        }

        return $this->html;
    }

    /**
     * Check if Torchlight is used.
     * @return bool
     */
    private function usesTorchlight(): bool {
        // Check if Torchlight is enabled and if attribution is enabled. If it is not, we don't need to search the text.
        if (!(config('blog.torchlight.enabled'))) {
            return false;
        }

        // Check if the HTML contains Torchlight code
        return str_contains($this->html, '<!-- Syntax highlighted by torchlight.dev -->');
    }

    /**
     * Check if we should inject attribution. Should only be called after usesTorchlight has returned true.
     * @return bool
     */
    private function useAttribution(): bool {
        return config('blog.torchlight.attribution');
    }

}
