<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Cms\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Juzaweb\Cms\Http\Controllers\BackendController;

class PermalinkController extends BackendController
{
    public function index()
    {
        $title = trans('juzaweb::app.permalinks');
        $permalinks = apply_filters('juzaweb.permalinks', []);

        return view('juzaweb::backend.permalink.index', compact(
            'title',
            'permalinks'
        ));
    }

    public function save(Request $request)
    {
        $request->validate([
            'permalink' => 'required|array',
        ]);

        $permalinks = $request->post('permalink');

        foreach ($permalinks as $permalink) {
            if (empty(Arr::get($permalink, 'base'))) {
                return $this->error([
                    'message' => trans('validation.required', ['attribute' => trans('juzaweb::app.permalink_base')])
                ]);
            }
        }

        set_config('permalinks', $permalinks);

        return $this->success([
            'message' => trans('juzaweb::app.save_successfully')
        ]);
    }
}
