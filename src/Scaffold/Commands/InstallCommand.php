<?php

namespace Novatura\Laravel\Scaffold\Commands;

use Illuminate\Console\Command;
use Novatura\Laravel\Core\Utils\PackageUtils;

class InstallCommand extends Command
{
    use PackageUtils;

    protected $signature = 'novatura:scaffold:install
                            {--A|auth=false : Install auth scaffold?}
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
        if ($this->option('auth')) {
            $this->installAuth();
        }
    }

    protected function installFrontend()
    {
        echo "Installing frontend scaffold...\n";

        /**
         * Composer packages
         */
        if (!$this->requireComposerPackages([
            'inertiajs/inertia-laravel:^0.6.3',
            'tightenco/ziggy:^1.0',
        ])) {
            echo "Composer packages installation failed.\n";
            throw new \Exception("Composer packages installation failed.");
        }

        /**
         * NPM Packages
         */
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


    }

    protected function installAuth()
    {
        echo "Installing auth scaffold...\n";

        /**
         * Composer packages
         */
        if (!$this->requireComposerPackages([
            'laravel/sanctum:^3.2',
        ])) {
            throw new \Exception("Composer packages installation failed.");
        }
    }
}