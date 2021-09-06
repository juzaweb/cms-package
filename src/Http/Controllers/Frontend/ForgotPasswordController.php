<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Cms\Http\Controllers\Frontend;

class ForgotPasswordController
{
    public function index()
    {
        return view('theme::auth.forgot_password', [
            'title' => trans('juzaweb::app.forgot_password')
        ]);
    }
}