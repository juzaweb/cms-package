<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

Route::group([
    'namespace' => '\Juzaweb\Cms\Http\Controllers',
    'middleware' => 'guest'
], function () {
    Route::post('/login', 'Auth\LoginController@login');
    Route::post('/register', 'Auth\RegisterController@register');
    Route::post('/forgot-password', 'Auth\ForgotPasswordController@forgotPassword');
});

Route::group([
    'middleware' => 'guest'
], function () {
    Route::get('/login', 'LoginController@index')->name('login');
    Route::get('/register', 'RegisterController@index')->name('register');
    Route::get('/forgot-password', 'ForgotPasswordController@index')->name('forgot_password');
});

Route::get('/', 'HomeController@index')->name('home');
Route::get('/search', 'SearchController@index')->name('search');
Route::get('/search-ajax', 'SearchController@index')->name('search.ajax');

Route::get('/{slug?}', 'RouteController@index')
    ->where('slug', '.*');
