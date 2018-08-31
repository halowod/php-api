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
    
    // 系统退出、刷新
    $api->get('logout', 'User\AuthController@logout'); # 退出
    $api->get('refresh', 'User\AuthController@refresh'); # 刷新
    
    
    // 后台 -  权限管理， 给用户分配权限、 添加新的权限
    $api->any('role', 'Access\RoleController@store'); # 用户组 
    
    $api->get('user', 'User\UserController@index'); # 用户列表
    $api->get('user/{id}', 'User\UserController@show'); # 获取单个用户信息
    $api->post('user', 'User\UserController@store'); # 添加用户
    $api->put('user/{id}', 'User\UserController@update'); # 更改用户信息
    $api->delete('user/{id}', 'User\UserController@delete'); # 删除用户
    
    $api->get('access', 'User\AccessController@index'); # 权限路由列表
    $api->get('access/{id}', 'User\AccessController@show'); # 获取单个权限信息
    $api->post('access', 'User\AccessController@store'); # 添加权限
    $api->put('access/{id}', 'User\AccessController@update'); # 更改权限信息
    $api->delete('access/{id}', 'User\AccessController@delete'); # 删除权限路由
    
    
    
    
    
    // 前台权限管理
    
    
    
    
    
});


// 需要验签的路由
$api->version('v1', [
    'namespace' => 'Controllers\V1',
    'middleware' => 'sign'
//    'middleware' => ['sign', 'auth']
], function ($api) {
    // 注册、登录、退出
    $api->post('reg', 'User\AuthController@reg'); # 注册
    $api->post('login', 'User\AuthController@login'); # 登录
    
    
});


// 不验证
$api->version('v1', [
    'namespace' => 'Controllers\V1'
], function ($api) {
    $api->any('test', 'TestController@index'); # 测试
    
});