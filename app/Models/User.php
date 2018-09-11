<?php

namespace Mo;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable;

    protected $fillable = [
        'name', 'password',
    ];

    protected $hidden = [
        'password',
    ];
    protected $appends = [
        'role_id', 'role_name'
    ];
    
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return [];
    }
    
    /**
     * 获取用户列表
     * @return type
     */
    public static function getUserList($arr)
    {
        $where = [];
        
        if (!empty($arr['user_name'])) {
            $where[] = ['name', 'like', '%'.$arr['user_name'].'%'];
        }
        if (!empty($arr['start_date'])) {
            $where[] = ['created_at', '>', $arr['start_date']];
        }
        if (!empty($arr['end_date'])) {
            $where[] = ['created_at', '<', $arr['end_date']];
        }
        
        return self::where($where)->orderBy('created_at', 'desc')->paginate(10);
    }
    
    /**
     * 添加角色
     */
    public static function addUser($arr)
    {
        $user = new User;

        $user->name = $arr['user_name'];
        $user->password = password_hash($arr['pass'], PASSWORD_DEFAULT);
        $user->phone = $arr['phone'];
        
        // 判断user_name 是否为空
        if (empty($user->name) || empty($user->password)) {
            msg(100, '用户名密码必填');
        }

        // 判断是否有重复数据
        if (self::where('name', $user->name)->first()) {
            msg(804, '该用户组已存在');
        }
                
        $res = $user->save();
        if (! $res) {
            msg(805, '数据操作失败');
        }
        
        $user_id = $user->id;
        
        
        // 关联 role_user 表
        $res1 = RoleUser::addRoleUser($arr['role_id'], $user_id);
        
        if (! $res1) {
            msg(805, '数据操作失败');
        }
        
        msg(0, 'success');
    }
    
    /**
     * 获取 角色信息
     */
    public function getUserInfo($arr)
    {
        if (empty($arr['user_id'])) {
            msg(100, '缺少参数user_id');
        }
        
        return self::where('id', $arr['user_id'])->first();
        
        
    }
    
    public function getRoleUser()
    {
        return $this->hasOne('Mo\RoleUser', 'user_id', 'id')->first();
    }
    
    public function getRoleIdAttribute()
    {
        try {
            $role_id = $this->getRoleUser()->role_id;
        } catch (\Exception $exc) {
//            msg(1, $exc->getMessage());
            $role_id = 0;
        }
         
        return $role_id ?? 0;
    }
    
    
    public function getRoleNameAttribute()
    {
        try {
            $role_name = Role::where('id', $this->getRoleUser()->role_id)->value('role_name');
            
        } catch (\Exception $exc) {
//            msg(1, $exc->getMessage());
            $role_name = '';
        }
         
        return $role_name ?? '';
    }
    
    /**
     * 更新 用户信息
     */
    public static function updateUser($arr)
    {
        
        // 判断user_name 是否为空
        if (empty($arr['user_name']) || empty($arr['user_id'])) {
            msg(100, '缺少参数user_name, id');
        }
        
        $user = User::find($arr['user_id']);
        
        $user->name = $arr['user_name'];
        $user->phone = $arr['phone'];
        
        // 判断是否有重复数据
        $where[] = ['name', '=', $user->name];
        $where[] = ['id', '<>', $arr['user_id']];
        if (User::where($where)->first()) {
            msg(804, '该用户组已存在');
        }
        
        $res = $user->save();
        if (! $res) {
            msg(805, '数据操作失败');
        }
        
        $user_id = $user->id;
        
        // 关联 role_user 表
        $res1 = RoleUser::addRoleUser($arr['role_id'], $user_id);
        
        if (! $res1) {
            msg(805, '数据操作失败');
        }
        
        msg(0, 'success');
    }
    
    /**
     * 删除
     */
    public static function delUser($ids)
    {
        // 验证
        if (empty($ids)) {
            msg(100, '参数异常');
        }
        
        return self::destroy(explode(',', $ids));
    }
    
    
    
}