<?php

namespace App\Repositories\Interfaces;

interface RoleInterface
{
    public function getAllRoles();
    public function getRoleById($roleId);
    public function deleteRole($roleId);
    public function createRole(array $roleDetails);
    public function updateRole($roleId, array $newDetails);
    public function addPermission($roleId, $permissionId);
    public function removePermission($roleId, $permissionId);
}

