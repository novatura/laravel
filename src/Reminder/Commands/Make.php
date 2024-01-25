<?php

namespace Novatura\Laravel\Reminder\Commands;

use Illuminate\Console\Command;
use Novatura\Laravel\Support\MakeFile;
use Novatura\Laravel\Core\Utils\FileUtils;
use Illuminate\Support\Facades\File;

class Make extends Command
{

    use FileUtils;


    protected $signature = 'novatura:make:reminder --name={name : The name of the reminder}';

    protected $description = 'Create a reminder class';


    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $name = $this->argument('name');

        $generateFiles = [
            ['path' => app_path("Reminders/{$name}.php"), 'stub' => 'reminder.stub', 
                'variables' => [
                    'class_name' => $name, 
                    'base_class_path' => 'Novatura\Laravel\Core\Reminders\Reminder', 
                    'base_class_name' => 'Reminder', 
                ]
            ],
        ];

        (new MakeFile($this, $generateFiles))->generate();

        $this->comment("\nGeneral Information:\n - Reminders use laravel jobs to execute\n - Run: artisan queue:work\n - When you update a reminder, you will need to restart the worker to reload the job\n");
    }

}