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
        $title = $keyword ? trans('juzaweb::app.result_for_keyword', [
            'name' => $keyword,
        ]) : trans('juzaweb::app.search_results');

        $posts = Search::wherePublish()
            ->whereSearch($request->all())
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

    public function ajaxSearch(Request $request)
    {
        $limit = $request->input('limit', 5);

        if ($limit > 100) {
            $limit = 100;
        }

        $paginate = Search::wherePublish()
            ->whereSearch($request->all())
            ->paginate($limit);

        $paginate->getCollection()->transform(function ($item) {
            return $item->post;
        });

        $results = $paginate->items();
        foreach ($results as $key => $item) {
            if (empty($item)) {
                unset($results[$key]);

                continue;
            }

            $item->thumbnail = $item->getThumbnail();
            $item->link = $item->getLink();
            $item->title = $item->getTitle();
            $item->description = $item->getDescription();
            $item->created_date = jw_date_format($item->created_at);
        }

        $data['results'] = $results;
        if ($paginate->nextPageUrl()) {
            $data['pagination'] = ['more' => true];
        }

        return response()->json($data);
    }
}
