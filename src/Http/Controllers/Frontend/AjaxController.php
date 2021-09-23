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
use Juzaweb\Facades\HookAction;
use Juzaweb\Http\Controllers\FrontendController;

class AjaxController extends FrontendController
{
    public function ajaxNone(Request $request, $key)
    {
        return $this->ajax($request, $key, false);
    }

    public function ajaxAuth(Request $request, $key)
    {
        return $this->ajax($request, $key, true);
    }

    protected function ajax(Request $request, $key, $auth)
    {
        $ajax = HookAction::getFrontendAjaxs($key, $auth);
        if (empty($ajax)) {
            return response([
                'status' => false,
                'message' => 'Ajax function not found.'
            ]);
        }

        return app($ajax->get('callback'), [$request])->response();
    }
}
