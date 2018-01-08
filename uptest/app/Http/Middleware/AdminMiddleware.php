<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'admin')
    {
        if( Auth::guard($guard)->check() &&  Auth::guard($guard)->authenticate()->role == 'admin') {
            return $next($request);
        }
       // Auth::logout();
       // Auth::logout();
        return redirect()->guest('admin/login');
    }
}
