<?php

namespace Novatura\Laravel;

use Illuminate\Support\ServiceProvider;
use Novatura\Laravel\Scaffold\Commands\InstallCommand;

class NovaturaLaravelProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            InstallCommand::class,
        ]);
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/novatura.php' => config_path('novatura.php'),
        ]);
    }
}