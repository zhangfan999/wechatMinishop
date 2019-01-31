<?php
namespace app\api\controller;
use think\Controller;
use think\Db;

class Cart extends Common
{
    // 添加购物车
    public function addCart() {
        if($this->checkToken()){
            $openid = input('openid', '');
            $uid = getUidByOpenid($openid);
            $gid = input('gid', 0);
            $goodsNum = input('goodsNum', 0);
            if($uid){
                //判断库存
                $goods = Db::name('goods')->where('id', $gid)->find();
                if($goods['store'] >= $goodsNum){
                    //判断购物车是否已存在，存在则加数量，不存在添加一条数据
                    $cartNum = Db::name('cart')->where('uid', $uid)->where('gid', $gid)->count();
                    if($cartNum){
                        //存在则原数据加数量
                        Db::name('cart')->where('uid', $uid)->where('gid', $gid)->setInc('num', $goodsNum);
                    }else{
                        //新增购物车数据
                        $data['uid'] = $uid;
                        $data['gid'] = $gid;
                        $data['num'] = $goodsNum;
                        $data['name'] = $goods['name'];
                        $data['price'] = $goods['price'];
                        Db::name('cart')->insert($data);
                    }
                    exit(json_encode(['code'=>200, 'msg'=>'购物车添加成功']));
                }else{
                    exit(json_encode(['code'=>400, 'msg'=>'商品库存不足']));
                }
            }else{
                exit(json_encode(['code'=>400, 'msg'=>'请重新登录']));
            }
        }else{
            exit(json_encode(['code'=>400, 'msg'=>'请重新登录']));
        }
    }

    //检查是否已加入购物车
    public function checkCart() {
        if($this->checkToken()){
            $gid = input('gid',0);
            $goodsNum = input('goodsNum',0);
            $openid = input('openid', '');
            $uid = getUidByOpenid($openid);
            $count = Db::name('cart')->where('uid', $uid)->where('gid', $gid)->count();
            if($count){
                exit(json_encode(['code'=>200, 'msg'=>'该商品已加入购物车']));
            }else{
                $this->addCart();
            }
        }else{
            exit(json_encode(['code'=>400, 'msg'=>'请重新登录']));
        }
    }

    // 获取购物车数据
    public function cartList() {
        if($this->checkToken()){
            $openid = input('openid', '');
            $uid = getUidByOpenid($openid);
            if($uid){
                $cartList = Db::name('cart')->where('uid', $uid)->order('id')->select();
                if(!empty($cartList)){
                    //遍历购物车数据获取相应商品信息
                    foreach ($cartList as $key => $value) {
                        $cartList[$key] = array_merge((array)Db::name('goods')->where('id', $value['gid'])->field('id,img')->find(), (array)$value);
                    }
                }else{
                    exit(json_encode(['code'=>400, 'msg'=>'购物车为空']));
                }
            }else{
                exit(json_encode(['code'=>400, 'msg'=>'请重新登录']));
            }
            exit(json_encode(['code'=>200, 'msg'=>'购物车信息获取成功', 'carts'=>$cartList]));
        }else{
            exit(json_encode(['code'=>400, 'msg'=>'请重新登录']));
        }
    }

    //更新购物车商品单选状态
    public function updateSelect(){
        if($this->checkToken()){
            $id = input('id',0);
            $selected = input('selected',1);
            $result = Db::name('cart')->where('id', $id)->update(['selected'=>$selected]);
            exit(json_encode(['code'=>200, 'msg'=>'购物车商品状态更新成功']));
        }else{
            exit(json_encode(['code'=>400, 'msg'=>'请重新登录']));
        }
    }

    //更新购物车商品全选或反选状态
    public function updateSelectAll(){
        if($this->checkToken()){
            $selected = input('selected',1);
            $openid = input('openid', '');
            $uid = getUidByOpenid($openid);
            $result = Db::name('cart')->where('uid', $uid)->update(['selected'=>$selected]);
            exit(json_encode(['code'=>200, 'msg'=>'购物车商品状态更新成功']));
        }else{
            exit(json_encode(['code'=>400, 'msg'=>'请重新登录']));
        }
    }

    //更新购物车商品数量
    public function updateNum(){
        if($this->checkToken()){
            $id = input('id',0);
            $num = input('num',0);
            $result = Db::name('cart')->where('id', $id)->update(['num'=>$num]);
            exit(json_encode(['code'=>200, 'msg'=>'购物车商品数量更新成功']));
        }else{
            exit(json_encode(['code'=>400, 'msg'=>'请重新登录']));
        }
    }

    //删除购物车
    public function deleteCart(){
        if($this->checkToken()){
            $id = input('id',0);
            $result = Db::name('cart')->where('id', $id)->delete();
            exit(json_encode(['code'=>200, 'msg'=>'购物车商品删除成功']));
        }else{
            exit(json_encode(['code'=>400, 'msg'=>'请重新登录']));
        }
    }

    //订单确认页面获取购物车和收货地址
    public function orderInfo(){
        if($this->checkToken()){
            $cartIds = input('cartIds', '');
            $openid = input('openid', '');
            $uid = getUidByOpenid($openid);
            //购物车
            $cartList = Db::name('cart')->where('id', 'in', $cartIds)->order('id')->select();
            if(!empty($cartList)){
                //遍历购物车数据获取相应商品信息
                foreach ($cartList as $key => $value) {
                    $cartList[$key] = array_merge(Db::name('goods')->where('id',$value['gid'])->field('id,img')->find(),$value);
                }
            }
            //获取收货地址
            $address = Db::name('address')->where('uid',$uid)->where('is_default', 1)->find();
            $result = array(
                'code' => 200,
                'msg' => '获取成功',
                'info' => array('address'=>$address, 'cartList'=>$cartList)
            );
            exit(json_encode($result));
        }else{
            exit(json_encode(['code'=>400, 'msg'=>'请重新登录']));
        }
    }

    //订单列表页面提交支付
    public function getWxpayData(){
        if($this->checkToken()){
            $oid = input('oid', 0); //订单ID
            $data['order_sn_submit'] = $this->get_order_sn();
            //更新支付订单号
            Db::name('order')->where('id',$oid)->update($data);
            $result = array('code'=>200, 'msg'=>'微信支付信息获取成功', 'result'=>$this->getWxpayInfo($data['order_sn_submit']));
            exit(json_encode($result));
        }else{
            exit(json_encode(['code'=>400, 'msg'=>'请重新登录']));
        }
    }

    //确认订单提交
    public function submitOrder(){
        if($this->checkToken()){
            $cartIds = input('cartIds', '');
            $openid = input('openid', '');
            $uid = getUidByOpenid($openid);
            $addressId = input('addressId', 0); //地址ID
            $amount = input('amount', 0); //订单金额

            $result = $this->addOrder($uid, $addressId, $amount, $cartIds); //添加订单和订单商品
            $result['order'] = Db::name('order')->where('order_sn_submit', $result['order_sn_submit'])->find();
            //两次签名调起微信支付
            $result['data'] = $this->getWxpayInfo($result['order_sn_submit']);

            //删除购物车中选定商品
            Db::name('cart')->where('id', 'in', $cartIds)->delete();
            exit(json_encode($result));
        }else{
            exit(json_encode(['code'=>400, 'msg'=>'请重新登录']));
        }
    }

    public function getWxpayInfo($order_sn_submit) {
        //分析
        // 先是预支付：需要订单名称、订单号、金额、openid
        // 然后对支付的结果再次签名调起支付：需要prepay_id

        //根据order_sn_submit获取订单信息
        $order = Db::name('order')->where('order_sn_submit', $order_sn_submit)->find();
        //订单名称，先取一个商品价格最高的ID
        $gid = Db::name('order_goods')->where('oid', $order['id'])->order('price desc')->limit(1)->value('gid');
        //获取该商品名
        $orderBody = Db::name('goods')->where('id', $gid)->value('name');
        //订单号
        $tade_no = $order_sn_submit;
        //订单金额
        $total_fee = $order['amount'] * 100; //注意微信支付中金额是以分为单位，不是元
        //openid
        $open_id = Db::name('user')->where('id', $order['uid'])->value('openid');
        //统一 下单 预支付
        $response = $this->prePay($orderBody, $tade_no, $total_fee, $open_id);

        // 对预支付的结果再次签名之后调起支付
        $wdata = $this->pay($response['prepay_id']);
        $data['wdata'] = $wdata;
        $data['pay_money'] = $total_fee;

        return $data;
    }

    //统一 下单 预支付
    public function prePay($body, $out_trade_no, $total_fee, $open_id) {
        $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
        $notify_url = config('wxpay.notify_url');
        $nonce_str = $this->getRandChar(32);

        $data['appid'] = config('wxpay.appid');
        $data['mch_id'] = config('wxpay.mch_id');
        $data['nonce_str'] = $nonce_str;
        $data['body'] = $body;
        $data['out_trade_no'] = $out_trade_no;
        $data['total_fee'] = $total_fee;
        $data['spbill_create_ip'] = $this->get_client_ip();
        $data['notify_url'] = $notify_url;
        $data['trade_type'] = 'JSAPI';
        $data['openid'] = $open_id;
        $data['sign'] = $this->sign($data);

        $xml = $this->arrayToXml($data);

        $response = $this->postXmlCurl($xml, $url);

        //将微信返回的结果xml转成数组
        return $this->xmlstr_to_array($response);
    }

    //第二次签名，数据返回给客户端
    public function pay($prepayId){
        $data['appId'] = config('wxpay.appid');
        $data['nonceStr'] = $this->getRandChar(32);
        $data['package'] = "prepay_id=" . $prepayId;
        $data['signType'] = 'MD5';
        $data['timeStamp'] = time();

        $data['sign'] = $this->getSign($data);
        return $data;
    }

    //添加新订单
    public function addOrder($uid, $addressId, $amount, $cartIds){
        //收货信息
        $address = Db::name('address')->where('id', $addressId)->find();
        $data = array(
            'order_sn' => $this->get_order_sn(), //订单号，小程序显示用
            'order_sn_submit' => $this->get_order_sn(), //订单号，支付时提交用，每次变化
            'uid' => $uid,
            'consignee' => $address['consignee'],
            'address' => $address['address'],
            'mobile' => $address['mobile'],
            'amount' => $amount,
        );
        //获取生成订单ID
        $oid = Db::name('order')->insertGetId($data);

        //新增order_goods表
        $cartList = Db::name('cart')->where('id', 'in', $cartIds)->order('id')->select();
        foreach ($cartList as $value) {
            $goods['oid'] = $oid; //订单ID
            $goods['gid'] = $value['gid']; //商品ID
            $goods['num'] = $value['num']; //购买数量
            $goods['price'] = $value['price']; //价格
            Db::name('order_goods')->insert($goods);
        }
        return array('code'=>200, 'msg'=>'提交订单成功', 'order_sn_submit'=>$data['order_sn_submit']);
    }

    //获取订单号
    public function get_order_sn(){
        //防止重复订单号存在
        while (true) {
            $order_sn = date('YmdHis').rand(1000,9999); //订单号
            $count = Db::name('order')->where('order_sn', $order_sn)->count();
            if($count == 0){
                break;
            }
        }
        return $order_sn;
    }

    // 获取指定长度的随机字符串
    public function getRandChar($length){
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;

        for ($i = 0; $i < $length; $i ++) {
            $str .= $strPol[rand(0, $max)]; // rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }

        return $str;
    }

    // 获取当前服务器的IP
    public function get_client_ip(){
        if ($_SERVER['REMOTE_ADDR']) {
            $cip = $_SERVER['REMOTE_ADDR'];
        } elseif (getenv("REMOTE_ADDR")) {
            $cip = getenv("REMOTE_ADDR");
        } elseif (getenv("HTTP_CLIENT_IP")) {
            $cip = getenv("HTTP_CLIENT_IP");
        } else {
            $cip = "unknown";
        }
        // 第三季修正本地调试支付发起失败问题
        // 127.0.0.1 正常，::1 有问题
        $cip = $cip == '::1' ? '127.0.0.1' : $cip;

        return $cip;
    }

    //生成签名
    public function sign($Obj){
        foreach ($Obj as $k => $v) {
            $Parameters[strtolower($k)] = $v;
        }
        // 签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String = $this->formatBizQueryParaMap($Parameters, false);
        // 签名步骤二：在string后加入KEY
        $String = $String . "&key=" . config('wxpay.api_key');
        // 签名步骤三：MD5加密
        $result_ = strtoupper(md5($String));
        return $result_;
    }

    //生成签名
    public function getSign($Obj){
        foreach ($Obj as $k => $v) {
            $Parameters[strtolower($k)] = $v;
        }
        // 签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String  = "appId=".$Obj['appId']."&nonceStr=".$Obj['nonceStr']."&package=".$Obj['package']."&signType=MD5&timeStamp=".$Obj['timeStamp'];
        // 签名步骤二：在string后加入KEY
        $String = $String . "&key=" . config('wxpay.api_key');
        // 签名步骤三：MD5加密
        $result_ = strtoupper(md5($String));
        return $result_;
    }

    // 数组转xml
    public function arrayToXml($arr){
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
        }
        $xml .= "</xml>";
        return $xml;
    }

    // post https请求，CURLOPT_POSTFIELDS xml格式
    public function postXmlCurl($xml, $url, $second = 30){
        // 初始化curl
        $ch = curl_init();
        // 超时时间
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        // 这里设置代理，如果有的话
        // curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
        // curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        // 设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        // 要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        // post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        // 运行curl
        $data = curl_exec($ch);

        // 返回结果
        if ($data) {
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            echo "curl出错，错误码:$error" . "<br>";
                echo "<a href='http://curl.haxx.se/libcurl/c/libcurl-errors.html'>错误原因查询</a></br>";
                    curl_close($ch);
                    return false;
        }
    }

    // xml转成数组
    public function xmlstr_to_array($xmlstr){
        //禁止引用外部xml实体

        libxml_disable_entity_loader(true);

        $xmlstring = simplexml_load_string($xmlstr, 'SimpleXMLElement', LIBXML_NOCDATA);

        $val = json_decode(json_encode($xmlstring),true);

        return $val;


    }

    // 将数组转成uri字符串
    public function formatBizQueryParaMap($paraMap, $urlencode){
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v) {
            if ($urlencode) {
                $v = urlencode($v);
            }
            $buff .= strtolower($k) . "=" . $v . "&";
        }
        $reqPar;
        if (strlen($buff) > 0) {
            $reqPar = substr($buff, 0, strlen($buff) - 1);
        }
        return $reqPar;
    }

}
