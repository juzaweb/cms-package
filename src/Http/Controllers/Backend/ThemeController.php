<?php

namespace Juzaweb\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Juzaweb\Http\Controllers\BackendController;
use Juzaweb\Support\ArrayPagination;
use Juzaweb\Facades\Theme;
use Juzaweb\Support\JuzawebApi;
use Juzaweb\Support\Manager\UpdateManager;

class ThemeController extends BackendController
{
    protected $api;

    public function __construct(JuzawebApi $api)
    {
        $this->api = $api;
    }

    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $activated = jw_current_theme();

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

    public function install()
    {
        $this->addBreadcrumb([
            'title' => trans('juzaweb::app.themes'),
            'url' => action([static::class, 'index'])
        ]);

        $title = trans('juzaweb::app.install');

        return view('juzaweb::backend.theme.install', compact(
            'title'
        ));
    }

    public function getDataTheme(Request $request)
    {
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        $installed = installed_themes();
        $activated = jw_current_theme();

        $page = (int) round(($offset + $limit) / $limit);
        $data = $this->api->getResponse('theme/all', [
            'page' => $page,
            'limit' => $limit
        ]);

        $rows = $data->data;
        foreach ($rows as $row) {
            $row->content = view('juzaweb::components.theme_item', [
                'item' => $row,
                'installed' => $installed,
                'activated' => $activated
            ])->render();
        }

        return response()->json([
            'total' => $data->meta->total,
            'rows' => $data->data,
        ]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'theme' => 'required'
        ]);

        $updater = new UpdateManager('theme', $request->post('theme'));
        if ($updater->checkUpdate()) {
            $updater->update();
        }

        return $this->success([
            'message' => trans('juzaweb::app.updated_successfully')
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

        $this->putCache($theme);
        Artisan::call('theme:publish', [
            'theme' => $theme,
            'type' => 'assets',
        ]);

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
            'name' => $theme,
            'namespace' => 'Theme\\',
            'path' => config('juzaweb.theme.path') .'/'.$theme,
        ];

        $str = '<?php

return ' . var_export($themeStatus, true) .';

';
        File::put(base_path('bootstrap/cache/theme_statuses.php'), $str);
    }
}
