<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzawebcms/juzawebcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
 *
 * Created by JUZAWEB.
 * Date: 6/23/2021
 * Time: 10:19 AM
 */

Route::group(['prefix' => 'email'], function () {
    Route::post('/', 'EmailController@save')->name('admin.setting.email.save');

    Route::post('send-test-mail', 'EmailController@sendTestMail')->name('admin.setting.email.test-email');
});

Route::jwResource('email-template', 'EmailTemplateController');

Route::group(['prefix' => 'logs/email'], function () {
    Route::get('/', 'EmailLogController@index')->name('admin.logs.email');

    Route::get('/get-data', 'EmailLogController@getData')->name('admin.logs.email.getdata');

    Route::post('/status', 'EmailLogController@status')->name('admin.logs.email.status');

    Route::post('/remove', 'EmailLogController@remove')->name('admin.logs.email.remove');
});
