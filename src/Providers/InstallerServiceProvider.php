<?php

namespace Juzaweb\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Juzaweb\Console\Commands\InstallCommand;
use Juzaweb\Http\Middleware\CanInstall;
use Juzaweb\Http\Middleware\Installed;

class InstallerServiceProvider extends ServiceProvider
{
    protected $namespace = 'Juzaweb\Http\Controllers';

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/installer.php',
            'installer'
        );

        $this->commands([
            InstallCommand::class,
        ]);
    }

    public function boot(Router $router)
    {
        $router->aliasMiddleware('install', CanInstall::class);
        $router->pushMiddlewareToGroup('web', Installed::class);
    }
}
