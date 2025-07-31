<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
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
    // if (request()->is('dashboard') || request()->is('invoices') || request()->is('profile')) {

    //     Paginator::useTailwind();
    // } else {

    //     Paginator::useBootstrap();
    // }
        Model::shouldBeStrict(!app()->isProduction()); // if you have eager loading it happend error in page
        Paginator::useBootstrap();
    }
}
