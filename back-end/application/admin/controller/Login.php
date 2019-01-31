<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;

class Login extends Controller
{
    public function index() {
        if(request()->isPost()){
            $username = trim(input('post.username/s')); //强制转换为字符串类型
            $password = md5(trim(input('post.password/s')));
            $user = db('admin')->where('name', $username)->find();
            if(!$user){
                //返回错误信息
                $data['status'] = 202;
                $data['msg'] = '管理员不存在';
                return json($data);
            }else{
                //密码校验
                if($password != $user['password']){
                    //返回错误信息
                    $data['status'] = 202;
                    $data['msg'] = '管理员密码错误';
                    return json($data);
                }else{
                    $userInfo['name'] = $username;
                    session('user', $userInfo);
                    //返回成功信息
                    $data['status'] = 200;
                    $data['url'] = url('/admin');
                    return json($data);
                }
            }
        }else{
            if(session('user.name')==null || session('user.name')!='admin'){
                session(null);
                return view();
            }else{
                $this->redirect('index/index');
            }
        }
    }

    //退出
    public function loginout(){
        session(null);
        $this->redirect('login/index');
    }

}
