<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Providers;

use Illuminate\Support\ServiceProvider;

class CmsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerProviders();
    }

    protected function registerProviders()
    {
        $this->app->register(InstallerServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(BackendServiceProvider::class);
        $this->app->register(HooksServiceProvider::class);
        $this->app->register(CoreServiceProvider::class);
        $this->app->register(BackendServiceProvider::class);
        $this->app->register(DbConfigServiceProvider::class);
        $this->app->register(HookActionServiceProvider::class);
        $this->app->register(PerformanceServiceProvider::class);
        $this->app->register(FilemanagerServiceProvider::class);
        $this->app->register(HooksServiceProvider::class);
        $this->app->register(HookBladeServiceProvider::class);
        $this->app->register(PostTypeServiceProvider::class);
        $this->app->register(PluginServiceProvider::class);
        $this->app->register(ThemeServiceProvider::class);
        $this->app->register(TranslationServiceProvider::class);
        $this->app->register(LogViewerServicesProvider::class);
        //$this->app->register(SwaggerServiceProvider::class);
    }
}
