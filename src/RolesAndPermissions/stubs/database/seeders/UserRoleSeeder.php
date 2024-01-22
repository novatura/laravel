<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = Role::all();
        
        $roles->each(function ($role) {
            $user = User::create([
                'first_name' => $role->name,
                'last_name' => 'Test',
                'email' => $role->name . '@example.com',
                'password' => 'password',
            ]);

            $user->roles()->attach($role->id); 
        });
        
    }
}