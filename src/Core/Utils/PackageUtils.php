<?php

namespace Novatura\Laravel\Core\Utils;

use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

/**
 * Package utils trait
 */
trait PackageUtils
{
    /**
     * Require composer packages
     * 
     * @param array $packages composer packages to require
     * @param bool $asDev require as dev dependencies?
     */
    function requireComposerPackages(array $packages, $asDev = false)
    {
        $command = array_merge(
            ['composer', 'require'],
            $asDev ? ['--dev'] : [],
            $packages
        );

        return (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => -1]))
            ->setTimeout(null)
            ->run() === 0;
    }

    /**
     * Update node packages
     * 
     * @param callable $callback callback to update packages - (existingPcks[]) -> newPcks[]
     * @param bool $dev update dev dependencies?
     */
    function updateNodePackages(callable $callback, $dev = true)
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    /**
     * Flush node modules
     */
    function flushNodeModules()
    {
        tap(new Filesystem, function ($files) {
            $files->deleteDirectory(base_path('node_modules'));
            $files->delete(base_path('yarn.lock'));
            $files->delete(base_path('package-lock.json'));
            $files->delete(base_path('bun.lockb'));
        });
    }

    /**
     * Install node modules
     * Automatically detects:
     * - package-lock.json -> npm
     * - yarn.lock -> yarn
     * - bun.lockb -> bun
     * - else, npm
     */
    function installNodeModules($mngr = 'npm')
    {
        $detected = 'npm';
        $cmd = 'install';

        if (file_exists(base_path('package-lock.json'))) {
            $detected = 'npm';
        } elseif (file_exists(base_path('yarn.lock'))) {
            $detected = 'yarn';
        } elseif (file_exists(base_path('bun.lockb'))) {
            $detected = 'bun';
        }

        if ($mngr !== $detected) {
            $this->flushNodeModules();
        }

        return (new Process([$mngr, $cmd], base_path(), ['COMPOSER_MEMORY_LIMIT' => -1]))
            ->setTimeout(null)
            ->run() === 0;
    }
}
