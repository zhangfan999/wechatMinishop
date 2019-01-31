<?php
namespace app\admin\model;

use think\Model;

class Category extends Model
{
    // 无限级分类
    public static function tree($data){
        $tree = [];

        foreach ($data as $value) {
            $tree[$value['id']] = $value;
        }

        foreach ($tree as $key => $value)
            $tree[$value['pid']]['son'][] = &$tree[$key]; //引用
        $tree = isset($tree[0]['son']) ? $tree[0]['son'] : array();

        return $tree;
    }
}
