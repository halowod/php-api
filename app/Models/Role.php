<?php

namespace Mo;

use Illuminate\Database\Eloquent\Model;

/**
 * 用户组 管理
 */

class Role extends Model
{
//    protected $table = 'test.role';
    protected $table = 'role';
    protected $hidden = ['updated_at'];
    
    
    
    public static function getRoleList()
    {
        return self::get();
    }
    
    
}