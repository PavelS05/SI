<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\Paginator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

public function boot(): void
{

    Paginator::defaultView('layouts.pagination');

    Gate::define('access-carriers', function ($user) {
        return in_array($user->role, ['ops', 'csr', 'admin']);
    });

    Gate::define('access-customers', function ($user) {
        return in_array($user->role, ['sales', 'csr', 'admin']);
    });

    Gate::define('access-admin', function ($user) {
        return $user->role === 'admin';
    });
}
}
