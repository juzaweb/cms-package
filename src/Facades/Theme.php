<?php

namespace Juzaweb\Theme\Facades;

use Illuminate\Support\Facades\Facade;
use Juzaweb\Theme\Contracts\ThemeContract;

/**
 * @method static set(string $theme)
 * @method static has(string $theme)
 * @method static getThemePath(string $theme = null)
 * @method static getThemeInfo(string $theme)
 * @method static get(string $theme)
 * @method static assets(string $path, $theme = null, $secure = null)
 * @method static publicPath(string $theme)
 * @method static \Noodlehaus\Config[] all()
 * @see \Juzaweb\Theme\Managers\Theme
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
