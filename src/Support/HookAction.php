<?php
/**
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Support;

use Illuminate\Support\Collection;
use Juzaweb\Facades\Hook;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Juzaweb\Abstracts\MenuBoxAbstract;
use Juzaweb\Models\Taxonomy;
use Juzaweb\Support\Theme\PostTypeMenuBox;
use Juzaweb\Support\Theme\TaxonomyMenuBox;

class HookAction
{
    /**
     * Registers menu item in menu builder.
     *
     * @param string $key
     * @param array $args
     * @throws \Exception
     */
    public function registerPermalink($key, $args = [])
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
            'key' => $key,
            'callback' => '',
            'position' => 20,
        ], $args));

        global $jw_permalinks;

        $jw_permalinks[$key] = new Collection($args);
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
        global $jw_admin_menu;

        $opts = [
            'title' => $menuTitle,
            'key' => $menuSlug,
            'icon' => 'fa fa-list-ul',
            'url' => str_replace('.', '/', $menuSlug),
            'parent' => null,
            'position' => 20,
        ];

        $item = array_merge($opts, $args);
        if ($item['parent']) {
            $jw_admin_menu[$item['parent']]['children'][$item['key']] = $item;
        } else {
            if (Arr::has($jw_admin_menu, $item['key'])) {
                if (Arr::has($jw_admin_menu[$item['key']], 'children')) {
                    $item['children'] = $jw_admin_menu[$item['key']]['children'];
                }
                $jw_admin_menu[$item['key']] = $item;
            } else {
                $jw_admin_menu[$item['key']] = $item;
            }
        }

        return true;
    }

    /**
     * Register menu box
     *
     * @param string $key
     * @param array $args
     */
    public function registerMenuBox($key, $args = [])
    {
        global $jw_menu_boxs;

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

        $jw_menu_boxs[$key] = collect($item);

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
        global $jw_menu_boxs;

        if ($keys) {
            if (is_string($keys)) {
                $keys = [$keys];
            }

            return array_only($jw_menu_boxs, $keys);
        }

        return $jw_menu_boxs;
    }

    /**
     * Get registed menu box
     *
     * @param string|array $key
     * @return \Illuminate\Support\Collection|false
     */
    public function getMenuBox($key)
    {
        global $jw_menu_boxs;

        if ($key) {
            return Arr::get($jw_menu_boxs, $key);
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
        global $jw_taxonomies;

        $objectTypes = is_string($objectType) ? [$objectType] : $objectType;
        foreach ($objectTypes as $objectType) {
            $type = Str::singular($objectType);
            $menuSlug = $type . '.' . $taxonomy;

            $opts = [
                'label_type' => ucfirst($type) .' '. $args['label'],
                'priority' => 20,
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
                    'hierarchical'
                ],
            ];

            $args['type'] = $type;
            $args['post_type'] = $objectType;
            $args['taxonomy'] = $taxonomy;
            $args['singular'] = Str::singular($taxonomy);
            $args = new Collection(array_merge($opts, $args));

            $jw_taxonomies[$objectType][$taxonomy] = $args;

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
            throw new \Exception('Post type model is required. E.x: \\Juzaweb\\Models\\Post.');
        }

        if (empty($args['label'])) {
            throw new \Exception('Post type label is required.');
        }

        global $jw_post_types;

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
        $jw_post_types[$args->get('key')] = $args;

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

    /**
     * Get post type setting
     *
     * @param string|null $postType
     * @return \Illuminate\Support\Collection
     * */
    public function getPostTypes($postType = null)
    {
        global $jw_post_types;

        if ($postType) {
            return Arr::get($jw_post_types, $postType);
        }

        return collect($jw_post_types);
    }

    public function getTaxonomies($postType = null)
    {
        global $jw_taxonomies;

        $taxonomies = collect($jw_taxonomies);

        if (empty($taxonomies)) {
            return $taxonomies;
        }

        $taxonomies = collect($taxonomies[$postType] ?? []);
        $taxonomies = $taxonomies ?
            $taxonomies->sortBy('menu_position')
            : [];

        return $taxonomies;
    }

    /**
     * Sync taxonomies post type
     *
     * @param string $postType
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array $attributes
     * @return void
     *
     * @throws \Exception
     */
    public function syncTaxonomies($postType, $model, array $attributes)
    {
        $taxonomies = $this->getTaxonomies($postType);

        foreach ($taxonomies as $taxonomy) {
            if (method_exists($model, 'taxonomies')) {
                $data = Arr::get($attributes, $taxonomy->get('taxonomy'), []);
                $detachIds = $model->taxonomies()
                    ->where('taxonomy', '=', $taxonomy->get('taxonomy'))
                    ->whereNotIn('id', $data)
                    ->pluck('id')
                    ->toArray();

                $model->taxonomies()->detach($detachIds);
                $model->taxonomies()
                    ->syncWithoutDetaching(combine_pivot($data, [
                        'term_type' => $postType
                    ]), ['term_type' => $postType]);
            }
        }
    }

    public function enqueueScript($src = '', $ver = '1.0', $inFooter = false)
    {
        global $jw_scripts;

        if (!is_url($src)) {
            $src = asset($src);
        }

        $jw_scripts[] = new Collection([
            'src' => $src,
            'ver' => $ver,
            'inFooter' => $inFooter,
        ]);
    }

    public function enqueueStyle($src = '', $ver = '1.0', $inFooter = false)
    {
        global $jw_styles;

        if (!is_url($src)) {
            $src = asset($src);
        }

        $jw_styles[] = new Collection([
            'src' => $src,
            'ver' => $ver,
            'inFooter' => $inFooter,
        ]);
    }

    public function getEnqueueScripts($inFooter = false)
    {
        global $jw_scripts;

        $scripts = new Collection($jw_scripts);
        return $scripts->where('inFooter', $inFooter);
    }

    public function getEnqueueStyles($inFooter = false)
    {
        global $jw_styles;
        $scripts = new Collection($jw_styles);
        return $scripts->where('inFooter', $inFooter);
    }
}
