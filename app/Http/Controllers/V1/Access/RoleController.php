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
        if (empty($method)) {
            msg(100, '缺少method参数');
        }
        
        // 分发路由
        switch ($method) {
            case 'access.role.list':
                $this->show($request);
                break;

            default:
                msg(100, '请求参数无效');
                break;
        }
        
    }
    
    /**
     * 查看角色
     */
    public function show(Request $request)
    {
        $data = Role::getRoleList();
        msg(0, 'success', $data);
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


