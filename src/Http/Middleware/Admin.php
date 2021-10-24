<?php

namespace Juzaweb\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    public function handle($request, Closure $next)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        if (! Auth::user()->is_admin) {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
