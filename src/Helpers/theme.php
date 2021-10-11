<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Juzaweb\Facades\HookAction;
use Juzaweb\Facades\Theme;
use Juzaweb\Facades\ThemeConfig;
use Juzaweb\Models\Menu;
use Juzaweb\Support\Theme\MenuBuilder;

function body_class($class = '')
{
    $class = trim('jw-theme jw-theme-body ' . $class);

    return apply_filters('theme.body_class', $class);
}

function theme_assets(string $path)
{
    $path = str_replace('assets/', '', $path);

    return Theme::assets($path);
}

if (! function_exists('page_url')) {
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

if (! file_exists('jw_theme_info')) {
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

if (! function_exists('jw_current_theme')) {
    /**
     * Get current active theme
     *
     * @return string
     */
    function jw_current_theme()
    {
        $themeFile = JW_BASEPATH . '/bootstrap/cache/theme_statuses.php';

        if (file_exists($themeFile)) {
            $theme = require $themeFile;
        } else {
            $theme = [
                'namespace' => 'Theme\\',
                'path' => JW_BASEPATH . '/themes/default',
                'name' => 'default',
            ];
        }

        return $theme['name'];
    }
}

if (! function_exists('jw_theme_config')) {
    /**
     * Get particular theme all information.
     *
     * @param string|null $theme
     * @return Collection
     */
    function jw_theme_config(string $theme = null)
    {
        if (empty($theme)) {
            $theme = jw_current_theme();
        }

        return Theme::getThemeConfig($theme);
    }
}

if (! function_exists('home_page')) {
    function jw_home_page()
    {
        return apply_filters('get_home_page', get_config('home_page'));
    }
}

if (! function_exists('get_name_template_part')) {
    /**
     * Get template part name.
     *
     * @param string $type // Singular of post
     * @param string $slug
     * @param string $name
     * @return string
     */
    function get_name_template_part($type, $slug, $name = null)
    {
        $name = (string) $name;

        if ($name !== '') {
            $template = "{$slug}-{$name}";
            if (view()->exists('theme::template-parts.' . $template)) {
                return $template;
            }
        }

        if (! in_array($type, ['post', 'page'])) {
            $template = "{$slug}-{$type}";
            if (view()->exists('theme::template-parts.' . $template)) {
                return $template;
            }
        }

        return $slug;
    }
}

if (! function_exists('get_template_part')) {

    /**
     * Loads a template part into a template.
     *
     * @param \Juzaweb\Traits\PostTypeModel $post
     * @param string $slug
     * @param string $name
     * @param array $args
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function get_template_part($post, $slug, $name = null, $args = [])
    {
        do_action("get_template_part_{$slug}", $post, $slug, $name, $args);

        $name = (string)$name;
        $type = $post ? $post->getPostType('singular') : 'none';
        $template = get_name_template_part($type, $slug, $name);

        return view('theme::template-parts.'.$template, [
            'post' => $post,
        ]);
    }
}

if (! function_exists('jw_menu_items')) {
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

if (! function_exists('jw_page_menu')) {
    function jw_page_menu($args)
    {
        return trans('juzaweb::app.menu_not_found');
    }
}

if (! function_exists('jw_nav_menu')) {
    function jw_nav_menu($args = [])
    {
        $defaults = [
            'menu' => '',
            'container_before' => '<ul class="navbar-nav">',
            'container_after' => '</ul>',
            'fallback_cb' => 'jw_page_menu',
            'theme_location' => '',
            'item_view' => view('juzaweb::items.menu_item'),
        ];

        $args = array_merge($defaults, $args);
        $menu = null;

        if ($args['menu']) {
            $menu = $args['menu'];
        }

        if ($args['theme_location']) {
            $menu = get_menu_by_theme_location($args['theme_location']);
        }

        if (empty($menu)) {
            return call_user_func($args['fallback_cb'], $args);
        }

        $items = jw_menu_items($menu);
        $builder = new MenuBuilder($items, $args);

        return $builder->render();
    }
}

if (! function_exists('set_theme_config')) {
    function set_theme_config($key, $value)
    {
        return ThemeConfig::setConfig($key, $value);
    }
}

if (! function_exists('get_theme_config')) {
    function get_theme_config($key, $default = null)
    {
        return ThemeConfig::getConfig($key, $default);
    }
}

if (! function_exists('get_theme_mod')) {
    function get_theme_mod($key, $default = null)
    {
        return ThemeConfig::getConfig($key, $default);
    }
}

if (! file_exists('get_menu_by_theme_location')) {
    function get_menu_by_theme_location($location)
    {
        $locations = get_theme_config('nav_location');
        $menuId = $locations[$location] ?? null;
        if ($menuId) {
            return Menu::find($menuId);
        }

        return null;
    }
}

if (! function_exists('get_logo')) {
    function get_logo($default = null)
    {
        return upload_url(
            get_config('logo'),
            asset($default ?: 'vendor/juzaweb/styles/images/logo.svg')
        );
    }
}

if (! function_exists('get_icon')) {
    function get_icon($default = null)
    {
        return upload_url(
            get_config('icon'),
            asset($default ?: 'vendor/juzaweb/styles/images/favicon.ico')
        );
    }
}

if (! function_exists('is_home')) {
    function is_home()
    {
        return Route::currentRouteName() == 'home';
    }
}

if (! function_exists('page_block')) {
    function page_block($key)
    {
    }
}

if (! function_exists('jw_get_sidebar')) {
    function jw_get_sidebar($key)
    {
        return HookAction::getSidebars($key);
    }
}

if (! function_exists('jw_get_widgets_sidebar')) {
    function jw_get_widgets_sidebar($key)
    {
        $content = get_theme_config('sidebar_' . $key);

        return collect($content);
    }
}

if (! function_exists('dynamic_sidebar')) {
    function dynamic_sidebar($key)
    {
        $sidebar = HookAction::getSidebars($key);
        if (empty($sidebar)) {
            return '';
        }

        $widgets = jw_get_widgets_sidebar($key);

        return view('juzaweb::components.dynamic_sidebar', compact(
            'widgets',
            'sidebar'
        ));
    }
}

if (! function_exists('installed_themes')) {
    function installed_themes()
    {
        $themes = Theme::all();

        return array_keys($themes);
    }
}

if (! function_exists('comment_template')) {
    /**
     * Show comments frontend
     *
     * @param \Juzaweb\Traits\PostTypeModel $post
     * @param string $view
     * @return \Illuminate\View\View
     */
    function comment_template($post, $view = null)
    {
        if (empty($view) || ! view()->exists($view)) {
            $view = 'juzaweb::items.frontend_comment';
        }

        $comments = $post->comments()
            ->with(['user'])
            ->whereApproved()
            ->paginate(10);

        return view($view, compact(
            'comments'
        ));
    }
}
