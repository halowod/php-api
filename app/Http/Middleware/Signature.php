<?php

namespace App\Http\Middleware;

use Closure;
use Ser\SignatureService as sign;

class Signature
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
        if (! sign::handle($request)) {
            msg(104, 'Incorrect signature.');
        } 
        
        return $next($request);
    }
}
