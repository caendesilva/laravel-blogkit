<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (config('app.env') !== 'local') {
            abort(403, 'Cannot run demo seeder in production!');
        }

        if (!User::where('email', 'admin@example.org')->count()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@example.org',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'is_admin' => true,
                'is_author' => true,
            ]);
        }
        
        if (!User::where('email', 'author@example.org')->count()) {
            User::create([
                'name' => 'Author',
                'email' => 'author@example.org',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'is_author' => true,
            ]);
        }
        
        if (!User::where('email', 'guest@example.org')->count()) {
            User::create([
                'name' => 'Guest',
                'email' => 'guest@example.org',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]);
        }
        
        if (config('blog.bans')) {
            if (!User::where('email', 'banned@example.org')->count()) {
                User::create([
                    'name' => 'Banned',
                    'email' => 'banned@example.org',
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                    'is_banned' => true,
                ]);
            }
        }

        \App\Models\User::factory(8)->create();

        $this->call([
            PostSeeder::class,
            CommentSeeder::class,
        ]);
    }
}
