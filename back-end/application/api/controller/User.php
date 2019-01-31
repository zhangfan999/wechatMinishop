<?php
namespace app\api\controller;
use think\Controller;
use think\Db;

// +----------------------------------------------------------------------
// | openId
//   wx.login ——code(登录凭证，每次变化)——网络请求——openId（唯一标识，同用户同一个小程序唯一的）
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | 用户注册及登录
//   后台接收(code+openId)——后台单独获取openId——进行对比——正确：判断数据库存在openId，存在即登录——重置token并返回
//                                                                                不存在即注册——生成token
//                                                   ——错误：返回信息并要求用户重登录
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | 有权限的接口调用
//   后台接收(openId+token[在有效期内])——数据库进行验证——正确：走其他业务逻辑、错误：要求用户重登录
// +----------------------------------------------------------------------

class User extends Common
{
    //获取用户信息，类似登录功能
    public function getUser(){
        if($this->checkOpenid()){
            $openid = input('openid','');
            // 第三季修正
            $data['nickname'] = input('nickname','');
            $data['head'] = input('head','');
            //检索用户表
            $user = Db::name('user')->where('openid', $openid)->find();
            if($user){
                // 第三季修正
                // 当用户昵称或头像为空，同时接收的昵称或头像不为空，说明首次登录授权，需要更新用户表昵称和头像
                if($user['nickname']=='' && $data['nickname']!=''){
                    // 更新用户表
                    Db::name('user')->where('openid', $openid)->update($data);
                    $user['nickname'] = $data['nickname'];
                    $user['head'] = $data['head'];
                }

                // 重置token
                $user['token'] = $this->resetToken();
                if($user['token']){
                    exit(json_encode(['code'=>200, 'msg'=>'验证成功', 'data'=>$user]));
                }else{
                    exit(json_encode(['code'=>401, 'msg'=>'token重置失败，请重新授权']));
                }
            }else{
                exit(json_encode(['code'=>400, 'msg'=>'无此用户']));
            }
        }else{
            exit(json_encode(['code'=>401, 'msg'=>'登录失败，请重新授权']));
        }
    }

    //用户注册
    public function register(){
        $data['openid'] = input('openid','');
        // 第三季修正
        // $data['nickname'] = input('nickname','');
        // $data['head'] = input('head','');
        $data['token'] = getRandChar(32);
        $data['token_time'] = time();
        $id = Db::name('user')->strict(false)->insertGetId($data);
        if($id){
            $user = Db::name('user')->where('id', $id)->find();
            exit(json_encode(['code'=>200, 'msg'=>'注册成功', 'data'=>$user]));
        }else{
            exit(json_encode(['code'=>400, 'msg'=>'注册失败']));
        }
    }

    //获取用户收货地址
    public function getAddress(){
        if($this->checkToken()){
            $openid = input('openid', '');
            $uid = getUidByOpenid($openid);
            $address = Db::name('address')->where('uid', $uid)->select();
            if(!$address){
                exit(json_encode(['code'=>400, 'msg'=>'无收货地址']));
            }
            exit(json_encode(['code'=>200, 'msg'=>'收货地址获取成功', 'info'=>$address]));
        }else{
            exit(json_encode(['code'=>400, 'msg'=>'请重新登录']));
        }
    }

    //获取某个用户具体某个收货地址
    public function getAddressById(){
        if($this->checkToken()){
            $id = input('id', 0); //地址ID
            $address = Db::name('address')->where('id', $id)->find();
            if(!$address){
                exit(json_encode(['code'=>400, 'msg'=>'无收货地址']));
            }
            exit(json_encode(['code'=>200, 'msg'=>'收货地址获取成功', 'info'=>$address]));
        }else{
            exit(json_encode(['code'=>400, 'msg'=>'请重新登录']));
        }
    }

    //添加收货地址
    public function addAddress(){
        if($this->checkToken()){
            $openid = input('openid', '');
            $uid = getUidByOpenid($openid);
            //将当前用户所有收货地址取消默认状态
            Db::name('address')->where('uid', $uid)->setField('is_default', 0);
            //新增
            $data['uid'] = $uid;
            $data['consignee'] = input('consignee', '');
            $data['address'] = input('address', '');
            $data['mobile'] = input('mobile', '');
            $result = Db::name('address')->insert($data);
            if($result){
                exit(json_encode(['code'=>200, 'msg'=>'收货地址添加成功']));
            }else{
                exit(json_encode(['code'=>400, 'msg'=>'收货地址添加失败']));
            }
        }else{
            exit(json_encode(['code'=>400, 'msg'=>'请重新登录']));
        }
    }

    //删除收货地址
    public function deleteAddress(){
        if($this->checkToken()){
            $openid = input('openid', '');
            $uid = getUidByOpenid($openid);
            $id = input('id', 0); //地址ID
            Db::name('address')->where('id', $id)->delete();
            //判断当前用户如果没有默认收货地址，则将最新一条地址设为默认
            $count = Db::name('address')->where('uid',$uid)->where('is_default', 1)->count();
            if(!$count){
                //设置最新一条地址为默认
                $count = Db::name('address')->where('uid',$uid)->order('id desc')->limit(1)->setField('is_default', 1);
            }
            exit(json_encode(['code'=>200, 'msg'=>'收货地址删除成功']));
        }else{
            exit(json_encode(['code'=>400, 'msg'=>'请重新登录']));
        }
    }

    //设默认地址
    public function setDefault(){
        if($this->checkToken()){
            $id = input('id', 0); //地址ID
            $openid = input('openid', '');
            $uid = getUidByOpenid($openid);
            //除当前地址外都设为非默认
            Db::name('address')->where('uid',$uid)->where('id', 'neq', $id)->setField('is_default', 0);
            //再将当前地址设为默认
            Db::name('address')->where('id', $id)->setField('is_default', 1);
            exit(json_encode(['code'=>200, 'msg'=>'默认地址设置成功']));
        }else{
            exit(json_encode(['code'=>400, 'msg'=>'请重新登录']));
        }
    }

    // 编辑收货地址
    public function editAddress() {
        if($this->checkToken()){
            $id = input('id', 0);

            $data['consignee'] = input('consignee', '');
            $data['address'] = input('address', '');
            $data['mobile'] = input('mobile', '');
            $result = Db::name('address')->where('id', $id)->update($data);
            if($result !== false){
                exit(json_encode(['code'=>200, 'msg'=>'收货地址编辑成功']));
            }else{
                exit(json_encode(['code'=>400, 'msg'=>'收货地址编辑失败']));
            }
        }else{
            exit(json_encode(['code'=>400, 'msg'=>'请重新登录']));
        }
    }

    //判断有无默认收货地址
    public function haveAddress(){
        if($this->checkToken()){
            $openid = input('openid', '');
            $uid = getUidByOpenid($openid);
            $count = Db::name('address')->where('uid', $uid)->where('is_default', 1)->count();
            if($count){
                exit(json_encode(['code'=>200, 'msg'=>'有默认收货地址']));
            }else{
                exit(json_encode(['code'=>401, 'msg'=>'无默认收货地址']));
            }
        }else{
            exit(json_encode(['code'=>400, 'msg'=>'请重新登录']));
        }
    }

    // 订单列表
    public function getOrderList(){
        if($this->checkToken()){
            $openid = input('openid', '');
            $uid = getUidByOpenid($openid);
            $status = input('status', 'ALL');
            $page = input('page', 1);
            $map = [];
            switch ($status) {
                case 'WAITPAY':
                    $map['order_status'] = 0;
                    break;
                case 'WAITSEND':
                    $map['order_status'] = 2;
                    break;
                case 'WAITRECEIVE':
                    $map['order_status'] = 3;
                    break;
                case 'FINISH':
                    $map['order_status'] = 1;
                    break;
                default:
                    break;
            }
            $map['uid'] = $uid;
            $config = ['page'=>$page, 'list_rows'=>5];
            $order = Db::name('order')->where($map)->order('id desc')->paginate(null,false,$config);
            foreach ($order as $key => $value) {
                //获取该订单中商品金额最大的一件商品ID
                $gid = Db::name('order_goods')->where('oid',$value['id'])->order('price desc')->limit(1)->value('gid');
                $order[$key] = array_merge((array)Db::name('goods')->where('id',$gid)->field('name,img')->find(), (array)$value);
            }
            exit(json_encode(['code'=>200, 'msg'=>'订单列表加载成功', 'info'=>$order]));
        }else{
            exit(json_encode(['code'=>400, 'msg'=>'请重新登录']));
        }
    }

    //取消订单
    public function cancelOrder(){
        if($this->checkToken()){
            $openid = input('openid', '');
            $uid = getUidByOpenid($openid);
            $oid = input('oid', 0);
            Db::name('order')->where('id',$oid)->where('uid',$uid)->setField('order_status', 4);
            exit(json_encode(['code'=>200, 'msg'=>'订单取消成功']));
        }else{
            exit(json_encode(['code'=>400, 'msg'=>'请重新登录']));
        }
    }

    //确认收货
    public function confirmOrder(){
        if($this->checkToken()){
            $openid = input('openid', '');
            $uid = getUidByOpenid($openid);
            $oid = input('oid', 0);
            Db::name('order')->where('id',$oid)->where('uid',$uid)->setField('order_status', 1);
            exit(json_encode(['code'=>200, 'msg'=>'确认收货成功']));
        }else{
            exit(json_encode(['code'=>400, 'msg'=>'请重新登录']));
        }
    }

    //获取某个订单信息
    public function getOrderDetail(){
        if($this->checkToken()){
            $openid = input('openid', '');
            $uid = getUidByOpenid($openid);
            $oid = input('oid', 0);
            $order = Db::name('order')->where('id',$oid)->where('uid',$uid)->find();
            if($order){
                //修改订单状态
                switch ($order['order_status']) {
                    case 0:
                        $order['order_status'] = '待付款';
                        break;
                    case 1:
                        $order['order_status'] = '已完成';
                        break;
                    case 2:
                        $order['order_status'] = '待发货';
                        break;
                    case 3:
                        $order['order_status'] = '待收货';
                        break;
                    case 4:
                        $order['order_status'] = '已取消';
                        break;

                    default:
                        # code...
                        break;
                }
                //查询该订单下所有商品信息
                $goods = Db::name('order_goods')->where('oid', $oid)->select();
                //根据GID获取商品图片标题等信息
                foreach ($goods as $key => $value) {
                    $goods[$key] = array_merge(Db::name('goods')->where('id',$goods[$key]['gid'])->field('name,img')->find(), $value);
                }
                $order['goods'] = $goods;

                exit(json_encode(['code'=>200, 'msg'=>'订单详情获取成功', 'result'=>$order]));
            }else{
                exit(json_encode(['code'=>401, 'msg'=>'该订单不存在']));
            }
        }else{
            exit(json_encode(['code'=>400, 'msg'=>'请重新登录']));
        }
    }

    //获取openid
    public function getOpenid(){
        $appid = input('appid','');
        $secret = input('secret','');
        $js_code = input('js_code','');

        $url = 'https://api.weixin.qq.com/sns/jscode2session';
        $data = array(
            'appid' => $appid,
            'secret' => $secret,
            'js_code' => $js_code,
            'grant_type' => 'authorization_code',
        );

        $res = httpRequest($url, 'POST', $data);
        //输出测试，正式使用请删除下面一行
        //输出{"session_key":"GxT18piX7JEvUhazrrcsxw==","openid":"oEE2t4n0eerWnb2mNShyK2ttXLc0"}
        // file_put_contents("../log.txt", $res, FILE_APPEND);

        $obj = json_decode($res); //返回数组或对象
        if($obj->openid != null && $obj->openid != ''){
            exit(json_encode(['code'=>200, 'msg'=>'openid获取成功', 'result'=>$obj->openid]));
        }else{
            exit(json_encode(['code'=>400, 'msg'=>'openid获取失败']));
        }
    }

}
