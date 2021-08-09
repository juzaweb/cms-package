<?php

namespace Juzaweb\Cms\Http\Controllers\Backend\Design;

use Illuminate\Http\Request;
use Juzaweb\Cms\Http\Controllers\BackendController;
use Juzaweb\Cms\Traits\ArrayPagination;
use Juzaweb\Cms\Theme\Facades\Theme;

class ThemeController extends BackendController
{
    use ArrayPagination;

    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $activated = get_config('activated_theme', 'default');

        $themes = Theme::all();
        $currentTheme = $themes[$activated] ?? null;
        unset($themes[$activated]);
        $themes = $this->arrayPaginate($themes, 10, $page);

        return view('juzaweb::backend.design.themes.index', [
            'title' => trans('juzaweb::app.themes'),
            'themes' => $themes,
            'currentTheme' => $currentTheme,
            'activated' => $activated
        ]);
    }
    
    public function activate(Request $request)
    {
        $request->validate([
            'theme' => 'required'
        ]);

        $theme = $request->post('theme');
        if (!Theme::has($theme)) {
            return $this->error([
                'message' => trans('juzaweb::message.theme_not_found')
            ]);
        }

        set_config('activated_theme', $theme);
        return $this->success([
            'redirect' => route('admin.design.themes'),
        ]);
    }

    public function delete(Request $request)
    {

    }
}
