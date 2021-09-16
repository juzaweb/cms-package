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
        $this->validate($request, [
            'widget' => 'required',
            'sidebars' => 'required|array',
        ]);

        do_action(Action::WIDGETS_INIT);

        $widget = $request->get('widget');
        $sidebars = $request->get('sidebars');

        $widgetData = HookAction::getWidgets($widget);

        $results = [];
        foreach ($sidebars as $sidebar) {
            $results[$sidebar] = view('juzaweb::backend.widget.components.sidebar_widget_item', [
                'slot' => $widgetData['widget']->form(),
            ])->render();
        }

        return response()->json([
            'widget' => $widget,
            'items' => $results
        ]);
    }
}
