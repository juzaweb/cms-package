<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package juzawebcms/juzawebcms
 * @author The Anh Dang
 *
 * Developed based on Laravel Framework
 * Github: https://github.com/juzawebcms/juzawebcms
 */

Route::group(['prefix' => 'themes'], function () {
    Route::get('/', 'Backend\ThemeController@index')->name('admin.themes');
    
    Route::post('/activate', 'Backend\ThemeController@activate')->name('admin.themes.activate');
});

Route::group(['prefix' => 'reading'], function () {
    Route::get('/', 'Backend\ReadingController@index')->name('admin.reading');

    Route::post('/save', 'Backend\ReadingController@save')->name('admin.reading.save');
});

Route::group(['prefix' => 'permalinks'], function () {
    Route::get('/', 'Backend\PermalinkController@index')->name('admin.permalink');

    Route::post('/save', 'Backend\PermalinkController@save')->name('admin.permalink.save');
});

