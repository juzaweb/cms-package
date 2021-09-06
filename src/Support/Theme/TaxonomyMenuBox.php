<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Cms\Support\Theme;

use Illuminate\Support\Arr;
use Juzaweb\Cms\Abstracts\MenuBoxAbstract;

class TaxonomyMenuBox extends MenuBoxAbstract
{
    protected $key;
    /**
     * @var \Illuminate\Support\Collection $query
     */
    protected $taxonomy;

    public function __construct($key, $taxonomy)
    {
        $this->key = $key;
        $this->taxonomy = $taxonomy;
    }

    public function mapData($data)
    {
        $result = [];
        $items = $data['items'];

        /**
         * @var \Illuminate\Database\Eloquent\Builder $query
         */
        $query = app($this->taxonomy->get('model'))->query();
        $items = $query->whereIn('id', $items)->get();

        foreach ($items as $item) {
            $result[] = $this->getData([
                'name' => $item->name,
                'model_id' => $item->id,
            ]);
        }

        return $result;
    }

    public function getData($item)
    {
        return [
            'name' => $item['name'],
            'model_class' => $this->taxonomy->get('model'),
            'model_id' => $item['model_id'],
        ];
    }

    public function addView()
    {
        return view('jw_theme::backend.menu.boxs.taxonomy_add', [
            'taxonomy' => $this->taxonomy,
            'key' => $this->key
        ]);
    }

    public function editView($item)
    {
        return view('jw_theme::backend.menu.boxs.taxonomy_edit', [
            'taxonomy' => $this->taxonomy,
            'key' => $this->key,
            'item' => $item
        ]);
    }

    public function getLinks($menuItems)
    {
        $permalink = apply_filters('juzaweb.permalinks', []);
        $permalink = Arr::get($permalink, $this->key);
        $base = $permalink->get('base');
        $query = app($this->taxonomy->get('model'))->query();
        $items = $query->whereIn('id', $menuItems->pluck('model_id')->toArray())
            ->get(['id', 'slug'])->keyBy('id');

        return $menuItems->map(function ($item) use ($base, $items) {
            $item->link = url()->to($base . '/' . $items[$item->model_id]->slug) . '/';
            return $item;
        });
    }
}