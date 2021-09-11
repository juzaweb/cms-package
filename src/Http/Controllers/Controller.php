<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package juzaweb/laravel-cms
 * @author The Anh Dang
 *
 * Developed based on Laravel Framework
 * Github: https://juzaweb.com/cms
 */

namespace Juzaweb\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
