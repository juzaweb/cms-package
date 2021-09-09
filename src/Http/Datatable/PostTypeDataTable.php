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

    public function mount($postType)
    {
        if (is_string($postType)) {
            $postType = HookAction::getPostTypes($postType)->toArray();
        }

        $this->postType = $postType;
    }

    /**
     * Columns datatable
     *
     * @return array
     */
    public function columns()
    {
        return [
            'title' => [
                'label' => trans('juzaweb::app.title'),
            ],
            'created' => [
                'label' => trans('juzaweb::app.created_at'),
                'width' => '15%',
                'formatter' => function ($row, $index) {
                    return jw_date_format($row->created_at);
                }
            ],
            'status' => [
                'label' => trans('juzaweb::app.status'),
                'width' => '20%'
            ],
        ];
    }

    public function actions()
    {
        return [
            'publish' => trans('juzaweb::app.publish'),
            'private' => trans('juzaweb::app.private'),
            'draft' => trans('juzaweb::app.draft'),
            'delete' => trans('juzaweb::app.delete'),
        ];
    }

    public function bulkActions($action, $ids)
    {
        foreach ($ids as $id) {
            switch ($action) {
                case 'delete':
                    $this->makeModel()->find($id)->delete($id);
                    break;
                case 'publish':
                case 'private':
                case 'draft':
                    $this->makeModel()->find($id)->update([
                        'status' => $action
                    ]);
                    break;
            }
        }
    }

    public function searchFields()
    {
        return [
            'search' => [
                'type' => 'text',
                'label' => trans('juzaweb::app.search'),
                'placeholder' => trans('juzaweb::app.search'),
            ],
            'status' => [
                'type' => 'select',
                'label' => trans('juzaweb::app.search'),
                'options' => $this->makeModel()->getStatuses(),
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
        /**
         * @var Builder $query
         */
        $query = $this->makeModel()->query();

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

    protected function makeModel()
    {
        return app($this->postType['model']);
    }
}
