<?php

namespace Novatura\Laravel;

use Illuminate\Support\ServiceProvider;

class NovaturaLaravelProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerCommands();
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/novatura.php' => config_path('novatura.php'),
        ]);
    }

    /**
     * Loads all commands from any `Commands` directory in the package
     */
    private function registerCommands()
    {
        $commands = [];
        $directories = glob(__DIR__ . "/**/Commands", GLOB_ONLYDIR);
        foreach ($directories as $directory) {
            $files = glob($directory . "/*.php");
            
            foreach ($files as $file) {
                $class = 'Novatura\\Laravel\\' . str_replace("/", "\\", substr($file, strlen(__DIR__) + 1, -4));
                
                if (class_exists($class)) {
                    $commands[] = $class;
                }
            }
        }

        $this->commands($commands);
    }
}