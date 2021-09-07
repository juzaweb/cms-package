<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 *
 * Created by JUZAWEB.
 * Date: 8/12/2021
 * Time: 3:58 PM
 */

namespace Juzaweb\Cms\Providers;

use Illuminate\Support\ServiceProvider;

class CmsServiceProvider extends ServiceProvider
{
    public function register()
    {
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
        $this->app->register(InstallerServiceProvider::class);
        $this->app->register(PluginServiceProvider::class);
        $this->app->register(ThemeServiceProvider::class);
        //$this->app->register(SwaggerServiceProvider::class);
    }
}
