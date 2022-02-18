<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ResetDemoApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset the demo app';

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
        if (config('blog.demoMode') !== true) {
            return $this->error('Blog must be in demo mode to do this!');
        }

        try {
            Artisan::call('migrate:fresh --seed --force');
        } catch (\Throwable $th) {
            $this->error("Something went wrong!");
            return $this->line($th->getMessage());
        }

        return $this->info('Database reset!');
    }
}
