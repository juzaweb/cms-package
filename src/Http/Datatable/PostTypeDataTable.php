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

use Illuminate\Database\Eloquent\Builder;
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
                'formatter' => [$this, 'rowActionsFormatter']
            ],
            'created' => [
                'label' => trans('juzaweb::app.created_at'),
                'width' => '15%',
                'formatter' => function ($value, $row, $index) {
                    return jw_date_format($row->created_at);
                }
            ],
            'status' => [
                'label' => trans('juzaweb::app.status'),
                'width' => '10%',
                'align' => 'center',
                'formatter' => function ($value, $row, $index) {
                    switch ($row->status) {
                        case 'publish':
                            return '<span class="text-success">'. trans('juzaweb::app.publish') .'</span>';
                            break;
                        case 'private':
                            return '<span class="text-warning">'. trans('juzaweb::app.private') .'</span>';
                            break;
                        case 'draft':
                            return '<span class="text-secondary">'. trans('juzaweb::app.draft') .'</span>';
                            break;
                        case 'trash':
                            return '<span class="text-danger">'. trans('juzaweb::app.trash') .'</span>';
                            break;
                    }

                    return '<span class="text-secondary">'. trans('juzaweb::app.draft') .'</span>';
                }
            ],
        ];
    }

    public function actions()
    {
        return array_merge($this->makeModel()->getStatuses(), [
            'delete' => trans('juzaweb::app.delete'),
        ]);
    }

    public function bulkActions($action, $ids)
    {
        foreach ($ids as $id) {
            switch ($action) {
                case 'delete':
                    $this->makeModel()->find($id)->delete($id);
                    break;
            }
        }

        if (in_array($action, array_keys($this->makeModel()->getStatuses()))) {
            $this->makeModel()->find($id)->update([
                'status' => $action
            ]);
        }
    }

    public function searchFields()
    {
        $data = [
            'keyword' => [
                'type' => 'text',
                'label' => trans('juzaweb::app.keyword'),
                'placeholder' => trans('juzaweb::app.keyword'),
            ],
            'status' => [
                'type' => 'select',
                'label' => trans('juzaweb::app.search'),
                'options' => $this->makeModel()->getStatuses(),
            ]
        ];

        $taxonomies = HookAction::getTaxonomies($this->postType['key']);
        foreach ($taxonomies as $key => $taxonomy) {
            $data[$key] = [
                'type' => 'taxonomy',
                'label' => $taxonomy->get('label'),
                'taxonomy' => $taxonomy,
            ];
        }

        return $data;
    }

    public function rowAction($row)
    {
        return [
            'edit' => [
                'label' => trans('juzaweb::app.edit'),
                'url' => route('admin.posts.edit', [$row->id]),
            ],
            'trash' => [
                'label' => trans('juzaweb::app.trash'),
                'class' => 'text-danger',
                'action' => 'trash',
            ],
            'view' => [
                'label' => trans('juzaweb::app.view'),
                'url' => '',
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
        $query->whereFilter($data);

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
