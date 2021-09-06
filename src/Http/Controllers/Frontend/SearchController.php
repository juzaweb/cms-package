<?php

namespace Juzaweb\Cms\Http\Controllers\Frontend;

use Illuminate\Http\Request;

class SearchController extends FrontendController
{
    public function index(Request $request)
    {
        return view('search');
    }
    
    public function ajaxSearch()
    {
    
    }
}
