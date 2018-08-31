<?php

namespace Controllers\V1\Access;

use Controllers\Controller;
use Illuminate\Http\Request;
use Mo\Role;

/**
 * 用户组
 */

class RoleController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * 角色列表
     */
    public function index()
    {
        echo 123;die;
    }
    
    /**
     * 添加角色
     */
    public function store(Request $request)
    {
        // 验证数据传输类型 content-type: application/json
        
        $method = $request->input('method');
        
        // 分发路由
        switch ($method) {
            case 'access.role.list':
                break;

            default:
                break;
        }
        echo $method;die;
        
        $param = json_decode($request->getContent());
        pretty_print($param);
        pretty_print($param->method);
    }
    
    /**
     * 查看角色
     */
    public function show()
    {
        
    }
    
    /**
     * 更新角色信息
     */
    public function update()
    {
        
    }
    
    /**
     * 删除角色
     */
    public function delete()
    {
        
    }
    
}


