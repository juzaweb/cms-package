<?php

namespace Juzaweb\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Juzaweb\Console\Commands\InstallCommand;
use Illuminate\Support\Facades\Route;

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

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'juzaweb');

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'juzaweb');

        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        parent::boot();
    }

    public function map()
    {
        $this->mapWebRoutes();
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../routes/installer.php');
    }
}
