<?php

namespace Juzaweb\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Juzaweb\Abstracts\Action;
use Juzaweb\Http\Controllers\BackendController;
use Juzaweb\Models\User;

class DashboardController extends BackendController
{
    public function index()
    {
        do_action(Action::BACKEND_DASHBOARD_ACTION);

        return view('juzaweb::backend.dashboard', [
            'title' => trans('juzaweb::app.dashboard'),
        ]);
    }

    public function getDataUser(Request $request)
    {
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);

        $query = User::query();
        $query->where('status', '=', 1);
        $query->where('is_admin', '=', 0);

        $query->orderBy('created_at', 'DESC');
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get([
            'id',
            'name',
            'email',
            'created_at',
        ]);

        foreach ($rows as $row) {
            $row->created = $row->created_at->format('Y-m-d');
        }

        return response()->json([
            'total' => count($rows),
            'rows' => $rows,
        ]);
    }

    public function viewsChart()
    {
        $max_day = date('t');
        $result = [];
        $result[] = [trans('juzaweb::app.day'), trans('juzaweb::app.views')];
        for ($i = 1;$i <= $max_day;$i++) {
            $day = $i < 10 ? '0'. $i : $i;
            $result[] = [(string) $day, (int) $this->countViewByDay(date('Y-m-' . $day))];
        }

        return response()->json($result);
    }
}
