<?php
/**
 * @package    juzaweb/juzaweb
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
 */

namespace Juzaweb\Providers;

use Illuminate\Support\Facades\File;
use Juzaweb\Facades\Theme;
use Juzaweb\Support\Installer;
use Juzaweb\Support\ServiceProvider;

class HookActionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->booted(function () {
            foreach (static::$actions as $action) {
                app($action)->handle();
            }

            /*if (Installer::alreadyInstalled()) {
                $currentTheme = jw_current_theme();
                $themePath = Theme::getThemePath($currentTheme);
                if (is_dir($themePath)) {
                    Theme::set($currentTheme);

                    $actionPath = $themePath . '/src/Actions';
                    if (is_dir($actionPath)) {
                        $files = File::files($actionPath);
                        foreach ($files as $file) {
                            app('Theme\Actions\\' . str_replace('.php', '', $file->getFilename()))->handle();
                        }
                    }
                }
            }*/

            $currentTheme = jw_current_theme();
            Theme::set($currentTheme);

            do_action('juzaweb.init');
        });
    }
}
