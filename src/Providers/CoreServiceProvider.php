<?php
/**
 *
 *
 * @package    juzawebcms/juzawebcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
 *
 * Created by JUZAWEB.
 * Date: 5/25/2021
 * Time: 9:53 PM
 */

namespace Juzaweb\Cms\Providers;

use Barryvdh\Debugbar\ServiceProvider as DebugbarServiceProvider;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\Facades\Schema;
use Juzaweb\Cms\Console\Commands\UpdateCommand;
use Juzaweb\Cms\Support\HookAction;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Console\Scheduling\Schedule;
use Juzaweb\Cms\Support\PostType;

class CoreServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->bootMigrations();
        $this->bootPublishes();
        $this->loadFactoriesFrom(__DIR__ . '/../database/factories');

        Validator::extend('recaptcha', 'Juzaweb\Cms\Validators\Recaptcha@validate');
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
        $mainPath = __DIR__ . '/../database/migrations';
        $this->loadMigrationsFrom($mainPath);
    }

    protected function bootPublishes()
    {
        $this->publishes([
            __DIR__ . '/../../config/juzaweb.php' => base_path('config/juzaweb.php'),
            __DIR__ . '/../../config/locales.php' => base_path('config/locales.php'),
        ], 'juzaweb_config');
    }

    protected function registerSingleton()
    {
        $this->app->singleton('juzaweb.hook', function () {
            return new HookAction();
        });

        $this->app->singleton('juzaweb.post_type', function () {
            return new PostType();
        });
    }
}