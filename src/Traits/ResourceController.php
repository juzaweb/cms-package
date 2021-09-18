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
    public function index(...$params)
    {
        return view($this->viewPrefix . '.index',
            $this->getDataForIndex(...$params)
        );
    }

    public function create(...$params)
    {
        $this->addBreadcrumb([
            'title' => $this->getTitle(...$params),
            'url' => action([static::class, 'index'], ...$params),
        ]);

        $model = $this->makeModel();
        return view($this->viewPrefix . '.form', array_merge([
            'title' => trans('juzaweb::app.add_new')
        ], $this->getDataForForm($model, ...$params)));
    }

    public function edit(...$params)
    {
        $indexParams = $params;
        unset($indexParams[$this->getPathIdIndex($indexParams)]);
        $indexParams = collect($indexParams)->values()->toArray();

        $this->addBreadcrumb([
            'title' => $this->getTitle(...$params),
            'url' => action([static::class, 'index'], ...$indexParams),
        ]);

        $model = $this->makeModel()->findOrFail($this->getPathId($params));
        return view($this->viewPrefix . '.form', array_merge([
            'title' => $model->{$model->getFieldName()}
        ], $this->getDataForForm($model, ...$params)));
    }

    public function store(Request $request, ...$params)
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
            $this->afterStore($request, $model, ...$params);
            $this->afterSave($request, $model, ...$params);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->storeSuccessResponse(
            $model,
            $request,
            ...$params
        );
    }

    public function update(Request $request, ...$params)
    {
        $validator = $this->validator($request->all());
        if (is_array($validator)) {
            $validator = Validator::make($request->all(), $validator);
        }

        $validator->validate();

        $model = $this->makeModel()->findOrFail($this->getPathId($params));
        DB::beginTransaction();
        try {
            $this->beforeUpdate($request, $model, ...$params);
            $model->update($request->all());
            $this->afterUpdate($request, $model, ...$params);
            $this->afterSave($request, $model, ...$params);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->updateSuccessResponse(
            $model,
            $request,
            ...$params
        );
    }

    protected function beforeStore(Request $request, ...$params)
    {
        //
    }

    protected function afterStore(Request $request, $model, ...$params)
    {
        //
    }

    protected function beforeUpdate(Request $request, $model, ...$params)
    {
        //
    }

    protected function afterUpdate(Request $request, $model, ...$params)
    {
        //
    }

    /**
     * After Save model
     *
     * @param Request $request
     * @param \Juzaweb\Models\Model $model
     * @param mixed $params
     */
    protected function afterSave(Request $request, $model, ...$params)
    {
        //
    }

    protected function makeModel()
    {
        return app($this->getModel());
    }

    protected function parseDataForSave(array $attributes, ...$params)
    {
        return $attributes;
    }

    /**
     * Get data for form
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return array
     */
    protected function getDataForForm($model, ...$params)
    {
        return [
            'model' => $model
        ];
    }

    protected function getDataForIndex(...$params)
    {
        $dataTable = $this->getDataTable(...$params);

        return [
            'title' => $this->getTitle(...$params),
            'dataTable' => $dataTable
        ];
    }

    protected function getPathIdIndex($params)
    {
        return count($params) - 1;
    }

    protected function getPathId($params)
    {
        return $params[$this->getPathIdIndex($params)];
    }

    protected function storeSuccessResponse($model, $request, ...$params)
    {
        return $this->success([
            'message' => trans('juzaweb::app.created_successfully'),
            'redirect' => action([static::class, 'index'], ...$params)
        ]);
    }

    protected function updateSuccessResponse($model, $request, ...$params)
    {
        return $this->success([
            'message' => trans('juzaweb::app.updated_successfully')
        ]);
    }

    /**
     * Get data table resource
     *
     * @return \Juzaweb\Abstracts\DataTable
     */
    abstract protected function getDataTable(...$params);

    /**
     * Validator for store and update
     *
     * @param array $attributes
     * @return Validator|array
     */
    abstract protected function validator(array $attributes, ...$params);

    /**
     * Get model resource
     *
     * @return string // namespace model
     */
    abstract protected function getModel(...$params);

    /**
     * Get title resource
     *
     * @return string
     **/
    abstract protected function getTitle(...$params);
}