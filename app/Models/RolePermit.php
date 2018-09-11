<?php

namespace Mo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * 用户角色关联
 */

class RolePermit extends Model
{
    protected $table = 'role_permit';
    protected $hidden = ['created_at', 'updated_at'];


    /**
     * 添加 角色 - 权限关联
     * 【一个角色对应多个权限】
     * @return type
     */
    public static function addRolePermit($permit_ids, $role_id)
    {
        if (empty($permit_ids)) {
            return true;
        }
        
        // 删除用户相关的角色
        self::where('role_id', $role_id)->delete();
        
        // 添加关联信息
        $data = [];
        $permit_id_arr = explode(',', $permit_ids);
        
        for ($i = 0; $i < count($permit_id_arr); $i++) {
            $data[$i]['role_id'] = $role_id;
            $data[$i]['permit_id'] = $permit_id_arr[$i];
        }
        
        DB::table('public.role_permit')->insert($data);
    }
    
    
    
    
    
}