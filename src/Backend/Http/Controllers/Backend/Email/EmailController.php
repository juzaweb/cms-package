<?php

namespace Juzaweb\Cms\Backend\Http\Controllers\Backend\Email;

use Juzaweb\Cms\Backend\Http\Controllers\BackendController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Juzaweb\Cms\Email\EmailService;

class EmailController extends BackendController
{
    public function index()
    {
        $config = get_config('email', []);
        return view('juzacms::backend.email.index', [
            'title' => trans('juzacms::app.email_setting'),
            'config' => $config,
        ]);
    }
    
    public function save(Request $request)
    {
        $email = $request->post('email');
        set_config('email', $email);
        
        return $this->success([
            'message' => trans('juzacms::app.save_successfully')
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
            'message' => trans('juzacms::app.send_mail_successfully')
        ]);
    }
}
