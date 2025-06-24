<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

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
        Gate::define('admin', function (User $user) {
            return $user->role === 'admin';
        });

        // Bagikan notifikasi ke semua view admin
        View::composer('components.layouts.admin', function ($view) {
            if (Auth::check() && Auth::user()->role === 'admin') {
                $unreadNotifications = Auth::user()->unreadNotifications;
                $view->with('unreadNotifications', $unreadNotifications);
            }
        });

        Paginator::useBootstrap();
    }
}
