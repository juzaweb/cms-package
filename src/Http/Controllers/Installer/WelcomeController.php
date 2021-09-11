<?php

namespace Juzaweb\Http\Controllers\Installer;

use Juzaweb\Http\Controllers\Controller;

class WelcomeController extends Controller
{
    public function index()
    {
        return redirect()->route('installer.welcome');
    }

    public function welcome()
    {
        return view('juzaweb::installer.welcome');
    }
}
