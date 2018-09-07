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
    $api->post('role', 'Access\RoleController@store'); # 角色
    $api->post('user', 'Access\UserController@store'); # 后台用户管理
    $api->post('access', 'Access\AccessController@store'); # 权限
    
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