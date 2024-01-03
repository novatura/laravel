<?php

namespace Novatura\Laravel\Repository\Commands;

use Illuminate\Console\Command;
use Novatura\Laravel\Support\MakeFile;

use ReflectionClass;
use ReflectionMethod;

use Novatura\Laravel\Support\GenerateStub;

class Initiate extends Command
{
    protected $signature = 'novatura:repository:test';

    protected $description = 'Create scaffolding for testing repositories.';

    protected $baseStubPath;

    public function __construct()
    {
        parent::__construct();
    }

    private function getRepositoriesFiles() {
        $folder = app_path('Repositories');

        $files = glob($folder . '/*.php');

        return $files;
    }

    private function getFilesAndMethods() {
        $filesAndMethods = [];

        foreach ($this->getRepositoriesFiles() as $file) {

            $className = pathinfo($file, PATHINFO_FILENAME);

            $repo = sprintf('App\\Repositories\\%s', $className);

            $model = sprintf('App\\Models\\%s', str_replace('Repository', '', $className));

            if (class_exists($repo) && class_exists($model)) {
                $reflectionClass = new ReflectionClass($repo);
                $methods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);

                $methodsArray = [];

                foreach ($methods as $method) {
                    if($method->name != "__construct")
                    $methodsArray[] = $method->name;
                }

                $filesAndMethods[$className]['methods'] = $methodsArray;
                $filesAndMethods[$className]['model'] = $model;

            } else if (!class_exists($model)) {

                $this->error("Model Not Found for {$className}, Looking for {$model}, skipping ...\n");

            } else if (!class_exists($repo)) {

                $this->error("Repo Not Found: {$className}\n");

            }
        }

        return $filesAndMethods;
    }

    private function getMethodContent(array $methods){

        $methodsContent = "";

        foreach($methods as $method){
            $methodContent = (new GenerateStub(__DIR__ . '/../stubs/test_method.stub', ['method_name' => 'test_' . $method]))->generate();

            $methodsContent = $methodsContent . $methodContent . "\n\n";
        }

        return $methodsContent;
    }

    public function handle()
    {


        foreach ($this->getFilesAndMethods() as $repo_name => $filesAndMethod){
            $generateFiles[] = ['path' => base_path("tests/Repositories/{$repo_name}Tests.php"), 'stub' => 'test_class.stub', 
                'variables' => ['model_path' => $filesAndMethod['model'], 'repository_name' => $repo_name, 'test_class_name' => $repo_name . "Tests",'methods' => $this->getMethodContent($filesAndMethod['methods'])]];
        }

        (new MakeFile($this, $generateFiles))->generate();

        $this->comment("\nTo complete the setup:\n - Complete the methods in the test files generated\n");
    }

}