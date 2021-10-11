<?php

namespace Juzaweb\Http\Controllers\Frontend;

use Juzaweb\Http\Controllers\FrontendController;

class LoginController extends FrontendController
{
    public function index()
    {
        do_action('recaptcha.init');

        return view('theme::auth.login', [
            'title' => trans('juzaweb::app.login'),
        ]);
    }
}
