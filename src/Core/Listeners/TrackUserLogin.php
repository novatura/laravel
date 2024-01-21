<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Novatura\Laravel\Core\Models\LogIn;

class TrackUserLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserLoggedIn $event)
    {
        $user = $event->user;

        // Log IP address and browser information
        $ipAddress = request()->ip();
        $browser = request()->header('User-Agent');

        LogIn::create([
            'browser' => $browser,
            'ip' => $ipAddress,
            'user_id' => $user->id,
        ]);

    }
}
