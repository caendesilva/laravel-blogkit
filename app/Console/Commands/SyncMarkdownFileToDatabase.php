<?php

namespace App\Console\Commands;

use App\Http\Controllers\MarkdownFileParser;
use Illuminate\Console\Command;

class SyncMarkdownFileToDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'markdown:sync {filename? : Specify a file to sync, otherwise all files will be synced.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync markdown files to the database.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return $this->info(
            MarkdownFileParser::sync($this->argument('filename'))
        );
    }
}
