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
use Illuminate\Support\Facades\Schema;
use Juzaweb\Console\Commands\UpdateCommand;
use Juzaweb\Contracts\GlobalDataContract;
use Juzaweb\Contracts\HookActionContract;
use Juzaweb\Support\GlobalData;
use Juzaweb\Support\HookAction;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Console\Scheduling\Schedule;

class CoreServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->bootMigrations();
        $this->bootPublishes();
        $this->loadFactoriesFrom(__DIR__ . '/../../database/factories');

        Validator::extend('recaptcha', 'Juzaweb\Validators\Recaptcha@validate');
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

        $this->commands([
            UpdateCommand::class,
        ]);
    }

    protected function bootMigrations()
    {
        $mainPath = __DIR__ . '/../../database/migrations';
        $this->loadMigrationsFrom($mainPath);
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
    }
}
