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

use Illuminate\Support\ServiceProvider;
use Juzaweb\Facades\HookAction;
use Juzaweb\Support\Locale;

class TranslationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../views', 'jw_trans');
        HookAction::loadActionForm(__DIR__ . '/../../actions');

        $mainPath = __DIR__ . '/../database/migrations';
        $this->loadMigrationsFrom($mainPath);
    }

    public function register()
    {
        $this->app->singleton('juzaweb.locale', function () {
            return new Locale();
        });
    }
}
