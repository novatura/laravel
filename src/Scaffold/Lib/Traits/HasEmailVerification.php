<?php

namespace Novatura\Laravel\Scaffold\Lib\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use Novatura\Laravel\Scaffold\Lib\Notifications\VerifyEmail;
use Novatura\Laravel\Scaffold\Lib\Models\EmailVerification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

trait HasEmailVerification
{
    public function sendVerificationCode()
    {

        $code = Str::random(6);

        EmailVerification::create([
            'code' => $code,
            'user_id' => $this->id,
            'email' => $this->email,
        ]);

        Notification::send($this, new VerifyEmail($code));

    }

    public function verify($code)
    {

        $verification = EmailVerification::where('user_id', $this->id)->where('code', $code)->where('email', $this->email)->first();

        if(!$verification){
            throw ValidationException::withMessages([
                'code' => 'Invalid Code',
            ]);
        }

        $createdAt = $verification->created_at;
        $currentTime = now(); // Assuming 'now()' function gives the current time in Laravel, you may need to adjust this based on your framework or use PHP's built-in functions.
    
        $timeDifference = $currentTime->diffInMinutes($createdAt);
    
        if ($timeDifference > 60) {
            throw ValidationException::withMessages([
                'code' => 'Code Has Expired',
            ]);
        }

        $this->email_verified_at = Carbon::now();

        $this->save();

        $intended = Session::get('verified:intended');

        if($intended){
            Session::forget('verified:intended');

            $verification->delete();
    
            return redirect($intended);
        } else {
            $verification->delete();
    
            return redirect('/');
        }



    }

    public function isVerified(){
        return $this->email_verified_at;
    }


    public static function bootHasEmailVerification()
    {
        static::updating(function ($model) {
            // Check if the email attribute is being updated
            if ($model->isDirty('email')) {
                // Set email_verified_at to null
                $model->email_verified_at = null;
            }
        });
    }

}