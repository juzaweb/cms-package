<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

$adminPrefix = config('juzaweb.admin_prefix');

Route::group([
    'prefix' => $adminPrefix,
    'middleware' => 'guest'
], function () {
    Route::get('/login', 'Auth\LoginController@index')->name('admin.login');
    Route::post('/login', 'Auth\LoginController@login');

    Route::get('/register', 'Auth\RegisterController@index')->name('admin.register');
    Route::post('/register', 'Auth\RegisterController@register');

    Route::get('/forgot-password', 'Auth\ForgotPasswordController@index')->name('admin.forgot_password');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', 'Auth\LoginController@logout')->name('auth.logout');
});
