<?php
/**
 *
 *
 * @package    juzawebcms/juzawebcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 5/25/2021
 * Time: 9:53 PM
 */

namespace Juzaweb\Cms\Providers;

use Illuminate\Support\Facades\Schema;
use Juzaweb\Cms\Backend\Providers\BackendServiceProvider;
use Juzaweb\Cms\Backend\Providers\RouteServiceProvider;
use Juzaweb\Cms\Core\Helpers\HookAction;
use Juzaweb\Cms\Email\Providers\EmailTemplateServiceProvider;
use Juzaweb\Cms\FileManager\Providers\FilemanagerServiceProvider;
use Juzaweb\Cms\Notification\Providers\NotificationServiceProvider;
use Juzaweb\Cms\Performance\Providers\PerformanceServiceProvider;
use Juzaweb\Cms\Plugin\PluginServiceProvider;
use Juzaweb\Cms\PostType\Providers\PostTypeServiceProvider;
use Juzaweb\Cms\Repository\Providers\RepositoryServiceProvider;
use Juzaweb\Cms\Theme\Providers\ThemeServiceProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Juzaweb\Cms\Updater\UpdaterServiceProvider;
use Juzaweb\Cms\Installer\Providers\InstallerServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->bootMigrations();
        $this->bootPublishes();
        $this->loadFactoriesFrom(__DIR__ . '/../../database/factories');

        Validator::extend('recaptcha', 'Juzaweb\Cms\Core\Validators\Recaptcha@validate');
        Schema::defaultStringLength(150);
    }

    public function register()
    {
        $this->registerProviders();
        $this->registerSingleton();
        $this->mergeConfigFrom(__DIR__ . '/../../config/juzaweb.php', 'juzaweb');
    }

    protected function bootMigrations()
    {
        $mainPath = __DIR__ . '/../../database/migrations';
        $this->loadMigrationsFrom($mainPath);
    }

    protected function bootPublishes()
    {
        $this->publishes([
            __DIR__ . '/../../config/juzaweb.php' => base_path('config/juzaweb.php'),
        ], 'juzaweb_config');

        $this->publishes([
            __DIR__ . '/../Backend/resources/views' => resource_path('vendor/juzaweb/resources/views'),
        ], 'juzaweb_views');

        $this->publishes([
            __DIR__ . '/../Backend/resources/lang' => resource_path('vendor/juzaweb/resources/lang'),
        ], 'juzaweb_lang');
    }

    protected function registerProviders()
    {
        //$this->app->register(UpdaterServiceProvider::class);
        $this->app->register(BackendServiceProvider::class);
        $this->app->register(InstallerServiceProvider::class);
        $this->app->register(DbConfigServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(HookActionServiceProvider::class);
        $this->app->register(PerformanceServiceProvider::class);
        $this->app->register(FilemanagerServiceProvider::class);
        //$this->app->register(RepositoryServiceProvider::class);
        $this->app->register(PostTypeServiceProvider::class);
        //$this->app->register(NotificationServiceProvider::class);
        //$this->app->register(EmailTemplateServiceProvider::class);
        //$this->app->register(ThemeServiceProvider::class);
        //$this->app->register(PluginServiceProvider::class);
    }

    protected function registerSingleton()
    {
        $this->app->singleton('juzaweb.hook', function () {
            return new HookAction();
        });
    }
}