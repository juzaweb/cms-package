<?php
/**
 * Created by PhpStorm.
 * User: dtv
 * Date: 10/16/2021
 * Time: 8:15 PM
 */

namespace Juzaweb\Http\Controllers\Frontend;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Juzaweb\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use Juzaweb\Models\User;

class ProfileController extends FrontendController
{
    public function index($slug = null)
    {
        $title = trans('juzaweb::app.profile');
        $user = Auth::user();

        return view('theme::profile.index', compact(
            'title',
            'user',
            'slug'
        ));
    }

    public function changePassword()
    {
        $title = trans('juzaweb::app.change_password');
        $user = Auth::user();

        return view('theme::profile.change_password', compact(
            'title',
            'user'
        ));
    }

    public function notification()
    {
        $title = trans('juzaweb::app.profile');
        $user = Auth::user();
        $notifications = $user->unreadNotifications;

        return view('theme::profile.notification.index', compact(
            'title',
            'notifications',
            'user'
        ));
    }

    public function doChangePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|confirmed|string|max:32|min:6',
        ]);

        $currentPassword = $request->post('current_password');
        $password = $request->post('password');
        $user = Auth::user();

        if (!Hash::check($currentPassword, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => trans('juzaweb::app.current_password_incorrect'),
            ]);
        }

        $user->update([
            'password' => Hash::make($password),
        ]);

        return $this->success([
            'message' => trans('juzaweb::app.change_password_successfully'),
        ]);
    }
}
