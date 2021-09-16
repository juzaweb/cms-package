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

use Illuminate\Http\Request;
use Juzaweb\Abstracts\Action;
use Juzaweb\Facades\HookAction;
use Juzaweb\Http\Controllers\BackendController;

class WidgetController extends BackendController
{
    public function index()
    {
        do_action(Action::WIDGETS_INIT);

        $title = trans('juzaweb::app.widgets');
        $widgets = HookAction::getWidgets();
        $sidebars = HookAction::getSidebars();

        return view('juzaweb::backend.widget.index', compact(
            'title',
            'widgets',
            'sidebars'
        ));
    }

    public function getWidgetItem(Request $request)
    {

    }
}
