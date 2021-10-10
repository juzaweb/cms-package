<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

require __DIR__ . '/installer.php';

Route::group([
    'middleware' => 'guest'
], function () {
    Route::get('login', 'Frontend\LoginController@index')->name('login');
    Route::get('register', 'Frontend\RegisterController@index')->name('register');
    Route::get('forgot-password', 'Frontend\ForgotPasswordController@index')->name('forgot_password');
    Route::get('verification/{email}/{token}', 'Auth\VerificationController@verification')->name('verification');

    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('forgot-password', 'Auth\ForgotPasswordController@forgotPassword');
});

Route::match(['get', 'post'], 'ajax/{slug}', 'Frontend\AjaxController@ajax')->name('ajax');

Route::get('/', 'Frontend\HomeController@index')->name('home');
Route::match(['get', 'post'], 'search', 'Frontend\SearchController@index')->name('search');
Route::match(['get', 'post'], 'search/ajax', 'Frontend\SearchController@ajaxSearch')->name('ajax.search');
Route::post('{base}/{slug}', 'Frontend\PostController@comment')->name('comment');
Route::get('{slug?}', 'Frontend\RouteController@index')->where('slug', '.*');
