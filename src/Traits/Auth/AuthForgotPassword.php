<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Traits\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Juzaweb\Models\PasswordReset;
use Juzaweb\Models\User;
use Juzaweb\Support\Email;
use Juzaweb\Traits\ResponseMessage;

trait AuthForgotPassword
{
    use ResponseMessage;

    public function index()
    {
        do_action('forgot-password.index');

        return view('juzaweb::auth.forgot_password', [
            'title' => trans('juzaweb::app.forgot_password'),
        ]);
    }

    public function forgotPassword(Request $request)
    {
        do_action('forgot-password.handle', $request);

        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => trans('juzaweb::app.email_does_not_exists')
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
                ->withTemplate('forgot_password')
                ->setEmails([$request->post('email')])
                ->setParams([
                    'name' => $user->name,
                    'email' => $email,
                    'token' => $resetToken,
                    'url' => route('user.reset_password', [
                        'email' => $email,
                        'token' => $resetToken,
                    ]),
                ])
                ->send();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->success([
            'message' => trans('app.send_email_successfully'),
            'redirect' => route('forgot_password')
        ]);
    }
}