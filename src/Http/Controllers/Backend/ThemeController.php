<?php

namespace Juzaweb\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Juzaweb\Http\Controllers\BackendController;
use Juzaweb\Support\ArrayPagination;
use Juzaweb\Facades\Theme;

class ThemeController extends BackendController
{
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $activated = get_config('activated_theme', 'default');

        $themes = Theme::all();
        $currentTheme = $themes[$activated] ?? null;
        unset($themes[$activated]);
        $pagination = ArrayPagination::make($themes);
        $themes = $pagination->paginate(10, $page);

        return view('juzaweb::backend.theme.index', [
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
        $this->putCache($theme);

        return $this->success([
            'redirect' => route('admin.themes'),
        ]);
    }

    public function delete(Request $request)
    {

    }

    protected function putCache($theme)
    {
        Cache::forever('current_theme_info', jw_theme_info($theme));

        $themeStatus = [
            'namespace' => 'Theme\\',
            'path' => config('juzaweb.theme.path') .'/'.$theme.'/src',
        ];

        $str = '<?php

return ' . var_export($themeStatus, true) .';

';
        File::put(base_path('bootstrap/cache/theme_statuses.php'), $str);
    }
}
