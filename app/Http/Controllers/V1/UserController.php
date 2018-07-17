<?php

namespace Controllers\V1;

use Controllers\Controller;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\JWTAuth;

/**
 * 用户模块 qin
 * 2018-04-08 14:48
 */
class UserController extends Controller
{
    
    private $jwt;
    
    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }
    /**
     * get
     */
    public function index()
    {
        //  验证 用户
        //  $token = $this->jwt->getToken();
        $user = $this->jwt->parseToken()->authenticate();
        print_r($user->toarray());die;
    }
    
    /**
     * post
     * 创建一个新用户
     */
    public function store(Request $request)
    {
        $credentials = $request->only('name', 'password');
        if (empty($credentials)) {
            msg(100, '请求参数无效');
        }
        
        if (! $token = $this->jwt->attempt($credentials)) {
            return response()->json(['user_not_found'], 404);
        }
        
        return response()->json(compact('token'));
    }
    
    
    
}
