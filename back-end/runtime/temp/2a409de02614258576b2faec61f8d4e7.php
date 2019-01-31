<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:88:"C:\Users\Administrator\Desktop\myminishop\public/../application/admin\view\ad\index.html";i:1518235449;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>广告管理</title>
    <meta name="keywords" content="广告管理">
    <meta name="description" content="广告管理">
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
                        <li class="<?php if(input('tab',1) == 1): ?>active<?php endif; ?>"><a data-toggle="tab" href="#tab-1" aria-expanded="true">广告列表</a></li>
                        <li class="<?php if(input('tab',1) == 2): ?>active<?php endif; ?>"><a data-toggle="tab" href="#tab-2" aria-expanded="false">添加新广告</a></li>
                        <li id="showtab" class="<?php if(input('tab',1) == 3): ?>active<?php endif; ?>"><a data-toggle="tab" href="#tab-3" style="<?php if(input('tab',1) != 3): ?>display:none<?php endif; ?>" aria-expanded="false">编辑广告</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane <?php if(input('tab',1) == 1): ?>active<?php endif; ?>">
                            <div class="panel-body">
                                <form method="post" class="form-horizontal" action="<?php echo url('index'); ?>" data-type="ajax">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th width="10%">排序</th>
                                                    <th width="30%">广告图片</th>
                                                    <th width="20%">标题</th>
                                                    <th width="20%">类型</th>
                                                    <th width="20%">操作</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(is_array($lists) || $lists instanceof \think\Collection || $lists instanceof \think\Paginator): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="sort[<?php echo $vo['id']; ?>]" class="form-control" value="<?php echo $vo['sort']; ?>">
                                                        </td>
                                                        <td><img src="/public/uploads/<?php echo $vo['img']; ?>" alt="<?php echo $vo['title']; ?>" width="160"></td>
                                                        <td style="text-align:left"><?php echo $vo['title']; ?></td>
                                                        <td><?php echo !empty($vo['type'])?'广告' : '幻灯片'; ?></td>
                                                        <td>
                                                            <a href="<?php echo url('index',['id'=>$vo['id'], 'tab'=>3]); ?>" title="编辑"><i class="fa fa-edit text-navy"></i></a>&nbsp;&nbsp;
                                                            <a name="delete" href="<?php echo url('delete',['id'=>$vo['id']]); ?>" title="删除"><i class="fa fa-trash-o text-navy"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; endif; else: echo "" ;endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-4 col-sm-offset-2">
                                            <button class="btn btn-primary" type="submit">提交</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div id="tab-2" class="tab-pane <?php if(input('tab',1) == 2): ?>active<?php endif; ?>">
                            <div class="panel-body">
                                <form method="post" class="form-horizontal" action="<?php echo url('add'); ?>" data-type="ajax">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">标题</label>
                                        <div class="col-sm-10">
                                            <input type="text" name='title' class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">图片</label>
                                        <div class="col-sm-10">
                                            <div id="file-pretty">
                                                <input id="file_path" name="file" type="file" class="form-control" style="display:none">
                                                <div class="input-append input-group">
                                                    <span class="input-group-btn">
                                                        <button id="btn_path" type="button" class="btn btn-white">选择图片</button>
                                                    </span>
                                                    <input id="info_path" type="text" name='img' class="form-control input-large" value="">
                                                </div>
                                            </div>
                                            <script type="text/javascript">
                                                $(function(){
                                                    $('#btn_path').click(function(){
                                                        $("#file_path").click();
                                                    });

                                                    //异步上传
                                                    $("body").delegate("#file_path", 'change', function(){
                                                        var filepath = $("input[name='file']").val();
                                                        var arr = filepath.split('.');
                                                        var ext = arr[arr.length-1];//图片后缀

                                                        if('gif|jpg|png|bmp'.indexOf(ext)>=0){
                                                            $.ajaxFileUpload({
                                                               url: '<?php echo url('upload_image'); ?>',
                                                               type: 'post',
                                                               data: { name: 'file' },
                                                               secureuri: false,
                                                               fileElementId: 'file_path',
                                                               dataType: 'json',
                                                               success: function (data, status) {
                                                                   $('#info_path').val(data);
                                                                   $('#info_path').focus();
                                                               },
                                                               error: function (data, status, e){
                                                                   layer.alert('上传失败');
                                                               }
                                                            });
                                                        }else{
                                                            // 清空file
                                                            $('#file_path').val('');
                                                            layer.alert('请上传合适的图片类型');
                                                        }
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">类型</label>
                                        <div class="col-sm-10">
                                            <div class="radio i-checks">
                                                <label><input type="radio" value="0" name="type" checked><i></i> 幻灯片</label>
                                                <label><input type="radio" value="1" name="type"><i></i> 广告</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">关联商品ID</label>
                                        <div class="col-sm-10">
                                            <input type="text" name='gid' class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">排序</label>
                                        <div class="col-sm-10">
                                            <input type="text" name='sort' class="form-control" value="">
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
                        <div id="tab-3" class="tab-pane <?php if(input('tab',1) == 3): ?>active<?php endif; ?>">
                            <div class="panel-body">
                                <form method="post" class="form-horizontal" action="<?php echo url('edit'); ?>" data-type="ajax">
                                    <input type="hidden" name="tab" value="3">
                                    <input type="hidden" name="id" value="<?php echo $info['id']; ?>">

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">标题</label>
                                        <div class="col-sm-10">
                                            <input type="text" name='title' class="form-control" value="<?php echo $info['title']; ?>">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">图片</label>
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
                                        <label class="col-sm-2 control-label">类型</label>
                                        <div class="col-sm-10">
                                            <div class="radio i-checks">
                                                <label><input type="radio" value="0" name="type" <?php echo !empty($info['type'])?'' : 'checked'; ?>><i></i> 幻灯片</label>
                                                <label><input type="radio" value="1" name="type" <?php echo !empty($info['type'])?'checked' : ''; ?>><i></i> 广告</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">关联商品ID</label>
                                        <div class="col-sm-10">
                                            <input type="text" name='gid' class="form-control" value="<?php echo $info['gid']; ?>">
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
