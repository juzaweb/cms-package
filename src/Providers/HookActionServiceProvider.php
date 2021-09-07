<?php
/**
 * @package    juzaweb/juzaweb
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
 */

namespace Juzaweb\Cms\Providers;

use Juzaweb\Cms\Support\ServiceProvider;

class HookActionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->booted(function () {
            foreach (static::$actions as $action) {
                app($action)->handle();
            }

            do_action('juzaweb.init');
        });
    }
}
