<?php

namespace App\Repositories\Interfaces;

interface RoleInterface
{
    public function getAllRoles();
    public function getRoleById($roleId);
    public function deleteRole($roleId);
    public function createRole(array $roleDetails);
    public function updateRole($roleId, array $newDetails);
    public function updatePermission($roleId, $permissionIds);
    public function addUsers($roleId, $userIds);
}

