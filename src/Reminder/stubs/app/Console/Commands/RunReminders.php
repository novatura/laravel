<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reminders = Reminder::where('scheduled_at', '<=', now())->get();

        foreach ($reminders as $reminder) {
            // Unserialize the query
            $query = $reminder->query;

            // Execute the query
            $result = $query->get();

            // Check the condition callback if provided
            $conditionCallback = $reminder->condition_callback;

            if (!$conditionCallback || $conditionCallback($result)) {
                // Run the notification class
                $notificationClass = $reminder->notification_class;
                $notification = new $notificationClass();
                $notification->send();

                // Optional: Mark the reminder as processed or delete it
                $reminder->delete();
            }
        }

        $this->info('Reminders checked and processed.');
    }
}
