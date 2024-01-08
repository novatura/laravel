<?php

namespace Novatura\Laravel\RolesAndPermissions\Commands;

use Illuminate\Console\Command;
use Novatura\Laravel\Support\GenerateStub;
use Novatura\Laravel\Support\GenerateFile;
use Novatura\Laravel\Support\MakeFile;
use Carbon\Carbon;

class Install extends Command
{
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

        // $generateFiles = [
        //     ['path' => app_path('Models/Permission.php'), 'stub' => 'permission_model.stub'],
        //     ['path' => app_path('Models/Role.php'), 'stub' => 'role_model.stub'],

        //     ['path' => database_path("migrations/{$this->getCurrentTimestamp()->subSecond()->format('Y_m_d_His')}_create_permissions_table.php"), 'stub' => 'permission_migration.stub'],
        //     ['path' => database_path("migrations/{$this->getCurrentTimestamp()->subSecond()->format('Y_m_d_His')}_create_roles_table.php"), 'stub' => 'role_migration.stub'],
        //     ['path' => database_path("migrations/{$this->getCurrentTimestamp()->format('Y_m_d_His')}_create_role_permissions_table.php"), 'stub' => 'role_permission_migration.stub'],

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
}