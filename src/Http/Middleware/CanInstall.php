<?php

namespace Juzaweb\Cms\Http\Middleware;

use Closure;
use Juzaweb\Cms\Support\Installer;

class CanInstall
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        if (Installer::alreadyInstalled()) {
            return redirect()->home();
        }

        return $next($request);
    }
}
