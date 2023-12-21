<?php

namespace Novatura\Laravel\ModelLogging\Commands;

use Illuminate\Console\Command;
use Novatura\Laravel\Support\MakeFile;

class Install extends Command
{
    protected $signature = 'novatura:model_logging:install';

    protected $description = 'Create files for automated logging on all model changes';

    protected $baseStubPath;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $generateFiles = [
            ['path' => app_path('Providers/ModelLoggingProvider.php'), 'stub' => 'provider.stub'],
            ['path' => app_path('Observers/ModelLoggingObserver.php'), 'stub' => 'observer.stub'],
        ];

        (new MakeFile($this, $generateFiles))->generate();
        $this->comment("\nTo complete the setup:\n - Include the ModelLoggingProvider in the app config file");
    }

}