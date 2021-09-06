<?php

namespace Juzaweb\Theme\Http\Controllers;

class LoginController extends FrontendController
{
    public function index()
    {
        return view('theme::auth.login', [
            'title' => trans('juzaweb::app.login')
        ]);
    }
}
