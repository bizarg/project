<?php

namespace App\Http\Middleware;

use App\Types\Error;
use App\User;
use Closure;

class AdminApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = [];
        $xsauth = $request->headers->get('X-S-AUTH');

        if (!isset($xsauth)) {
            $response['error'] = Error::auth_key_bad;
        } else {
            if ($xsauth != env('API_KEY_ADMIN')) {
                $user = User::where('api_key', $xsauth)->where('reseller', 1)->first();
                isset($user) ? $request->user = $user : $response['error'] = Error::auth_key_bad;
 
            }

            $jsonStr = $request->getContent();
            if (empty($jsonStr)) {
                $response['error'] = Error::request_empty;
            } else {
                $jsonObj = json_decode($request->getContent(), true);
                if (is_null($jsonObj)) {
                    $response['error'] = Error::request_json_error;
                } else {
                    $request->data = $jsonObj;
                }
            }

        }
        if (isset($response['error'])) {
            return response()->json($response);
        } else {
            return $next($request);
        }
    }
}
