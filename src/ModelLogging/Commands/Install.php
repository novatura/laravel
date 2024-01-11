<?php

namespace Novatura\Laravel\ModelLogging\Commands;

use Illuminate\Console\Command;
use Novatura\Laravel\Support\MakeFile;
use Novatura\Laravel\Core\Utils\FileUtils;
use Illuminate\Support\Facades\File;

class Install extends Command
{

    use FileUtils;


    protected $signature = 'novatura:model_logging:install';

    protected $description = 'Create files for automated logging on all model changes';

    protected $baseStubPath;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info("Copying new files...");
        File::copyDirectory(__DIR__ . '/../stubs', base_path());

        $this->info("Adding ModelLoggingProvider to config/App.php...");
        $this->addProvider('App\Providers\ModelLoggingProvider::class');
    }

}