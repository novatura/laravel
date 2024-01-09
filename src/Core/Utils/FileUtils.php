<?php

namespace Novatura\Laravel\Core\Utils;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * File utils trait
 * 
 * Lot's of this code comes from:
 * https://github.com/laravel/breeze/blob/1.x/src/Console/InstallCommand.php
 */
trait FileUtils
{
    function replaceInFile(string $find, string $replace, string $file)
    {
        $content = file_get_contents($file);
        $content = str_replace($find, $replace, $content);
        file_put_contents($file, $content);
    }

    /**
     * Install middleware after another middleware
     * 
     * @param string $after middleware to install after
     * @param string $name middleware name
     * @param string $group middleware group
     * 
     * @return void
     */
    function installMiddlewareAfter(string $after, string $name, string $group = 'web')
    {
        $httpKernel = file_get_contents(app_path('Http/Kernel.php'));

        $middlewareGroups = Str::before(Str::after($httpKernel, '$middlewareGroups = ['), '];');
        $middlewareGroup = Str::before(Str::after($middlewareGroups, "'$group' => ["), '],');

        if (! Str::contains($middlewareGroup, $name)) {
            $modifiedMiddlewareGroup = str_replace(
                $after.',',
                $after.','.PHP_EOL.'            '.$name.',',
                $middlewareGroup,
            );

            file_put_contents(app_path('Http/Kernel.php'), str_replace(
                $middlewareGroups,
                str_replace($middlewareGroup, $modifiedMiddlewareGroup, $middlewareGroups),
                $httpKernel
            ));
        }
    }

    /**
     * Get files in directory
     * 
     * @param string $directory The directory to get files from
     * @param string $extension The extension to filter by (optional)
     * 
     * @return array<File>
     */
    function getFilesInDirectory(string $directory, string $extension = null)
    {
        $files = File::files($directory);

        if ($extension) {
            $files = array_filter($files, function ($file) use ($extension) {
                return pathinfo($file, PATHINFO_EXTENSION) === $extension;
            });
        }

        return $files;
    }

    /**
     * Add Route
     */
    function addInertiaRoute(string $routeFile, string $route, string $name, string $pageRef)
    {
        $routeContents = file_get_contents($routeFile);
        $routeContents .= PHP_EOL . PHP_EOL . "Route::get('$route', function () { return \Inertia\Inertia::render('$pageRef'); })->name('$name');";
        file_put_contents($routeFile, $routeContents);
    }

}