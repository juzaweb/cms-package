<?php

namespace Juzaweb\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Juzaweb\Http\Controllers\Controller;
use Juzaweb\Models\PasswordReset;
use Juzaweb\Models\User;
use Juzaweb\Support\Email;
use Juzaweb\Traits\ResponseMessage;

class ForgotPasswordController extends Controller
{
    use ResponseMessage;

    public function index()
    {
        do_action('auth.forgot-password.index');

        return view('juzaweb::auth.forgot_password', [
            'title' => trans('juzaweb::app.forgot_password'),
        ]);
    }

    public function forgotPassword(Request $request)
    {
        do_action('auth.forgot-password.handle', $request);

        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $email = $request->post('email');
        $user = User::whereEmail($email)
            ->where('status', '=', 'active')
            ->first();

        try {
            $resetToken = Str::random(32);
            PasswordReset::create([
                'email' => $request->post('email'),
                'token' => $resetToken,
            ]);

            Email::make()
                ->withTemplate('reset_password')
                ->setParams([
                    'name' => $user->name,
                    'email' => $email,
                    'token' => $resetToken,
                ])
                ->send();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            throw $exception;
        }

        return $this->success(['redirect' => route('auth.forgot-password')]);
    }
}
