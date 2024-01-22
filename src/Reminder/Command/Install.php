<?php

namespace Novatura\Laravel\ModelLogging\Commands;

use Illuminate\Console\Command;
use Novatura\Laravel\Support\MakeFile;
use Novatura\Laravel\Core\Utils\FileUtils;
use Illuminate\Support\Facades\File;

class Install extends Command
{

    use FileUtils;


    protected $signature = 'novatura:reminder:install';

    protected $description = 'Create files for teh reminder model';


    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info("Copying new files...");
        File::copyDirectory(__DIR__ . '/../stubs', base_path());

    }

}