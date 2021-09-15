<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Http\Controllers\Backend;

use Juzaweb\Http\Controllers\BackendController;

class WidgetController extends BackendController
{
    public function index()
    {
        return view('juzaweb::backend.widget.index', [
            'title' => trans('juzaweb::app.widgets')
        ]);
    }
}
