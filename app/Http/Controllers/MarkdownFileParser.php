<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Spatie\YamlFrontMatter\YamlFrontMatter;

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
    /**
     * The default directory for markdown posts
     */
    public const MARKDOWN_DIRECTORY = '/resources/markdown/'; 

    /**
     * Static methods (not relating to a single markdown post instance)
     * 
     * Note that some of these may be moved to (or referenced in) a facade.
     */

    /**
     * Get the qualified file path from the name of a markdown file
     * 
     * @example getQualifiedFilepath("example-post") returns "/mnt/c/sites/laravel-blogkit/resources/markdown/example-post.md"
     * 
     * @param string $filename the name of the markdown file (without the extension)
     * @param bool $validateExistence should the method check if the file exists on disk?
     * 
     * @return string
     */
    public static function getQualifiedFilepath(string $filename, bool $validateExistence = true): string {
        $filepath = base_path() . SELF::MARKDOWN_DIRECTORY . $filename . '.md';

        if ($validateExistence && !file_exists($filepath)) {
            throw new Exception("File not found", 1);
        }

        return $filepath;
    }
    
    /**
     * Sync markdown files to the database.
     * 
     * @param string|null $filename to sync. If this is set, only the specified file will be synced. Else, all files in the directory will be synced.
     * @return string $message a human status message
     */
    public static function sync(string $filename = null) {
        $time_start = microtime(true);
        $count = (int) 0;

        $files = [];

        if ($filename === null) {
            $files = SELF::getMarkdownPostsAsArray();
        } else {
            $filepath = SELF::getQualifiedFilepath($filename);
            
            $files[$filename] = $filepath;
        }

        foreach ($files as $filename => $filepath) {
            $count++;
            (new SELF)
                ->parse($filename, $filepath)
                ->save();
        }

        $time = (float) ((microtime(true) - $time_start) / 60);
        return "Synced {$count} posts in {$time} seconds.";
    }

    /**
     * Get an array of all filepaths of markdown files in the markdown directory 
     * 
     * @return array $files where key is the filename and the value is the filepath
     */
    public static function getMarkdownPostsAsArray(): array
    {
        $files = [];
    
        foreach (glob(self::getQualifiedFilepath('*', false)) as $filepath) {
            $files[substr(basename($filepath), 0, -3)] = $filepath; // Remove the extension and add the filepath to the array
        }

        return $files;
    }


    /**
     * Methods relating to a single markdown post instance
     */

    /**
     * The Post instance created by the parser
     * 
     * @var Post $post
     */
    protected Post $post;

    /**
     * Parse a markdown file and create a Post instance
     * 
     * @param string $filename of the markdown file
     * @param string|null $filepath optionally provide the full filepath
     * 
     * @return $this
     */
    public function parse(string $filename, string|null $filepath = null)
    {
        if (!$filepath) {
            $filepath = SELF::getQualifiedFilepath($filename);
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

    /**
     * Save the current Post instance
     * 
     * @return $this
     */
    public function save()
    {
        if (Post::where('slug', $this->post->slug)->exists()) {
            $replacing = Post::where('slug', $this->post->slug)->firstOrFail();
            $id = $replacing->id;
            $replacing->delete();
            $this->post->id = $id;
        }
        
        $this->post->save();
        
        return $this;
    }

    /**
     * Return the current Post instance
     * 
     * @return \App\Models\Post
     */
    public function get(): \App\Models\Post
    {
        return $this->post;
    }

    /**
     * Internal methods
     */

    /**
     * Validate and sanitize the front matter data
     * 
     * @param array $matter the frontmatter array
     * @return array $data the validated and sanitized data
     */
    private function validateMatter(array $matter): array
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
        
        try {
            $author = User::find($validated['author'])->first();
        } catch (\Throwable $th) {
            throw new Exception('Could not find any users', 1);
        }

        if (!$author) {
            throw new Exception('User does not exist', 1);
        }

        try {
            $tags = explode(', ', $validated['tags']);
        } catch (\Throwable $th) {
            throw new Exception('Could not parse tags', 1);
        }

        try {
            $published_at = Carbon::parse($validated['published']);
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

        // Assemble the data array
        $data = [
            'title'          => $validated['title'],
            'body'           => $validated['body'],
            'description'    => $validated['description'],
            'featured_image' => $validated['featured_image'],
            'published_at'     => $published_at,
            'updated_at'     => $updated_at,
            'user_id'        => $author->id,
            'tags'           => $tags,
            'slug'           => $slug,
        ];
        
        return $data; // The validation passed
    }
}
