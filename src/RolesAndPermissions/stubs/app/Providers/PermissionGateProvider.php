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
                Log::build([
                    'driver' => 'single',
                    'path' => storage_path("logs/novatura/permission_gates.log"),
                ])->info('Creating gate: ' . $permission->name);
    
                Gate::define($permission->name, function(User $user) use ($permission) {
                    Log::build([
                        'driver' => 'single',
                        'path' => storage_path("logs/novatura/permission_check.log"),
                    ])->info([
                        'Checking User for Permission',
                        $user->full_name,
                        // $user->role->permissions->pluck('name'),
                        $permission->name,
                    ]);
                    return $user->hasPermissionId($permission->id);
                });
            });
        } catch (\Exception $e) {
            Log::build([
                'driver' => 'single',
                'path' => storage_path("logs/novatura/gate_error.log"),
            ])->info($e->getMessage());
        }
    }
}
