<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Permission;
use Illuminate\Support\Facades\Artisan;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Generates the permissions from the routes
        Artisan::call('novatura:permissions:generate');

        // Careful, changing this can break stuff
        // These are for extra permissions used around the system that are not connected to routes.
        // If you are using this for route permissions (can:index.users), 
        // instead add the gate to the route and run novatura:permissions:generate
        $permissions = [
            'assign.developer',
            'remove.developer',
        ];


        foreach ($permissions as $permission){
            if(!Permission::where('name', $permission)->first()){
                
                Permission::create([
                    'name' => $permission
                ]);
            }
        }
    }
}
