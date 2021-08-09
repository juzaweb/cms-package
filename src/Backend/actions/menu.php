<?php
/**
 * MYMO CMS - Free Laravel CMS
 *
 * @package    juzacmscms/juzacmscms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzacmscms/juzacmscms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 5/26/2021
 * Time: 9:18 PM
*/

use Juzaweb\Cms\Core\Facades\HookAction;

HookAction::addAdminMenu(
    trans('juzacms::app.dashboard'),
    'dashboard',
    [
        'icon' => 'fa fa-dashboard',
        'position' => 1
    ]
);

/*HookAction::addAdminMenu(
    'juzacms::app.dashboard',
    'dashboard',
    [
        'icon' => 'fa fa-dashboard',
        'position' => 1,
        'parent' => 'dashboard',
    ]
);

HookAction::addAdminMenu(
    'juzacms::app.updates',
    'updates',
    [
        'icon' => 'fa fa-refresh',
        'position' => 2,
        'parent' => 'dashboard',
    ]
);
*/

/*HookAction::addAdminMenu(
    trans('juzacms::app.media'),
    'media',
    [
        'icon' => 'fa fa-image',
        'position' => 10
    ]
);*/

HookAction::addAdminMenu(
    trans('juzacms::app.users'),
    'users',
    [
        'icon' => 'fa fa-users',
        'position' => 60
    ]
);

HookAction::addAdminMenu(
    trans('juzacms::app.setting'),
    'setting',
    [
        'icon' => 'fa fa-cogs',
        'position' => 70
    ]
);

HookAction::addAdminMenu(
    trans('juzacms::app.general_setting'),
    'setting.system',
    [
        'icon' => 'fa fa-cogs',
        'position' => 1,
        'parent' => 'setting',
    ]
);

/*HookAction::addAdminMenu(
    trans('juzacms::app.translations'),
    'setting.language',
    [
        'icon' => 'fa fa-language',
        'position' => 5,
        'parent' => 'setting',
    ]
);*/






