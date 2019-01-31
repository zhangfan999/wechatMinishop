<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:91:"C:\Users\Administrator\Desktop\myminishop\public/../application/admin\view\login\index.html";i:1520246847;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>雪狐微信小程序商城管理后台 - 管理登录</title>
    <meta name="keywords" content="雪狐微信小程序商城管理后台">
    <meta name="description" content="雪狐微信小程序商城管理后台">
    <link rel="shortcut icon" href="favicon.ico">
    <link href="/public/static/admin/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/public/static/admin/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="/public/static/admin/css/animate.min.css" rel="stylesheet">
    <link href="/public/static/admin/css/style.min862f.css?v=4.1.0" rel="stylesheet">
    <script>if(window.top !== window.self){ window.top.location = window.location;}</script>
</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div class="m-b-md">
                <img src="/public/uploads/head.png" class='img-circle circle-border' alt="">
            </div>

            <form class="m-t layui-form" method="post" action="<?php echo url('index'); ?>">
                <div class="form-group">
                    <input type="text" name="username" lay-verify="username" class="form-control uname layui-input" placeholder="用户名" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" lay-verify="password" class="form-control layui-input" placeholder="密码" required>
                </div>
                <button lay-submit="" class="btn btn-primary block full-width layui-btn">登 录</button>
            </form>
        </div>
    </div>
    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div class="signup-footer">
            <div>雪狐网（<a href="http://www.studyfox.cn" target="_blank">StudyFox.cn</a>）版权所有</div>
        </div>
    </div>

    <script src="/public/static/admin/js/jquery.min.js?v=2.1.4"></script>
    <script src="/public/static/admin/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="/public/static/admin/js/layer_hplus.js"></script>
    <script src="/public/static/admin/plugins/layui/layui.js"></script>
    <script type="text/javascript">
        layui.use('form', function(){
            var form = layui.form(),layer = layui.layer;

            //自定义验证规则
            form.verify({
                username: function(value){
                    if(value.length == 0){
                        return '用户名不能为空';
                    }
                },
                password: [
                    /^[\S]{6,}$/,
                    '密码必须大于6位'
                ]
            });

            form.on('submit', function(data){
                //先获取数据
                var url = $('form').attr('action');
                var data = $('form').serializeArray(); //序列化表单元素
                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: url,
                    data: data,
                    success: function(obj){
                        if(obj.status == 200){
                            location.href = obj.url;
                        }else{
                            layer.alert(obj.msg);
                        }
                    },
                    error: function(data){
                        layer.alert('登录失败');
                    }
                });
                return false;
            })
        });
    </script>
</body>

</html>
