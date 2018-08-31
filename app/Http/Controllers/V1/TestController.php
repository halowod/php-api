<?php

namespace Controllers\V1;

use Controllers\Controller;
use Illuminate\Http\Request;

/**
 * test qin
 * 2018-04-17 14:40
 */
class TestController extends Controller
{
    public function index(Request $request)
    {
        pretty_print($request->input());
//        pretty_print(url()->current());
        msg(180, 'success');
//        echo config('appkey.'.'e9d83b7f7751253d663dfd8ebbd4513c');
//        echo hash_hmac('md5', 'e9d83b7f7751253d663dfd8ebbd4513c', 'appkey');
//        echo password_hash(123456, PASSWORD_DEFAULT);
        
    }
    
}
