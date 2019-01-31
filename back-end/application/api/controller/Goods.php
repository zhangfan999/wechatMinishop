<?php
namespace app\api\controller;
use think\Controller;
use think\Db;

class Goods extends Common
{
    public function search(){
        $keywords = input('keywords', '');
        //接收页数，默认为1
        $page = input('page', 1);
        $config = ['page'=>$page, 'list_rows'=>5]; //每页5条记录
        $goods = DB::name('goods')->where('name', 'like', '%'.$keywords.'%')->order('id desc')->paginate(null, false, $config);
        exit(json_encode(['code'=>200, 'msg'=>'商品搜索成功', 'info'=>$goods]));
    }

    public function getGoods(){
        $cid = input('cid', 0);
        //接收页数，默认为1
        $page = input('page', 1);
        $config = ['page'=>$page, 'list_rows'=>5]; //每页5条记录
        $goods = DB::name('goods')->where('cid_two', $cid)->order('id desc')->paginate(null, false, $config);
        exit(json_encode(['code'=>200, 'msg'=>'商品列表加载成功', 'info'=>$goods]));
    }

    /**
     * 获取商品信息
     */
    public function goodsInfo(){
        $id = input('id', 0); //商品ID
        $goodsInfo = Db::name('goods')->where('id', $id)->find();

        if(!$goodsInfo){
            $goods = ['code'=>400, 'msg'=>'没有该商品'];
        }else{
            //浏览量自增
            Db::name('goods')->where('id', $id)->setInc('views');
            //获取图片信息
            $images = Db::name('goods_images')->where('gid', $id)->select();
            //获取域名
            $domain = config('wxpay.domain');
            $goodsInfo['content'] = str_replace("/uploads/", $domain."/uploads/", $goodsInfo['content']);
            $goods = ['code'=>200, 'msg'=>'商品信息获取成功', 'images'=>$images, 'info'=>$goodsInfo];
        }
        exit(json_encode($goods));
    }

    //商品收藏或取消收藏
    public function collectGoods(){
        if($this->checkToken()){
            $openid = input('openid', '');
            $uid = getUidByOpenid($openid);
            $gid = input('gid', 0);
            //判断是一用户同一商品是否已收藏
            $count = Db::name('goods_collect')->where('uid',$uid)->where('gid',$gid)->count();
            if($count){
                //已收藏则取消收藏
                Db::name('goods_collect')->where('uid',$uid)->where('gid',$gid)->delete();
                exit(json_encode(['code'=>200, 'msg'=>'已取消收藏']));
            }else{
                //添加收藏
                Db::name('goods_collect')->insert(['uid'=>$uid, 'gid'=>$gid]);
                exit(json_encode(['code'=>200, 'msg'=>'收藏成功']));
            }
        }else{
            exit(json_encode(['code'=>400, 'msg'=>'请重新登录']));
        }
    }

    //获取收藏
    public function getCollects(){
        if($this->checkToken()){
            $openid = input('openid', '');
            $uid = getUidByOpenid($openid);
            $page = input('page', 1);
            $config = ['page'=>$page, 'list_rows'=>5];
            $collect = Db::name('goods_collect')->where('uid', $uid)->order('id desc')->paginate(null,false,$config);
            $goods = [];
            foreach ($collect as $key => $value) {
                $goods[$key] = Db::name('goods')->where('id',$value['gid'])->find();
            }
            exit(json_encode(['code'=>200, 'msg'=>'收藏商品加载成功', 'info'=>$goods]));
        }else{
            exit(json_encode(['code'=>400, 'msg'=>'请重新登录']));
        }
    }

}
