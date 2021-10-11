<?php

namespace Juzaweb\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Juzaweb\Http\Controllers\Controller;
use Juzaweb\Models\User;
use Juzaweb\Traits\ResponseMessage;

class LoginController extends Controller
{
    use ResponseMessage;

    public function index()
    {
        do_action('user.login.index');

        do_action('recaptcha.init');

        return view('juzaweb::auth.login', [
            'title' => trans('juzaweb::app.login'),
        ]);
    }

    public function login(Request $request)
    {
        // Login handle action
        do_action('user.login.handle', $request);

        // Validate login
        $request->validate([
            'email' => 'required|email|max:150',
            'password' => 'required|min:6|max:32',
        ]);

        if (get_config('google_recaptcha')) {
            $request->validate([
                'recaptcha' => 'required|recaptcha',
            ]);
        }

        $email = $request->post('email');
        $password = $request->post('password');
        $remember = filter_var($request->post('remember'), FILTER_VALIDATE_BOOLEAN);
        $user = User::whereEmail($email)->first(['status', 'is_admin']);

        if (empty($user)) {
            return $this->error([
                'message' => trans('juzaweb::message.login_form.login_failed'),
            ]);
        }

        if ($user->status != 'active') {
            if ($user->status == 'verification') {
                return $this->error([
                    'message' => trans('juzaweb::message.login_form.verification'),
                ]);
            }

            return $this->error([
                'message' => trans('juzaweb::message.login_form.user_is_banned'),
            ]);
        }

        if (Auth::attempt([
            'email' => $email,
            'password' => $password,
        ], $remember)) {
            /**
             * @var User $user
             */
            $user = Auth::user();

            do_action('user.login.success', $user);

            return $this->success([
                'message' => trans('juzaweb::app.login_successfully'),
                'redirect' => $user->is_admin ? route('admin.dashboard') : '/',
            ]);
        }

        do_action('user.login.failed');

        return $this->error([
            'message' => trans('juzaweb::message.login_form.login_failed'),
        ]);
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
        }

        return redirect()->to('/');
    }
}
