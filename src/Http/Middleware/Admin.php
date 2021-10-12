<?php

namespace Juzaweb\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    public function handle($request, Closure $next)
    {
        if (! Auth::check()) {
            return redirect()->route('user.login');
        }

        if (! Auth::user()->is_admin) {
            return abort(404);
        }

        return $next($request);
    }
}
