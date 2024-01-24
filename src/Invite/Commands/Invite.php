<?php

namespace Novatura\Laravel\Invite\Commands;

use Illuminate\Console\Command;
use Novatura\Laravel\Core\Utils\FileUtils;
use Novatura\Laravel\Support\GenerateStub;
use Illuminate\Support\Facades\File;

class Invite extends Command
{
    use FileUtils;

    protected $signature = 'novatura:invite:install {--r|roles : Create invite with Roles}';
    protected $description = 'Use invitations for registration';

    public function handle()
    {

        /**
         * Copy file structure from ../stubs to project
         */
        $this->info("Copying new files...");
        if($this->option('roles')){
            File::copyDirectory(__DIR__ . '/../stubs/roles', base_path());
            $this->installMiddlewareAfter('SubstituteBindings::class', '\App\Http\Middleware\AppendInviteContext::class');
        } else {
            File::copyDirectory(__DIR__ . '/../stubs/standard', base_path());
        }

        $this->info("Changing existing files...");
        $this->changeOnPattern(
            base_path('routes/auth.php'),
            '/Route::get\(\'([^\']+)\', \[RegisteredUserController::class, \'create\'\]\)(?:.*);/',
            __DIR__ . '/../functions/createAuthRoute.stub'
        );

        $this->changeOnPattern(
            base_path('routes/auth.php'),
            '/Route::post\(\'([^\']+)\', \[RegisteredUserController::class, \'store\'\]\)(?:.*);/',
            __DIR__ . '/../functions/storeAuthRoute.stub'
        );

        $this->changeOnPattern(
            app_path('Http/Requests/Auth/RegisterRequest.php'), 
            '/return\s+\[(.+)\];/s', 
            __DIR__ . '/../functions/registerRequestRule.stub'
        );

        $this->changeOnPattern(
            app_path('Http/Controllers/Auth/RegisteredUserController.php'), 
            '/class\s+RegisteredUserController\s+extends\s+Controller\s*\{/', 
            __DIR__ . '/../functions/classConstructor.stub'
        );

        $this->changeOnPattern(
            app_path('Http/Controllers/Auth/RegisteredUserController.php'), 
            '/public\s+function\s+store\s*\([^}]+return\s+[^}]+}\s*/s', 
            __DIR__ . '/../functions/storeFunction.stub'
        );

        $this->changeOnPattern(
            app_path('Http/Controllers/Auth/RegisteredUserController.php'), 
            '/public\s+function\s+create\s*\([^}]+return\s+[^}]+}\s*/s', 
            __DIR__ . '/../functions/createFunction.stub'
        );

        $this->changeOnPatternReact(
            resource_path('js/Pages/Auth/Login.tsx'),
            '/<\/form>(.+)<\/Stack>/s',
            __DIR__ . '/../Components/login.stub'
        );

        $this->info("Adding Routes...");
        $this->addRoutes(['auth'], [
            "Route::post('/users/invite', [\App\Http\Controllers\Auth\RegistrationInvitationController::class, 'store'])->name('users.invite');",
        ]);

        $this->info("Binding Repository");
        $this->call('novatura:bind:repository', [
            'modelName' => 'Invite', 
        ]);

    }

}