<?php

namespace Juzaweb\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Juzaweb\Http\Controllers\FrontendController;

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
