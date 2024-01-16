<?php

namespace Novatura\Laravel\RolesAndPermissions\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Novatura\Laravel\Core\Utils\FileUtils;
use Novatura\Laravel\Core\Utils\PackageUtils;
use Carbon\Carbon;
use Novatura\Laravel\Support\GenerateStub;

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
            "Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->middleware('can:users.index')->name('users.index');",
            "Route::get('/users/{id}', [\App\Http\Controllers\UserController::class, 'show'])->middleware('can:users.show')->name('users.show');",
            "Route::patch('/users/{id}', [\App\Http\Controllers\UserController::class, 'update'])->middleware('can:users.update')->name('users.update');",
            "Route::delete('/users/{id}', [\App\Http\Controllers\UserController::class, 'destroy'])->middleware('can:users.destroy')->name('users.destroy');",
            "Route::patch('/users/{userId}/roles', [\App\Http\Controllers\UserController::class, 'updateRoles'])->middleware('can:users.update.roles')->name('users.update.roles');",
            "Route::post('/users/{userId}/roles/{roleId}', [\App\Http\Controllers\UserController::class, 'addRole'])->middleware('can:users.add.roles')->name('users.add.roles');",
            "Route::delete('/users/{userId}/roles/{roleId}', [\App\Http\Controllers\UserController::class, 'removeRole'])->middleware('can:users.remove.roles')->name('users.remove.roles');",
            "Route::get('/roles', [\App\Http\Controllers\RoleController::class, 'index'])->middleware('can:roles.index')->name('roles.index');",
            "Route::get('/roles/{id}', [\App\Http\Controllers\RoleController::class, 'show'])->middleware('can:roles.show')->name('roles.show');",
            "Route::post('/roles', [\App\Http\Controllers\RoleController::class, 'store'])->middleware('can:roles.store')->name('roles.store');",
            "Route::patch('/roles/{id}', [\App\Http\Controllers\RoleController::class, 'update'])->middleware('can:roles.update')->name('roles.update');",
            "Route::delete('/roles/{id}', [\App\Http\Controllers\RoleController::class, 'destroy'])->middleware('can:roles.destroy')->name('roles.destroy');",
            "Route::patch('/roles/{roleId}/permissions', [\App\Http\Controllers\RoleController::class, 'updatePermission'])->middleware('can:roles.update.permission')->name('roles.update.permission');",
            "Route::post('/roles/{roleId}/users', [\App\Http\Controllers\RoleController::class, 'addUsers'])->middleware('can:roles.add.users')->name('roles.add.users');",
        ]);

        $this->info("Adding Provider to Config/App.php...");
        $this->addProvider('App\Providers\PermissionGateProvider::class');

        $this->info("Binding Repositories...");
        $this->call('novatura:bind:repository', [
            'modelName' => 'User', 
        ]);
        $this->call('novatura:bind:repository', [
            'modelName' => 'Role', 
        ]);
        $this->call('novatura:bind:repository', [
            'modelName' => 'Permission', 
        ]);


        //Editing the user model to add methods
        $filePath = app_path('Models/User.php');
        $content = file_get_contents($filePath);
        
        $lastBracePosition = strrpos($content, '}');

        $replacement_code = (new GenerateStub(__DIR__ . '/../generate_stub/hasPermissions.stub'))->generate();
        
        if ($lastBracePosition !== false) {
            $newContent = substr_replace($content, $replacement_code . "\n\n}", $lastBracePosition, 1);
            file_put_contents($filePath, $newContent);
        } else {
            $this->error("Not Found");
        }

        // (new MakeFile($this, $generateFiles))->generate();
        $this->comment("\nTo complete the setup:\n - artisan migrate\n - artisan novatura:permissions:generate");
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