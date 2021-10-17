<?php

namespace Juzaweb\Facades;

use Illuminate\Support\Facades\Facade;
use Juzaweb\Contracts\ThemeContract;

/**
 * @method static set(string $theme)
 * @method static has(string $theme)
 * @method static getThemePath(string $theme = null, $path = '')
 * @method static getThemeInfo(string $theme)
 * @method static getScreenshot(string $theme)
 * @method static get(string $theme)
 * @method static assets(string $path, $theme = null, $secure = null)
 * @method static publicPath(string $theme)
 * @method static \Noodlehaus\Config[] all()
 *
 * @see \Juzaweb\Support\Theme\Theme
 */
class Theme extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ThemeContract::class;
    }
}
