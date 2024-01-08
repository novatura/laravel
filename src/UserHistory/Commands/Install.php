<?php

namespace Novatura\Laravel\UserHistory\Commands;

use Illuminate\Console\Command;
use Novatura\Laravel\Support\GenerateStub;
use Novatura\Laravel\Support\GenerateFile;
use Novatura\Laravel\Support\MakeFile;
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
        $generateFiles = [
            ['path' => app_path('Models/History.php'), 'stub' => 'history_model.stub'],

            ['path' => database_path("migrations/{$this->getCurrentTimestamp()->subSecond()->format('Y_m_d_His')}_create_historiess_table.php"), 'stub' => 'history_migration.stub'],
            ['path' => app_path('providers/HistoryMacroProvider.php'), 'stub' => 'macro_provider.stub'],
        ];

        if ($this->option('controllers')) {
            // Only add controllers if the -c option is true
            $generateFiles = array_merge($generateFiles, [
                ['path' => app_path('Http/Controllers/HistoryController.php'), 'stub' => 'permission_controller.stub'],
            ]);
        }


        (new MakeFile($this, $generateFiles))->generate();
        $this->comment("\nTo complete the setup:\n - Migrate the new database files\n - Add the roles relationship to the user model\n - Include the PermissionGateProvider in the app config file");
    }

    protected function getCurrentTimestamp(): Carbon
    {
        return Carbon::now();
    }
}