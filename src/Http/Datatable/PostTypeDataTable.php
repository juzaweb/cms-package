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
use Juzaweb\Facades\HookAction;

class PostTypeDataTable extends DataTable
{
    protected $postType;

    public function __construct($postType)
    {
        if (is_string($postType)) {
            $postType = HookAction::getPostTypes($postType);
        }

        $this->postType = $postType;
    }

    /**
     * Columns datatable
     *
     * @return array
     */
    protected function columns()
    {
        return [
            'title' => [
                'label' => trans('juzaweb::app.title'),
            ],
            'created_at' => [
                'label' => trans('juzaweb::app.created_at'),
                'width' => '15%'
            ],
            'status' => [
                'label' => trans('juzaweb::app.status'),
                'width' => '20%'
            ],
        ];
    }

    protected function actions()
    {
        return [
            'publish' => trans('juzaweb::app.publish'),
            'private' => trans('juzaweb::app.private'),
            'draft' => trans('juzaweb::app.draft'),
            'delete' => trans('juzaweb::app.delete'),
        ];
    }

    protected function bulkActions($action, $ids)
    {

    }

    /**
     * Query data datatable
     *
     * @param array $data
     * @return Builder
     */
    protected function query($data)
    {
        $model = $this->postType->get('model');
        /**
         * @var Builder $query
         */
        $query = app($model)->query();

        if ($search = Arr::get($data, 'search')) {
            $query->where(function (Builder $q) use ($search) {
                $q->where('name', 'like', '%'. $search .'%');
                $q->orWhere('description', 'like', '%'. $search .'%');
            });
        }

        if ($status = Arr::get($data, 'status')) {
            $query->where('status', '=', $status);
        }

        return $query;
    }
}
