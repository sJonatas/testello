<?php

namespace App\Providers;

use App\Services\ShippingRateImporterService;
use App\Services\ShippingRateService;
use Illuminate\Foundation\Application;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ShippingRateService::class);
        $this->app->bind(ShippingRateImporterService::class, function (Application $app) {
            return new ShippingRateImporterService($app->make(ShippingRateService::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
