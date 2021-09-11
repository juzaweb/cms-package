<?php

namespace Juzaweb\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Juzaweb\Facades\GlobalData;
use Juzaweb\Http\Controllers\BackendController;
use Juzaweb\Http\Datatable\TaxonomyDataTable;
use Juzaweb\Models\Taxonomy;
use Juzaweb\Traits\ResourceController;

class TaxonomyController extends BackendController
{
    use ResourceController {
        getDataForForm as DataForForm;
        getDataForIndex as DataForIndex;
        store as TraitStore;
    }

    protected $viewPrefix = 'juzaweb::backend.taxonomy';

    protected function getDataTable($taxonomy)
    {
        $setting = $this->getSetting($taxonomy);
        $dataTable = new TaxonomyDataTable();
        $dataTable->mountData($setting->toArray());
        return $dataTable;
    }

    public function storeSuccessResponse($model, $request, $taxonomy)
    {
        return $this->success([
            'message' => trans('juzaweb::app.successfully'),
            'html' => view('juzaweb::components.tag-item', [
                'item' => $model,
                'name' => $taxonomy,
            ])->render()
        ]);
    }

    public function getTagComponent(Request $request, $taxonomy)
    {
        $item = Taxonomy::findOrFail($request->input('id'));
        return $this->response([
            'html' => view('juzaweb::components.tag-item', [
                'item' => $item,
                'name' => $taxonomy
            ])
                ->render()
        ], true);
    }

    /**
     * Get post type by url
     *
     * @return string
     */
    protected function getPostType()
    {
        $split = explode('.', Route::currentRouteName());
        return Str::plural($split[count($split) - 3]);
    }

    /**
     * Get taxonomy setting
     *
     * @param string $taxonomy
     * @return \Illuminate\Support\Collection
     */
    protected function getSetting($taxonomy)
    {
        $taxonomies = GlobalData::get('taxonomies');
        return $taxonomies[$this->getPostType()][$taxonomy] ?? collect([]);
    }

    /**
     * Validator for store and update
     *
     * @param array $attributes
     * @return Validator|array
     */
    protected function validator(array $attributes)
    {
        return [
            'name' => 'required'
        ];
    }

    /**
     * Get model resource
     *
     * @return string // namespace model
     */
    protected function getModel()
    {
        return Taxonomy::class;
    }

    /**
     * Get title resource
     *
     * @return string
     */
    protected function getTitle($taxonomy)
    {
        $setting = $this->getSetting($taxonomy);
        return $setting->get('label');
    }

    protected function getDataForIndex($taxonomy)
    {
        $data = $this->DataForIndex($taxonomy);
        $data['taxonomy'] = $taxonomy;
        $data['setting'] = $this->getSetting($taxonomy);
        return $data;
    }

    protected function getDataForForm($model, $taxonomy)
    {
        $data = $this->DataForForm($model, $taxonomy);
        $data['taxonomy'] = $taxonomy;
        $data['setting'] = $this->getSetting($taxonomy);
        return $data;
    }
}
