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
 * Date: 8/14/2021
 * Time: 5:13 PM
 */

namespace Juzaweb\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Juzaweb\Facades\HookAction;
use Illuminate\Support\Arr;

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
            foreach ($pluginInfo as $key => $item) {
                $path = $pluginsFolder . '/' . $item['path'];
                $namespace = Arr::get($item, 'namespace');
                $domain = Arr::get($item, 'domain');

                if (is_dir($path) && $namespace && $domain) {
                    $this->bootResources($path, $namespace, $domain);
                    $actionPath = $path .'/../actions';

                    if (is_dir($actionPath)) {
                        HookAction::loadActionForm($actionPath);
                    }
                }
            }
        }
    }

    public function register()
    {
        $plugins = $this->getActivePlugins();
        if (empty($plugins)) {
            return;
        }

        $pluginsFolder = $this->getPluginsPath();

        foreach ($plugins as $pluginInfo) {
            foreach ($pluginInfo as $key => $item) {
                $path = $pluginsFolder . '/' . $item['path'];
                $namespace = Arr::get($item, 'namespace');

                if (is_dir($path) && $namespace) {
                    $this->registerPlugin($path);
                }
            }
        }
    }

    protected function registerPlugin($path)
    {
        $this->registerDatabase($path);
    }

    protected function registerDatabase($path)
    {
        if ($this->app->runningInConsole()) {
            app(Factory::class)->load($path . '/database/factories');
        }
    }

    protected function getActivePlugins()
    {
        $pluginFile = base_path('bootstrap/cache/plugins_statuses.php');
        if (!file_exists($pluginFile)) {
            return false;
        }

        $plugins = require $pluginFile;
        return $plugins;
    }

    protected function getPluginsPath()
    {
        return base_path('plugins');
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
            $assetsPublic = public_path('plugins/' . $namespace . '/assets');
            $this->publishes([
                $assetsPath => $assetsPublic,
            ], $domain . '_assets');
        }
    }
}