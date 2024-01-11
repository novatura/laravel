<?php

namespace Novatura\Laravel\RolesAndPermissions\Commands;

use Illuminate\Console\Command;
use Novatura\Laravel\Support\GenerateStub;
use Novatura\Laravel\Support\GenerateFile;
use Novatura\Laravel\Support\MakeFile;
use Carbon\Carbon;
use Novatura\Laravel\Core\Utils\FileUtils;

class Install extends Command
{

    use FileUtils;

    protected $signature = 'novatura:roles:install';

    protected $description = 'Create files for a roles and permissions based architecture using gates';

    protected $baseStubPath;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {






        /**
         * Copy file structure from ../stubs to project
         */
        $this->info("Copying new files...");
        File::copyDirectory(__DIR__ . '/../stubs', base_path());


        $this->info("Adding Routes...");
        $this->addRoutes(['auth'], [
            "Route::get('/users', [UserController::class, 'index'])->middleware('can:index_users')->name('users.index');",
            "Route::get('/users/{id}', [UserController::class, 'show'])->middleware('can:show_users')->name('users.show');",
            "Route::patch('/users/{id}', [UserController::class, 'update'])->middleware('can:update_users')->name('users.update');",
            "Route::delete('/users/{id}', [UserController::class, 'destroy'])->middleware('can:delete_users')->name('users.destroy');",
            "Route::patch('/users/{userId}/roles', [UserController::class, 'updateRoles'])->middleware('can:update_users_roles')->name('users.update.roles');",
            "Route::post('/users/{userId}/roles/{roleId}', [UserController::class, 'addRole'])->middleware('can:add_users_roles')->name('users.add.roles');",
            "Route::delete('/users/{userId}/roles/{roleId}', [UserController::class, 'removeRole'])->middleware('can:remove_users_roles')->name('users.remove.roles');",
            "Route::get('/roles', [RoleController::class, 'index'])->middleware('can:index_roles')->name('roles.index');",
            "Route::get('/roles/{id}', [RoleController::class, 'show'])->middleware('can:show_roles')->name('roles.show');",
            "Route::post('/roles', [RoleController::class, 'store'])->middleware('can:store_roles')->name('roles.store');",
            "Route::patch('/roles/{id}', [RoleController::class, 'update'])->middleware('can:update_roles')->name('roles.update');",
            "Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->middleware('can:delete_roles')->name('roles.destroy');",
            "Route::patch('/roles/{roleId}/permissions', [RoleController::class, 'updatePermission'])->middleware('can:update_roles_permissions')->name('roles.update.permission');",
            "Route::post('/roles/{roleId}/users', [RoleController::class, 'addUsers'])->middleware('can:add_roles_users')->name('roles.add.users');",
        ]);

        $this->comment("\nTo complete the setup:\n - Migrate the new database files\n - Add the roles relationship to the user model\n - Include the PermissionGateProvider in the app config file");
    }

    protected function getCurrentTimestamp(): Carbon
    {
        return Carbon::now();
    }
}