<?php

namespace Juzaweb\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Juzaweb\Events\EmailHook;
use Juzaweb\Http\Controllers\Controller;
use Juzaweb\Models\User;
use Juzaweb\Traits\ResponseMessage;

class RegisterController extends Controller
{
    use ResponseMessage;

    public function index()
    {
        if (! get_config('users_can_register', 1)) {
            return abort(403, trans('juzaweb::message.register-form.register-closed'));
        }

        do_action('auth.register.index');

        do_action('recaptcha.init');

        return view('juzaweb::auth.register', [
            'title' => trans('juzaweb::app.sign-up'),
        ]);
    }

    public function register(Request $request)
    {
        do_action('auth.register.handle', $request);

        if (! get_config('users_can_register', 1)) {
            return $this->error(trans('juzaweb::message.register-form.register-closed'));
        }

        // Validate register
        $request->validate([
            'email' => 'required|email|max:150|unique:users,email',
            'password' => 'required|min:6|max:32|confirmed',
        ]);

        // Create user
        $name = $request->post('name');
        $email = $request->post('email');
        $password = $request->post('password');

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }

        if (get_config('user_verification')) {
            $verifyToken = Str::random(32);

            $user->update([
                'status' => 'verification',
                'verification_token' => $verifyToken,
            ]);

            event(new EmailHook('register_success', [
                'to' => [$email],
                'params' => [
                    'name' => $name,
                    'email' => $email,
                    'verifyToken' => $verifyToken,
                    'verifyUrl' => route('verification', [$email, $verifyToken]),
                ],
            ]));

            return $this->success([
                'redirect' => route('register'),
                'message' => trans('juzaweb::app.registered_success_verify'),
            ]);
        } else {
            event(new EmailHook('register_success', [
                'params' => [
                    'name' => $name,
                    'email' => $email,
                ],
            ]));
        }

        do_action('auth.register.success', $user);

        return $this->success([
            'redirect' => route('login'),
            'message' => trans('juzaweb::app.registered_success'),
        ]);
    }
}
