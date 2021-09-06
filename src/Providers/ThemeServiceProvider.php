<?php

namespace Juzaweb\Cms\Providers;

use Illuminate\Support\ServiceProvider;
use Juzaweb\Cms\Contracts\ThemeContract;
use Juzaweb\Cms\Support\Theme\Theme;

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
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerTheme();
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

    protected function bootPublishes()
    {
        $this->publishes([
            __DIR__ . '/../../config/theme.php' => base_path('config/theme.php'),
        ], 'jw_theme');
    }
}
