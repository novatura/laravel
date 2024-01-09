<?php

namespace Novatura\Laravel\UserHistory\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class Install extends Command
{
    protected $signature = 'novatura:history:install {--c|controllers : Include controllers}';

    protected $description = 'Create files for tracking user history with dedicated Model Macros';

    protected $baseStubPath;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        /**
         * Copy file structure from ../stubs to project
         */
        $this->info("Copying new files...");
        File::copyDirectory(__DIR__ . '/../stubs', base_path());

        $this->comment("\nTo complete the setup:\n - Migrate the new database files\n - Add the roles relationship to the user model\n - Include the PermissionGateProvider in the app config file");
    }

    protected function getCurrentTimestamp(): Carbon
    {
        return Carbon::now();
    }
}