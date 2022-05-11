<?php

namespace Consensus\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register('Barryvdh\Debugbar\ServiceProvider');

            if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
                error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
            }
        }
    }
}
