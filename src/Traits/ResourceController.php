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
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

trait ResourceController
{
    public function index(...$params)
    {
        return view(
            $this->viewPrefix . '.index',
            $this->getDataForIndex(...$params)
        );
    }

    public function create(...$params)
    {
        $this->authorize('create', $this->getModel(...$params));

        $indexRoute = str_replace(
            '.create',
            '.index',
            Route::currentRouteName()
        );

        $this->addBreadcrumb([
            'title' => $this->getTitle(...$params),
            'url' => route($indexRoute, $params),
        ]);

        $model = $this->makeModel(...$params);

        return view($this->viewPrefix . '.form', array_merge([
            'title' => trans('juzaweb::app.add_new'),
        ], $this->getDataForForm($model, ...$params)));
    }

    public function edit(...$params)
    {
        $indexRoute = str_replace(
            '.edit',
            '.index',
            Route::currentRouteName()
        );

        $indexParams = $params;
        unset($indexParams[$this->getPathIdIndex($indexParams)]);
        $indexParams = collect($indexParams)->values()->toArray();

        $this->addBreadcrumb([
            'title' => $this->getTitle(...$params),
            'url' => route($indexRoute, $indexParams),
        ]);

        $model = $this->makeModel(...$indexParams)->findOrFail($this->getPathId($params));
        $this->authorize('update', $model);

        return view($this->viewPrefix . '.form', array_merge([
            'title' => $model->{$model->getFieldName()},
        ], $this->getDataForForm($model, ...$params)));
    }

    public function store(Request $request, ...$params)
    {
        $this->authorize('create', $this->getModel(...$params));

        $validator = $this->validator($request->all(), ...$params);
        if (is_array($validator)) {
            $validator = Validator::make($request->all(), $validator);
        }

        $validator->validate();
        $data = $this->parseDataForSave($request->all());

        DB::beginTransaction();

        try {
            $this->beforeStore($request);
            $model = $this->makeModel(...$params);
            $slug = $request->get('slug');

            if ($slug && method_exists($model, 'generateSlug')) {
                $data['slug'] = $model->generateSlug($slug);
            }

            $model = $model->create($data);

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
        $validator = $this->validator($request->all(), ...$params);
        if (is_array($validator)) {
            $validator = Validator::make($request->all(), $validator);
        }

        $validator->validate();
        $data = $this->parseDataForSave($request->all());

        $model = $this->makeModel(...$params)
            ->findOrFail($this->getPathId($params));
        $this->authorize('update', $model);

        DB::beginTransaction();
        try {
            $this->beforeUpdate($request, $model, ...$params);
            $slug = $request->get('slug');
            if ($slug && method_exists($model, 'generateSlug')) {
                $model->generateSlug($slug);
            }

            $model->update($data);

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

    protected function makeModel(...$params)
    {
        return app($this->getModel(...$params));
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
            'model' => $model,
        ];
    }

    protected function getDataForIndex(...$params)
    {
        $dataTable = $this->getDataTable(...$params);

        return [
            'title' => $this->getTitle(...$params),
            'dataTable' => $dataTable,
            'linkCreate' => action([static::class, 'create'], $params),
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
        $indexRoute = str_replace(
            '.store',
            '.index',
            Route::currentRouteName()
        );

        return $this->success([
            'message' => trans('juzaweb::app.created_successfully'),
            'redirect' => route($indexRoute, $params),
        ]);
    }

    protected function updateSuccessResponse($model, $request, ...$params)
    {
        return $this->success([
            'message' => trans('juzaweb::app.updated_successfully'),
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
     * @param array $params
     * @return string // namespace model
     */
    abstract protected function getModel(...$params);

    /**
     * Get title resource
     *
     * @param array $params
     * @return string
     */
    abstract protected function getTitle(...$params);
}
