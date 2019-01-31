<?php
namespace app\api\controller;
use think\Controller;
use think\Db;

class Index extends Common
{
    public function index()
    {
        //幻灯片(不涉及token验证，可对外公开)
        $banner = Db::name('ad')->where('type',0)->order('sort desc')->limit(6)->select();
        //广告
        $ad = Db::name('ad')->where('type',1)->order('sort desc')->limit(4)->select();
        //获取楼层分类
        $category = Db::name('category')->where('is_show_index',1)->order('sort')->select();
        foreach ($category as $key => $value) {
            //获取当前主分类下最新四条商品信息
            $goods = Db::name('goods')->where('cid_one',$value['id'])->order('id desc')->limit(4)->select();
            $category[$key]['list'] = $goods;
        }

        exit(json_encode(['code'=>200, 'msg'=>'首页数据获取成功', 'banner'=>$banner, 'ad'=>$ad, 'goods'=>$category]));
    }
}
