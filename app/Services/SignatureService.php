<?php

namespace Ser;

/**
 *  签名认证处理
 */
class SignatureService
{
    /**
     * 签名算法 采用 HMAC-SHA1 算法
     * 1. 将除“s”外的所有参数过滤空值，
     * 2. 按key进行字典升序排列， 
     * 3. 所有参数拼接成字符串 ，拼接 accessKey 字符串
     * 4. 将上面生成的字符串进行base64编码
     * 5. 使用HMAC-SHA1加密算法，使用 appSecret 对 Step2 中得到的源串加密。
     * 6. 转换大写
     */
    
    //生成 AppSecret 加密规则 md5(base64(md5($appKey)).md5($salt))
    
    
    
    private static $sign;
    
    private static $param;
    
    private static $appSecret; // 通过appKey 查找 appSecret

    
    /**
     * 验证是否通过
     */
    public static function handle($request)
    {
        // 获取请求头里的appKey
        $appkey = $request->header('key');
        if (! empty(config('appkey.'.$appkey))) {
            self::$appSecret = config('appkey.'.$appkey);
        }
        
        $signature = $request->header('Signature');
        
        $param = $request->input();
        
        // 防止重放攻击  timestamp 期限60秒
//        $time = time() - $param['stime'];
//        
//        if ($time > 60) {
//            msg(107, 'timestamp参数无效');
//        }
        
        self::$param = $param;
        
        self::filterEmpty();
        
        self::sort();
        
        self::arrToString();
        
        self::base64Encode();
        
        self::hmacSha1();
        
        if (self::$sign != $signature) {
            return false;
        }
        
        return true;
    }
    
    /**
     * 空值过滤
     */
    private static function filterEmpty()
    {
        // 过滤掉参数里的 "s" 数组， 以及value为空的键值
        $filter = function ($param) 
        {
            foreach ($param as $key => $value) {
                
                if ($key == 's') {
                    unset($param[$key]);
                    continue;
                }
                
                if (ctype_space($value)) {
                    unset($param[$key]);
                }
            }
            
            return $param;
        };
        
        self::$param = $filter(self::$param);
    }
    
    /**
     * 数组排序
     */
    private static function sort()
    {
        $param = self::$param;
        
        if (isset($param)) {
            ksort ($param);
        }
        
        self::$param = $param;
    }
    
    /**
     * 转换字符串
     */
    private static function arrToString()
    {
        $str = function($param)
        {
            $res = '';
            $count = count($param);
            foreach ($param as $key => $value) {
                $res .= $key . '=' . $value . '&';
            }
            
            return rtrim($res, '&');
        };
        
        self::$param = $str(self::$param);
    }
    
    /**
     * baes64 编码
     */
    private static function base64Encode()
    {
        self::$param = base64_encode(self::$param);
    }
    
    /**
     * HMAC-SHA1 加密
     */
    private static function hmacSha1()
    {
        self::$sign = strtoupper(hash_hmac('sha1', self::$param, self::$appSecret));
    }
}
