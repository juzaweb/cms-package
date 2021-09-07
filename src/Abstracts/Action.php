<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Cms\Abstracts;

use Juzaweb\Cms\Facades\Hook;

abstract class Action
{
    const JUZAWEB_INIT_ACTION = 'juzaweb.init';
    const BACKEND_CALL_ACTION = 'backend.call_action';
    const BACKEND_MENU_INDEX_ACTION = 'backend.menu.index';
    const BACKEND_DASHBOARD_ACTION = 'backend.dashboard';
    const POST_FORM_RIGHT_ACTION = 'post_type.posts.form.right';
    const POST_FORM_LEFT_ACTION = 'post_type.posts.form.left';

    abstract public function handle();

    protected function addAction($tag, $callback, $priority = 20, $arguments = 1)
    {
        Hook::addAction($tag, $callback, $priority, $arguments);
    }

    protected function addFilter($tag, $callback, $priority = 20, $arguments = 1)
    {
        Hook::addFilter($tag, $callback, $priority, $arguments);
    }

    protected function applyFilters($tag, $value, ...$args)
    {
        return Hook::filter($tag, $value, ...$args);
    }
}
