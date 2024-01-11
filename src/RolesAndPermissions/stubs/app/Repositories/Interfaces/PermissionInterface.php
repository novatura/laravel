<?php

namespace App\Repositories\Interfaces;

interface PermissionInterface 
{
    public function getAllPermission();
    public function getPermissionById($permissionId);
}