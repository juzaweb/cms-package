<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

use Juzaweb\Cms\Facades\Theme;
use Juzaweb\Cms\Models\Menu;
use Juzaweb\Cms\Support\Theme\MenuBuilder;
use Juzaweb\Cms\Facades\ThemeConfig;
use Illuminate\Support\Collection;

function body_class($class = '')
{
    $class = trim('jw-theme jw-theme-body ' . $class);

    return apply_filters('theme.body_class', $class);
}

function theme_assets(string $path)
{
    return Theme::assets($path);
}

if (!function_exists('page_url')) {
    function page_url($slug)
    {
        return url()->to($slug);
    }
}

/**
 * Get particular theme all information.
 *
 * @param string $theme
 * @return string
 */
function theme_path(string $theme)
{
    return Theme::getThemePath($theme);
}

if (!file_exists('jw_theme_info')) {
    /**
     * Get particular theme all information.
     *
     * @param string|null $theme
     * @return null|Config
     */
    function jw_theme_info(string $theme = null)
    {
        if (empty($theme)) {
            return jw_theme_info(jw_current_theme());
        }

        return Theme::getThemeInfo($theme);
    }
}

if (!function_exists('jw_current_theme')) {
    function jw_current_theme()
    {
        return get_config('activated_theme', 'default');
    }
}

if (!function_exists('jw_theme_config')) {
    /**
     * Get particular theme all information.
     *
     * @param string|null $theme
     * @return Collection
     */
    function jw_theme_config(string $theme = null)
    {
        $config = (jw_theme_info($theme))->get('config');
        return $config ?? new Collection([]);
    }
}

if (!function_exists('home_page')) {
    function jw_home_page()
    {
        return apply_filters('get_home_page', get_config('home_page'));
    }
}

/**
 * Loads a template part into a template.
 *
 * @param \Juzaweb\Cms\Models\Model $post
 * @param string $slug
 * @param string $name
 * @param array $args
 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
 */
function get_template_part($post, $slug, $name = null, $args = [])
{
    do_action("get_template_part_{$slug}", $post, $slug, $name, $args);

    $name = (string) $name;

    if ($name !== '') {
        $template = "{$slug}-{$name}";

        if (view()->exists('theme::template-parts.' . $template)) {
            return view('theme::template-parts.' . $template, [
                'post' => $post
            ]);
        }
    }

    return view('theme::template-parts.' . $slug, [
        'post' => $post
    ]);
}

if (!function_exists('jw_menu_items')) {
    /**
     * Get menu item in menu
     *
     * @param Menu $menu
     * @return Collection
     */
    function jw_menu_items($menu)
    {
        return $menu->items()
            ->orderBy('num_order', 'ASC')
            ->get();
    }
}

if (!function_exists('jw_page_menu')) {
    function jw_page_menu()
    {

    }
}

if (!function_exists('jw_nav_menu')) {
    function jw_nav_menu($args = [])
    {
        $defaults = [
            'menu' => '',
            'container_before' => '',
            'container_after' => '',
            'fallback_cb' => 'jw_page_menu',
            'theme_location' => '',
            'item_view' => '',
        ];

        $args = array_merge($defaults, $args);

        $items = jw_menu_items($args['menu']);
        $builder = new MenuBuilder($items, $args);

        return $builder->render();
    }
}

if (!function_exists('set_theme_config')) {
    function set_theme_config($key, $value)
    {
        return ThemeConfig::setConfig($key, $value);
    }
}

if (!function_exists('get_theme_config')) {
    function get_theme_config($key, $default = null)
    {
        return ThemeConfig::getConfig($key, $default);
    }
}

if (!function_exists('get_theme_mod')) {
    function get_theme_mod($key, $default = null)
    {
        return ThemeConfig::getConfig($key, $default);
    }
}
