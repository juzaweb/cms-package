<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

Route::get('/themes/{theme}/{path}', 'AssetController@assetsTheme')
    ->where('theme', '[0-9a-z]+')
    ->where('path', '[0-9a-zA-Z\.\/\-]+');

Route::get('/themes/{theme}/{path}', 'AssetController@assetsTheme')
    ->where('theme', '[0-9a-z]+')
    ->where('path', '[0-9a-zA-Z\.\/\-]+');

Route::get('/storage/{path}', 'AssetController@assetsStorage')
    ->where('path', '[0-9a-zA-Z\.\/\-]+');
