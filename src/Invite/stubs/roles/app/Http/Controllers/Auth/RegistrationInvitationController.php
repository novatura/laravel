<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\InvitationRequest;
use App\Models\Invite;
use App\Repositories\Interfaces\InviteInterface;

class RegistrationInvitationController extends Controller
{

    private InviteInterface $inviteRepository;

    public function __construct(InviteInterface $inviteRepository) 
    {
        $this->inviteRepository = $inviteRepository;
    }


    public function store(InvitationRequest $request)
    {
        $this->inviteRepository->createInvite($request->validated());

        return redirect()->back();
    }
}
