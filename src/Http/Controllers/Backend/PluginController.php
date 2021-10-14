<?php

namespace Juzaweb\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Juzaweb\Facades\Plugin;
use Juzaweb\Http\Controllers\BackendController;
use Juzaweb\Support\ArrayPagination;
use Juzaweb\Support\JuzawebApi;
use Juzaweb\Support\Manager\UpdateManager;

class PluginController extends BackendController
{
    protected $api;

    public function __construct(JuzawebApi $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        return view('juzaweb::backend.plugin.index', [
            'title' => trans('juzaweb::app.plugins'),
        ]);
    }

    public function install()
    {
        $this->addBreadcrumb([
            'title' => trans('juzaweb::app.plugins'),
            'url' => action([static::class, 'index']),
        ]);

        $title = trans('juzaweb::app.install');

        return view('juzaweb::backend.plugin.install', compact(
            'title'
        ));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'plugin' => 'required',
        ]);

        $updater = new UpdateManager('plugin', $request->post('plugin'));
        if ($updater->checkUpdate()) {
            $updater->update();
        }

        return $this->success([
            'message' => trans('juzaweb::app.updated_successfully'),
        ]);
    }

    public function getDataPlugin(Request $request)
    {
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        $installed = installed_plugins();

        $page = (int) round(($offset + $limit) / $limit);

        $data = $this->api->getResponse('plugin/all', [
            'page' => $page,
        ]);

        $rows = $data->data;
        foreach ($rows as $row) {
            $row->content = view('juzaweb::components.plugin_item', [
                'item' => $row,
                'installed' => $installed,
            ])->render();
        }

        return response()->json([
            'total' => $data->meta->total,
            'rows' => $data->data,
        ]);
    }

    public function getDataTable(Request $request)
    {
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);

        $results = [];
        $plugins = Plugin::all();
        foreach ($plugins as $plugin) {
            $item = [
                'id' => $plugin->get('name'),
                'name' => $plugin->getDisplayName(),
                'description' => $plugin->get('description'),
                'status' => $plugin->isEnabled() ?
                    'active' : 'inactive',
            ];
            $results[] = $item;
        }

        $total = count($results);
        $page = (int) round(($offset + $limit) / $limit);
        $data = ArrayPagination::make($results);
        $data = $data->paginate($limit, $page);

        return response()->json([
            'total' => $total,
            'rows' => $data->items(),
        ]);
    }

    public function bulkActions(Request $request)
    {
        $request->validate([
            'ids' => 'required',
            'action' => 'required',
        ], [], [
            'ids' => trans('tadcms::app.plugins'),
            'action' => trans('tadcms::app.action'),
        ]);

        $action = $request->post('action');
        $ids = $request->post('ids');
        foreach ($ids as $plugin) {
            try {
                DB::beginTransaction();
                switch ($action) {
                    case 'delete':
                        Plugin::delete($plugin);
                        break;
                    case 'activate':
                        Plugin::enable($plugin);
                        break;
                    case 'deactivate':
                        Plugin::disable($plugin);
                        break;
                    case 'update':
                        $updater = new UpdateManager('plugin', $request->post('plugin'));
                        if ($updater->checkUpdate()) {
                            $updater->update();
                        }
                        break;
                }
                DB::commit();
            } catch (\Throwable $e) {
                DB::rollBack();

                return $this->error([
                    'message' => trans($e->getMessage()),
                ]);
            }
        }

        return $this->success([
            'message' => trans('juzaweb::app.successfully'),
            'redirect' => route('admin.plugin'),
        ]);
    }
}
