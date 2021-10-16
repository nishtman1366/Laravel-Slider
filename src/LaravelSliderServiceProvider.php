<?php

namespace Nishtman\LaravelSlider;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Nishtman\LaravelSlider\Commands\LaravelSliderCommand;

class LaravelSliderServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('LaravelSlider', function ($app) {
            return new LaravelSlider();
        });
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/config/config.php' => config_path('slider.php'),
            ], 'config');

            $this->commands([
                LaravelSliderCommand::class,
            ]);
        }

        $this->registerRoutes();
    }

    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        });
    }

    protected function routeConfiguration()
    {
        return [
            'prefix' => config('slider.routes.prefix'),
            'middleware' => config('slider.routes.middleware'),
        ];
    }
}
