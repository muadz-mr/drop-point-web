<?php

namespace App\Providers;

use App\Models\Package;
use App\Observers\PackageObserver;
use App\Support\Helper;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('helper', function () {
            return new Helper;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Package::observe(PackageObserver::class);
    }
}
