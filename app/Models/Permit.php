<?php

namespace Mo;

use Illuminate\Database\Eloquent\Model;

/**
 * 权限 管理
 */

class Permit extends Model
{
    protected $table = 'permit';
    protected $hidden = ['updated_at'];


    /**
     * 获取权限列表
     * @return type
     */
    public static function getPermitList($arr)
    {
        $where = [];
        
        if (!empty($arr['permit_name'])) {
            $where[] = ['permit_name', 'like', '%'.$arr['permit_name'].'%'];
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
     * 获取权限级联关系
     * @return type
     */
    public static function getPermitView()
    {
        $data = self::get();
        
        return self::getTree($data, 0);
        
    }
    
    public static function getTree($data, $pid)
    {
        $dataTree = [];
        if ($pid == 0) {
            $dataTree[] = [
                'value' => 0,
                'label' => '无',
            ];
        }
        
        
        foreach ($data as $value) {
            if ($pid == $value->pid) {
                
//                $value['children'] = self::getTree($data, $value['id']);
//                $dataTree[] = $value;
                
                $valueNew['value'] = $value->id;
                $valueNew['label'] = $value->permit_name;
                
                $valueNew['children'] = self::getTree($data, $value['id']);
                if (empty($valueNew['children'])) {
                    unset($valueNew['children']);
                }
                $dataTree[] = $valueNew;
            }
            
            
        }
        
        return $dataTree;
        
    }

    /**
     * 添加权限
     */
    public static function addPermit($arr)
    {
        $permit = new Permit;

        $permit->action = $arr['permit_action'];
        $permit->method = $arr['permit_method'];
        $permit->permit_name = $arr['permit_name'];
        $permit->parent_path = !empty($arr['parent_path']) ? $arr['parent_path'] : '0';
        
        // 判断参数是否为空
        if (empty($permit->action) || empty($permit->method) || empty($permit->permit_name)) {
            msg(100, '缺少参数');
        }
        
        // 根据 parent path， 得出 parent id
        $parent_arr = explode(',', $permit->parent_path);
        if (count($parent_arr) == 1) {
            $permit->pid = $permit->parent_path;
        } else {
            $permit->pid = end($parent_arr);
        }
        
        // 判断是否有重复数据
        if (Permit::where('permit_name', $permit->permit_name)->first()) {
            msg(804, '该用户组已存在');
        }
        
        return $permit->save();
    }
    
    /**
     * 获取 权限的信息
     */
    public static function getPermitInfo($arr)
    {
        if (empty($arr['permit_id'])) {
            msg(100, '缺少参数permit_id');
        }
        
        return self::where('id', $arr['permit_id'])->first();
    }
    
    /**
     * 更新 权限信息
     */
    public static function updatePermit($arr)
    {
        
        // 判断permit_name 是否为空
        if (empty($arr['permit_name']) || empty($arr['permit_method']) || empty($arr['permit_action'])) {
            msg(100, '参数缺失');
        }
        
        $permit = Permit::find($arr['permit_id']);
        
        $permit->action = $arr['permit_action'];
        $permit->method = $arr['permit_method'];
        $permit->permit_name = $arr['permit_name'];
        $permit->parent_path = !empty($arr['parent_path']) ? $arr['parent_path'] : '0';
        
        // 根据 parent path， 得出 parent id
        $parent_arr = explode(',', $permit->parent_path);
        if (count($parent_arr) == 1) {
            $permit->pid = $permit->parent_path;
        } else {
            $permit->pid = end($parent_arr);
        }
        
        // 判断是否有重复数据
        $where[] = ['permit_name', '=', $permit->permit_name];
        $where[] = ['id', '<>', $arr['permit_id']];
        if (Permit::where($where)->first()) {
            msg(804, '该权限已存在');
        }
        
        return $permit->save();
        
    }
    
    /**
     * 删除
     */
    public static function delPermit($ids)
    {
        // 验证
        if (empty($ids)) {
            msg(100, '参数异常');
        }
        
        return self::destroy(explode(',', $ids));
    }
    
    
}