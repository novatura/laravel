<?php

namespace Novatura\Laravel\Core\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Notifiable;
use Novatura\Laravel\Core\Reminders\Reminder;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class SendReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $reminder;

    public function __construct(Reminder $reminder)
    {
        $this->reminder = $reminder;
    }

    public function handle()
    {
        if ($this->reminder->shouldDispatch()) {

            $user = $this->reminder->getUser();

            if($this->reminder->getNotification() instanceof Notification){
                $notification = $this->reminder->getNotification();
        
                // Send the notification using the user's notify method
                $user->notify($notification);
            } else if ($this->reminder->getMailable() instanceof Mailable){

                Mail::to($user->email)->send($this->reminder->getMailable());

            }

        }

    }
}
