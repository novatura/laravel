<?php

namespace Novatura\Laravel\RolesAndPermissions\Commands;

use Illuminate\Console\Command;
use Novatura\Laravel\Support\MakeFile;

use \App\Models\Permission;

class PermissionsGenerate extends Command
{
    protected $signature = 'novatura:permissions:generate';

    protected $description = 'Create the Permissions from the names of the routes';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Read the content of web.php file
        $webFileContent = file_get_contents(base_path('routes/web.php'));

        // Define a regular expression to match routes with ->name()
        $pattern = '/can:([\w.]+)/';

        // Match all occurrences of the pattern
        preg_match_all($pattern, $webFileContent, $matches);

        // Extract the route names from the matches
        $routeNames = $matches[1];

        // Get all existing permissions from the database
        $existingPermissions = Permission::all()->pluck('name')->toArray();

        // Find permissions to be deleted
        $permissionsToDelete = array_diff($existingPermissions, $routeNames);

        // Delete permissions that are no longer in the web.php file
        foreach ($permissionsToDelete as $permission) {
            $deletedPermission = Permission::where('name', $permission)->delete();
            if ($deletedPermission) {
                $this->info("Permission " . $permission . " has been deleted");
            }
        }

        // Create new permissions for routes that do not exist
        foreach ($routeNames as $route) {
            if (Permission::where('name', $route)->first()) {
                $this->info("Permission " . $route . " already exists. Skipping ...");
            } else {
                Permission::create([
                    'name' => $route
                ]);
                $this->info("Permission " . $route . " has been generated");
            }
        }

    }
}