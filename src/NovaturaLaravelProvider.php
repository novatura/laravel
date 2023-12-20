<?php

use Illuminate\Support\ServiceProvider;

class NovaturaLaravelProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([

        ]);
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/novatura.php' => config_path('novatura.php'),
        ]);
    }
}