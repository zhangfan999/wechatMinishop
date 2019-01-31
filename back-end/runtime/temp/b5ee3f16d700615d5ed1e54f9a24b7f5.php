<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:91:"C:\Users\Administrator\Desktop\myminishop\public/../application/admin\view\goods\index.html";i:1518920148;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品管理</title>
    <meta name="keywords" content="商品管理">
    <meta name="description" content="商品管理">
    <link rel="shortcut icon" href="favicon.ico">
    <link href="/public/static/admin/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/public/static/admin/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="/public/static/admin/css/plugins/jsTree/style.min.css" rel="stylesheet">
    <link href="/public/static/admin/css/animate.min.css" rel="stylesheet">
    <link href="/public/static/admin/css/style.min862f.css?v=4.1.0" rel="stylesheet">
</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeIn">
        <div class="row">
            <div class="col-sm-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>分类</h5>
                    </div>
                    <div class="ibox-content">

                        <div id="jstree">
                            <ul>
                                <li class="jstree-open">全部展开、折叠
                                    <ul>
                                        <?php if(is_array($categoryList) || $categoryList instanceof \think\Collection || $categoryList instanceof \think\Paginator): $i = 0; $__LIST__ = $categoryList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                        <li class="<?php echo $pid==$vo['id']?'jstree-open' : ''; ?>"><?php echo $vo['name']; ?>
                                            <ul>
                                                <?php if(is_array($vo['son']) || $vo['son'] instanceof \think\Collection || $vo['son'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['son'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voson): $mod = ($i % 2 );++$i;?>
                                                <li data-jstree='{"type":"html"}'>
                                                    <a class="<?php if(input('id',0) == $voson['id']): ?>jstree-clicked<?php endif; ?>" href="<?php echo url('content',['id'=>$voson['id']]); ?>"><?php echo $voson['name']; ?></a>
                                                </li>
                                                <?php endforeach; endif; else: echo "" ;endif; ?>
                                            </ul>
                                        </li>
                                        <?php endforeach; endif; else: echo "" ;endif; ?>
                                    </ul>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-sm-9">
                <iframe id="iframe_content" width="100%" src="<?php echo url('content',['id'=>input('id',0)]); ?>" frameborder="0" scrolling="auto" onload="changeFrameHeight()"></iframe>
            </div>
        </div>
    </div>
    <script src="/public/static/admin/js/jquery.min.js?v=2.1.4"></script>
    <script src="/public/static/admin/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="/public/static/admin/js/content.min.js?v=1.0.0"></script>
    <script src="/public/static/admin/js/plugins/iCheck/icheck.min.js"></script>
    <script src="/public/static/admin/js/plugins/jsTree/jstree.min.js"></script>
    <style>
        .jstree-open>.jstree-anchor>.fa-folder:before {
            content: "\f07c"
        }

        .jstree-default .jstree-icon.none {
            width: 0
        }
    </style>
    <script>
        function changeFrameHeight() {
            document.getElementById("iframe_content").height = document.documentElement.clientHeight - 44;
        };
        window.onresize = function() {
            changeFrameHeight();
        }
        $(document).ready(function() {
            $("#jstree")
            .on('changed.jstree', function(e, data) {
                var url = $('#' + data.node.id).children('a').attr('href');
                if (url != '#') {
                    $('#iframe_content').attr('src', url);
                }
            })
            .on('select_node.jstree', function(e, data) {
                if (data.node.id == 'j1_1') {
                    if (data.instance.is_open(data.instance.get_next_dom(data.node))) {
                        var i, j;
                        for (i = 0, j = data.node.children.length; i < j; i++) {
                            data.instance.close_node(data.node.children[i]);
                        }
                    } else {
                        data.instance.open_all(data.node);
                    }
                } else {
                    data.instance.toggle_node(data.node);
                }
            })
            .jstree({
                "core": {
                    "check_callback": true,
                    "dblclick_toggle": false
                },
                "plugins": ["types", "dnd"],
                "types": {
                    "default": {
                        "icon": "fa fa-folder"
                    },
                    "html": {
                        "icon": "fa fa-file-code-o"
                    },
                    "svg": {
                        "icon": "fa fa-file-picture-o"
                    },
                    "css": {
                        "icon": "fa fa-file-code-o"
                    },
                    "img": {
                        "icon": "fa fa-file-image-o"
                    },
                    "js": {
                        "icon": "fa fa-file-text-o"
                    }
                }
            });
        });
    </script>
</body>

</html>
