<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserInterface;

class UserRepository implements UserInterface
{

    protected User $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function getAllUser() 
    {
        return $this->user->all();
    }

    public function getUserById($userId) 
    {
        return $this->user->findOrFail($userId);
    }

    public function deleteUser($userId) 
    {
        $this->user->destroy($userId);
    }

    public function createUser(array $data) 
    {
        return $this->user->create($data);
    }

    public function updateUser($userId, array $newData) 
    {
        return $this->user->whereId($userId)->update($newData);
    }

    public function getAllUsersWithRoles(){
        return User::with('roles')->get();
    }

    public function addRole($userId, $roleId){
        return $this->findOrFail($userId)->roles()->attach($roleId);
    }

    public function removeRole($userId, $roleId){
        return $this->findOrFail($userId)->roles()->detach($roleId);
    }
}