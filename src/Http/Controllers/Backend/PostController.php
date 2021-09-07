<?php

namespace Juzaweb\Http\Controllers\Backend;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Juzaweb\Http\Controllers\BackendController;
use Juzaweb\Traits\PostTypeController;
use Juzaweb\Models\Post;

class PostController extends BackendController
{
    use PostTypeController;

    protected $viewPrefix = 'juzaweb::backend.post';

    public function getDataTable(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);

        $query = Post::query();
        
        if ($search) {
            $query->where(function (Builder $q) use ($search) {
                $q->where('name', 'like', '%'. $search .'%');
                $q->orWhere('description', 'like', '%'. $search .'%');
            });
        }
        
        if ($status) {
            $query->where('status', '=', $status);
        }
        
        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();
        
        foreach ($rows as $row) {
            $row->thumb_url = $row->getThumbnail();
            $row->created = jw_date_format($row->created_at);
            $row->edit_url = route('admin.posts.edit', [$row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }

    protected function getModel()
    {
        return Post::class;
    }
}
