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
        $setting = HookAction::getPostTypes(
            $this->makeModel()->getPostType('key')
        );

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

    protected function parseDataForSave(array $attributes, ...$params)
    {
        $attributes['type'] = $this->makeModel()->getPostType('key');
        return $attributes;
    }
}
