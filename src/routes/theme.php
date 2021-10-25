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
require __DIR__ . '/components/theme.profile.php';

\Juzaweb\Support\Route\Auth::routes();

Route::match(['get', 'post'], 'ajax/{slug}', 'Frontend\AjaxController@ajax')->name('ajax');

Route::get('/', 'Frontend\HomeController@index')->name('home');
Route::match(['get', 'post'], 'search', 'Frontend\SearchController@index')->name('search');
Route::match(['get', 'post'], 'search/ajax', 'Frontend\SearchController@ajaxSearch')->name('ajax.search');
Route::post('{base}/{slug}', 'Frontend\PostController@comment')->name('comment');
Route::get('{slug?}', 'Frontend\RouteController@index')->where('slug', '.*');
