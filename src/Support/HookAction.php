<?php
/**
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Cms\Support;

use Illuminate\Support\Collection;
use Juzaweb\Cms\Facades\Hook;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Juzaweb\Cms\Abstracts\MenuBoxAbstract;
use Juzaweb\Cms\Models\Taxonomy;
use Juzaweb\Cms\Support\Theme\PostTypeMenuBox;
use Juzaweb\Cms\Support\Theme\TaxonomyMenuBox;

class HookAction
{
    /**
     * Add hook actions folder
     *
     * @param string $path
     **/
    public function loadActionForm($path)
    {
        add_filters('juzaweb.actions', function ($items) use ($path) {
            $items[] = $path;
            return collect($items)->unique();
        });
    }

    /**
     * Registers menu item in menu builder.
     *
     * @param string $postType
     * @param array $args
     * @throws \Exception
     * */
    public function registerPermalink($postType, $args = [])
    {
        if (empty($args['label'])) {
            throw new \Exception('Permalink args label is required');
        }

        if (empty($args['base'])) {
            throw new \Exception('Permalink args default_base is required');
        }

        $args = new Collection(array_merge([
            'label' => '',
            'base' => '',
            'callback' => '',
            'priority' => 20,
            'position' => 20,
        ], $args));

        add_filters('juzaweb.permalinks', function ($items) use ($postType, $args) {
            $args['key'] = $postType;
            $items[$postType] = collect($args);
            return $items;
        }, $args->get('priority'));
    }

    public function addAction($tag, $callback, $priority = 20, $arguments = 1)
    {
        Hook::addAction($tag, $callback, $priority, $arguments);
    }

    public function addFilter($tag, $callback, $priority = 20, $arguments = 1)
    {
        Hook::addFilter($tag, $callback, $priority, $arguments);
    }

    public function applyFilters($tag, $value, ...$args)
    {
        return Hook::filter($tag, $value, ...$args);
    }

    /**
     * Add setting form
     * @param string $key
     * @param array $args
     *      - name : Name form setting
     *      - view : View form setting
     */
    public function addSettingForm($key, $args = [])
    {
        Hook::addFilter('admin.general_settings.forms', function ($items) use ($key, $args) {
            $items[$key] = $args;
            return $items;
        }, $args['priority'] ?? 10);
    }

    /**
     * Add a top-level menu page.
     *
     * This function takes a capability which will be used to determine whether
     * or not a page is included in the menu.
     *
     * The function which is hooked in to handle the output of the page must check
     * that the user has the required capability as well.
     *
     * @param string $menuTitle The trans key to be used for the menu.
     * @param string $menuSlug The url name to refer to this menu by. not include admin-cp
     * @param array $args
     * - string $icon Url icon or fa icon fonts
     * - string $parent The parent of menu. Default null
     * - int $position The position in the menu order this item should appear.
     * @return bool.
     */
    public function addAdminMenu($menuTitle, $menuSlug, $args = [])
    {
        $opts = [
            'title' => $menuTitle,
            'key' => $menuSlug,
            'icon' => 'fa fa-list-ul',
            'url' => str_replace('.', '/', $menuSlug),
            'parent' => null,
            'position' => 20,
        ];
        $item = array_merge($opts, $args);

        return add_filters('juzaweb.admin_menu', function ($menu) use ($item) {
            if ($item['parent']) {
                $menu[$item['parent']]['children'][$item['key']] = $item;
            } else {
                if (Arr::has($menu, $item['key'])) {
                    if (Arr::has($menu[$item['key']], 'children')) {
                        $item['children'] = $menu[$item['key']]['children'];
                    }
                    $menu[$item['key']] = $item;
                } else {
                    $menu[$item['key']] = $item;
                }
            }

            return $menu;
        });
    }

    /**
     * Register menu box
     *
     * @param string $key
     * @param array $args
     */
    public function registerMenuBox($key, $args = [])
    {
        $opts = [
            'title' => '',
            'key' => $key,
            'group' => '',
            'menu_box' => '',
            'priority' => 20,
        ];

        $item = array_merge($opts, $args);

        /**
         * @var MenuBoxAbstract $menuBox
         */
        $menuBox = $item['menu_box'];

        add_filters('juzaweb.menu_boxs', function ($items) use ($key, $item) {
            $items[$key] = collect($item);
            return $items;
        }, $item['priority']);

        add_action('juzaweb.add_menu_items', function () use (
            $key,
            $item,
            $menuBox
        ) {
            echo view('juzaweb::backend.items.menu_box', [
                'label' => $item['title'],
                'key' => $key,
                'slot' => $menuBox->addView()->render()
            ])->render();
        }, $item['priority']);
    }

    /**
     * Get registed menu box
     *
     * @param string|array $keys
     * @return array
     */
    public function getMenuBoxs($keys = [])
    {
        $menuBoxs = $this->applyFilters('juzaweb.menu_boxs', []);
        if ($keys) {
            if (is_string($keys)) {
                $keys = [$keys];
            }

            return array_only($menuBoxs, $keys);
        }

        return $menuBoxs;
    }

    /**
     * Get registed menu box
     *
     * @param string|array $key
     * @return \Illuminate\Support\Collection|false
     */
    public function getMenuBox($key)
    {
        $menuBoxs = $this->applyFilters('juzaweb.menu_boxs', []);
        if ($key) {
            return Arr::get($menuBoxs, $key);
        }

        return false;
    }

    /**
     * JUZAWEB CMS: Creates or modifies a taxonomy object.
     * @param string $taxonomy (Required) Taxonomy key, must not exceed 32 characters.
     * @param array|string $objectType
     * @param array $args (Optional) Array of arguments for registering a post type.
     * @return void
     *
     * @throws \Exception
     */
    public function registerTaxonomy($taxonomy, $objectType, $args = [])
    {
        $objectTypes = is_string($objectType) ? [$objectType] : $objectType;
        foreach ($objectTypes as $objectType) {
            $type = Str::singular($objectType);
            $menuSlug = $type . '.' . $taxonomy;

            $opts = [
                'label_type' => ucfirst($type) .' '. $args['label'],
                'priority' => 20,
                'description' => '',
                'hierarchical' => false,
                'parent' => $objectType,
                'menu_slug' => $menuSlug,
                'menu_position' => 20,
                'model' => Taxonomy::class,
                'menu_icon' => 'fa fa-list',
                'show_in_menu' => true,
                'menu_box' => true,
                'rewrite' => true,
                'supports' => [
                    'thumbnail',
                    'hierarchical'
                ],
            ];

            $args['type'] = $type;
            $args['post_type'] = $objectType;
            $args['taxonomy'] = $taxonomy;
            $args['singular'] = Str::singular($taxonomy);
            $args = new Collection(array_merge($opts, $args));

            add_filters('juzaweb.taxonomies', function ($items) use ($taxonomy, $objectType, $args) {
                $items[$objectType][$taxonomy] = $args;
                return $items;
            }, $args->get('priority'));

            if ($args->get('show_in_menu')) {
                $this->addAdminMenu(
                    $args->get('label'),
                    $menuSlug,
                    [
                        'icon' => $args->get('menu_icon', 'fa fa-list'),
                        'parent' => $args->get('parent'),
                        'position' => $args->get('menu_position')
                    ]
                );
            }

            if ($args->get('rewrite')) {
                $base = Str::singular($type . '-' . $taxonomy);
                $this->registerPermalink($menuSlug, [
                    'label' => $args->get('label'),
                    'base' => $base,
                    'priority' => $args->get('priority'),
                ]);
            }

            if ($args->get('menu_box')) {
                $this->registerMenuBox($menuSlug, [
                    'title' => $args->get('label_type'),
                    'group' => 'taxonomy',
                    'priority' => 15,
                    'menu_box' => new TaxonomyMenuBox(
                        $menuSlug,
                        $args
                    ),
                ]);
            }
        }
    }

    /**
     * JUZAWEB CMS: Registers a post type.
     * @param string $key (Required) Post type key. Must not exceed 20 characters
     * @param array $args Array of arguments for registering a post type.
     *
     * @throws \Exception
     */
    public function registerPostType($key, $args = [])
    {
        if (empty($args['model'])) {
            throw new \Exception('Post type model is required. E.x: \\Juzaweb\Cms\\Models\\Post.');
        }

        if (empty($args['label'])) {
            throw new \Exception('Post type label is required.');
        }

        $args = array_merge([
            'description' => '',
            'priority' => 20,
            'show_in_menu' => true,
            'rewrite' => true,
            'taxonomy_rewrite' => true,
            'menu_box' => true,
            'menu_position' => 20,
            'menu_icon' => 'fa fa-list-alt',
            'supports' => [],
        ], $args);

        $args['key'] = $key;
        $args['singular'] = Str::singular($key);
        $args['model_key'] = str_replace('\\', '_', $args['model']);

        $args = new Collection($args);

        add_filters('juzaweb.post_types', function ($items) use ($args) {
            $items[$args->get('key')] = $args;
            return $items;
        }, $args->get('priority'));

        if ($args->get('show_in_menu')) {
            $this->registerMenuPostType($key, $args);
        }

        $supports = $args->get('supports', []);
        if (in_array('category', $supports)) {
            $this->registerTaxonomy('categories', $key, [
                'label' => trans('juzaweb::app.categories'),
                'priority' => $args->get('priority') + 5,
                'menu_position' => 4,
                'show_in_menu' => $args->get('show_in_menu'),
                'rewrite' => $args->get('taxonomy_rewrite'),
            ]);
        }

        if (in_array('tag', $args['supports'])) {
            $this->registerTaxonomy('tags', $key, [
                'label' => trans('juzaweb::app.tags'),
                'priority' => $args->get('priority') + 6,
                'menu_position' => 15,
                'show_in_menu' => $args->get('show_in_menu'),
                'rewrite' => $args->get('taxonomy_rewrite'),
                'supports' => []
            ]);
        }

        if ($args->get('rewrite')) {
            $this->registerPermalink($key, [
                'label' => $args->get('label'),
                'base' => $args->get('singular'),
                'priority' => $args->get('priority'),
            ]);
        }

        if ($args->get('menu_box')) {
            $this->registerMenuBox('post_type.' . $key, [
                'title' => $args->get('label'),
                'group' => 'post_type',
                'menu_box' => new PostTypeMenuBox($key, $args),
                'priority' => 10
            ]);
        }
    }

    /**
     * @param string $key
     * @param Collection $args
     */
    protected function registerMenuPostType($key, $args)
    {
        $supports = $args->get('supports', []);

        $this->addAdminMenu(
            $args->get('label'),
            $key,
            [
                'icon' => $args->get('menu_icon', 'fa fa-edit'),
                'position' => $args->get('menu_position', 20)
            ]
        );

        $this->addAdminMenu(
            trans('juzaweb::app.all') . ' '. $args->get('label'),
            $key,
            [
                'icon' => 'fa fa-list-ul',
                'position' => 2,
                'parent' => $key,
            ]
        );

        $this->addAdminMenu(
            trans('juzaweb::app.add_new'),
            $key . '.create',
            [
                'icon' => 'fa fa-plus',
                'position' => 3,
                'parent' => $key,
            ]
        );

        if (in_array('comment', $supports)) {
            $this->addAdminMenu(
                trans('juzaweb::app.comments'),
                $args->get('singular') . '.comments',
                [
                    'icon' => 'fa fa-comments',
                    'position' => 20,
                    'parent' => $key,
                ]
            );
        }
    }
}
