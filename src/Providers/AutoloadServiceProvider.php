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

use Composer\Autoload\ClassLoader;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AutoloadServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $plugins = $this->getActivePlugins();
        if (empty($plugins)) {
            return;
        }

        $pluginsFolder = $this->getPluginsPath();
        foreach ($plugins as $pluginInfo) {
            $pluginInfo = json_decode($pluginInfo['class_map'], true);
            foreach ($pluginInfo as $key => $item) {
                $path = Arr::get($item, 'path');
                if (! is_dir($path)) {
                    $path = $pluginsFolder . '/' . $path;
                }

                $namespace = Arr::get($item, 'namespace');
                $domain = Arr::get($item, 'domain');

                if (is_dir($path) && $namespace && $domain) {
                    $this->bootResources($path, $namespace, $domain);
                }
            }
        }
    }

    public function register()
    {
        $pluginsFolder = $this->getPluginsPath();
        $loader = new ClassLoader($pluginsFolder);

        $plugins = $this->getActivePlugins();
        if ($plugins) {
            foreach ($plugins as $pluginInfo) {
                $pluginInfo = json_decode($pluginInfo['class_map'], true);

                foreach ($pluginInfo as $key => $item) {
                    $path = $item['path'];
                    if (!is_dir($path)) {
                        $path = $pluginsFolder . '/' . $path;
                    }

                    $namespace = Arr::get($item, 'namespace');

                    $loader->setPsr4($namespace, [$path]);
                    if (is_dir($path) && $namespace) {
                        $this->registerPlugin($path, $namespace);
                    }
                }
            }
        }

        $loader->register(true);
    }

    protected function registerPlugin($path, $namespace)
    {
        $this->registerDatabase($path);
        $this->registerRoute($path, $namespace);
    }

    protected function registerDatabase($path)
    {
        $factoryPath = $path . '/../database/factories';
        if (is_dir($factoryPath)) {
            if ($this->app->runningInConsole()) {
                $this->loadFactoriesFrom($factoryPath);
            }
        }
    }

    protected function getActivePlugins()
    {
        $status = DB::table('configs')
            ->where('code', '=', 'plugin_statuses')
            ->first(['value']);

        return json_decode($status->value, true);
    }

    protected function getPluginsPath()
    {
        return config('juzaweb.plugin.path');
    }

    protected function registerRoute($path, $namespace)
    {
        $namespace = $namespace . 'Http\Controllers';

        $adminRoute = $path . '/routes/admin.php';
        $apiRoute = $path . '/routes/api.php';

        if (file_exists($adminRoute)) {
            Route::middleware('admin')
                ->namespace($namespace)
                ->prefix(config('juzaweb.admin_prefix'))
                ->group($path . '/routes/admin.php');
        }

        if (file_exists($apiRoute)) {
            Route::middleware('api')
                ->namespace($namespace)
                ->prefix('api')
                ->group($path . '/routes/api.php');
        }
    }

    public function bootResources($path, $namespace, $domain)
    {
        $sourcePath = $path .'/resources/views';
        $langPath = $path . '/resources/lang';
        $assetsPath = $path .'/resources/assets';

        if (is_dir($sourcePath)) {
            $this->loadViewsFrom($sourcePath, $domain);

            $viewPublic = resource_path('views/vendor/' . $domain);
            $this->publishes([
                $sourcePath => $viewPublic,
            ], $domain . '_views');
        }

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $domain);
            $langPublic = resource_path('lang/vendor/' . $domain);

            $this->publishes([
                $langPath => $langPublic,
            ], $domain . '_lang');
        }

        if (is_dir($assetsPath)) {
            $assetsPublic = public_path('jw-styles/plugins/' . $namespace . '/assets');
            $this->publishes([
                $assetsPath => $assetsPublic,
            ], $domain . '_assets');
        }
    }
}
