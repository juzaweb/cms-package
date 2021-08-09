<?php
/**
 * MYMO CMS - Free Laravel CMS
 *
 * @package    juzawebcms/juzawebcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 5/30/2021
 * Time: 12:08 PM
 */

Route::postTypeResource('posts', 'Backend\PostController');

Route::juzawebResource('comments', 'Backend\CommentController');

