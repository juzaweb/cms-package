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

namespace Juzaweb\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CmsServiceProvider extends ServiceProvider
{
    public function register()
    {
        if (!$this->checkDbInstall()) {
            $this->app->register(InstallerServiceProvider::class);
        } else {
            $this->registerProviders();
        }
    }

    protected function registerProviders()
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
        $this->app->register(PluginServiceProvider::class);
        $this->app->register(ThemeServiceProvider::class);
        $this->app->register(TranslationServiceProvider::class);
        //$this->app->register(SwaggerServiceProvider::class);
    }

    protected function checkDbInstall()
    {
        try {
            DB::connection()->getPdo();

        } catch (\Exception $e) {
            return false;
        }

        if (!Schema::hasTable('configs')) {
            return false;
        }

        if (!Schema::hasTable('users')) {
            return false;
        }

        return DB::table('users')
            ->where('is_admin', '=', 1)
            ->exists();
    }
}
