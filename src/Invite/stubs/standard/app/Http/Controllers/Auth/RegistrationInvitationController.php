<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\InvitationRequest;
use App\Models\Invite;

class RegistrationInvitationController extends Controller
{
    public function store(InvitationRequest $request)
    {
        $request->validated();

        try {
            do {
                //generate a random string using Laravel's str_random helper
                $token = Str::random(16);
            } //check if the token already exists and if it does, try again
            while (Invite::where('token', $token)->first());
         
            //create a new invite record
            $invite = Invite::create([
                'email' => $request->get('email'),
                'token' => $token,
            ]);
         
            // send the email
            Mail::to($request->get('email'))->send(new InviteCreated($invite));

            return redirect()->back();

        } catch (\Exceptions $e){
            return response()->back()->withError(['Error', 'Internal Server Error']);
        }
    }
}
