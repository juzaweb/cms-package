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

HookAction::addAdminMenu(
    trans('juzaweb::app.plugins'),
    'plugins',
    [
        'icon' => 'fa fa-plug',
        'position' => 50
    ]
);
