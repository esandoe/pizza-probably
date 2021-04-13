<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Parsedown;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Parsedown::class, function ($app) {
            return (new Parsedown)->setSafeMode(true);
        });
    }
}
