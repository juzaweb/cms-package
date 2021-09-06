<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Theme\Support;

use Illuminate\Support\Arr;
use Juzaweb\Theme\Abstracts\MenuBoxAbstract;

class PostTypeMenuBox extends MenuBoxAbstract
{
    protected $key;
    protected $postType;

    public function __construct($key, $postType)
    {
        $this->key = $key;
        $this->postType = $postType;
    }

    public function mapData($data)
    {
        $result = [];
        $items = $data['items'];

        $query = app($this->postType->get('model'))->query();
        $items = $query->whereIn('id', $items)->get();

        foreach ($items as $item) {
            $result[] = $this->getData([
                'name' => $item->getTitle(),
                'model_id' => $item->id,
            ]);
        }

        return $result;
    }

    public function getData($item)
    {
        return [
            'name' => $item['name'],
            'model_class' => $this->postType->get('model'),
            'model_id' => $item['model_id'],
        ];
    }

    public function addView()
    {
        return view('jw_theme::backend.menu.boxs.post_type_add', [
            'key' => $this->key,
            'postType' => $this->postType
        ]);
    }

    public function editView($item)
    {
        return view('jw_theme::backend.menu.boxs.post_type_edit', [
            'item' => $item,
            'postType' => $this->postType
        ]);
    }

    public function getLinks($menuItems)
    {
        $permalink = apply_filters('juzaweb.permalinks', []);
        $permalink = Arr::get($permalink, $this->postType->get('key'));

        if (empty($permalink)) {
            $base = '';
        } else {
            $base = $permalink->get('base');
        }

        $query = app($this->postType->get('model'))->query();
        $items = $query->whereIn('id', $menuItems->pluck('model_id')->toArray())
            ->get(['id', 'slug'])->keyBy('id');

        return $menuItems->map(function ($item) use ($base, $items) {
            $item->link = url()->to($base . '/' . $items[$item->model_id]->slug) . '/';
            return $item;
        });
    }
}