<?php
/**
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Providers;

use Barryvdh\Debugbar\ServiceProvider as DebugbarServiceProvider;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Juzaweb\Contracts\GlobalDataContract;
use Juzaweb\Contracts\HookActionContract;
use Juzaweb\Contracts\XssCleanerContract;
use Juzaweb\Support\GlobalData;
use Juzaweb\Support\HookAction;
use Juzaweb\Support\XssCleaner;

class CoreServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->bootMigrations();
        $this->bootPublishes();

        if ($this->app->runningInConsole()) {
            $this->loadFactoriesFrom(__DIR__.'/../../database/factories');
        }

        Validator::extend('recaptcha', '\Juzaweb\Support\Validators\ReCaptcha@validate');
        Schema::defaultStringLength(150);

        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            //$schedule->command('juzaweb:update')->everyMinute();
        });
    }

    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(IdeHelperServiceProvider::class);

            if (config('app.debug')) {
                $this->app->register(DebugbarServiceProvider::class);
            }
        }

        $this->registerSingleton();
        $this->mergeConfigFrom(__DIR__ . '/../../config/juzaweb.php', 'juzaweb');
        $this->mergeConfigFrom(__DIR__ . '/../../config/locales.php', 'locales');
    }

    protected function bootMigrations()
    {
        $mainPath = JW_PACKAGE_PATH . '/database/migrations';
        $directories = glob($mainPath . '/*', GLOB_ONLYDIR);
        $paths = array_merge([$mainPath], $directories);

        $this->loadMigrationsFrom($paths);
    }

    protected function bootPublishes()
    {
        $this->publishes([
            JW_PACKAGE_PATH . '/config/juzaweb.php' => base_path('config/juzaweb.php'),
            JW_PACKAGE_PATH . '/config/locales.php' => base_path('config/locales.php'),
        ], 'juzaweb_config');
    }

    protected function registerSingleton()
    {
        $this->app->singleton(HookActionContract::class, function () {
            return new HookAction();
        });

        $this->app->singleton(GlobalDataContract::class, function () {
            return new GlobalData();
        });

        $this->app->singleton(XssCleanerContract::class, function () {
            return new XssCleaner();
        });
    }
}
