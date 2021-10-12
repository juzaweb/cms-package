<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Http\Datatables;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Juzaweb\Abstracts\DataTable;
use Juzaweb\Models\Comment;

class CommentDatatable extends DataTable
{
    protected $postType;

    public function mount($postType)
    {
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
            'author' => [
                'label' => trans('juzaweb::app.name'),
                'formatter' => function ($value, $row, $index) {
                    return e($row->getUserName());
                },
            ],
            'email' => [
                'label' => trans('juzaweb::app.email'),
                'width' => '15%',
                'align' => 'center',
                'formatter' => function ($value, $row, $index) {
                    if ($value) {
                        return e($value);
                    }

                    return $row->user->email ?? '';
                },
            ],
            'content' => [
                'label' => trans('juzaweb::app.content'),
                'formatter' => function ($value, $row, $index) {
                    return e($value);
                },
            ],
            'post' => [
                'label' => trans('juzaweb::app.post'),
                'width' => '20%',
                'formatter' => function ($value, $row, $index) {
                    return $row->postType()->getTitle();
                },
            ],
            'status' => [
                'label' => trans('juzaweb::app.status'),
                'width' => '10%',
                'formatter' => function ($value, $row, $index) {
                    return Comment::allStatuses()[$value];
                },
            ],
            'created_at' => [
                'label' => trans('juzaweb::app.created_at'),
                'width' => '15%',
                'align' => 'center',
                'formatter' => function ($value, $row, $index) {
                    return jw_date_format($row->created_at);
                },
            ],
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
        $query = Comment::query()->with(['user']);
        $query->where('object_type', '=', $this->postType);

        if ($keyword = Arr::get($data, 'keyword')) {
            $query->where(function (Builder $q) use ($keyword) {
                $q->where('name', 'like', '%'. $keyword .'%');
                $q->orWhere('content', 'like', '%'. $keyword .'%');
            });
        }

        if ($status = Arr::get($data, 'status')) {
            $query->where('status', '=', $status);
        }

        return $query;
    }

    public function actions()
    {
        $actions = parent::actions();
        $statuses = Comment::allStatuses();
        foreach ($statuses as $key => $status) {
            $actions[$key] = [
                'label' => $status,
            ];
        }

        return $actions;
    }

    public function bulkActions($action, $ids)
    {
        foreach ($ids as $id) {
            switch ($action) {
                case 'delete':
                    Comment::find($id)->delete($id);

                    break;
            }
        }

        if (in_array($action, array_keys(Comment::allStatuses()))) {
            if (in_array($action, array_keys(Comment::allStatuses()))) {
                Comment::whereIn('id', $ids)->update([
                    'status' => $action,
                ]);
            }
        }
    }
}
