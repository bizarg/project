<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if(!$user->canDo('VIEW_ADMIN', FALSE)){
            return redirect('/');
        }

        return $next($request);
    }
}
