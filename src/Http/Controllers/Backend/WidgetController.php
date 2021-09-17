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
use Illuminate\Support\Str;
use Juzaweb\Abstracts\Action;
use Juzaweb\Facades\HookAction;
use Juzaweb\Http\Controllers\BackendController;

class WidgetController extends BackendController
{
    public function __construct()
    {
        do_action(Action::WIDGETS_INIT);
    }

    public function index()
    {
        $title = trans('juzaweb::app.widgets');
        $widgets = HookAction::getWidgets();
        $sidebars = HookAction::getSidebars();

        return view('juzaweb::backend.widget.index', compact(
            'title',
            'widgets',
            'sidebars'
        ));
    }

    public function update(Request $request, $key)
    {
        $content = $request->input('content');
        $content = collect(json_decode($content, true))
            ->keyBy('key');

        foreach($content as $key => $widget) {
            $widgetData = HookAction::getWidgets($widget->get('widget'));
            $data = $widgetData->update($widget->values()->toArray());
            $content->put($key, $data);
        }
        dd($content);
        set_theme_config('sidebar_' . $key, $content->toArray());

        return $this->success([
            'message' => trans('juzaweb::app.save_successfully')
        ]);
    }

    public function getWidgetItem(Request $request)
    {
        $this->validate($request, [
            'widget' => 'required',
            'sidebars' => 'required|array',
        ]);

        $widget = $request->get('widget');
        $sidebars = $request->get('sidebars');

        $widgetData = HookAction::getWidgets($widget);

        $results = [];
        foreach ($sidebars as $sidebar) {
            $key = Str::random(10);
            $results[$sidebar] = view('juzaweb::backend.widget.components.sidebar_widget_item', [
                'widget' => $widgetData,
                'sidebar' => $sidebar,
                'key' => $key
            ])->render();
        }

        return response()->json([
            'widget' => $widget,
            'items' => $results
        ]);
    }
}
