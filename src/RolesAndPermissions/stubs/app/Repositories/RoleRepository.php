<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RoleInterface;
use App\Models\Role;

class RoleRepository implements RoleInterface 
{

    protected Role $role;

    public function __construct(){
        $this->role = new Role;
    }

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


    public function addPermission($roleId, $permissionId){
        return $this->findOrFail($roleId)->permissions()->attach($permissionId);
    }

    public function removePermission($roleId, $permissionId){
        return $this->findOrFail($roleId)->permissions()->detach($permissionId);
    }
}
