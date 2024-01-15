<?php

namespace Novatura\Laravel\Invite\Commands;

use Illuminate\Console\Command;
use Novatura\Laravel\Core\Utils\FileUtils;
use Novatura\Laravel\Support\GenerateStub;
use Illuminate\Support\Facades\File;

class Invite extends Command
{
    use FileUtils;

    protected $signature = 'novatura:invite:install';
    protected $description = 'Use invitations for registration';

    public function handle()
    {

        /**
         * Copy file structure from ../stubs to project
         */
        $this->info("Copying new files...");
        File::copyDirectory(__DIR__ . '/../stubs', base_path());

        $this->info("Changing existing files...");
        $this->changeOnPattern(
            base_path('routes/auth.php'),
            '/Route::get\(\'([^\']+)\', \[RegisteredUserController::class, \'create\'\]\)(?:.*);/',
            'createAuthRoute'
        );

        $this->changeOnPattern(
            base_path('routes/auth.php'),
            '/Route::post\(\'([^\']+)\', \[RegisteredUserController::class, \'store\'\]\)(?:.*);/',
            'storeAuthRoute'
        );

        $this->changeOnPattern(
            app_path('Http/Requests/Auth/RegisterRequest.php'), 
            '/return\s+\[(.+)\];/s', 
            'registerRequestRule'
        );

        $this->changeOnPattern(
            app_path('Http/Controllers/Auth/RegisteredUserController.php'), 
            '/public\s+function\s+store\s*\([^}]+return\s+[^}]+}\s*/s', 
            'storeFunction'
        );

        $this->changeOnPattern(
            app_path('Http/Controllers/Auth/RegisteredUserController.php'), 
            '/public\s+function\s+create\s*\([^}]+return\s+[^}]+}\s*/s', 
            'createFunction'
        );

        $this->info("Adding Routes...");
        $this->addRoutes(['auth'], [
            "Route::post('/users/invite', [\App\Http\Controllers\Auth\RegistrationInvitationController::class, 'store'])->name('users.invite');",
        ]);

    }

    public function changeOnPattern($file, $pattern, $stubFile){
        $fileContents = file_get_contents($file);

        preg_match($pattern, $fileContents, $matches);

        // Check if the pattern is found
        if (!empty($matches)) {
            // Captured function content is in $matches[0]
            $capturedFunctionContent = $matches[0];

            // Wrap the entire function content in a block comment
            $commentedFunctionContent = '/*' . "\n\t" . $capturedFunctionContent . "\t" . '*/' . "\n";

            $stub = (new GenerateStub(__DIR__ . '/../functions/' . $stubFile . '.stub'))->generate();

            $newCode = $commentedFunctionContent . "\n" . $stub;

            // Replace the original function content with the commented version
            $fileContents = str_replace($capturedFunctionContent, $newCode, $fileContents);

            // Save the modified content back to the file
            file_put_contents($file, $fileContents);

            $this->info($file . " Updated");
        } else {
            $this->error($file. " Failed to Update");
        }
    }

}