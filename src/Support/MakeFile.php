<?php

namespace Novatura\Laravel\Support;

use Illuminate\Console\Command;

use ReflectionClass;

class MakeFile {

    protected $paths_and_stubs;

    protected $command;

    protected $baseStubPath;

    /**
     * __construct
     *
     * @param  string $path
     * @param  array $variables
     * @return void
     */
    public function __construct(Command $command, array $paths_and_stubs = [])
    {
        $this->command = $command;
        $this->paths_and_stubs = $paths_and_stubs;
        $reflection = new ReflectionClass($command);
        $this->baseStubPath = dirname($reflection->getFileName()) . '/../stubs/';
    }

    public function generate(){

        foreach ($this->paths_and_stubs as $generateFile) {
            try {
                $path = $generateFile['path'];
                $stub = $generateFile['stub'];

                $content = (new GenerateStub("{$this->baseStubPath}{$stub}"))->generate();
                (new GenerateFile($path, $content))->generate();
    
                $this->command->info("Created: {$path}");
    
            } catch (\Exception $e) {
    
                $this->command->error("Error creating file {$path}: {$e->getMessage()}");
            }
        }

    }


}