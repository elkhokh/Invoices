<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

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
            //to solve the problem of bootstrap because the new version of laravel use telwaind
        // Paginator::useTailwind();
        Paginator::useBootstrap();
    }
}
