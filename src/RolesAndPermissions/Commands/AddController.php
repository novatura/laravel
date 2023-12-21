<?php

namespace Novatura\Laravel\RolesAndPermissions\Commands;

use Illuminate\Console\Command;
use Novatura\Laravel\Support\MakeFile;

class AddController extends Command
{
    protected $signature = 'novatura:roles:controllers';

    protected $description = 'Create the Role and Permission Controllers';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $generateFiles = [
            ['path' => app_path('Http/Controllers/PermissionController.php'), 'stub' => 'permission_controller.stub'],
            ['path' => app_path('Http/Controllers/RoleController.php'), 'stub' => 'role_controller.stub'],
        ];


        (new MakeFile($this, $generateFiles))->generate();

    }
}