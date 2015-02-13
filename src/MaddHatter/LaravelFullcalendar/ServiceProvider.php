<?php namespace MaddHatter\LaravelFullcalendar;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('laravel-fullcalendar', function ($app) {
            return $app->make('MaddHatter\LaravelFullcalendar\Calendar');
        });
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../../views/', 'fullcalendar');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravel-fullcalendar'];
    }

}

