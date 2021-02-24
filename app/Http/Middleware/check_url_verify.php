<?php

namespace App\Http\Middleware;

use Closure;

class check_url_verify
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
        if($request->url=="")
        {
            return response('error');
        }
        return $next($request);
    }
}
