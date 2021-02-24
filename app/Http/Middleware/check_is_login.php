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
        
        if (Auth::check() or Auth::viaRemember() ) {
                // $request->is_login=1;
                $request->owner_id=Auth::user()->id;
                return $next($request);
        }

        if (!Auth::check() and !Auth::viaRemember()) {
            return redirect('/',301);
        }
    }
}
