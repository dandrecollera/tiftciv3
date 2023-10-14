<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AlumniHandler
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->missing('sessionkey')) {
            return redirect()->route('loginScreen', ['err' => 4]);
            die();
        }
        $value = $request->session()->get('sessionkey');
        $decrypted_value = decrypt($value);

        $userinfo = explode(",",$decrypted_value);

        if ($userinfo[5] != 'alumni') {
            return redirect()->route('loginScreen', ['err' => 5]);
            die();
        }
        $request->attributes->add(['userinfo' => $userinfo]);
        return $next($request);
    }
}
