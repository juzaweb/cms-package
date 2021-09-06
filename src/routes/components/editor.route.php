<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 *
 * Created by JUZAWEB.
 * Date: 8/11/2021
 * Time: 12:10 PM
 */

Route::group(['prefix' => 'editor'], function () {
    Route::get('/', 'Backend\ThemeEditorController@index')->name('admin.editor');

    Route::post('/save', 'Backend\ThemeEditorController@save')->name('admin.editor.save');
});
