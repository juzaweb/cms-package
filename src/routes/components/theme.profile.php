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
    'middleware' => 'auth',
    'prefix' => 'profile'
], function () {
    Route::get('notification', 'Frontend\ProfileController@notification')->name('profile.notification');
    Route::get('change-password', 'Frontend\ProfileController@changePassword')->name('profile.change_password');
    Route::post('change-password', 'Frontend\ProfileController@doChangePassword');
    Route::get('/{slug?}', 'Frontend\ProfileController@index')->name('profile');
});
