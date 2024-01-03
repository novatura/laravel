<?php

namespace Novatura\Laravel\Scaffold\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Novatura\Laravel\Core\Utils\FileUtils;
use Novatura\Laravel\Core\Utils\PackageUtils;

class InstallCommand extends Command
{
    use PackageUtils;
    use FileUtils;

    protected $signature = 'novatura:scaffold:install
                            {--U|use=yarn : Package manager to use (npm|yarn) }';
    protected $description = 'Install Novatura Frontend/Auth Scaffold';
    
    /**
     * Execute the console command.
     * 
     * @return int|null
     */
    public function handle()
    {
        $this->installFrontend();
    }

    protected function installFrontend()
    {
        $this->info("Installing frontend scaffold...");

        /**
         * Composer packages
         */
        $this->info("Installing composer packages...");
        if (!$this->requireComposerPackages([
            'inertiajs/inertia-laravel:^0.6.3',
            'tightenco/ziggy:^1.0',
            'laravel/sanctum:^3.2'
        ])) {
            echo "Composer packages installation failed.\n";
            throw new \Exception("Composer packages installation failed.");
        }

        /**
         * NPM Packages
         */
        $this->info("Installing npm packages...");
        $this->updateNodePackages(function ($packages) {
            return [
                '@inertiajs/react' => '^1.0.14',
                'react' => '^18.2.0',
                'react-dom' => '^18.2.0',
                '@mantine/core' => '^7.3.2',
                '@mantine/hooks' => '^7.3.2',
                '@mantine/nprogress' => '^7.3.2',
            ] + $packages;
        }, false);
        $this->updateNodePackages(function ($packages) {
            return [
                '@vitejs/plugin-react' => '^4.2.1',
                'postcss' => '^8.4.32',
                'postcss-preset-mantine' => '^1.12.0',
                'postcss-simple-vars' => '^7.0.1',
                '@types/node' => '^20.10.5',
                '@types/react' => '^18.2.45',
                '@types/react-dom' => '^18.2.18',
                'typescript' => '^5.3.3'
            ] + $packages;
        }, true);
        $this->installNodeModules($this->option('use'));

        /**
         * Delete old files
         */
        $this->info("Deleting old files...");
        if (file_exists(resource_path('js/app.js'))) {
            unlink(resource_path('js/app.js'));
        }
        if (file_exists(resource_path('js/bootstrap.js'))) {
            unlink(resource_path('js/bootstrap.js'));
        }
        if (file_exists(resource_path('views/welcome.blade.php'))) {
            unlink(resource_path('views/welcome.blade.php'));
        }

        /**
         * Copy file structure from ../stubs to project
         */
        $this->info("Copying new files...");
        File::copyDirectory(__DIR__ . '/../stubs', base_path());

        /**
         * Patch files
         */
        $this->info("Updating required Laravel files...");
        $this->replaceInFile('/home', '/dashboard', app_path('Providers/RouteServiceProvider.php'));
        $this->replaceInFile('resources/js/app.js', 'resources/js/app.tsx', base_path('vite.config.js'));
        $this->installMiddlewareAfter('SubstituteBindings::class', '\App\Http\Middleware\HandleInertiaRequests::class');
        $this->installMiddlewareAfter('\App\Http\Middleware\HandleInertiaRequests::class', '\Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class');

        $this->line("");
        $this->info("Frontend scaffold installed.");
        $this->info("Make sure you migrate your database.");
    }
}