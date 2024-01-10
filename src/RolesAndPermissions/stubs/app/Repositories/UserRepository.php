<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserInterface;

class UserRepository implements UserInterface
{


    public function getAllUser() 
    {
        return User::all();
    }

    public function getUserById($userId) 
    {
        return User::findOrFail($userId);
    }

    public function deleteUser($userId) 
    {
        User::destroy($userId);
    }

    public function createUser(array $data) 
    {
        return User::create($data);
    }

    public function updateUser($userId, array $newData) 
    {
        return User::whereId($userId)->update($newData);
    }

    public function getAllUsersWithRoles(){
        return User::with('roles')->get();
    }

    public function addRole($userId, $roleId){
        return User::findOrFail($userId)->roles()->attach($roleId);
    }

    public function removeRole($userId, $roleId){
        return User::findOrFail($userId)->roles()->detach($roleId);
    }
}