<?php

namespace Novatura\Laravel\Core\Traits;

use Illuminate\Database\Eloquent\Model;
use Novatura\Laravel\Core\Models\LogIn;
use Jenssegers\Agent\Agent;

trait HasLoginHistory
{
    public function trackLogin()
    {

        // Log IP address and browser information
        $ipAddress = request()->ip();
        // $browser = request()->header('User-Agent');

        $agent = new Agent();

        // Get browser information
        $browser = $agent->browser();

        // // Accessing browser information
        // $browserName = $browserInfo->browser;

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
