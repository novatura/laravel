<?php

namespace Novatura\Laravel;

use Illuminate\Support\ServiceProvider;
use Novatura\Laravel\Scaffold\Commands\InstallCommand;

use Novatura\Laravel\RolesAndPermissions\Commands\Install as RolesAndPermissionInstallCommand;
use Novatura\Laravel\RolesAndPermissions\Commands\AddSeeder as RolesAndPermissionAddSeederCommand;
use Novatura\Laravel\RolesAndPermissions\Commands\AddController as RolesAndPermissionAddControllerCommand;

use Novatura\Laravel\ModelLogging\Commands\Install as ModelLoggingInstallCommand;

use Novatura\Laravel\UserHistory\Commands\Install as UserHistoryInstallCommand;


class NovaturaLaravelProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            InstallCommand::class,
            RolesAndPermissionInstallCommand::class,
            RolesAndPermissionAddSeederCommand::class,
            RolesAndPermissionAddControllerCommand::class,
            ModelLoggingInstallCommand::class,
            UserHistoryInstallCommand::class,
        ]);
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/novatura.php' => config_path('novatura.php'),
        ]);
    }
}