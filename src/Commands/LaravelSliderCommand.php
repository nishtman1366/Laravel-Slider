<?php

namespace Nishtman\LaravelSlider\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class LaravelSliderCommand extends Command
{
    public $signature = 'slider:install';

    public $description = 'Publish config file and run migrations';

    public function handle()
    {
        $this->info('Installing Laravel Sider...');
        $this->info('Publishing configuration...');
        if (! $this->configExists('slider.php')) {
            $this->publishConfiguration();
            $this->info('Published configuration');
        } else {
            if ($this->shouldOverwriteConfig()) {
                $this->info('Overwriting configuration file...');
                $this->publishConfiguration($force = true);
            } else {
                $this->info('Existing configuration was not overwritten');
            }
        }

        $this->runMigrations();

        $this->info('Slider package successfully installed');
    }

    private function configExists($fileName)
    {
        return File::exists(config_path($fileName));
    }

    private function shouldOverwriteConfig()
    {
        return $this->confirm(
            'Config file already exists. Do you want to overwrite it?',
            false
        );
    }

    private function publishConfiguration($forcePublish = false)
    {
        $params = [
            '--provider' => "Nishtman\Laravel-Slider\LaravelSliderServiceProvider",
            '--tag' => "config",
        ];

        if ($forcePublish === true) {
            $params['--force'] = true;
        }

        $this->call('vendor:publish', $params);
        $this->call('config:cache');
    }

    private function runMigrations()
    {
        $this->call('migrate');
    }
}
