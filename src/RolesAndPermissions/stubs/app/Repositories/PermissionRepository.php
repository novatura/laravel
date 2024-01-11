<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Repositories\Interfaces\PermissionInterface;

class PermissionRepository implements PermissionInterface
{

    protected Permission $permission;

    public function getAllPermission() 
    {
        return Permission::all();
    }

    public function getPermissionById($permissionId) 
    {
        return Permission::findOrFail($permissionId);
    }

}