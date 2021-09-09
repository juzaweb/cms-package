<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzawebcms/juzawebcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
 *
 * Created by JUZAWEB.
 * Date: 5/31/2021
 * Time: 9:55 PM
 */

namespace Juzaweb\Abstracts;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

abstract class DataTable
{
    protected $perPage = 10;

    /**
     * Columns datatable
     *
     * @return array
     */
    abstract protected function columns();

    /**
     * Query data datatable
     *
     * @param array $data
     * @return Builder
     */
    abstract protected function query($data);

    protected function actions()
    {
        return [];
    }

    protected function bulkActions($action, $ids)
    {
        //
    }

    protected function getData()
    {
        $request = request();
        $query = $this->query($request->all());

        return $query->paginate($this->perPage);
    }

    public function getColumns()
    {
        return $this->columns();
    }

    public function render()
    {
        $request = request();
        if ($request->isMethod('POST')) {
            $action = $request->post('action');
            $ids = $request->post('ids', []);

            if ($action && $ids) {
                $this->bulkActions($action, $ids);
            }
        }

        $items = $this->getData();

        return view('juzaweb::components.datatable', [
            'columns' => $this->columns(),
            'actions' => $this->actions(),
            'items' => $items,
            'table' => Crypt::encryptString(static::class),
        ]);
    }
}
