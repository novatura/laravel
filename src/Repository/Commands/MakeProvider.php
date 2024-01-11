<?php

namespace Novatura\Laravel\Repository\Commands;

use Illuminate\Console\Command;
use Novatura\Laravel\Support\MakeFile;
use Novatura\Laravel\Core\Utils\FileUtils;
use Novatura\Laravel\Support\GenerateStub;

class MakeProvider extends Command
{

    use FileUtils;


    protected $signature = 'novatura:make:repository:provider --model={modelName? : The name of the model}';

    protected $description = 'Create provider for binding repositories.';

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
                    $this->error('Provider Already Exists');
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
