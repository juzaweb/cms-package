<?php

namespace Juzaweb\Providers;

use Illuminate\Support\ServiceProvider;
use Juzaweb\Contracts\ThemeContract;
use Juzaweb\Support\Theme\Theme;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/theme.php', 'theme');

        $this->app->singleton(ThemeContract::class, function ($app) {
            $theme = new Theme($app, $this->app['view']->getFinder(), $this->app['config'], $this->app['translator']);

            return $theme;
        });
    }
}
