<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Abstracts;

use Juzaweb\Facades\Hook;

abstract class Action
{
    public const JUZAWEB_INIT_ACTION = 'juzaweb.init';
    public const BACKEND_CALL_ACTION = 'backend.call_action';
    public const FRONTEND_CALL_ACTION = 'frontend.call_action';
    public const FRONTEND_HEADER_ACTION = 'theme.header';
    public const FRONTEND_FOOTER_ACTION = 'theme.footer';
    public const BACKEND_MENU_INDEX_ACTION = 'backend.menu.index';
    public const BACKEND_DASHBOARD_ACTION = 'backend.dashboard';
    public const POST_FORM_RIGHT_ACTION = 'post_type.posts.form.right';
    public const POST_FORM_LEFT_ACTION = 'post_type.posts.form.left';
    public const PERMALINKS_SAVED_ACTION = 'permalinks.saved';
    public const BACKEND_HEADER_ACTION = 'juzaweb_header';
    public const BACKEND_FOOTER_ACTION = 'juzaweb_footer';
    public const WIDGETS_INIT = 'juzaweb.widget_init';

    public const DATATABLE_SEARCH_FIELD_TYPES_FILTER = 'datatable.search_field_types';
    public const FRONTEND_SEARCH_QUERY = 'frontend.search_query';

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
