<?php

namespace App\Repositories;

use App\Models\Reminder;
use App\Repositories\Interfaces\ReminderInterface;

class ReminderRepository implements ReminderInterface
{

    public function getAllReminder() 
    {
        return Reminder::all();
    }

    public function getReminderById($reminderId) 
    {
        return Reminder::findOrFail($reminderId);
    }

    public function deleteReminder($reminderId) 
    {
        return Reminder::destroy($reminderId);
    }

    //Create a method per group of notification/schedule
    //ie: MessageRecievedNotification, remind in 48 hours
    /*
    $reminder = Reminder::create([
        'scheduled_at' => now()->AddHours(48),
        'query' => User::whereId($id)->whereNull('email_verified_at'),
        'condition_callback' => function ($result) {
            return $result->count() > 0;
        },
        'notification_class' => YourNotification::class,
    ]);
    */

}