<?php
/**
 * MYMO CMS - Free Laravel CMS
 *
 * @package    juzacmscms/juzacmscms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzacmscms/juzacmscms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 6/19/2021
 * Time: 6:31 PM
 */

namespace Juzaweb\Cms\Backend\Providers;

use Illuminate\Support\ServiceProvider;
use Juzaweb\Cms\Backend\Http\Middleware\Admin;
use Illuminate\Routing\Router;
use Juzaweb\Cms\Backend\Macros\RouterMacros;
use Juzaweb\Cms\Core\Facades\HookAction;

class BackendServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->bootMiddlewares();
        $this->bootPublishes();
        HookAction::loadActionForm(__DIR__ . '/../actions');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'juzacms');

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'juzacms');
    }

    public function register()
    {
        $this->registerRouteMacros();
    }

    protected function bootMiddlewares()
    {
        $this->app['router']->aliasMiddleware('admin', Admin::class);
    }

    protected function bootPublishes()
    {
        $this->publishes([
            __DIR__ . '/../../../assets' => public_path('juzacms'),
        ], 'juzacms_assets');

        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('vendor/juzacmscms'),
        ], 'juzacms_lang');
    }

    protected function registerRouteMacros()
    {
        Router::mixin(new RouterMacros());
    }
}