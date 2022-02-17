<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Post' => 'App\Policies\PostPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        
        //Determine if the given user can access any dashboards.
        Gate::define('access-dashboards', function (User $user) {
            return $user->is_admin || $user->is_author;
        });

        // Determine if the given user can access admin dashboards.
        Gate::define('access-admin', function (User $user) {
            return $user->is_admin;
        });

    }
}
