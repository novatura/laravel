<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Validation\ValidationException;

class NewEmailController extends Controller
{

    public function edit(): Response
    {
        return Inertia::render('Auth/EmailVerification/Email');
    }

    public function update(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email'
        ]);

        $request->user()->update([
            'email' => $request->email
        ]);

        $request->user()->sendVerificationCode();

        return redirect()->route('verify.email.code');
    }

    public function updateAndConfirm(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'current_email' => 'required|string|email'
        ]);

        if($request->user()->email != $request->current_email){
            throw ValidationException::withMessages([
                'current_email' => 'This email does not match your current email address',
            ]);
        }

        $request->user()->update([
            'email' => $request->email
        ]);

        $request->user()->sendVerificationCode();

        return redirect()->route('verify.email.code');
    }

}
