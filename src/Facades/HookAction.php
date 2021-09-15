<?php

namespace Juzaweb\Facades;

use Illuminate\Support\Facades\Facade;
use Juzaweb\Contracts\HookActionContract;

/**
 * @method static addAdminMenu(string $menuTitle, $menuSlug, array $args)
 * @method static registerMenuItem(string $key, $componentClass)
 * @method static registerPostType(string $key, $args = [])
 * @method static registerTaxonomy(string $taxonomy, $objectType, $args = [])
 * @method static registerPermalink(string $postType, array $args = [])
 * @method static addSettingForm($key, $args = [])
 * @method static mixed applyFilters($tag, $value, ...$args)
 * @method static void addFilter($tag, $callback, $priority = 20, $arguments = 1)
 * @method static void addAction($tag, $callback, $priority = 20, $arguments = 1)
 * @method static void registerMenuBox($tag, array $args = [])
 * @method static void enqueueScript($key, $src = '', $ver = '1.0', $inFooter = false)
 * @method static void enqueueStyle($key, $src = '', $ver = '1.0', $inFooter = false)
 * @method static void registerNavMenus($locations = [])
 * @method static void registerPageBlock($key, $args = [])
 * @method static array getMenuBoxs(array $keys = [])
 * @method static \Illuminate\Support\Collection getMenuBox(string $key)
 * @method static \Illuminate\Support\Collection getPermalinks(string $key = null)
 * @method static \Illuminate\Support\Collection getPostTypes($postType = null)
 * @method static \Illuminate\Support\Collection getTaxonomies($postType = null)
 * @method static void registerEmailHook(string $key, $args = [])
 * @method static \Illuminate\Support\Collection getEmailHooks($key = null)
 *
 * @see \Juzaweb\Support\HookAction
 */
class HookAction extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return HookActionContract::class;
    }
}
