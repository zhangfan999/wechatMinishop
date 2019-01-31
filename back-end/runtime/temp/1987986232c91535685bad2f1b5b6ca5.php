<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:90:"C:\Users\Administrator\Desktop\myminishop\public/../application/admin\view\goods\edit.html";i:1518927768;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>编辑商品</title>
    <meta name="keywords" content="编辑商品">
    <meta name="description" content="编辑商品">
    <link rel="shortcut icon" href="favicon.ico">
    <link href="/public/static/admin/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/public/static/admin/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="/public/static/admin/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/public/static/admin/css/animate.min.css" rel="stylesheet">
    <link href="/public/static/admin/css/style.min862f.css?v=4.1.0" rel="stylesheet">
    <script src="/public/static/admin/js/jquery.min.js?v=2.1.4"></script>
    <script src="/public/static/admin/js/ajaxfileupload.js"></script>
    <link href="/public/static/admin/css/admin.css" rel="stylesheet">
</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeIn">
        <div class="row">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a href="<?php echo url('goods/index',['id'=>$id]); ?>"><i class="fa fa-mail-reply text-navy"></i>返回商品管理</a></li>
                        <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true">编辑商品</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body">
                                <form method="post" class="form-horizontal" action="<?php echo url('edit'); ?>" enctype="multipart/form-data" data-type="ajax">
                                    <input type="hidden" name="cid_two" value="<?php echo $info['cid_two']; ?>">
                                    <input type="hidden" name="id" value="<?php echo $info['id']; ?>">

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">分类</label>
                                        <div class="col-sm-10 control-label" style="text-align:left">
                                            <?php echo $name; ?>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">商品名称</label>
                                        <div class="col-sm-10">
                                            <input type="text" name='name' class="form-control" value="<?php echo $info['name']; ?>">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">库存</label>
                                        <div class="col-sm-10">
                                            <input type="text" name='store' class="form-control" value="<?php echo $info['store']; ?>">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">价格</label>
                                        <div class="col-sm-10">
                                            <input type="text" name='price' class="form-control" value="<?php echo $info['price']; ?>">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">商品图片</label>
                                        <div class="col-sm-10">
                                            <div id="file-pretty">
                                                <input id="file_path_edit" name="file" type="file" class="form-control" style="display:none">
                                                <div class="input-append input-group">
                                                    <span class="input-group-btn">
                                                        <button id="btn_path_edit" type="button" class="btn btn-white">选择图片</button>
                                                    </span>
                                                    <input id="info_path_edit" type="text" name='img' class="form-control input-large" value="<?php echo $info['img']; ?>">
                                                </div>
                                            </div>
                                            <script type="text/javascript">
                                                $(function(){
                                                    $('#btn_path_edit').click(function(){
                                                        $("#file_path_edit").click();
                                                    });

                                                    //异步上传
                                                    $("body").delegate("#file_path_edit", 'change', function(){
                                                        var filepath = $("input[name='file']").val();
                                                        var arr = filepath.split('.');
                                                        var ext = arr[arr.length-1];//图片后缀

                                                        if('gif|jpg|png|bmp'.indexOf(ext)>=0){
                                                            $.ajaxFileUpload({
                                                               url: '<?php echo url('upload_image'); ?>',
                                                               type: 'post',
                                                               data: { name: 'file' },
                                                               secureuri: false,
                                                               fileElementId: 'file_path_edit',
                                                               dataType: 'json',
                                                               success: function (data, status) {
                                                                   $('#info_path_edit').val(data);
                                                                   $('#info_path_edit').focus();
                                                               },
                                                               error: function (data, status, e){
                                                                   layer.alert('上传失败');
                                                               }
                                                            });
                                                        }else{
                                                            // 清空file
                                                            $('#file_path_edit').val('');
                                                            layer.alert('请上传合适的图片类型');
                                                        }
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">排序</label>
                                        <div class="col-sm-10">
                                            <input type="text" name='sort' class="form-control" value="<?php echo $info['sort']; ?>">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">商品描述</label>
                                        <div class="col-sm-10">
                                            <script id="container" name="content" type="text/plain"><?php echo $info['content']; ?></script>
                                            <script src="/public/static/admin/plugins/ueditor/ueditor.config.js"></script>
                                            <script src="/public/static/admin/plugins/ueditor/ueditor.all.js"></script>
                                            <script>
                                                var url='<?php echo url('ueditor/index'); ?>';
                                                var ue = UE.getEditor('container',{
                                                    initialFrameHeight:360,
                                                    serverUrl :url,
                                                });
                                            </script>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group">
                                        <div class="col-sm-4 col-sm-offset-2">
                                            <button class="btn btn-primary" type="submit">提交</button>
                                        </div>
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
    <script src="/public/static/admin/js/content.min.js?v=1.0.0"></script>
    <script src="/public/static/admin/js/plugins/iCheck/icheck.min.js"></script>
    <script src="/public/static/admin/js/plugins/layer/layer.min.js"></script>
    <script src="/public/static/admin/js/layer_hplus.js"></script>
    <script src="/public/static/admin/js/plugins/prettyfile/bootstrap-prettyfile.js"></script>
    <script src="/public/static/admin/js/plugins/cropper/cropper.min.js"></script>
    <script src="/public/static/admin/js/demo/form-advanced-demo.min.js"></script>
    <script src="/public/static/admin/js/plugins/layer/laydate/laydate.js"></script>
</body>

</html>
