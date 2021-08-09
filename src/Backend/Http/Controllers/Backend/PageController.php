<?php

namespace Juzaweb\Cms\Backend\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Juzaweb\Cms\Backend\Http\Controllers\BackendController;
use Juzaweb\Cms\PostType\Models\Page;

class PageController extends BackendController
{
    public function index()
    {
        return view('juzacms::backend.pages.index', [
            'title' => trans('juzacms::app.pages')
        ]);
    }
    
    public function getData(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = Page::query();
        
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->orWhere('name', 'like', '%'. $search .'%');
                $subquery->orWhere('description', 'like', '%'. $search .'%');
            });
        }
        
        if (!is_null($status)) {
            $query->where('status', '=', $status);
        }
        
        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();
        
        foreach ($rows as $row) {
            $row->thumb_url = $row->getThumbnail();
            $row->edit_url = route('admin.page.edit', [$row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function form($id = null)
    {
        $this->addBreadcrumb([
            'title' => trans('juzacms::app.pages'),
            'url' => route('admin.page.index')
        ]);

        $model = Page::firstOrNew(['id' => $id]);
        return view('juzacms::backend.pages.form', [
            'model' => $model,
            'title' => $model->name ?: trans('juzacms::app.add_new')
        ]);
    }
    
    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'status' => 'required|in:0,1',
            'thumbnail' => 'nullable|string|max:250',
        ], [], [
            'name' => trans('juzacms::app.name'),
            'status' => trans('juzacms::app.status'),
            'thumbnail' => trans('juzacms::app.thumbnail'),
        ]);
        
        $model = Page::firstOrNew(['id' => $request->id]);
        $model->fill($request->all());
        $model->save();

        return $this->success([
            'message' => trans('juzacms::app.successfully'),
            'redirect' => route('admin.page.index')
        ]);
    }
    
    public function bulkActions(Request $request)
    {
        $request->validate([
            'ids' => 'required',
            'action' => 'required',
        ], [], [
            'ids' => trans('juzacms::app.pages')
        ]);

        $ids = $request->post('ids');
        $action = $request->post('action');

        try {
            DB::beginTransaction();
            switch ($action) {
                case 'delete':
                    Page::destroy($ids);
                    break;
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->error([
                'message' => $exception->getMessage()
            ]);
        }

        return $this->success([
            'message' => trans('juzacms::app.successfully')
        ]);
    }
}
