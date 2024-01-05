<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class VerifyEmailController extends Controller
{


    public function index(): Response
    {
        return Inertia::render('Auth/EmailVerification/Enter');
    }

    public function verify(Request $request)
    {

        $request->validate([
            'code' => 'required|string|min:6|max:6'
        ]);

        return request()->user()->verify($request->code);

    }

}
