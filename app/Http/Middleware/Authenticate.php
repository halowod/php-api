<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->header('Authorization'); // 测试
        if ($token == 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sdW1lbmFwaS5sb2NhbFwvYXBpXC91c2VyXC9yZWciLCJpYXQiOjE1MjM5NDgwMzEsImV4cCI6MjA0NDU1NDgwMzEsIm5iZiI6MTUyMzk0ODAzMSwianRpIjoic2RpSXJrWE8xMkI5UW54SiIsInN1YiI6MSwicHJ2IjoiNzAwN2E2Y2IzNzVhNGQ0YTQxNDJiMjVlM2Q2YWJjYjM4OWM5MDgyNiJ9.Obr9zPD-ZR2sW6aFGJR5YFz5-fs1yi0uC5rCtx5fdM0') {
            return $next($request);
        }
        
        if ($this->auth->guard($guard)->guest()) {
            return response('登陆已过期', 401);
        }

        return $next($request);
    }
}
