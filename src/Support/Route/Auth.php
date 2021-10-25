<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Support\Route;

use Illuminate\Support\Facades\Route;

class Auth
{
    public static function routes()
    {
        Route::group([
            'middleware' => 'guest',
        ], function () {
            Route::get('login', 'Auth\LoginController@index')->name('login');
            Route::post('login', 'Auth\LoginController@login');

            Route::get('register', 'Auth\RegisterController@index')->name('register');
            Route::post('register', 'Auth\RegisterController@register');

            Route::get('forgot-password', 'Auth\ForgotPasswordController@index')->name('forgot_password');
            Route::post('forgot-password', 'Auth\ForgotPasswordController@forgotPassword');

            Route::get('reset-password', 'Auth\ResetPasswordController@index');
            Route::post('reset-password', 'Auth\ResetPasswordController@resetPassword');

            Route::get('verification/{email}/{token}', 'Auth\RegisterController@verification')->name('verification');
        });

        Route::group(['middleware' => 'auth'], function () {
            Route::post('logout', 'Auth\LoginController@logout')->name('logout');
        });
    }
}