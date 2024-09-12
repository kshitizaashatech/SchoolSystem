<?php

namespace App\Providers;

use App\Http\Services\SchoolService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind SchoolService to the container
        $this->app->singleton(SchoolService::class, function ($app) {
            return new SchoolService(/* any dependencies SchoolService may have */);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(125);
    }
}