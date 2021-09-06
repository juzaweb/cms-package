<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 *
 * Created by JUZAWEB.
 * Date: 6/5/2021
 * Time: 12:25 PM
 */

use Juzaweb\Cms\Facades\HookAction;

HookAction::addSettingForm('email', [
    'name' => trans('juzaweb::app.email_setting'),
    'view' => 'juzaweb::email.setting'
]);

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
