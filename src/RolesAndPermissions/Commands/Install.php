<?php

namespace Novatura\Laravel\RolesAndPermissions\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Novatura\Laravel\Core\Utils\FileUtils;
use Novatura\Laravel\Core\Utils\PackageUtils;
use Carbon\Carbon;

class Install extends Command
{
    use PackageUtils;
    use FileUtils;

    protected $signature = 'novatura:roles:install
                            {--U|use=yarn : Package manager to use (npm|yarn) }';
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

        $this->installFrontend();

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

        $this->info("Adding Provider to Config/App.php...");
        $this->addProvider('App\Providers\PermissionGateProvider::class');

        //     ['path' => app_path('providers/PermissionGateProvider.php'), 'stub' => 'permission_provider.stub'],
        // ];

        // if ($this->option('controllers')) {
        //     // Only add controllers if the -c option is true
        //     $generateFiles = array_merge($generateFiles, [
        //         ['path' => app_path('Http/Controllers/PermissionController.php'), 'stub' => 'permission_controller.stub'],
        //         ['path' => app_path('Http/Controllers/RoleController.php'), 'stub' => 'role_controller.stub'],
        //     ]);
        // }

        // if ($this->option('seeder')) {
        //     // Only add controllers if the -c option is true
        //     $generateFiles = array_merge($generateFiles, [
        //         ['path' => database_path('seeders/RoleSeeder.php'), 'stub' => 'role_seeder.stub'],
        //     ]);
        // }

        // (new MakeFile($this, $generateFiles))->generate();
        $this->comment("\nTo complete the setup:\n - Migrate the new database files\n - Add the roles relationship to the user model\n - Include the PermissionGateProvider in the app config file");
    }

    protected function getCurrentTimestamp(): Carbon
    {
        return Carbon::now();
    }

    protected function installFrontend()
    {
        $this->info("Causing chaos...");

        /**
         * NPM Packages
         */
        $this->info("Installing npm packages...");
        $this->updateNodePackages(function ($packages) {
            return [
                '@inertiajs/react' => '^1.0.14',
                'react' => '^18.2.0',
                'react-dom' => '^18.2.0',
                '@mantine/core' => '^7.4.0',
                '@mantine/dates' => '^7.4.0',
                '@mantine/hooks' => '^7.4.0',
                '@mantine/nprogress' => '^7.3.2',
                '@mantine/notifications' => '^7.4.0',
                'lucide-react' => '^0.3.0',
                'mantine-react-table' => '^2.0.0-alpha.9',
                'dayjs' => '^1.11.10',
                'clsx' => '^2.1.0',
                '@tabler/icons-react' => '^2.45.0',
            ] + $packages;
        }, false);

        $this->info("Earning dunce points..");

        $this->updateNodePackages(function ($packages) {
            return [
                '@vitejs/plugin-react' => '^4.2.1',
                'postcss' => '^8.4.32',
                'postcss-preset-mantine' => '^1.12.0',
                'postcss-simple-vars' => '^7.0.1',
                '@types/node' => '^20.10.5',
                '@types/react' => '^18.2.45',
                '@types/react-dom' => '^18.2.18',
                'typescript' => '^5.3.3',
            ] + $packages;
        }, true);
        $this->installNodeModules($this->option('use'));

        $this->info("Causing a Ruckus...");
        
        // Update Providers.tsx
        $this->replaceInFile('function Providers', "import '@mantine/dates/styles.css';\nimport 'mantine-react-table/styles.css';\n\nfunction Providers", base_path('resources/js/Providers.tsx'));

        $this->line("");
        $this->info("Roles and permissions scaffold installed.");
        
        $this->line("");
        $this->info("Make sure you migrate your database fresh");
    }
}