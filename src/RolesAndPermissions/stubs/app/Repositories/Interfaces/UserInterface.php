<?php

namespace App\Repositories\Interfaces;

interface UserInterface 
{
    public function getAllUser();
    public function getUserById($userId);
    public function deleteUser($userId);
    public function createUser(array $newData);
    public function updateUser($userId, array $newData);
    public function addRole($userId, $roleId);
}