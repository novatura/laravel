<?php

namespace Novatura\Laravel\RolesAndPermissions\Commands;

use Illuminate\Console\Command;
use Novatura\Laravel\Support\GenerateStub;
use Novatura\Laravel\Support\GenerateFile;
use Carbon\Carbon;

class RolesAndPermissionCommand extends Command
{
    protected $signature = 'novatura:roles:install';

    protected $description = 'Create all the files required a roles and permissions based architecture using gates';

    protected $base_stub_path;

    public function __construct()
    {
        parent::__construct();

        $this->base_stub_path = __DIR__ . '/../stubs/';
    }


    // private function generatePermissionModel(){
    //     return (new GenerateStub('../stubs/permission_model.stub'))->generate();
    // }

    public function handle(){

        $this->info($this->base_stub_path);


        $this->info(app_path());

        $generate_files = [
            ['path' => (app_path() . '/Models/Permission.php'), 'content' => (new GenerateStub($this->base_stub_path . 'permission_model.stub'))->generate()],
            ['path' => (app_path() . '/Models/Role.php'), 'content' => (new GenerateStub($this->base_stub_path . 'role_model.stub'))->generate()],

            ['path' => (app_path() . '/Http/Controllers/PermissionController.php'), 'content' => (new GenerateStub($this->base_stub_path . 'permission_controller.stub'))->generate()],
            ['path' => (app_path() . '/Http/Controllers/RoleController.php'), 'content' => (new GenerateStub($this->base_stub_path . 'role_controller.stub'))->generate()],

            ['path' => (base_path() . '/database/migrations/'. Carbon::now()->subSecond()->format('Y_m_d_His') . '_create_permissions_table.php'), 'content' => (new GenerateStub($this->base_stub_path . 'permission_migration.stub'))->generate()],
            ['path' => (base_path() . '/database/migrations/'. Carbon::now()->subSecond()->format('Y_m_d_His') . '_create_roles_table.php'), 'content' => (new GenerateStub($this->base_stub_path . 'role_migration.stub'))->generate()],
            ['path' => (base_path() . '/database/migrations/'. Carbon::now()->format('Y_m_d_His') . '_create_role_permissions_table.php'), 'content' => (new GenerateStub($this->base_stub_path . 'role_permission_migration.stub'))->generate()],

            ['path' => (base_path() . '/database/seeders/RoleSeeder.php'), 'content' => (new GenerateStub($this->base_stub_path . 'role_seeder.stub'))->generate()],

        ];

        foreach ($generate_files as $generate_file){
            try {
                $path = $generate_file['path'];
                (new GenerateFile($path, $generate_file['content']))->generate();
    
                $this->info("Created : {$path}");
    
            } catch (\Exception $e) {
    
                $this->error("File {$path} : {$e->getMessage()}");
            }
        }

    }


}