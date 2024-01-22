<?php

namespace App\Repositories\Interfaces;

interface InviteInterface 
{
    public function getInviteFromToken($token);
    public function createInvite($data);
    public function createUserFromInvite($data, $token);
}