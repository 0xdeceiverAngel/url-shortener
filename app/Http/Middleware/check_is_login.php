<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class check_is_login
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
        if(!Auth::check() or !Auth::viaRemember())
        {
            return "no auth";
            // return redirect('/',301);
        }
        
        return $next($request);
    }
}
