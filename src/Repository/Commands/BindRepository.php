<?php

namespace Novatura\Laravel\Repository\Commands;

use Illuminate\Console\Command;
use Novatura\Laravel\Support\MakeFile;
use Novatura\Laravel\Core\Utils\FileUtils;
use Novatura\Laravel\Support\GenerateStub;

class BindRepository extends Command
{

    use FileUtils;


    protected $signature = 'novatura:bind:repository --model={modelName? : The name of the model you want to bind}';

    protected $description = 'Binding repositories with interfaces.';

    protected $baseStubPath;

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {

        if($this->argument('modelName')){
            $modelName = $this->argument('modelName');

            $model = sprintf('App\\Models\\' . $modelName);

            if(class_exists($model)){

                $modelName = ucwords($modelName);

                $generateFiles = [];
        
                $providerExists = $this->providerExists();
        
                if(!$providerExists){
                    $generateFiles[] = [
                        'path' => app_path("Providers/RepositoryServiceProvider.php"), 
                        'stub' => 'provider.model.stub', 
                        'variables' => ['interface_name' => $modelName . 'Interface', 'repository_name' => $modelName . 'Repository']
                    ];
                } else {
                    $this->info('Binding Repository and Interface for ' . $modelName);
                    $this->bindRepository((new GenerateStub(__DIR__ . '/../stubs/bind.stub', ['interface_name' => $modelName . 'Interface', 'repository_name' => $modelName . 'Repository']))->generate());
                    return;
                }
        
                (new MakeFile($this, $generateFiles))->generate();

            } else {
                $this->error('Model Not Found');
                return;
            }
        } else {

            $generateFiles = [];
        
            $providerExists = $this->providerExists();
    
            if(!$providerExists){
                $generateFiles[] = [
                    'path' => app_path("Providers/RepositoryServiceProvider.php"), 
                    'stub' => 'provider.stub'
                ];
            } else {
                $this->error('Provider Already Exists');
                return;
            }
    
            (new MakeFile($this, $generateFiles))->generate();

        }

        $this->addProvider('App\Providers\RepositoryServiceProvider::class');

    }


    public function providerExists(){

        return file_exists(app_path('Providers/RepositoryServiceProvider.php'));

    }

}
