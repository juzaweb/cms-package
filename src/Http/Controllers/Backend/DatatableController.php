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
use Juzaweb\Http\Controllers\BackendController;
use Illuminate\Support\Facades\Crypt;
use Juzaweb\Abstracts\DataTable;

class DatatableController extends BackendController
{
    public function getData(Request $request)
    {
        $table = $this->getTable($request->get('table'));
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);

        $query = $table->getQuery($request->all());
        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();

        $columns = $table->getColumns();
        foreach ($rows as $index => $row) {
            foreach ($columns as $key => $column) {
                if (!empty($column['formatter'])) {
                    $row->{$key} = $column['formatter']($row->{$key}, $row, $index);
                }
            }
        }

        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }

    public function bulkActions(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'action' => 'required',
        ]);

        $action = $request->post('action');
        $ids = $request->post('ids');


    }

    /**
     * Get datatable
     *
     * @param string $table
     * @return DataTable
     */
    protected function getTable($table)
    {
        $table = Crypt::decryptString($table);
        return app($table);
    }
}