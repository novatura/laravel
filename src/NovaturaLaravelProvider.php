<?php

namespace Novatura\Laravel;

use Illuminate\Support\ServiceProvider;
use Novatura\Laravel\RolesAndPermissions\Commands\RolesAndPermissionCommand;

class NovaturaLaravelProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            RolesAndPermissionCommand::class,
        ]);
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/novatura.php' => config_path('novatura.php'),
        ]);
    }
}