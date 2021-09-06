<?php

namespace Juzaweb\Cms\Http\Controllers\Frontend;

class RegisterController extends FrontendController
{
    public function index()
    {
        return view('theme::auth.register');
    }
}
