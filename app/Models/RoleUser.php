<?php

namespace Mo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * 用户角色关联
 */

class RoleUser extends Model
{
    protected $table = 'role_user';
    protected $hidden = ['created_at', 'updated_at'];


    /**
     * 添加 角色 - 用户关联
     * 【说明：目前一个用户只可关联一个角色】
     * @return type
     */
    public static function addRoleUser($role_id = 0, $user_id = 0)
    {
        // 删除用户相关的角色
        self::where('user_id', $user_id)->delete();
        
        
        // 添加关联信息
        return DB::insert('insert into public.role_user (role_id, user_id) values (?, ?)', [$role_id, $user_id]);
    }
    
    
    
    
    
}