<?php

namespace Novatura\Laravel\Core\Traits;

use Illuminate\Database\Eloquent\Model;
use Novatura\Laravel\Core\Models\LogIn;

trait HasLoginHistory
{
    public function trackLogin()
    {

        // Log IP address and browser information
        $ipAddress = request()->ip();
        $browser = request()->header('User-Agent');

        LogIn::create([
            'browser' => $browser,
            'ip' => $ipAddress,
            'user_id' => $this->id,
        ]);
    }

    public function getTrackedLogins()
    {
        return LogIn::where('user_id', $this->id)->get();
    }
}
