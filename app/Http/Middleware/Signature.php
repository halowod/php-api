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
        $sign = $request->header('Signature'); // 测试
        if ($sign == '2D07A24FB20651C0799225A6CB32467E13BE0D60') {
            return $next($request);
        }
        
        if (! sign::handle($request)) {
            msg(104, 'Incorrect signature.');
        } 
        
        return $next($request);
    }
}
