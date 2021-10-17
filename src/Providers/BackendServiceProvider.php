<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzawebcms/juzawebcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
 *
 * Created by JUZAWEB.
 * Date: 6/19/2021
 * Time: 6:31 PM
 */

namespace Juzaweb\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Juzaweb\Actions\EnqueueStyleAction;
use Juzaweb\Actions\MenuAction;
use Juzaweb\Http\Middleware\Admin;
use Juzaweb\Support\Html\Field;
use Juzaweb\Support\Macros\RouterMacros;
use Juzaweb\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->bootMiddlewares();
        $this->bootPublishes();
        $this->registerAction([
            MenuAction::class,
            EnqueueStyleAction::class,
        ]);
    }

    public function register()
    {
        $this->registerRouteMacros();
        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Field', Field::class);
        });
    }

    protected function bootMiddlewares()
    {
        $this->app['router']->aliasMiddleware('admin', Admin::class);
    }

    protected function bootPublishes()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'juzaweb');
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/juzaweb'),
        ], 'juzaweb_views');

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'juzaweb');
        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/juzaweb'),
        ], 'juzaweb_lang');

        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('jw-styles/juzaweb'),
        ], 'juzaweb_assets');
    }

    protected function registerRouteMacros()
    {
        Router::mixin(new RouterMacros());
    }
}
