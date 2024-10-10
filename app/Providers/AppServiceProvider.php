<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use URL;

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
        if(head(explode('://', config('app.url'))) == 'https')
        {
            URL::forceScheme('https');
        }
    }
}
