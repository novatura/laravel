<?php

namespace Novatura\Laravel\RolesAndPermissions\Commands;

use Illuminate\Console\Command;
use Novatura\Laravel\Support\MakeFile;

class AddSeeder extends Command
{
    protected $signature = 'novatura:roles:seeder';

    protected $description = 'Create the Role Seeder';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $generateFiles = [
            ['path' => database_path('seeders/RoleSeeder.php'), 'stub' => 'role_seeder.stub'],
        ];


        (new MakeFile($this, $generateFiles))->generate();

    }
}