<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Juzaweb\Facades\PostType;
use Juzaweb\Http\Datatable\PostTypeDatatable;

trait PostTypeController
{
    use ResourceController {
        ResourceController::afterSave as traitAfterSave;
    }

    public function index()
    {
        $postType = $this->getSetting();
        $viewPrefix = $this->viewPrefix ?? 'juzaweb::backend.post';
        $dataTable = new PostTypeDatatable();

        return view($viewPrefix . '.index', [
            'title' => $postType->get('label'),
            'postType' => $postType,
            'dataTable' => $dataTable
        ]);
    }

    public function create()
    {
        $this->addBreadcrumb([
            'title' => $this->getSetting()->get('label'),
            'url' => action([static::class, 'index']),
        ]);

        $model = $this->makeModel();
        $viewPrefix = $this->viewPrefix ?? 'juzaweb::backend.post';

        return view($viewPrefix . '.form', array_merge([
            'title' => trans('juzaweb::app.add_new')
        ], $this->getDataDataForForm($model)));
    }

    public function edit($id)
    {
        $this->addBreadcrumb([
            'title' => $this->getSetting()->get('label'),
            'url' => action([static::class, 'index']),
        ]);

        $model = $this->makeModel()->findOrFail($id);
        $viewPrefix = $this->viewPrefix ?? 'juzaweb::backend.post';

        return view($viewPrefix . '.form', array_merge([
            'title' => $model->name ?? $model->title
        ], $this->getDataDataForForm($model)));
    }

    /**
     * @return string
     * */
    abstract protected function getModel();

    protected function afterSave(Request $request, $model)
    {
        $this->traitAfterSave($request, $model);
        $model->syncTaxonomies($request->all());
    }

    public function bulkActions(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'action' => 'required',
        ]);

        $action = $request->post('action');
        $ids = $request->post('ids');

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

        return $this->success([
            'message' => trans('juzaweb::app.successfully')
        ]);
    }

    protected function getTitle()
    {
        return $this->getSetting()->get('label');
    }

    protected function validator(array $attributes)
    {
        $validator = Validator::make($attributes, [
            'title' => 'required|string|max:250',
            'description' => 'nullable',
            'status' => 'required|in:draft,publish,trash,private',
            'thumbnail' => 'nullable|string|max:150',
        ]);

        return $validator;
    }

    protected function getSetting()
    {
        $setting = PostType::getPostTypes($this->makeModel()->getPostType('key'));
        if (empty($setting)) {
            throw new \Exception('Post type ' . $this->makeModel()->getPostType() . ' does not exists.');
        }

        return $setting;
    }

    /**
     * Get data for form
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return array
     * */
    protected function getDataDataForForm($model)
    {
        return [
            'postType' => $model->getPostType('key'),
            'model' => $model
        ];
    }
}