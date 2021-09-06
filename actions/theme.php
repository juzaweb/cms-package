<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

use Juzaweb\Cms\Facades\HookAction;
use Juzaweb\Cms\Models\Page;
use Juzaweb\Cms\Models\Post;
use Juzaweb\Cms\Support\CustomMenuBox;

HookAction::registerMenuBox('custom_url', [
    'title' => trans('juzaweb::app.custom_url'),
    'group' => 'custom',
    'menu_box' => new CustomMenuBox()
]);

HookAction::registerPostType('pages', [
    'label' => trans('juzaweb::app.pages'),
    'model' => Page::class,
    'menu_icon' => 'fa fa-edit',
    'rewrite' => false,
]);

HookAction::registerPostType('posts', [
    'label' => trans('juzaweb::app.posts'),
    'model' => Post::class,
    'menu_icon' => 'fa fa-edit',
    'menu_position' => 15,
    'supports' => [
        'category',
        'tag',
        'comment'
    ],
]);

HookAction::addAdminMenu(
    trans('juzaweb::app.appearance'),
    'appearance',
    [
        'icon' => 'fa fa-paint-brush',
        'position' => 40
    ]
);

HookAction::addAdminMenu(
    trans('juzaweb::app.themes'),
    'themes',
    [
        'icon' => 'fa fa-paint-brush',
        'position' => 1,
        'parent' => 'appearance',
    ]
);

HookAction::addAdminMenu(
    trans('juzaweb::app.menu'),
    'menu',
    [
        'icon' => 'fa fa-list',
        'position' => 2,
        'parent' => 'appearance',
    ]
);

HookAction::addAdminMenu(
    trans('juzaweb::app.editor'),
    'editor',
    [
        'icon' => 'fa fa-edit',
        'position' => 30,
        'parent' => 'appearance',
        'turbolinks' => false,
    ]
);

HookAction::addAdminMenu(
    trans('juzaweb::app.reading'),
    'reading',
    [
        'icon' => 'fa fa-book',
        'position' => 10,
        'parent' => 'setting',
    ]
);

HookAction::addAdminMenu(
    trans('juzaweb::app.permalinks'),
    'permalinks',
    [
        'icon' => 'fa fa-link',
        'position' => 15,
        'parent' => 'setting',
    ]
);
