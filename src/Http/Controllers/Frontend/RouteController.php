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
 * Date: 6/10/2021
 * Time: 3:31 PM
 */

namespace Juzaweb\Cms\Http\Controllers\Frontend;

use Illuminate\Support\Facades\App;

class RouteController extends FrontendController
{
    public function index($slug = null)
    {
        $slug = explode('/', $slug);
        $base = apply_filters('theme.permalink.base', $slug[0], $slug);
        $permalinks = $this->getPermalinks();
        $permalink = $permalinks->where('base', $base)->first();

        if ($permalink && $callback = $permalink->get('callback')) {
            unset($slug[0]);

            return $this->callController($callback, 'index', $slug);
        }

        return $this->callController(PageController::class, 'index', $slug);
    }

    protected function getPermalinks()
    {
        return collect(apply_filters('juzaweb.permalinks', []));
    }

    protected function callController($callback, $method = 'index', $parameters = [])
    {
        do_action('theme.call_controller', $callback, $method, $parameters);

        return App::call($callback . '@index', $parameters);
    }
}