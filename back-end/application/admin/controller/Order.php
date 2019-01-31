<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;

class Order extends Common
{
    public function index() {
        return view();
    }

    public function getDataTables() {
        //获取请求过来的数据
        $getParam = request()->param();

        $draw = $getParam['draw'];

        //排序
        $orderSql = $getParam['order'][0]['dir'];

        //自定义查询参数
        $extra_search = $getParam['extra_search'];

        //获取表名
        $tablename = request()->controller();
        // 总记录数
        $recordsTotal = Db::name($tablename)->count();
        //过滤条件后的总记录数
        $search = $getParam['search']['value'];
        $recordsFiltered = strlen($search) ?  Db::name($tablename)->where($extra_search,'like','%'.$search.'%')->count() : $recordsTotal;

        //分页
        $start = $getParam['start']; //起始下标
        $length = $getParam['length']; //每页显示记录数

        //根据开始下标计算出当前页
        $page = intval($start/$length) + 1;
        $config = ['page'=>$page, 'list_rows'=>$length];
        $list = Db::name($tablename)->where($extra_search,'like','%'.$search.'%')->order($orderSql)->paginate(null,false,$config);
        $lists = [];
        if(!empty($list)){
            foreach ($list as $key => $value) {
                $lists[$key] = $value;
                $lists[$key]['uid'] = Db::name('user')->where('id', $value['uid'])->value('nickname');
                //重设订单状态
                switch ($value['order_status']) {
                    case 0:
                        $lists[$key]['order_status'] = '待付款';
                        break;
                    case 1:
                        $lists[$key]['order_status'] = '已完成';
                        break;
                    case 2:
                        $lists[$key]['order_status'] = '待发货';
                        break;
                    case 3:
                        $lists[$key]['order_status'] = '待收货';
                        break;
                    case 4:
                        $lists[$key]['order_status'] = '已取消';
                        break;
                    default:
                        break;
                }
                $order_status = $lists[$key]['order_status'];
                $lists[$key]['order_status'] = "<span id='order_status_".$value['id']."'>".$order_status."</span>";

                $lists[$key]['operate'] = "<a oid='".$value['id']."' href='javascript:;' class='goods'>查看订单</a>&nbsp;&nbsp;
                <a id='".$value['id']."' href='javascript:;' class='change_order_status'>".$order_status."</a>";
            }
        }

        $data = array(
            "draw"=>$draw,
            "recordsTotal"=>$recordsTotal, //数据总数
            "recordsFiltered"=>$recordsFiltered, //过滤之后的记录总数
            "data"=>$lists
        );

        echo json_encode($data);
    }

    //查看订单商品
    public function orderGoods($id = 0){
        $lists = Db::name('order_goods')->where('oid', $id)->select();
        foreach ($lists as $key => $value) {
            $lists[$key]['goods'] = Db::name('goods')->where('id',$value['gid'])->find();
        }
        $this->assign('lists', $lists);
        return view();
    }

    //修改订单状态
    public function changeOrderStatus(){
        if(request()->isPost()) {
            $id = input('id', 0);
            $order_status = db('order')->where('id', $id)->value('order_status');
            $num = 0;
            $str = '';
            switch ($order_status) {
                case 0:
                    $num = 2;
                    $str = '待发货';
                    break;
                case 2:
                    $num = 3;
                    $str = '待收货';
                    break;
                case 3:
                    $num = 1;
                    $str = '已完成';
                    break;
                default:
                    break;
            }
            if($num!=0 && $num!=4){
                //设置订单状态值
                $result = db('order')->where('id',$id)->setField('order_status', $num);
                if($result!==false){
                    $data['status'] = 200;
                    $data['order_status'] = $str;
                    $data['msg'] = '设置成功';
                }else{
                    $data['status'] = 202;
                    $data['msg'] = '设置失败';
                }
            }else{
                $data['status'] = 202;
                $data['msg'] = '无需设置';
            }
            return json($data);
        }
    }
}
