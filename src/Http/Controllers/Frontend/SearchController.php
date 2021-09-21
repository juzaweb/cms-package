<?php

namespace Juzaweb\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Juzaweb\Http\Controllers\FrontendController;
use Juzaweb\Models\Search;

class SearchController extends FrontendController
{
    public function index(Request $request)
    {
        $keyword = $request->input('q');
        $title = trans('juzaweb::app.result_for_keyword', [
            'name' => $keyword
        ]);

        $posts = Search::select(['*'])
            ->wherePublish()
            ->whereSearch($keyword)
            ->paginate(12);

        $posts->getCollection()->transform(function ($item) {
            return $item->post;
        });

        return view('theme::search', compact(
            'posts',
            'title',
            'keyword'
        ));
    }
    
    public function ajaxSearch()
    {
    
    }
}
