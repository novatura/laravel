<?php

namespace App\Repositories\Interfaces;

interface UserInterface 
{
    public function getAllUser();
    public function getUserById($userId);
    public function deleteUser($userId);
    public function createUser(array $newData);
    public function updateUser($userId, array $newData);
    public function getAllUsersWithRoles();
    public function getAllUsersWithRole($roleId);
    public function getAllUsersWithoutRole($roleId);
    public function addRole($userId, $roleId);
    public function removeRole($userId, $roleId);
    public function updateRoles($userId, $roleIds);
}