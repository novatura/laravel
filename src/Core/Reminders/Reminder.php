<?php

namespace Novatura\Laravel\Core\Reminders;

use Novatura\Laravel\Core\Jobs\SendReminderJob;
use Illuminate\Support\Facades\Bus;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Log;

abstract class Reminder
{
    protected $delayInSeconds;
    protected $delayInMinutes;
    protected $delayInHours;
    protected $user_id;

    abstract public function shouldDispatch(): bool;

    public function getNotification() 
    {
        return null;
    }
    public function getMailable() 
    {
        return null;
    }

    public function __construct(User $user)
    {
        $this->user_id = $user->id;
        $this->delayInSeconds = 0;
        $this->delayInMinutes = 0;
        $this->delayInHours = 0;

        if (!$this->hasNotificationOrMailable()) {
            throw new \LogicException("At least one of getNotification or getMailable must be implemented.");
        }

    }

    private function hasNotificationOrMailable(): bool
    {
        return ($this->getNotification() != null) || ($this->getMailable() != null);
    }

    // Getter for $delayInSeconds
    public function getDelayInSeconds(): int { return $this->delayInSeconds; }

    // Setter for $delayInSeconds
    public function setDelayInSeconds(int $delayInSeconds): void { $this->delayInSeconds = $delayInSeconds; }

    // Getter for $delayInMinutes
    public function getDelayInMinutes(): int { return $this->delayInMinutes; }

    // Setter for $delayInMinutes
    public function setDelayInMinutes(int $delayInMinutes): void { $this->delayInMinutes = $delayInMinutes; }

    // Getter for $delayInHours
    public function getDelayInHours(): int { return $this->delayInHours; }

    // Setter for $delayInHours
    public function setDelayInHours(int $delayInHours): void { $this->delayInHours = $delayInHours; }

    public function getDispatchTime()
    {
        $delayInSeconds = $this->getDelayInHours() * 3600 + $this->getDelayInMinutes() * 60 + $this->getDelayInSeconds();
        
        return now()->addSeconds($delayInSeconds);
    }

    public function getUser(){
        return User::find($this->user_id);
    }

    public function dispatch(): void
    {
        SendReminderJob::dispatch($this)->delay($this->getDispatchTime());
    }

    // public function send() 
    // {

    //     Log::info($this->getUser());



    //     // if($this->getNotification() instanceof Notification){
    //     //     $notification = $this->getNotification();
    
    //     //     // Send the notification using the user's notify method
    //     //     $user->notify($notification);
    //     // } else if ($this->getMailable() instanceof Mailable){

    //     //     Mail::to($user->email)->send($this->getMailable());

    //     // } else {

    //     //     throw new \LogicException("At least one of getNotification or getMailable must be implemented.");
    //     // }


    // }
}
