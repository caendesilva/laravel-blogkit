<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use Illuminate\Support\Str;

/**
 * Handle Markdown file based posts.
 * 
 * Can return an eloquent collection merged with database models and convert a markdown file to a database model
 * 
 * @todo add artisan command to sync specific file or all files in directory
 * @todo add metadata to database models to indicate if the model was created using a file. This locks the file from being edited in the editor page. Instead it edits the raw markdown file and triggers a resave.
 */
class MarkdownFileParser extends Controller
{
    public const MARKDOWN_DIRECTORY = '/resources/markdown/'; // The default directory for markdown posts

    /**
     * Static methods (not relating to a single markdown post instance)
     */

    public static function sync(string $filename = null) {
        $time_start = microtime(true); 
        $count = (int) 0;

        $files = [];

        if ($filename === null) {
            foreach (glob(base_path() . SELF::MARKDOWN_DIRECTORY. "*.md") as $filepath) {
                $files[basename($filepath)] = $filepath;
            }
        } else {
            $filepath = base_path() . SELF::MARKDOWN_DIRECTORY . $filename . '.md';
            if (!file_exists($filepath)) {
                throw new Exception("File not found", 1);
            }
            $files[$filename] = $filepath;
        }

        foreach ($files as $filename => $filepath) {
            $count++;
            $parser = new SELF;
            $parser->parse($filename, $filepath)
                ->save();
        }

        $time = (float) number_format(((microtime(true) - $time_start) / 60), 2);
        return "Synced {$count} posts in {$time} seconds. ";
    }
    

    /**
     * Methods relating to a single markdown post instance
     */

     protected Post $post;

    public function parse(string $filename, string|null $filepath = null)
    {
        if (!$filepath) {
            $filepath = base_path() . SELF::MARKDOWN_DIRECTORY . $filename . '.md';
        }

        $object = YamlFrontMatter::parse(file_get_contents($filepath));

        // Validate and sanitize
        $validated = $this->validateMatter(
            array_merge($object->matter(), [
                'body' => $object->body(),
                'slug' => $filename,
                'updated_at' => filemtime($filepath),
            ])
        );

        $this->post = new Post;
        
        $this->post->forceFill($validated);

        return $this;
    }

    public function save()
    {
        if (Post::where('slug', $this->post->slug)) {
            $replacing = Post::where('slug', $this->post->slug)->firstOrFail();
            $id = $replacing->id;
            $replacing->delete();
        }

        $this->post->id = $id;
        $this->post->save();
        
        return $this;
    }

    public function get()
    {
        return $this->post;
    }

    /**
     * Internal methods
     */

    private function validateMatter(array $matter)
    {
        $validator = Validator::make($matter, [
            'author'         => 'numeric',
            'body'           => 'string',
            'description'    => 'nullable|string|max:255',
            'featured_image' => 'nullable|url|max:255',
            'published'      => 'date_format:Y-m-d H:i',
            'slug'           => 'string',
            'tags'           => 'nullable|string',
            'title'          => 'required|string|max:255',
            'updated_at'     => 'numeric',
            'visible'        => 'boolean',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors(), 1);
        }

        $validated = $validator->validated();

        // dd($validated = $validator->validated());
        
        $author = User::find($validated['author'])->first();
        if (!$author) {
            throw new Exception('User does not exist', 1);
        }

        try {
            $tags = explode(', ', $validated['tags']);
        } catch (\Throwable $th) {
            throw new Exception('Could not parse tags', 1);
        }

        try {
            $created_at = Carbon::parse($validated['published']);
        } catch (\Throwable $th) {
            throw new Exception('Could not parse publish date', 1);
        }
        
        try {
            $updated_at = Carbon::parse($validated['updated_at']);
        } catch (\Throwable $th) {
            throw new Exception('Could not parse modification date', 1);
        }

        try {
            $slug = Str::slug($validated['slug']);
        } catch (\Throwable $th) {
            throw new Exception('Could not generate slug', 1);
        }

        $data = [
            'title'          => $validated['title'],
            'body'           => $validated['body'],
            'description'    => $validated['description'],
            'featured_image' => $validated['featured_image'],
            'created_at'     => $created_at,
            'updated_at'     => $updated_at,
            'user_id'        => $author->id,
            'tags'           => $tags,
            'slug'           => $slug,
        ];
        
        return $data; // The validation passed
    }
}
