<?php
/**
 * @package    juzaweb/juzaweb
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
 */

namespace Juzaweb\Providers;

use Juzaweb\Facades\HookAction;
use Juzaweb\Facades\Theme;
use Juzaweb\Support\ServiceProvider;

class HookActionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->booted(function () {
            foreach (static::$actions as $action) {
                app($action)->handle();
            }

            $currentTheme = jw_current_theme();
            Theme::set($currentTheme);

            $config = Theme::getThemeConfig($currentTheme);
            $navMenus = $config->get('nav_menus', []);

            if ($navMenus) {
                HookAction::registerNavMenus($navMenus);
            }

            do_action('juzaweb.init');
        });
    }
}
