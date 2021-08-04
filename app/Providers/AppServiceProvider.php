<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        Schema::defaultStringLength(191);

        Blade::if('doctor', function () {
            if (auth('admin')->check()) return true;
            return auth()->check() && auth()->user()->isDoctor();
        });

        Blade::if('technician', function () {
            return auth('web')->check() && auth('web')->user()->isTechnician();
        });

        Blade::if('testResponsible', function () {
            return auth('web')->check() && auth('web')->user()->isTestResponsible();
        });
    }
}
