<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;

class Ad extends Common
{
    public function index($id = 0, $tab = 1){
        if(request()->isPost()){
            // 获取数组需加/a
            foreach (input('post.sort/a') as $key => $value) {
                Db::name('ad')->where('id',$key)->update(['sort'=>$value]);
            }
            return success('排序更新成功',url('index'));
        }else{
            $lists =  Db::name('ad')->order('sort')->select();
            $this->assign('lists', $lists);

            //编辑广告
            if(3 == $tab){
                $info = Db::name('ad')->where('id', $id)->find();
                if($info){
                    $this->assign('info', $info);
                }
            }
        }
        return view();
    }

    public function add(){
        //先判断post提交
        if(request()->isPost()){
            $data = input('post.');
            $result = Db::name('ad')->strict(false)->insert($data); //strict为false不进行字段严格检查
            if($result){
                return success('添加成功',url('index'));
            }else{
                return error('添加失败');
            }
        }
    }

    public function edit(){
        if(request()->isPost()){
            $data = input('post.');
            $result = Db::name('ad')->strict(false)->update($data);
            //如果信息未改变提交更新会返回false
            if($result !== false){
                return success('更新成功',url('index'));
            }else{
                return error('更新失败');
            }
        }
    }

    //删除功能
    public function delete($id=0){
        $imgUrl = ROOT_PATH . 'public/uploads/' . Db::name('ad')->where('id', $id)->value('img');
        try {
            unlink($imgUrl);
        } catch (Exception $e) {}
        if(Db::name('ad')->where('id', $id)->delete()){
            return success('删除成功',url('index'));
        }else{
            return error('删除失败');
        }
    }
}
