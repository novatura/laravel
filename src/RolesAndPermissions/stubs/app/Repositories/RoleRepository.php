<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RoleInterface;
use App\Models\Role;

class RoleRepository implements RoleInterface 
{
    public function getAllRoles() 
    {

        return Role::all();
    }

    public function getRoleById($roleId)
    {
        return Role::findOrFail($roleId);
    }

    public function deleteRole($roleId)
    {
        Role::destroy($roleId);
    }

    public function createRole(array $roleDetails)
    {
        return Role::create($roleDetails);
    }

    public function updateRole($roleId, array $newDetails)
    {
        return Role::whereId($roleId)->update($newDetails);
    }


    public function updatePermission($roleId, $permissionIds) {
        $role = Role::findOrFail($roleId);
        $role->permissions()->detach();
        return $role->permissions()->attach($permissionIds);
    }

    public function addUsers($roleId, $userIds) {
        $role = Role::findOrFail($roleId);
        return $role->users()->attach($userIds);
    } 
}
