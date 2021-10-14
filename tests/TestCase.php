<?php

namespace Nishtman\LaravelSlider\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nishtman\LaravelSlider\LaravelSliderServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Nishtman\\LaravelSlider\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelSliderServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-slider_table.php.stub';
        $migration->up();
        */
    }
}
