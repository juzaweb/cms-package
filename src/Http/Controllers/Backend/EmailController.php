<?php

namespace Juzaweb\Http\Controllers\Backend;

use Juzaweb\Http\Controllers\BackendController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use JuzawebService;

class EmailController extends BackendController
{
    public function save(Request $request)
    {
        $email = $request->post('email');
        set_config('email', $email);
        
        return $this->success([
            'message' => trans('juzaweb::app.save_successfully')
        ]);
    }
    
    public function sendTestMail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);
        
        $email = $request->post('email');
        EmailService::make()
            ->setEmails($email)
            ->setSubject('Send email test for {name}')
            ->setBody('Hello {name}, This is the test email')
            ->setParams(['name' => Auth::user()->name])
            ->send();

        return $this->success([
            'message' => trans('juzaweb::app.send_mail_successfully')
        ]);
    }
}
