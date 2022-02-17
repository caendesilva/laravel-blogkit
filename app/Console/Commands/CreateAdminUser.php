<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Admin User';

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
        $this->info("Create new Admin User");

        $name = $this->ask('What is your name?', 'Admin');
        $email = $this->ask('What is your email?', 'admin@example.org');
        $password = $this->secret('Enter a strong password');
        if ($this->confirm("Do you wish to create user {$name} with email {$email}?", true)) {
            $this->info("Creating a new Admin User!");
            if (empty($password)) {
                return $this->error("Password cannot be empty!");
            }
            if (strlen($password) < 8) {
                $this->warn('You are using a weak password!');
                if ($this->confirm('Would you like to set a new password?', true)) {
                    $password = $this->secret('Enter a strong password');
                }
            }
            try {
                User::forceCreate([
                    'name' => $name,
                    'email' => $email,
                    'email_verified_at' => now(),
                    'password' => Hash::make($password),
                    'is_admin' => true,
                    'is_author' => true,
                ]);
                $this->info("User created successfully!");
            } catch (\Throwable $th) {
                $this->error("Something went wrong!");
                return $this->line($th->getMessage());
            }
        } else {
            return $this->warn("Canceling creation of Admin User!");
        }
    }
}
