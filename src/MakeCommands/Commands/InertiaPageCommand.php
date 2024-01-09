<?php

namespace Novatura\Laravel\MakeCommands\Commands;

use Illuminate\Console\Command;
use Novatura\Laravel\Core\Utils\FileUtils;
use Novatura\Laravel\Support\GenerateStub;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class InertiaPageCommand extends Command
{
    use FileUtils;

    protected $signature = 'novatura:make:page {name : The name of the page}
                            {--D|dir= : The directory to create the page in (relative to src/pages)}
                            {--L|layout= : The layout to use}';
    protected $description = 'Create a new Inertia page';

    public function handle()
    {
        $name = $this->argument('name');
        $exploded = explode("/", $name);

        // If name has multiple parts, e.g. Auth/PasswordReset/Confirm,
        // Then we want to use the last part as the name, and the rest as the dir
        // Else, use $this->option('dir') as the dir
        $dir = $this->option('dir');
        if (count($exploded) > 1) {
            $name = array_pop($exploded);
            $dir = join("/", $exploded);
        }

        $layout = $this->option('layout');

        if (!$dir) {
            $dir = text(
                label: "Directory",
                placeholder: "E.g. Auth",
                hint: "The directory to create the page in (relative to src/pages) - leave blank for root directory",
            );

            $dir = trim($dir, " \t\n\r\v\x00/\\");
        }
        $dirDisplayName = $dir ? $dir : "Pages";


        if (!$layout) {
            $layouts = $this->getFilesInDirectory(resource_path('js/layouts'));
            $layouts = array_merge(array_combine(
                $layouts,
                array_map(fn ($layout) => join(".", array_slice(explode(".", $layout->getFileName()), 0, -1)), $layouts)
            ), ["" => "None"]);

            $layout = select(
                label: "Layout",
                options: $layouts,
                hint: "The layout to use",
            );
            $layoutName = $layouts[$layout];
        }

        // Build stub
        $contents = "";
        if ($layout !== "") {
            $contents = (new GenerateStub(__DIR__ . "/../stubs/InertiaPageWithLayout.tsx.stub", [
                "name" => $name,
                "layout" => $layoutName
            ]))->generate();
        } else {
            $contents = (new GenerateStub(__DIR__ . "/../stubs/InertiaPage.tsx.stub", [
                "name" => $name
            ]))->generate();
        }

        if (!confirm("Confirm creation of $name in $dir using $layoutName ?")) {
            return;
        }

        // Check for pages dir
        $pageDirName = is_dir(resource_path("js/pages")) ? "pages" : (is_dir(resource_path("js/Pages")) ? "Pages" : null);
        if (!$pageDirName) {
            mkdir(resource_path("js/pages"));
        }

        // Try to find/make specified dir
        // Dir may have many parts, e.g. Auth/PasswordReset/Confirm
        $parts = explode("/", $dir);
        $dir = "";
        foreach ($parts as $part) {
            $dir .= "/$part";
            if (!is_dir(resource_path("js/pages/$dir"))) {
                mkdir(resource_path("js/pages/$dir"));
            }
        }
        file_put_contents(resource_path("js/pages/$dir/$name.tsx"), $contents);

        $this->info("Created page $name in $dirDisplayName using $layoutName");

        if (!confirm("Would you like to create a route for this page?")) {
            return;
        }

        $routePath = text(
            label: "Route path",
            placeholder: "E.g. /auth/password-reset/confirm",
            hint: "The path to use for the route",
        );

        $routeName = text(
            label: "Route name",
            placeholder: "E.g. auth.password-reset.confirm",
            default: trim(str_replace("/", ".", $routePath), " \t\n\r\v\x00/\\."),
            hint: "The name to use for the route",
        );

        $routeFiles = $this->getFilesInDirectory(base_path("routes"));
        $routeFiles = array_combine(
            $routeFiles,
            array_map(fn ($route) => join(".", array_slice(explode(".", $route->getFileName()), 0, -1)), $routeFiles)
        );
        $routeFile = select(
            label: "Route file",
            options: $routeFiles,
            hint: "The file to add the route to",
        );

        $this->addInertiaRoute($routeFile, $routePath, $routeName, trim($dir, "/") . "/" . $name);

        $this->info("Added route $routeName to $routeFile");
    }
}