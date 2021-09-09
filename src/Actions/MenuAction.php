<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Actions;

use Juzaweb\Support\Theme\CustomMenuBox;
use Juzaweb\Abstracts\Action;
use Juzaweb\Facades\HookAction;
use Juzaweb\Facades\PostType;
use Juzaweb\Models\Page;
use Juzaweb\Models\Post;

class MenuAction extends Action
{
    public function handle()
    {
        $this->addAction(self::JUZAWEB_INIT_ACTION, [$this, 'addDatatableSearchFieldTypes']);
        $this->addAction(self::JUZAWEB_INIT_ACTION, [$this, 'addPostTypes']);
        $this->addAction(self::BACKEND_CALL_ACTION, [$this, 'addBackendMenu']);
        $this->addAction(self::BACKEND_CALL_ACTION, [$this, 'addSettingPage']);
        $this->addAction(self::BACKEND_MENU_INDEX_ACTION, [$this, 'addMenuBoxs']);
        $this->addAction(self::BACKEND_CALL_ACTION, [$this, 'addTaxonomiesForm']);
    }

    public function addBackendMenu()
    {
        HookAction::addAdminMenu(
            trans('juzaweb::app.dashboard'),
            'dashboard',
            [
                'icon' => 'fa fa-dashboard',
                'position' => 1
            ]
        );

        /*HookAction::addAdminMenu(
            'juzaweb::app.dashboard',
            'dashboard',
            [
                'icon' => 'fa fa-dashboard',
                'position' => 1,
                'parent' => 'dashboard',
            ]
        );

        HookAction::addAdminMenu(
            'juzaweb::app.updates',
            'updates',
            [
                'icon' => 'fa fa-refresh',
                'position' => 2,
                'parent' => 'dashboard',
            ]
        );*/

        /*HookAction::addAdminMenu(
            trans('juzaweb::app.media'),
            'media',
            [
                'icon' => 'fa fa-image',
                'position' => 10
            ]
        );*/

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

        HookAction::addAdminMenu(
            trans('juzaweb::app.plugins'),
            'plugins',
            [
                'icon' => 'fa fa-plug',
                'position' => 50
            ]
        );

        HookAction::addAdminMenu(
            trans('juzaweb::app.users'),
            'users',
            [
                'icon' => 'fa fa-users',
                'position' => 60
            ]
        );

        HookAction::addAdminMenu(
            trans('juzaweb::app.setting'),
            'setting',
            [
                'icon' => 'fa fa-cogs',
                'position' => 70
            ]
        );

        HookAction::addAdminMenu(
            trans('juzaweb::app.general_setting'),
            'setting.system',
            [
                'icon' => 'fa fa-cogs',
                'position' => 1,
                'parent' => 'setting',
            ]
        );

        HookAction::addAdminMenu(
            trans('juzaweb::app.translations'),
            'translations',
            [
                'icon' => 'fa fa-language',
                'position' => 90,
            ]
        );

        HookAction::addAdminMenu(
            trans('juzaweb::app.email_templates'),
            'email-template',
            [
                'icon' => 'fa fa-envelope',
                'position' => 50,
                'parent' => 'setting',
            ]
        );

        HookAction::addAdminMenu(
            trans('juzaweb::app.logs'),
            'logs',
            [
                'icon' => 'fa fa-users',
                'position' => 99
            ]
        );

        HookAction::addAdminMenu(
            trans('juzaweb::app.email_logs'),
            'logs.email',
            [
                'icon' => 'fa fa-cogs',
                'position' => 1,
                'parent' => 'logs',
            ]
        );
    }

    public function addSettingPage()
    {
        HookAction::addSettingForm('general', [
            'name' => trans('juzaweb::app.general_setting'),
            'view' => 'juzaweb::backend.setting.system.form.general'
        ]);

        HookAction::addSettingForm('recaptcha', [
            'name' => trans('juzaweb::app.google_recaptcha'),
            'view' => 'juzaweb::backend.setting.system.form.recaptcha',
            'priority' => 15
        ]);

        HookAction::addSettingForm('email', [
            'name' => trans('juzaweb::app.email_setting'),
            'view' => 'juzaweb::backend.email.setting',
            'priority' => 15
        ]);
    }

    public function addPostTypes()
    {
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
    }

    public function addMenuBoxs()
    {
        HookAction::registerMenuBox('custom_url', [
            'title' => trans('juzaweb::app.custom_url'),
            'group' => 'custom',
            'menu_box' => new CustomMenuBox()
        ]);
    }

    public function addTaxonomiesForm()
    {
        $types = PostType::getPostTypes();
        foreach ($types as $key => $type) {
            add_action('post_type.'.$key.'.form.right', function ($model) use ($key) {
                echo view('juzaweb::components.taxonomies', [
                    'postType' => $key,
                    'model' => $model
                ])->render();
            });
        }
    }

    public function addDatatableSearchFieldTypes()
    {
        $this->addFilter(Action::DATATABLE_SEARCH_FIELD_TYPES_FILTER, function ($items) {
            $items['text'] = [
                'view' => view('juzaweb::components.datatable.text_field')
            ];

            $items['select'] = [
                'view' => view('juzaweb::components.datatable.select_field')
            ];

            $items['taxonomy'] = [
                'view' => view('juzaweb::components.datatable.taxonomy_field')
            ];

            return $items;
        });
    }
}
