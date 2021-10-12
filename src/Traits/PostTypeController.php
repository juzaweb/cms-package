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
use Juzaweb\Facades\HookAction;
use Juzaweb\Http\Datatables\PostTypeDataTable;

trait PostTypeController
{
    use ResourceController {
        ResourceController::afterSave as traitAfterSave;
    }

    public function index()
    {
        $postType = $this->getSetting();
        $viewPrefix = $this->viewPrefix ?? 'juzaweb::backend.post';
        $dataTable = $this->getDataTable();

        return view($viewPrefix . '.index', [
            'title' => $this->getTitle(),
            'postType' => $postType,
            'dataTable' => $dataTable,
        ]);
    }

    public function create()
    {
        $this->addBreadcrumb([
            'title' => $this->getTitle(),
            'url' => action([static::class, 'index']),
        ]);

        $model = $this->makeModel();
        $viewPrefix = $this->viewPrefix ?? 'juzaweb::backend.post';

        return view($viewPrefix . '.form', array_merge([
            'title' => trans('juzaweb::app.add_new'),
        ], $this->getDataForForm($model)));
    }

    public function edit($id)
    {
        $this->addBreadcrumb([
            'title' => $this->getTitle(),
            'url' => action([static::class, 'index']),
        ]);

        $model = $this->makeModel()->findOrFail($id);
        $viewPrefix = $this->viewPrefix ?? 'juzaweb::backend.post';

        return view($viewPrefix . '.form', array_merge([
            'title' => $model->name ?? $model->title,
        ], $this->getDataForForm($model)));
    }

    /**
     * @return string
     */
    abstract protected function getModel();

    protected function afterSave(Request $request, $model)
    {
        $this->traitAfterSave($request, $model);
        $model->syncTaxonomies($request->all());
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
        $setting = HookAction::getPostTypes($this->makeModel()->getPostType('key'));
        if (empty($setting)) {
            throw new \Exception('Post type ' . $this->makeModel()->getPostType() . ' does not exists.');
        }

        return $setting;
    }

    /**
     * Get data table resource
     *
     * @return \Juzaweb\Abstracts\DataTable
     * @throws \Exception
     */
    protected function getDataTable()
    {
        $dataTable = new PostTypeDataTable();
        $dataTable->mountData($this->getSetting()->toArray());

        return $dataTable;
    }

    /**
     * Get data for form
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return array
     * */
    protected function getDataForForm($model)
    {
        return [
            'postType' => $model->getPostType('key'),
            'model' => $model,
        ];
    }
}
