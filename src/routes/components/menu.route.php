<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

Route::group(['prefix' => 'menu'], function () {
    Route::get('/', 'Backend\MenuController@index')->name('admin.menu');
    Route::get('/{id}', 'Backend\MenuController@index')->name('admin.menu.id');
    Route::post('/store', 'Backend\MenuController@store')->name('admin.menu.store');
    Route::put('/{id}', 'Backend\MenuController@update')->name('admin.menu.update');
    Route::post('/add-item', 'Backend\MenuController@addItem')->name('admin.menu.add-item');
});
