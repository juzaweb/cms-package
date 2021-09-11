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
    'middleware' => 'guest'
], function () {
    Route::get('/login', 'Frontend\LoginController@index')->name('login');
    Route::get('/register', 'Frontend\RegisterController@index')->name('register');
    Route::get('/forgot-password', 'Frontend\ForgotPasswordController@index')->name('forgot_password');

    Route::post('/login', 'Auth\LoginController@login');
    Route::post('/register', 'Auth\RegisterController@register');
    Route::post('/forgot-password', 'Auth\ForgotPasswordController@forgotPassword');
});

Route::get('/', 'Frontend\HomeController@index')->name('home');
Route::get('/search', 'Frontend\SearchController@index')->name('search');
Route::get('/search-ajax', 'Frontend\SearchController@index')->name('search.ajax');
Route::get('/{slug?}', 'Frontend\RouteController@index')->where('slug', '.*');
