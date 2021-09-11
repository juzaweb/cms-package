<?php

namespace Juzaweb\Http\Controllers\Backend;

use Illuminate\Support\Facades\DB;
use Juzaweb\Facades\GlobalData;
use Juzaweb\Facades\HookAction;
use Juzaweb\Http\Controllers\BackendController;
use Juzaweb\Models\Menu;
use Illuminate\Http\Request;
use Juzaweb\Models\MenuItem;

class MenuController extends BackendController
{
    public function index($id = null)
    {
        do_action('backend.menu.index', $id);

        $title = trans('juzaweb::app.menu');
        $navMenus = GlobalData::get('nav_menus');

        $this->loadMenuBoxs();

        if (empty($id)) {
            $menu = Menu::first();
        } else {
            $menu = Menu::where('id', '=', $id)->first();
        }

        return view('juzaweb::backend.menu.index', compact(
            'title',
            'menu',
            'navMenus'
        ));
    }

    public function addItem(Request $request)
    {
        $request->validate([
            'key' => 'required',
        ], [], [
            'key' => trans('juzaweb::app.key')
        ]);

        $menuRegister = HookAction::getMenuBox($request->post('key'));

        if (empty($menuRegister)) {
            return $this->error([
                'message' => 'Cannot find menu box'
            ]);
        }

        $menuBox = $menuRegister->get('menu_box');

        $result = [];
        $data = $menuBox->mapData($request->all());

        foreach ($data as $item) {
            $model = new MenuItem();
            $model->fill(array_merge($item, [
                'box_key' => $request->post('key')
            ]));

            $result[] = view('juzaweb::backend.items.menu_item', [
                'item' => $model
            ])->render();
        }

        return $this->success([
            'items' => $result
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:250',
        ], [], [
            'name' => trans('juzaweb::app.name')
        ]);
    
        $model = Menu::create($request->all());
    
        return $this->success([
            'message' => trans('juzaweb::app.saved_successfully'),
            'redirect' => route('admin.menu.id', [$model->id])
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'content' => 'required',
        ], [], [
            'name' => trans('juzaweb::app.name'),
            'content' => trans('juzaweb::app.menu'),
        ]);

        $items = json_decode($request->post('content'), true);

        DB::beginTransaction();
        try {

            $model = Menu::findOrFail($id);
            $model->update($request->all());
            $model->syncItems($items);

            do_action('admin.saved_menu', $model, $items);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    
        return $this->success([
            'message' => trans('juzaweb::app.saved_successfully'),
            'redirect' => route('admin.menu.id', [$model->id]),
        ]);
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        $menu->delete();

        return $this->success([
            'message' => trans('juzaweb::app.deleted_successfully')
        ]);
    }

    protected function loadMenuBoxs()
    {
        $menuBoxs = GlobalData::get('menu_boxs');
        foreach ($menuBoxs as $key => $item) {
            add_action('juzaweb.add_menu_items', function () use (
                $key,
                $item
            ) {
                echo e(view('juzaweb::backend.items.menu_box', [
                    'label' => $item['title'],
                    'key' => $key,
                    'slot' => $item['menu_box']->addView()->render()
                ]));
            });
        }
    }
}
