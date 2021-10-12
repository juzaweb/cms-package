<?php

namespace Juzaweb\Http\Controllers\Backend;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Juzaweb\Http\Controllers\BackendController;
use Juzaweb\Models\EmailList;

class EmailLogController extends BackendController
{
    public function index()
    {
        return view('juzaweb::backend.logs.email', [
            'title' => trans('juzaweb::app.email_logs'),
        ]);
    }

    public function getData(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');

        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);

        $query = EmailList::query();

        if ($search) {
            $query->where(function (Builder $q) use ($search) {
                $q->orWhere('subject', 'like', '%'. $search .'%');
                $q->orWhere('content', 'like', '%'. $search .'%');
            });
        }

        if ($status) {
            $query->where('status', '=', $status);
        }

        $count = $query->count();
        $query->orderBy('updated_at', 'DESC');
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();

        foreach ($rows as $row) {
            $row->created = $row->created_at->format('H:i Y-m-d');
            $row->content = $row->data['body'] ?? '';
            $row->subject = $row->data['subject'] ?? '';
        }

        return response()->json([
            'total' => $count,
            'rows' => $rows,
        ]);
    }

    public function status(Request $request)
    {
        $request->validate([
            'ids' => 'required',
            'status' => 'required|in:success,error,pending',
        ], [], [
            'ids' => trans('juzaweb::app.email_logs'),
            'status' => trans('juzaweb::app.status'),
        ]);

        EmailList::whereIn('id', $request->post('ids'))
            ->update([
                'status' => $request->post('status'),
            ]);

        return response()->json([
            'status' => 'success',
            'message' => trans('juzaweb::app.deleted_successfully'),
        ]);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'ids' => 'required',
        ], [], [
            'ids' => trans('juzaweb::app.email_logs'),
        ]);

        EmailList::destroy($request->post('ids', []));

        return response()->json([
            'status' => 'success',
            'message' => trans('juzaweb::app.deleted_successfully'),
        ]);
    }
}
