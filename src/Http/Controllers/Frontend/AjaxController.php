<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Juzaweb\Facades\HookAction;
use Juzaweb\Http\Controllers\FrontendController;

class AjaxController extends FrontendController
{
    protected function ajax(Request $request, $key)
    {
        $ajax = HookAction::getFrontendAjaxs($key);

        if (empty($ajax)) {
            return response([
                'status' => false,
                'message' => 'Ajax function not found.'
            ]);
        }

        if ($ajax->get('auth') && !Auth::check()) {
            return response([
                'status' => false,
                'message' => 'Ajax no rights.'
            ]);
        }

        return call_user_func($ajax->get('callback'));
    }
}
