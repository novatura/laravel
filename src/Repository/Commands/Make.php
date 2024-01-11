<?php

namespace Novatura\Laravel\Repository\Commands;

use Illuminate\Console\Command;
use Novatura\Laravel\Support\MakeFile;
use Novatura\Laravel\Core\Utils\FileUtils;
use Novatura\Laravel\Support\GenerateStub;

class Make extends Command
{

    use FileUtils;


    protected $signature = 'novatura:make:repository --model={modelName : The name of the model} {--i|interface : Include an Interface}';

    protected $description = 'Create scaffolding for a repository based on a model.';

    protected $baseStubPath;

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {


        $modelName = $this->argument('modelName');

        $model = sprintf('App\\Models\\' . $modelName);

        if(class_exists($model)){

            $this->createFiles($model, $modelName);

        } else {
            $this->error('Model Not Found');
            return;
        }

    }

    public function createFiles($model, $modelName){

        $modelName = ucwords($modelName);

        $generateFiles = [];

        if($this->option('interface')){
            $generateFiles = [
                ['path' => app_path("Repositories/{$modelName}Repository.php"), 'stub' => 'repository.interface.stub', 
                    'variables' => ['model_path' => $model, 'repo_class_name' => $modelName . 'Repository', 'model_class_name' => $modelName, 'model_name' => strtolower($modelName), 'interface_name' => "{$modelName}Interface"]],
                ['path' => app_path("Repositories/Interfaces/{$modelName}Interface.php"), 'stub' => 'interface.stub', 
                    'variables' => ['interface_name' => "{$modelName}Interface", "model_class_name" => $modelName, 'model_name' => strtolower($modelName)]
                ]
            ];
        } else {
            $generateFiles = [
                ['path' => app_path("Repositories/{$modelName}Repository.php"), 'stub' => 'repository.stub', 
                    'variables' => ['model_path' => $model, 'repo_class_name' => $modelName . 'Repository', 'model_class_name' => $modelName, 'model_name' => strtolower($modelName)]],
            ];
        }


        (new MakeFile($this, $generateFiles))->generate();

        $this->call('novatura:bind:repository', [
            'modelName' => $modelName,  // Pass any required options or arguments 
        ]);

        // if(!$providerExists){
        //     $this->comment("\nTo complete the setup:\n - Add the RepositoryServiceProvider to your app config\n");
        // } else {
        //     $this->comment("\nTo complete the setup:\n - Bind the Repository and Interface in the RepositoryServiceProvider\n");
        // }

    }

}