<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RequestVerificationController extends Controller
{
    public function create(): Response
    {

        return Inertia::render('Auth/EmailVerification/Send');
    }

    public function store()
    {
        request()->user()->sendVerificationCode();


        return redirect()->route('verify.email.code');

    }

}
