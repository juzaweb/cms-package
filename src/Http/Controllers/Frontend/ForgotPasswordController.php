<?php

namespace Juzaweb\Http\Controllers\Frontend;

use Juzaweb\Http\Controllers\Controller;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        do_action('auth.forgot-password.index');

        return view('theme::auth.forgot_password', [
            'title' => trans('juzaweb::app.forgot_password'),
        ]);
    }
}
