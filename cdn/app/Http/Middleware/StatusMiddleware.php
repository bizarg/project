<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class StatusMiddleware
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
            if(!$user->status){
                return redirect('status')->with('You are not an administrator!');
            }

        return $next($request);
    }
}
