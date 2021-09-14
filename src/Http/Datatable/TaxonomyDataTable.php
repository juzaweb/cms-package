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
use Juzaweb\Abstracts\DataTable;

class TaxonomyDataTable extends DataTable
{
    protected $taxonomy;

    public function mount($taxonomy)
    {
        $this->taxonomy = $taxonomy;
    }

    /**
     * Columns datatable
     *
     * @return array
     */
    public function columns()
    {
        return [
            'name' => [
                'label' => trans('juzaweb::app.name'),
                'formatter' => [$this, 'rowActionsFormatter']
            ],
            'total_post' => [
                'label' => trans('juzaweb::app.total_posts'),
                'width' => '15%',
                'align' => 'center',
            ],
            'created_at' => [
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
        /**
         * @var Builder $query
         */
        $query = $this->makeModel()->query();
        $data['post_type'] = $this->taxonomy['post_type'];
        $data['taxonomy'] = $this->taxonomy['taxonomy'];

        $query->whereFilter($data);

        return $query;
    }

    public function rowAction($row)
    {
        $data = parent::rowAction($row);

        $data['view'] = [
            'label' => trans('juzaweb::app.view'),
            'url' => '',
            'target' => '_blank',
        ];

        return $data;
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
    }

    protected function makeModel()
    {
        return app($this->taxonomy['model']);
    }
}
