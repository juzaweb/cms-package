<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzawebcms/juzawebcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
 */

namespace Juzaweb\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Juzaweb\Http\Middleware\XFrameHeadersMiddleware;
use Juzaweb\Support\BladeMinifyCompiler;

class PerformanceServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (config('juzaweb.performance.deny_iframe')) {
            $this->bootMiddlewares();
        }

        $this->bootSchemeSsl();
    }

    public function register()
    {
        if (config('juzaweb.performance.minify_views')) {
            $this->registerBladeCompiler();
        }
    }

    protected function bootMiddlewares()
    {
        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('web', XFrameHeadersMiddleware::class);
    }

    protected function bootSchemeSsl()
    {
        if (! empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
            if ($_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
                URL::forceScheme('https');
            }
        } else {
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
                URL::forceScheme('https');
            }
        }
    }

    protected function registerBladeCompiler()
    {
        $this->app->singleton('blade.compiler', function ($app) {
            return new BladeMinifyCompiler($app['files'], $app['config']['view.compiled']);
        });
    }
}
