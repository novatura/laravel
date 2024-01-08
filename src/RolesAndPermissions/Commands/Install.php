<?php

namespace Novatura\Laravel\RolesAndPermissions\Commands;

use Illuminate\Console\Command;
use Novatura\Laravel\Support\GenerateStub;
use Novatura\Laravel\Support\GenerateFile;
use Novatura\Laravel\Support\MakeFile;
use Carbon\Carbon;

class Install extends Command
{
    protected $signature = 'novatura:roles:install {--c|controllers : Include controllers} {--s|seeder : Include a Role Seeder}';

    protected $description = 'Create files for a roles and permissions based architecture using gates';

    protected $baseStubPath;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $generateFiles = [
            ['path' => app_path('Models/Permission.php'), 'stub' => 'permission_model.stub'],
            ['path' => app_path('Models/Role.php'), 'stub' => 'role_model.stub'],
            ['path' => app_path('Models/User.php'), 'stub' => 'user_model.stub'],

            ['path' => database_path("migrations/{$this->getCurrentTimestamp()->subSecond()->format('Y_m_d_His')}_create_permissions_table.php"), 'stub' => 'permission_migration.stub'],
            ['path' => database_path("migrations/{$this->getCurrentTimestamp()->subSecond()->format('Y_m_d_His')}_create_roles_table.php"), 'stub' => 'role_migration.stub'],
            ['path' => database_path("migrations/{$this->getCurrentTimestamp()->format('Y_m_d_His')}_create_role_permissions_table.php"), 'stub' => 'role_permission_migration.stub'],
            ['path' => database_path("migrations/{$this->getCurrentTimestamp()->format('Y_m_d_His')}_create_role_users_table.php"), 'stub' => 'role_users_migration.stub'],

            ['path' => app_path('providers/PermissionGateProvider.php'), 'stub' => 'permission_provider.stub'],

            ['path' => app_path('../routes/web.php'), 'stub' => 'web_routes.stub'],
        ];

        if ($this->option('controllers')) {
            // Only add controllers if the -c option is true
            $generateFiles = array_merge($generateFiles, [
                ['path' => app_path('Http/Controllers/PermissionController.php'), 'stub' => 'permission_controller.stub'],
                ['path' => app_path('Http/Controllers/RoleController.php'), 'stub' => 'role_controller.stub'],
                ['path' => app_path('Http/Controllers/UserController.php'), 'stub' => 'user_controller.stub'],
            ]);
        }

        if ($this->option('seeder')) {
            // Only add controllers if the -s option is true
            $generateFiles = array_merge($generateFiles, [
                ['path' => database_path('seeders/DatabaseSeeder.php'), 'stub' => 'database_seeder.stub'],
                ['path' => database_path('seeders/RoleSeeder.php'), 'stub' => 'role_seeder.stub'],
                ['path' => database_path('seeders/UserSeeder.php'), 'stub' => 'user_seeder.stub'],
            ]);
        }


        (new MakeFile($this, $generateFiles))->generate();
        $this->comment("\nTo complete the setup:\n - Migrate the new database files\n - Add the roles relationship to the user model\n - Include the PermissionGateProvider in the app config file");

        //$this->installFrontend();
    }

    protected function getCurrentTimestamp(): Carbon
    {
        return Carbon::now();
    }

    protected function installFrontend()
    {
        $this->info("Installing frontend for roles...");

        /**
         * NPM Packages (Waiting for John changes)
         */
        /*
        $this->info("Installing npm packages...");
        $this->updateNodePackages(function ($packages) {
            return [
                '@inertiajs/react' => '^1.0.14',
                'react' => '^18.2.0',
                'react-dom' => '^18.2.0',
                '@mantine/core' => '^7.3.2',
                '@mantine/hooks' => '^7.3.2',
                '@mantine/nprogress' => '^7.3.2',
                '@mantine/notifications' => '^7.4.0',
                'lucide-react' => '^0.3.0',
            ] + $packages;
        }, false);
        $this->updateNodePackages(function ($packages) {
            return [
                '@vitejs/plugin-react' => '^4.2.1',
                'postcss' => '^8.4.32',
                'postcss-preset-mantine' => '^1.12.0',
                'postcss-simple-vars' => '^7.0.1',
                '@types/node' => '^20.10.5',
                '@types/react' => '^18.2.45',
                '@types/react-dom' => '^18.2.18',
                'typescript' => '^5.3.3'
            ] + $packages;
        }, true);
        $this->installNodeModules($this->option('use'));
        */

        /**
         * Copy file structure from ../stubs to project
         */
        $this->info("Copying new files...");
        File::copyDirectory(__DIR__ . '/../frontend-stubs', base_path());
        
        $this->line("");
        $this->info("Frontend scaffolding for roles and permissions installed.");
        
        $this->line("");
        $this->info("Make sure you migrate your database fresh");
    }
}