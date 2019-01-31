<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:93:"C:\Users\Administrator\Desktop\myminishop\public/../application/admin\view\goods\content.html";i:1548834420;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品列表</title>
    <meta name="keywords" content="商品列表">
    <meta name="description" content="商品列表">
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
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5><?php echo !empty($name)?$name : '暂无'; ?>列表</h5>
        </div>
        <div class="ibox-content">
            <form method="post" class="form-horizontal" action="<?php echo url('deleteAll'); ?>" data-type="ajax">
                <input type="hidden" name="cid" value="<?php echo $infoList[0]['cid_two']; ?>">

                <table id="dataTables-example" class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 3%"><input id="isCheckAll" type="checkbox" class="i-checks"></th>
                            <th style="width: 5%">ID</th>
                            <th style="width: 30%">商品名称</th>
                            <th style="width: 8%">图片</th>
                            <th style="width: 8%">浏览</th>
                            <th style="width: 8%">库存</th>
                            <th style="width: 8%">收藏</th>
                            <th style="width: 8%">价格</th>
                            <th style="width: 8%">销售</th>
                            <th style="width:12%">操作</th>
                        </tr>
                    </thead>
                </table>
            </form>
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
                    "url": "<?php echo url('getDataTables',['id'=>input('id')]); ?>",
                    "data": function(d) {
                        d.extra_search = "name";
                    }
                },
                "ordering": false, //禁用全局排序
                "order": [0, '`id` desc'],
                "lengthMenu": [5, 10, 20, 50, 100],
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
                    render: function(data, type, row, meta) {
                        return '<input type="checkbox" class="i-checks" name="ids[' + row.id + ']">';
                    }
                }, {
                    data: "id"
                }, {
                    data: "name"
                }, {
                    data: "img"
                }, {
                    data: "views"
                }, {
                    data: "store"
                }, {
                    data: "collect"
                }, {
                    data: "price"
                }, {
                    data: "sales"
                }, {
                    data: "operate"
                }, ],
                "drawCallback": function() {
                    normal_init();
                },
                "initComplete": function() {
                    $("#normalToos").append("<div class='m-b-xs'>" +
                        "<div class='btn-group' id='exampleTableEventsToolbar' role='group'>" +
                        "<a class='btn btn-sm btn-outline btn-default' title='添加' target='_parent' href='<?php echo url('add',['id'=>input('id',0)]); ?>'>" +
                        "<i class='glyphicon glyphicon-plus' aria-hidden='true'></i></a>" +
                        "<button type='submit' class='btn btn-sm btn-outline btn-default' title='删除'>" +
                        "<i class='glyphicon glyphicon-trash' aria-hidden='true'></i></button></div></div>");
                }
            });

        });
    </script>
</body>

</html>
