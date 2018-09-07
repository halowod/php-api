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
            
            case 'access.role.add':
                $this->add($request);
                break;
            case 'access.role.info':
                $this->info($request);
                break;
            case 'access.role.update':
                $this->update($request);
                break;
            case 'access.role.del':
                $this->delete($request);
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
        $input = $request->input();
        
        $data = Role::getRoleList($input);
        
        if (! $data->count()) {
            msg(806, '暂无数据');
        }
        
        msg(0, 'success', $data);
    }
    
    /**
     * 添加用户组
     */
    public function add(Request $request)
    {
        //  验证 user_name 是否为空
        $input = $request->input();
        #----------------------------
        
        
        $res = Role::addRole($input);
        
        if (! $res) {
            msg(805, '数据库写入失败');
        }
        
        msg(0, 'success');
    }
    
    /**
     * 获取角色信息
     */
    public function info(Request $request)
    {
        //  验证 role_id 是否为空
        $input = $request->input();
        #----------------------------
        
        
        $data = Role::getRoleInfo($input);
        
        if (! $data) {
            msg(806, '未找到你的数据');
        }
        
        msg(0, 'success', $data);
    }
    
    /**
     * 更新角色信息
     */
    public function update(Request $request)
    {
        //  验证 role_name 是否为空
        $input = $request->input();
        #----------------------------
        
        $res = Role::updateRole($input);
        
        if (! $res) {
            msg(805, '数据库写入失败');
        }
        
        msg(0, 'success');
    }
    
    /**
     * 删除角色
     */
    public function delete(Request $request)
    {
        // 获取要删除的id
        $ids = $request->role_ids;
        
        // 判断 是否有关联的用户，如果有的话，不可删除，需要先取消用户关联
        #--------------------------------
        #--------------------------------
        
        $res = Role::delRole($ids);
        
        if (! $res) {
            msg(805, '删除失败');
        }
        
        msg(0, 'success');
    }
    
}


