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
    $api->get('user', 'UserController@index'); # 获取用户信息
});


// 需要验签的路由
$api->version('v1', [
    'namespace' => 'Controllers\V1',
    'middleware' => 'sign'
], function ($api) {
    $api->post('user/reg', 'UserController@store'); # 新用户注册
});


// 不验证
$api->version('v1', [
    'namespace' => 'Controllers\V1'
], function ($api) {
    $api->any('test', 'TestController@index'); # 测试
});