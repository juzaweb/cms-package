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
 * Date: 6/9/2021
 * Time: 2:05 PM
 */

namespace Juzaweb\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

trait ResourceController
{
    public function index()
    {
        return view($this->viewPrefix . '.index', $this->getDataForIndex());
    }

    public function create()
    {
        $this->addBreadcrumb([
            'title' => $this->getTitle(),
            'url' => action([static::class, 'index']),
        ]);

        $model = $this->makeModel();
        return view($this->viewPrefix . '.form', array_merge([
            'title' => trans('juzaweb::app.add_new')
        ], $this->getDataForForm($model)));
    }

    public function edit($id)
    {
        $this->addBreadcrumb([
            'title' => $this->getTitle(),
            'url' => action([static::class, 'index']),
        ]);

        $model = $this->makeModel()->findOrFail($id);
        return view($this->viewPrefix . '.form', array_merge([
            'title' => $model->{$model->getFieldName()}
        ], $this->getDataForForm($model)));
    }

    public function store(Request $request)
    {
        $validator = $this->validator($request->all());
        if (is_array($validator)) {
            $validator = Validator::make($request->all(), $validator);
        }

        $validator->validate();

        DB::beginTransaction();
        try {
            $this->beforeStore($request);
            $model = $this->getModel()::create($request->all());
            $this->afterStore($request, $model);
            $this->afterSave($request, $model);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->success([
            'message' => trans('juzaweb::app.created_successfully'),
            'redirect' => action([static::class, 'index'])
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = $this->validator($request->all());
        if (is_array($validator)) {
            $validator = Validator::make($request->all(), $validator);
        }

        $validator->validate();

        $model = $this->makeModel()->findOrFail($id);
        DB::beginTransaction();
        try {
            $this->beforeUpdate($request, $model);
            $model->update($request->all());
            $this->afterUpdate($request, $model);
            $this->afterSave($request, $model);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->success([
            'message' => trans('juzaweb::app.updated_successfully')
        ]);
    }

    protected function beforeStore(Request $request)
    {
        //
    }

    protected function afterStore(Request $request, $model)
    {
        //
    }

    protected function beforeUpdate(Request $request, $model)
    {
        //
    }

    protected function afterUpdate(Request $request, $model)
    {
        //
    }

    /**
     * After Save model
     *
     * @param Request $request
     * @param \Juzaweb\Models\Model $model
     */
    protected function afterSave(Request $request, $model)
    {
        //
    }

    protected function makeModel()
    {
        return app($this->getModel());
    }

    protected function parseDataForSave(array $attributes)
    {
        return $attributes;
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
            'model' => $model
        ];
    }

    protected function getDataForIndex()
    {
        $dataTable = $this->getDataTable();

        return [
            'title' => $this->getTitle(),
            'dataTable' => $dataTable
        ];
    }

    /**
     * Get data table resource
     *
     * @return \Juzaweb\Abstracts\DataTable
     */
    abstract protected function getDataTable();

    /**
     * Validator for store and update
     *
     * @param array $attributes
     * @return Validator|array
     */
    abstract protected function validator(array $attributes);

    /**
     * Get model resource
     *
     * @return string // namespace model
     */
    abstract protected function getModel();

    /**
     * Get title resource
     *
     * @return string
     **/
    abstract protected function getTitle();
}