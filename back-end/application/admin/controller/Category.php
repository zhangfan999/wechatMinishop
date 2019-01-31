<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use util\Tree;

class Category extends Common
{
    public function index($id = 0, $tab = 1){
        if(request()->isPost()){
            // 获取数组需加/a
            foreach (input('post.sort/a') as $key => $value) {
                Db::name('category')->where('id',$key)->update(['sort'=>$value]);
            }
            return success('排序更新成功',url('index'));
        }else{
            $category =  Db::name('category')->order('sort')->select();
            $tree = new Tree();
            $tree->tree($category, 'id', 'pid', 'name');
            $lists = $tree->getArray();
            $this->assign('lists', $lists);

            //编辑广告
            if(3 == $tab){
                $info = Db::name('category')->where('id', $id)->find();
                if($info){
                    $this->assign('info', $info);
                }
            }
        }
        return view();
    }

    public function add(){
        if(request()->isPost()){
            $count = Db::name('category')->where('name',input('post.name'))->count();
            if($count){
                return error('分类名称重名');
            }else{
                $result = Db::name('category')->strict(false)->insert(input('post.'));
                if($result){
                    return success('分类添加成功',url('index'));
                }else{
                    return error('分类添加失败');
                }
            }
        }
    }

    public function edit($id = 0){
        if(request()->isPost()){
            $count = Db::name('category')->where('id','<>',$id)->where('name',input('post.name'))->count();
            if($count){
                return error('分类名称重名');
            }else{
                $result = Db::name('category')->strict(false)->update(input('post.'));
                if($result !== false){
                    return success('分类编辑成功',url('index'));
                }else{
                    return error('分类编辑失败');
                }
            }
        }
    }
}
