<?php

namespace Controllers\V1\User;

use Controllers\Controller;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\JWTAuth;

/**
 * 用户
 * 2018-04-08 14:48
 */
class AuthController extends Controller
{
    
    private $jwt;
    
    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }
    
    /**
     * 注册
     */
    public function reg(Request $request)
    {
        $input = $request->only('name', 'password');
        
        // 验证 name、 password 的合法性
        #--------------------------
        
        // 入库
        
        
        // 生成 token 返回
        
        
    }
    
    /**
     * 登录
     */
    public function login(Request $request)
    {
        
    }
    
    /**
     * 登出
     */
    public function logout()
    {
        
    }
    
    /**
     * 刷新
     */
    public function refresh()
    {
        
    }
    
    
}
