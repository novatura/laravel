<?php

namespace Novatura\Laravel\Core\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Log;
use \App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use \App\Models\User;

use Novatura\Laravel\Core\Observers\ModelLoggingObserver;

class ModelLoggingProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        foreach ($this->getEloquentModels() as $model) {
            Log::build([
                'driver' => 'single',
                'path' => storage_path("logs/novatura/history/observers.log"),
            ])->info([$model]);
            $model::observe(ModelLoggingObserver::class);
        }
    }

    // Get all Eloquent models in the application
    protected function getEloquentModels()
        {
            Log::build([
                'driver' => 'single',
                'path' => storage_path("logs/novatura/history/observers.log"),
            ])->info('Getting Models');

            $path = app_path('Models');
    
            return collect(glob("$path/*.php"))
                ->map(function ($file) {
                    $class = sprintf('App\\Models\\%s', pathinfo($file)['filename']);
                    return class_exists($class) ? $class : null;
                })
                ->filter()
                ->toArray();
        }
}
