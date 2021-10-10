<?php

namespace Juzaweb\Http\Controllers\Frontend;

use Juzaweb\Http\Controllers\FrontendController;

class RegisterController extends FrontendController
{
    public function index()
    {
        do_action('recaptcha.init');

        return view('theme::auth.register', [
            'title' => trans('juzaweb::app.register')
        ]);
    }
}
