<?php

namespace Juzaweb\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Juzaweb\Contracts\ConfigContract;
use Juzaweb\Contracts\ThemeConfigContract;
use Juzaweb\Support\Installer;
use Juzaweb\Support\Theme\ThemeConfig;

class DbConfigServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (! Installer::alreadyInstalled()) {
            return;
        }

        $mail = get_config('email');
        $timezone = get_config('timezone');
        $language = get_config('language');

        if ($mail) {
            $config = [
                'driver' => 'smtp',
                'host' => $mail['host'] ?? '',
                'port' => $mail['port'] ?? '',
                'from' => [
                    'address' => $mail['from_address'] ?? '',
                    'name' => $mail['from_name'] ?? '',
                ],
                'encryption' => $mail['encryption'] ?? '',
                'username' => $mail['username'] ?? '',
                'password' => $mail['password'] ?? '',
            ];

            Config::set('mail', $config);
        }

        if ($timezone) {
            Config::set('app.timezone', $timezone);
            date_default_timezone_set($timezone);
        }

        if ($language) {
            Config::set('app.locale', $language);
        }
    }

    public function register()
    {
        if (! Installer::alreadyInstalled()) {
            return;
        }

        $this->app->singleton(ConfigContract::class, function ($app) {
            return new \Juzaweb\Support\Config($app);
        });

        $this->app->singleton(ThemeConfigContract::class, function ($app) {
            return new ThemeConfig($app, jw_current_theme());
        });
    }
}
