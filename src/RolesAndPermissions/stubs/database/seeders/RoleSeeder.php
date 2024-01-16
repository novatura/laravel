<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Role;
use App\Models\Permission;

use Illuminate\Database\QueryException;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //Roles that have all permissions
        $all = [
            'admin'
        ];

        //Roles and their permissions
        $selected = [
            'user' => []
        ];

        $permissions = Permission::all();

        foreach($all as $roleName){
            $role = Role::create([
                'name' => $roleName
            ]);

            $role->permissions()->attach($permissions->pluck('id'));

            echo $roleName . ' created with ' . $permissions->count() . "\n";
        }

        foreach($selected as $roleName => $rolePermissions) {
            $role = Role::create([
                'name' => $roleName
            ]);

            foreach($rolePermissions as $permissionName){
                if($permission = Permission::where('name', $permissionName)->first()){
                    $role->permissions()->attach($permission->id);
                } else {
                    echo $permissionName . " not found\n";
                }
            }

        }

        // List the roles you want a default user for
        $default_users = [
            'admin'
        ];

        foreach ($default_users as $roleName){
            $role = Role::where('name', $roleName)->first();

            if($role){
                $user = \App\Models\User::create([
                    'first_name' => 'Default',
                    'last_name' => ucwords($roleName),
                    'email' => $roleName . '@example.com',
                    'password' => 'password',
                ]);

                $user->roles()->attach($role);

                echo 'Default user created for: ' . $roleName . "\n";
            } else {
                echo 'Default user not created for: ' . $roleName . ", role not found\n";
            }
        }


    }
}
