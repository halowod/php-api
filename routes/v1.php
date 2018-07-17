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
//    $api->get('user', 'UserController@index'); # 用户列表
//    $api->get('user/{id}', 'UserController@show'); # 获取单个用户信息
//    $api->post('user', 'UserController@store'); # 添加用户
//    $api->put('user/{id}', 'UserController@update'); # 更改用户信息
//    $api->delete('user/{id}', 'UserController@delete'); # 删除用户
    
    
    
    
});


// 需要验签的路由
$api->version('v1', [
    'namespace' => 'Controllers\V1',
    'middleware' => 'sign'
], function ($api) {
    // 注册、登录、退出
    $api->post('reg', 'User\AuthController@reg'); # 注册
    $api->post('login', 'User\AuthController@login'); # 登录
    $api->post('logout', 'User\AuthController@logout'); # 退出
    
});


// 不验证
$api->version('v1', [
    'namespace' => 'Controllers\V1'
], function ($api) {
    $api->any('test', 'TestController@index'); # 测试
});