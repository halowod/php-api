<?php

namespace Mo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * 用户组 管理
 */

class Role extends Model
{
//    protected $table = 'test.role';
    protected $table = 'role';
    protected $hidden = ['updated_at'];
    protected $appends = [
        'permit_id'
    ];


    /**
     * 获取角色列表
     * @return type
     */
    public static function getRoleList($arr)
    {
        $where = [];
        
        if (!empty($arr['role_name'])) {
            $where[] = ['role_name', 'like', '%'.$arr['role_name'].'%'];
        }
        if (!empty($arr['start_date'])) {
            $where[] = ['created_at', '>', $arr['start_date']];
        }
        if (!empty($arr['end_date'])) {
            $where[] = ['created_at', '<', $arr['end_date']];
        }
        
        return self::where($where)->orderBy('created_at', 'desc')->paginate(10);
//        return self::where($where)->get();
    }
    
    /**
     * 添加角色
     */
    public static function addRole($arr)
    {
        $role = new Role;

        $role->role_name = $arr['role_name'];
        
        // 判断role_name 是否为空
        if (empty($role->role_name)) {
            msg(100, '缺少参数role_name');
        }

        // 判断是否有重复数据
        if (Role::where('role_name', $role->role_name)->first()) {
            msg(804, '该用户组已存在');
        }
        
        return $role->save();
    }
    
    /**
     * 获取 角色信息
     */
    public function getRoleInfo($arr)
    {
        if (empty($arr['role_id'])) {
            msg(100, '缺少参数role_id');
        }
        
        return self::where('id', $arr['role_id'])->first();
    }
    
    public function getRolePermit()
    {
         return $this->hasMany('Mo\RolePermit', 'role_id', 'id');
    }
    
    public function getPermitIdAttribute()
    {
        try {
            $permit_id = $this->getRolePermit()->select('permit_id')->get();
        } catch (\Exception $exc) {
            msg(1, $exc->getMessage());
            $permit_id = 0;
        }
        
        $arr = [];
        foreach ($permit_id as $key => $value) {
            $arr[] = $value->permit_id;
        }
        return empty($permit_id) ? 0 : implode($arr, ',');
    }
    
    /**
     * 更新 角色信息
     */
    public static function updateRole($arr)
    {
        
        // 判断role_name 是否为空
        if (empty($arr['role_name']) || empty($arr['role_id'])) {
            msg(100, '缺少参数role_name, id');
        }
        
        $role = self::find($arr['role_id']);
        
        $role->role_name = $arr['role_name'];
        
        // 判断是否有重复数据
        $where[] = ['role_name', '=', $role->role_name];
        $where[] = ['id', '<>', $arr['role_id']];
        
        if (Role::where($where)->first()) {
            msg(804, '该用户组已存在');
        }
        
        DB::beginTransaction();
        
        try {
            $role->save();
            
            // 更新 权限关联表 permit_checked_keys
            RolePermit::addRolePermit($arr['permit_checked_keys'], $arr['role_id']);
            DB::commit();
        } catch (\Exception $exc) {
            DB::rollBack();
            msg(1, $exc->getMessage());
        }
        
        return true;
    }
    
    /**
     * 删除
     */
    public static function delRole($ids)
    {
        // 验证
        if (empty($ids)) {
            msg(100, '参数异常');
        }
        
        return self::destroy(explode(',', $ids));
    }
    
    /**
     * 简单版列表
     */
    public static function simpledata()
    {
        return self::select('id as value', 'role_name as label')->get();
    }
    
    
    
}