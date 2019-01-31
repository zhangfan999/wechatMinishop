<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:90:"C:\Users\Administrator\Desktop\myminishop\public/../application/admin\view\user\index.html";i:1520090823;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户管理</title>
    <meta name="keywords" content="用户管理">
    <meta name="description" content="用户管理">
    <link rel="shortcut icon" href="favicon.ico">
    <link href="/public/static/admin/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/public/static/admin/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="/public/static/admin/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/public/static/admin/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="/public/static/admin/css/animate.min.css" rel="stylesheet">
    <link href="/public/static/admin/css/style.min862f.css?v=4.1.0" rel="stylesheet">
    <script src="/public/static/admin/js/jquery.min.js?v=2.1.4"></script>
    <link href="/public/static/admin/css/admin.css" rel="stylesheet">
</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeIn">
        <div class="row">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body">
                                <form method="post" class="form-horizontal" action="">
                                    <div class="table-responsive">
                                        <table id="dataTables-example" class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>昵称</th>
                                                    <th>头像</th>
                                                    <th>金额</th>
                                                    <th>消费累计</th>
                                                    <th>注册时间</th>
                                                    <th>openid</th>
                                                    <th>token</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/public/static/admin/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="/public/static/admin/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="/public/static/admin/js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="/public/static/admin/js/content.min.js?v=1.0.0"></script>
    <script src="/public/static/admin/js/plugins/iCheck/icheck.min.js"></script>
    <script src="/public/static/admin/js/plugins/layer/layer.min.js"></script>
    <script src="/public/static/admin/js/layer_hplus.js"></script>
    <script src="/public/static/admin/js/plugins/layer/laydate/laydate.js"></script>
    <script>
        $(document).ready(function() {
            $("#dataTables-example").dataTable({
                "bAutoWidth": false,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo url('getDataTables'); ?>",
                    "data": function(d) {
                        d.extra_search = "nickname|openid|token";
                    }
                },
                "ordering": false, //禁用全局排序
                "order": [0, '`id` desc'],
                "lengthMenu": [10, 20, 50, 100],
                "dom": "<'row'<'#normalToos.col-xs-4'><'col-xs-8'f>>" +
                    "<'row'<'col-xs-12't>>" +
                    "<'row'<'col-xs-6'li><'col-xs-6'p>>",
                "language": {
                    "zeroRecords": "没有检索到数据",
                    "lengthMenu": "每页 _MENU_ 条记录&nbsp;&nbsp;",
                    "search": "搜索 ",
                    "info": "共 _PAGES_ 页，_TOTAL_ 条记录，当前显示 _START_ 到 _END_ 条",
                    "paginate": {
                        "previous": "上一页",
                        "next": "下一页",
                    }
                },
                "columns": [{
                    data: "id"
                }, {
                    data: "nickname"
                }, {
                    data: "head"
                }, {
                    data: "money"
                }, {
                    data: "total_amount"
                }, {
                    data: "reg_time"
                }, {
                    data: "openid"
                }, {
                    data: "token"
                }],
                "drawCallback": function() {
                    normal_init();
                }
            });

        });
    </script>
</body>

</html>
