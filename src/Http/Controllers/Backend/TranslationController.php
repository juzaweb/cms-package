<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 *
 * Created by JUZAWEB.
 * Date: 8/15/2021
 * Time: 5:23 PM
 */

namespace Juzaweb\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Juzaweb\Http\Controllers\BackendController;
use Juzaweb\Traits\ArrayPagination;
use Juzaweb\Facades\Locale;

class TranslationController extends BackendController
{
    use ArrayPagination;

    public function index()
    {
        return view('jw_trans::translation.index', [
            'title' => trans('juzaweb::app.translations')
        ]);
    }

    public function getDataTable(Request $request)
    {
        $search = $request->get('search');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 10);
        $page = $offset <= 0 ? 1 : (round($offset / $limit)) + 1;

        $result = Locale::all();

        if ($search) {
            $result = collect($result)->filter(function ($item) use ($search) {
                return (
                    strpos($item['title'], $search) !== false
                );
            });
        }

        $total = count($result);
        $items = $this->arrayPaginate($result, $limit, $page)->values();

        return response()->json([
            'total' => $total,
            'rows' => $items
        ]);
    }
}
