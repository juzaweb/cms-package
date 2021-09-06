<?php

namespace Juzaweb\Theme\Providers;

use Illuminate\Support\ServiceProvider;
use Juzaweb\Cms\Facades\HookAction;
use Juzaweb\Theme\Console\ThemeGeneratorCommand;
use Juzaweb\Theme\Console\ThemeListCommand;
use Juzaweb\Theme\Console\ThemePublishCommand;
use Juzaweb\Theme\Contracts\ThemeContract;
use Juzaweb\Theme\Managers\Theme;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootPublishes();
        $this->bootMigrations();

        HookAction::loadActionForm(__DIR__ . '/../../actions');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerTheme();
        $this->consoleCommand();
        $this->mergeConfigFrom(__DIR__ . '/../../config/theme.php', 'theme');
    }

    /**
     * Register theme required components .
     *
     * @return void
     */
    public function registerTheme()
    {
        $this->app->singleton(ThemeContract::class, function ($app) {
            $theme = new Theme($app, $this->app['view']->getFinder(), $this->app['config'], $this->app['translator']);
            return $theme;
        });
    }

    protected function bootMigrations()
    {
        $mainPath = __DIR__ . '/../database/migrations';
        $this->loadMigrationsFrom($mainPath);
    }

    /**
     * Add Commands.
     *
     * @return void
     */
    public function consoleCommand()
    {
        $this->commands([
            ThemeGeneratorCommand::class,
            ThemeListCommand::class,
            ThemePublishCommand::class
        ]);
    }

    protected function bootPublishes()
    {
        $this->publishes([
            __DIR__ . '/../../config/theme.php' => base_path('config/theme.php'),
        ], 'jw_theme');

        $this->loadViewsFrom(__DIR__ . '/../views', 'jw_theme');
        $this->publishes([
            __DIR__ . '/../views' => resource_path('views/vendor/jw_theme'),
        ], 'jw_theme_views');
    }
}
