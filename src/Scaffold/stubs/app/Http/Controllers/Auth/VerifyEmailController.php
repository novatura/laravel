<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VerifyEmailController extends Controller
{


    public function index(Request $request)
    {
        if (!$request->has('c')) {
            return Inertia::render('Auth/EmailVerification/Enter');
        } else {
            return request()->user()->verify($request->query('c'));
        }
    }

    public function verify(Request $request)
    {

        $request->validate([
            'code' => 'required|string|min:6|max:6'
        ]);

        return request()->user()->verify($request->code);

    }

}
