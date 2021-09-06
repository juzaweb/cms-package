<?php

namespace Juzaweb\Theme\Http\Controllers;

class RegisterController extends FrontendController
{
    public function index()
    {
        return view('theme::auth.register');
    }
}
