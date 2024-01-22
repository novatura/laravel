<?php

namespace App\Repositories\Interfaces;

interface ReminderInterface 
{
    public function getAllReminder();
    public function getReminderById($reminderId);
}