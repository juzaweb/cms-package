<?php

namespace Juzaweb\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Juzaweb\Contracts\ConfigContract;
use Juzaweb\Support\Config as JwConfig;
use Juzaweb\Contracts\ThemeConfigContract;
use Juzaweb\Support\Theme\ThemeConfig;

class DbConfigServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $mail = get_config('email');
        $timezone = get_config('timezone');
        $language = get_config('language');

        if ($mail) {
            $config = [
                'driver'     => 'smtp',
                'host'       => $mail['host'] ?? '',
                'port'       => $mail['port'] ?? '',
                'from'       => [
                    'address'   => $mail['from_address'] ?? '',
                    'name'      => $mail['from_name'] ?? '',
                ],
                'encryption' => $mail['encryption'] ?? '',
                'username'   => $mail['username'] ?? '',
                'password'   => $mail['password'] ?? '',
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
        $this->app->singleton(ConfigContract::class, function () {
            return new JwConfig();
        });

        $this->app->singleton(ThemeConfigContract::class, function () {
            return new ThemeConfig(jw_current_theme());
        });
    }
}
