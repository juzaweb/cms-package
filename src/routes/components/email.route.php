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
    Route::post('/', 'Backend\EmailController@save')->name('admin.setting.email.save');

    Route::post('send-test-mail', 'Backend\EmailController@sendTestMail')->name('admin.setting.email.test-email');
});

Route::jwResource('email-template', 'Backend\EmailTemplateController');

Route::group(['prefix' => 'logs/email'], function () {
    Route::get('/', 'Backend\EmailLogController@index')->name('admin.logs.email');

    Route::get('/get-data', 'Backend\EmailLogController@getData')->name('admin.logs.email.getdata');

    Route::post('/status', 'Backend\EmailLogController@status')->name('admin.logs.email.status');

    Route::post('/remove', 'Backend\EmailLogController@remove')->name('admin.logs.email.remove');
});

Route::group(['prefix' => 'logs/error'], function () {
    Route::get('/', 'Backend\LogViewerController@index')->name('admin.logs.error');
    Route::get('/get-data', 'Backend\LogViewerController@listLogs')->name('admin.logs.error.get-logs');
    Route::delete('/delete', 'Backend\LogViewerController@delete')->name('admin.logs.delete');

    Route::get('/{date}', 'Backend\LogViewerController@show')->name('admin.logs.error.date');
    Route::get('/{date}/get-data', 'Backend\LogViewerController@listLogsDate')->name('admin.logs.error.get-logs-date');
});
