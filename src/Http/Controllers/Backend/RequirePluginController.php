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
use Illuminate\Support\Facades\Cache;
use Juzaweb\Facades\Theme;
use Juzaweb\Http\Controllers\BackendController;
use Juzaweb\Support\Manager\UpdateManager;

class RequirePluginController extends BackendController
{
    public function index()
    {
        $this->addBreadcrumb([
            'title' => trans('juzaweb::app.themes'),
            'url' => route('admin.themes'),
        ]);

        $title = trans('juzaweb::app.require_plugins');

        return view('juzaweb::backend.theme.require', compact(
            'title'
        ));
    }

    public function getData()
    {
        $themeInfo = Theme::getThemeInfo(jw_current_theme());
        $require = $themeInfo->get('require', []);
        $result = [];

        foreach ($require as $plugin => $ver) {
            $info = app('plugins')->find($plugin);
            if ($info) {
                if ($info->isEnabled()) {
                    continue;
                }
            }

            $result[] = [
                'id' => $plugin,
                'key' => $plugin,
                'version' => $ver,
                'status' => $info ? 'installed' : 'not_installed',
            ];
        }

        return response()->json([
            'total' => count($result),
            'rows' => $result,
        ]);
    }

    public function bulkActions(Request $request)
    {
        $this->validate($request, [
            'ids' => 'array|required',
            'action' => 'required',
        ]);

        $ids = $request->post('ids');
        $action = $request->post('action');
        $errors = [];

        switch ($action) {
            case 'activate':
                foreach ($ids as $id) {
                    $info = app('plugins')->find($id);
                    if (empty($info)) {
                        $installer = new UpdateManager('plugin', $id);
                        if (!$installer->update()) {
                            $errors[] = trans('juzaweb::app.plugin_name_not_found', ['name' => $id]);
                        }
                    }
                }
        }

        remove_backend_message('require_plugins');

        if ($errors) {
            return $this->error([
                'message' => $errors[0],
            ]);
        }

        return $this->success([
            'message' => trans('juzaweb::app.successfully'),
        ]);
    }
}
