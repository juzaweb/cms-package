<?php

namespace Juzaweb\Cms\Http\Controllers\Frontend;

class LoginController extends FrontendController
{
    public function index()
    {
        return view('theme::auth.login', [
            'title' => trans('juzaweb::app.login')
        ]);
    }
}
