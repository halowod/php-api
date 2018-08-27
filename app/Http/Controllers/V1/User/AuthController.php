<?php

namespace Controllers\V1\User;

use Controllers\Controller;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\JWTAuth;
use Carbon\Carbon;

/**
 * 用户
 * 2018-04-08 14:48
 */
class AuthController extends Controller
{
    
    private $jwt;
    
    public function __construct(JWTAuth $jwt)
    {
        parent::__construct();
        $this->jwt = $jwt;
    }
    
    /**
     * 注册
     */
    public function reg(Request $request)
    {
        $credentials = $request->only('name', 'password');
        
        // 验证 name、 password 的合法性
        #--------------------------
        
        // 入库  注册成功
        
        
        // 生成 token 返回
        $data = [
            'access_token' => \Auth::attempt($credentials),
            'token_type' => 'Bearer'
        ];
        
        msg(0, 'success', $data);
    }
    
    /**
     * 登录
     */
    public function login(Request $request)
    {
        $credentials = $request->only('name', 'password');
        
        // 验证用户 和 密码
        #----------------------------
        
        if (! $token = \Auth::attempt($credentials)) {
            msg(404, '登陆验证失败');
        }
        
        $data = [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expired_at' => Carbon::now()->addMinutes(config('jwt.ttl'))->toDateTimeString(),
            'refresh_at' => Carbon::now()->addMinutes(config('jwt.refresh_ttl'))->toDateTimeString(),
//            'user_id' => 
        ];
        
//        sleep(1);
        
        msg(0, 'success', $data);
    }
    
    /**
     * 登出
     */
    public function logout()
    {
        \Auth::logout();
        msg(0, 'logout success');
    }
    
    /**
     * 刷新token  原始的作废
     */
    public function refresh()
    {
        $token =  \Auth::refresh();
        
        $data = [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expired_at' => Carbon::now()->addMinutes(config('jwt.ttl'))->toDateTimeString(),
            'refresh_at' => Carbon::now()->addMinutes(config('jwt.refresh_ttl'))->toDateTimeString()
        ];
        
        msg(0, 'success', $data);
    }
    
    
}
