<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Log;
use \App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use \App\Models\User;

class PermissionGateProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        try {
            $permissions = Permission::all()->map(function ($permission) {
    
                Gate::define($permission->name, function(User $user) use ($permission) {
                    return $user->hasPermissionId($permission->id);
                });
            });
        } catch (\Exception $e) {
        }
    }
}
