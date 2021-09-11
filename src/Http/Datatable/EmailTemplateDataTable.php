<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Http\Datatable;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Juzaweb\Abstracts\DataTable;
use Juzaweb\Models\EmailTemplate;

class EmailTemplateDataTable extends DataTable
{
    /**
     * Columns datatable
     *
     * @return array
     */
    public function columns()
    {
        return [
            'code' => [
                'label' => trans('juzaweb::app.code'),
                'width' => '15%',
                'formatter' => [$this, 'rowActionsFormatter'],
            ],
            'subject' => [
                'label' => trans('juzaweb::app.subject'),
            ],
            'created' => [
                'label' => trans('juzaweb::app.created_at'),
                'width' => '15%',
                'align' => 'center',
                'formatter' => function ($value, $row, $index) {
                    return jw_date_format($row->created_at);
                }
            ]
        ];
    }

    /**
     * Query data datatable
     *
     * @param array $data
     * @return Builder
     */
    public function query($data)
    {
        $query = EmailTemplate::query();

        if ($keyword = Arr::get($data, 'keyword')) {
            $query->where(function (Builder $q) use ($keyword) {
                $q->orWhere('code', 'like', '%'. $keyword .'%');
                $q->orWhere('subject', 'like', '%'. $keyword .'%');
            });
        }

        return $query;
    }

    public function bulkActions($action, $ids)
    {
        switch ($action) {
            case 'delete':
                EmailTemplate::destroy($ids);
                break;
        }
    }
}
