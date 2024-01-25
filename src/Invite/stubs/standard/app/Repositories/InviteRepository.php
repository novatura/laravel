<?php

namespace App\Repositories;

use App\Models\Invite;
use App\Models\User;
use App\Models\Project;
use App\Repositories\Interfaces\InviteInterface;
use App\Mail\InviteCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InviteRepository implements InviteInterface
{

    public function getInviteFromToken($token)
    {
        $invite = Invite::where('token', $token)->first();

        if(!$invite){
            abort(404);
        }

        return $invite;
    }

    public function createInvite($data) 
    {

        do {
            //generate a random string using Laravel's str_random helper
            $token = Str::random(16);
        } //check if the token already exists and if it does, try again
        while (Invite::where('token', $token)->first());

        $invite = Invite::create([...$data, 'token' => $token]);

        Mail::to($data['email'])->send(new SendInviteMailable($invite));
        
    }

    public function createUserFromInvite($data, $token)
    {

        $invite = Invite::where('token', $token)->first();

        if(!$invite){
            throw new Exception('Token Not Found');
        }

        $user = User::create([...$data, 'email' => $invite->email]);

        if($user){

            $invite->delete();

            return $user;
    
        }

        throw new Exception('Creating User Failed');

    }
    
}