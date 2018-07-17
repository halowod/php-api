<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

/**
 * 说明   请求 header 头，需添加 Accept :  application/vnd.lumen.v1+json，具体配置参考dingoapi
 */

$api = app('Dingo\Api\Routing\Router');

// 验签+授权
$api->version('v1', [
    'namespace' => 'Controllers\V1',
    'middleware' => ['sign', 'auth']
], function ($api) {
//    $api->get('user', 'UserController@index'); # 获取用户信息

    // 用户 - 用于管理员操作
//    $api->get('auser', 'AuserController@index'); # 用户列表
//    $api->get('auser/{id}', 'AuserController@show'); # 获取单个用户信息
//    $api->post('auser', 'AuserController@store'); # 添加用户
//    $api->put('auser/{id}', 'AuserController@update'); # 更改用户信息
//    $api->delete('auser/{id}', 'AuserController@delete'); # 删除用户
    
    
    
    
});


// 需要验签的路由
$api->version('v1', [
    'namespace' => 'Controllers\V1',
    'middleware' => 'sign'
], function ($api) {
    // 注册、登录、退出
    $api->post('user/reg', 'UserController@reg'); # 注册
    $api->post('user/login', 'UserController@login'); # 登录
    $api->post('user/logout', 'UserController@logout'); # 退出
    
});


// 不验证
$api->version('v1', [
    'namespace' => 'Controllers\V1'
], function ($api) {
    $api->any('test', 'TestController@index'); # 测试
});