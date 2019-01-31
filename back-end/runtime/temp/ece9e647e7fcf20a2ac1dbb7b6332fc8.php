<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:92:"C:\Users\Administrator\Desktop\myminishop\public/../application/admin\view\goods\addimg.html";i:1518866247;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>批量添加商品图片</title>
    <meta name="keywords" content="批量添加商品图片">
    <meta name="description" content="批量添加商品图片">
    <link rel="shortcut icon" href="favicon.ico">
    <link href="/public/static/admin/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/public/static/admin/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="/public/static/admin/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/public/static/admin/css/animate.min.css" rel="stylesheet">
    <link href="/public/static/admin/css/style.min862f.css?v=4.1.0" rel="stylesheet">
    <link href="/public/static/admin/plugins/webuploader-0.1.5/webuploader.css" rel="stylesheet">
    <script src="/public/static/admin/js/jquery.min.js?v=2.1.4"></script>
</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeIn">
        <div class="row">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a href="<?php echo url('goods/index',['id'=>input('cid_two')]); ?>"><i class="fa fa-mail-reply text-navy"></i>返回商品管理</a></li>
                        <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true">添加图片</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body">
                                <form method="post" class="form-horizontal" action="<?php echo url('addImg'); ?>" enctype="multipart/form-data" data-type="ajax">
                                    <input type="hidden" name="cid_two" value="<?php echo input('cid_two'); ?>">
                                    <input type="hidden" name="id" value="<?php echo input('id'); ?>">

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">添加图片</label>
                                        <div class="col-sm-10">
                                            <input type="hidden" id="info_img" name='imagesStr' class="form-control" value="<?php echo $imagesStr; ?>">

                                            <?php if($imagesStr != ''): ?>
                                            <div id="uploader-list-container" class="uploader-list-container">
                                                <div class="queueListSuccess" style="margin:20px">
                                                    <ul class="filelist">
                                                        <?php if(is_array($goodsImages) || $goodsImages instanceof \think\Collection || $goodsImages instanceof \think\Paginator): $i = 0; $__LIST__ = $goodsImages;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                                        <li id="WU_FILE_<?php echo $vo['gid']; ?>-<?php echo $vo['id']; ?>" class="state-complete" studyfox_img="<?php echo $vo['img']; ?>">
                                                            <p class="imgWrap"><img src="/public/uploads/<?php echo $vo['img']; ?>" width="110" height="110"></p>
                                                            <div class="file-panel" style="height: 0px;"><span class="cancel">删除</span></div>
                                                            <span class="success"></span>
                                                        </li>
                                                        <?php endforeach; endif; else: echo "" ;endif; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                            <?php endif; ?>

                                            <div class="uploader-list-container">
                                                <div class="queueList">
                                                    <div id="dndArea" class="placeholder">
                                                        <div id="filePicker-2"></div>
                                                        <p>或将图片拖到这里，单次最多可选 10 张</p>
                                                    </div>
                                                </div>
                                                <div class="statusBar" style="display:none;">
                                                    <div class="progress"> <span class="text">0%</span> <span class="percentage"></span> </div>
                                                    <div class="info"></div>
                                                    <div class="btns">
                                                        <div id="filePicker2"></div>
                                                        <div class="uploadBtn">开始上传</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <script src="/public/static/admin/plugins/webuploader-0.1.5/webuploader.min.js"></script>
                                            <script type="text/javascript" >
                                            (function( $ ){
                                                // 当domReady的时候开始初始化
                                                $(function() {
                                                    var wrap = $('.uploader-list-container'),

                                                    // 图片容器
                                                    queue = $( '<ul class="filelist"></ul>' )
                                                        .appendTo( wrap.find( '.queueList' ) ),

                                                    // 状态栏，包括进度和控制按钮
                                                    statusBar = wrap.find( '.statusBar' ),

                                                    // 文件总体选择信息。
                                                    info = statusBar.find( '.info' ),

                                                    // 上传按钮
                                                    upload = wrap.find( '.uploadBtn' ),

                                                    // 没选择文件之前的内容。
                                                    placeHolder = wrap.find( '.placeholder' ),

                                                    progress = statusBar.find( '.progress' ).hide(),

                                                    // 添加的文件数量
                                                    fileCount = 0,

                                                    // 添加的文件总大小
                                                    fileSize = 0,

                                                    // 优化retina, 在retina下这个值是2
                                                    ratio = window.devicePixelRatio || 1,

                                                    // 缩略图大小
                                                    thumbnailWidth = 110 * ratio,
                                                    thumbnailHeight = 110 * ratio,

                                                    // 可能有pedding, ready, uploading, confirm, done.
                                                    state = 'pedding',

                                                    // 所有文件的进度信息，key为file id
                                                    percentages = {},
                                                    // 判断浏览器是否支持图片的base64
                                                    isSupportBase64 = ( function() {
                                                        var data = new Image();
                                                        var support = true;
                                                        data.onload = data.onerror = function() {
                                                            if( this.width != 1 || this.height != 1 ) {
                                                                support = false;
                                                            }
                                                        }
                                                        data.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";
                                                        return support;
                                                    } )(),

                                                    // 检测是否已经安装flash，检测flash的版本
                                                    flashVersion = ( function() {
                                                        var version;

                                                        try {
                                                            version = navigator.plugins[ 'Shockwave Flash' ];
                                                            version = version.description;
                                                        } catch ( ex ) {
                                                            try {
                                                                version = new ActiveXObject('ShockwaveFlash.ShockwaveFlash')
                                                                        .GetVariable('version');
                                                            } catch ( ex2 ) {
                                                                version = '0.0';
                                                            }
                                                        }
                                                        version = version.match( /\d+/g );
                                                        return parseFloat( version[ 0 ] + '.' + version[ 1 ], 10 );
                                                    } )(),

                                                    supportTransition = (function(){
                                                        var s = document.createElement('p').style,
                                                            r = 'transition' in s ||
                                                                    'WebkitTransition' in s ||
                                                                    'MozTransition' in s ||
                                                                    'msTransition' in s ||
                                                                    'OTransition' in s;
                                                        s = null;
                                                        return r;
                                                    })(),

                                                    // WebUploader实例
                                                    uploader;

                                                    // 实例化
                                                    uploader = WebUploader.create({
                                                        pick: {
                                                            id: '#filePicker-2',
                                                            label: '点击选择图片'
                                                        },
                                                        formData: {
                                                            uid: 123
                                                        },
                                                        dnd: '#dndArea',
                                                        paste: '#uploader',
                                                        swf: '/public/static/admin/plugins/webuploader-0.1.5/Uploader.swf',
                                                        chunked: false,
                                                        chunkSize: 512 * 1024,
                                                        server: '<?php echo url('upload_images'); ?>',
                                                        // runtimeOrder: 'flash',

                                                        accept: {
                                                            title: 'Images',
                                                            extensions: 'gif|jpg|png|bmp',
                                                            mimeTypes: 'image/*'
                                                        },

                                                        // 禁掉全局的拖拽功能。这样不会出现图片拖进页面的时候，把图片打开。
                                                        disableGlobalDnd: true,
                                                        fileNumLimit: 10,
                                                        fileSizeLimit: 200 * 1024 * 1024,    // 200 M
                                                        fileSingleSizeLimit: 50 * 1024 * 1024    // 50 M
                                                    });

                                                    // 拖拽时不接受 js, txt 文件。
                                                    uploader.on( 'dndAccept', function( items ) {
                                                        var denied = false,
                                                            len = items.length,
                                                            i = 0,
                                                            // 修改js类型
                                                            unAllowed = 'text/plain;application/javascript ';

                                                        for ( ; i < len; i++ ) {
                                                            // 如果在列表里面
                                                            if ( ~unAllowed.indexOf( items[ i ].type ) ) {
                                                                denied = true;
                                                                break;
                                                            }
                                                        }

                                                        return !denied;
                                                    });

                                                    uploader.on('dialogOpen', function() {
                                                        console.log('here');
                                                    });

                                                    // 添加“添加文件”的按钮，
                                                    uploader.addButton({
                                                        id: '#filePicker2',
                                                        label: '继续添加'
                                                    });

                                                    uploader.on('ready', function() {
                                                        window.uploader = uploader;
                                                    });

                                                    // 当有文件添加进来时执行，负责view的创建
                                                    function addFile( file ) {
                                                        var li = $( '<li id="' + file.id + '">' +
                                                                '<p class="title">' + file.name + '</p>' +
                                                                '<p class="imgWrap"></p>'+
                                                                '<p class="progress"><span></span></p>' +
                                                                '</li>' ),

                                                            btns = $('<div class="file-panel">' +
                                                                '<span class="cancel">删除</span>' +
                                                                '<span class="rotateRight">向右旋转</span>' +
                                                                '<span class="rotateLeft">向左旋转</span></div>').appendTo( li ),
                                                            prgress = li.find('p.progress span'),
                                                            wrap = li.find( 'p.imgWrap' ),
                                                            info = $('<p class="error"></p>'),

                                                            showError = function( code ) {
                                                                switch( code ) {
                                                                    case 'exceed_size':
                                                                        text = '文件大小超出';
                                                                        break;

                                                                    case 'interrupt':
                                                                        text = '上传暂停';
                                                                        break;

                                                                    default:
                                                                        text = '上传失败，请重试';
                                                                        break;
                                                                }

                                                                info.text( text ).appendTo( li );
                                                            };

                                                        if ( file.getStatus() === 'invalid' ) {
                                                            showError( file.statusText );
                                                        } else {
                                                            // @todo lazyload
                                                            wrap.text( '预览中' );
                                                            uploader.makeThumb( file, function( error, src ) {
                                                                var img;

                                                                if ( error ) {
                                                                    wrap.text( '不能预览' );
                                                                    return;
                                                                }

                                                                if( isSupportBase64 ) {
                                                                    img = $('<img src="'+src+'">');
                                                                    wrap.empty().append( img );
                                                                } else {
                                                                    $.ajax('../server/preview.php', {
                                                                        method: 'POST',
                                                                        data: src,
                                                                        dataType:'json'
                                                                    }).done(function( response ) {
                                                                        if (response.result) {
                                                                            img = $('<img src="'+response.result+'">');
                                                                            wrap.empty().append( img );
                                                                        } else {
                                                                            wrap.text("预览出错");
                                                                        }
                                                                    });
                                                                }
                                                            }, thumbnailWidth, thumbnailHeight );

                                                            percentages[ file.id ] = [ file.size, 0 ];
                                                            file.rotation = 0;
                                                        }

                                                        file.on('statuschange', function( cur, prev ) {
                                                            if ( prev === 'progress' ) {
                                                                prgress.hide().width(0);
                                                            } else if ( prev === 'queued' ) {
                                                                //li.off( 'mouseenter mouseleave' ); //解除事件监听
                                                                //btns.remove();
                                                                li.find( 'span.rotateLeft' ).remove(); //移除左旋转按钮
                                                                li.find( 'span.rotateRight' ).remove(); //移除右旋转按钮
                                                            }

                                                            // 成功
                                                            if ( cur === 'error' || cur === 'invalid' ) {
                                                                console.log( file.statusText );
                                                                showError( file.statusText );
                                                                percentages[ file.id ][ 1 ] = 1;
                                                            } else if ( cur === 'interrupt' ) {
                                                                showError( 'interrupt' );
                                                            } else if ( cur === 'queued' ) {
                                                                percentages[ file.id ][ 1 ] = 0;
                                                            } else if ( cur === 'progress' ) {
                                                                info.remove();
                                                                prgress.css('display', 'block');
                                                            } else if ( cur === 'complete' ) {
                                                                li.append( '<span class="success"></span>' );
                                                            }

                                                            li.removeClass( 'state-' + prev ).addClass( 'state-' + cur );
                                                        });

                                                        li.on( 'mouseenter', function() {
                                                            btns.stop().animate({height: 30});
                                                        });

                                                        li.on( 'mouseleave', function() {
                                                            btns.stop().animate({height: 0});
                                                        });

                                                        btns.on( 'click', 'span', function() {
                                                            var index = $(this).index(),
                                                                deg;

                                                            switch ( index ) {
                                                                case 0:
                                                                    uploader.removeFile( file );
                                                                    return;

                                                                case 1:
                                                                    file.rotation += 90;
                                                                    break;

                                                                case 2:
                                                                    file.rotation -= 90;
                                                                    break;
                                                            }

                                                            if ( supportTransition ) {
                                                                deg = 'rotate(' + file.rotation + 'deg)';
                                                                wrap.css({
                                                                    '-webkit-transform': deg,
                                                                    '-mos-transform': deg,
                                                                    '-o-transform': deg,
                                                                    'transform': deg
                                                                });
                                                            } else {
                                                                wrap.css( 'filter', 'progid:DXImageTransform.Microsoft.BasicImage(rotation='+ (~~((file.rotation/90)%4 + 4)%4) +')');
                                                            }
                                                        });

                                                        li.appendTo( queue );
                                                    }

                                                    // 负责view的销毁
                                                    function removeFile( file ) {
                                                        var li = $('#'+file.id);
                                                        var img_src = li.attr('studyfox_img');

                                                        delete percentages[ file.id ];
                                                        updateTotalProgress();
                                                        li.off().find('.file-panel').off().end().remove();

                                                        //后台删除图片
                                                        $.ajax({
                                                            url: '<?php echo url('delete_file'); ?>',
                                                            type: 'POST',
                                                            data: {'img': img_src},
                                                            success: function(result, textStatus){
                                                                //图片删除成功后移除文本框图片信息，三种情况 ,号位置在前 后 或没有,号
                                                                var images_value = $('#info_img').val();//隐藏文本框的值
                                                                images_value = images_value.replace(img_src+',', '').replace(','+img_src, '').replace(img_src, ''); //替换,号在右边;左边;直接替换
                                                                //重新赋值
                                                                $('#info_img').val(images_value);
                                                            },
                                                            error: function(XMLHttpRequest, textStatus){
                                                                layer.alert('删除失败!', {icon:2});
                                                            }
                                                        });
                                                    }

                                                    //删除原图片
                                                    $(".cancel").click(function(){
                                                        var img_src = $(this).parent().parent().attr('studyfox_img');
                                                        var id = $(this).parent().parent().attr('id');
                                                        //后台删除图片
                                                        $.ajax({
                                                            url: '<?php echo url('delete_file'); ?>',
                                                            type: 'POST',
                                                            data: {'img': img_src},
                                                            success: function(result, textStatus){
                                                                //图片删除成功后移除文本框图片信息，三种情况 ,号位置在前 后 或没有,号
                                                                var images_value = $('#info_img').val();//隐藏文本框的值
                                                                images_value = images_value.replace(img_src+',', '').replace(','+img_src, '').replace(img_src, ''); //替换,号在右边;左边;直接替换
                                                                //重新赋值
                                                                $('#info_img').val(images_value);

                                                                //view的销毁
                                                                var li = $('#'+id);
                                                                delete percentages[ id ];
                                                                updateTotalProgress();
                                                                li.off().find('.file-panel').off().end().remove();

                                                                //删除所有图片之后销毁外框
                                                                if(images_value==''){
                                                                  $("#uploader-list-container").remove();
                                                                }
                                                            },
                                                            error: function(XMLHttpRequest, textStatus){
                                                                layer.alert('删除失败!', {icon:2});
                                                            }
                                                        });
                                                    });

                                                    //淡入淡出
                                                    var topli = $(".cancel").parent().parent();
                                                    topli.on( 'mouseenter', function() {
                                                        $(this).children('.file-panel').stop().animate({height: 30});
                                                    });

                                                    topli.on( 'mouseleave', function() {
                                                        $(this).children('.file-panel').stop().animate({height: 0});
                                                    });

                                                    //上传成功返回文件名
                                                    uploader.on('uploadSuccess', function(file,response){
                                                        var images_value = $('#info_img').val()=='' ? '' : $('#info_img').val() + ',';
                                                        $('#info_img').val( images_value + response);
                                                        //在当前图片LI里添加图片地址
                                                        $('#'+file.id).attr('studyfox_img',response);
                                                    });

                                                    function updateTotalProgress() {
                                                        var loaded = 0,
                                                            total = 0,
                                                            spans = progress.children(),
                                                            percent;

                                                        $.each( percentages, function( k, v ) {
                                                            total += v[ 0 ];
                                                            loaded += v[ 0 ] * v[ 1 ];
                                                        } );

                                                        percent = total ? loaded / total : 0;


                                                        spans.eq( 0 ).text( Math.round( percent * 100 ) + '%' );
                                                        spans.eq( 1 ).css( 'width', Math.round( percent * 100 ) + '%' );
                                                        updateStatus();
                                                    }

                                                    function updateStatus() {
                                                        var text = '', stats;

                                                        if ( state === 'ready' ) {
                                                            text = '选中' + fileCount + '张图片，共' +
                                                                    WebUploader.formatSize( fileSize ) + '。';
                                                        } else if ( state === 'confirm' ) {
                                                            stats = uploader.getStats();
                                                            if ( stats.uploadFailNum ) {
                                                                text = '已成功上传' + stats.successNum+ '张图片至服务器，'+
                                                                    stats.uploadFailNum + '张图片上传失败，<a class="retry" href="#">重新上传</a>失败图片或<a class="ignore" href="#">忽略</a>'
                                                            }

                                                        } else {
                                                            stats = uploader.getStats();
                                                            text = '共' + fileCount + '张（' +
                                                                    WebUploader.formatSize( fileSize )  +
                                                                    '），已上传' + stats.successNum + '张';

                                                            if ( stats.uploadFailNum ) {
                                                                text += '，失败' + stats.uploadFailNum + '张';
                                                            }
                                                        }

                                                        info.html( text );
                                                    }

                                                    function setState( val ) {
                                                        var file, stats;

                                                        if ( val === state ) {
                                                            return;
                                                        }

                                                        upload.removeClass( 'state-' + state );
                                                        upload.addClass( 'state-' + val );
                                                        state = val;

                                                        switch ( state ) {
                                                            case 'pedding':
                                                                placeHolder.removeClass( 'element-invisible' );
                                                                queue.hide();
                                                                statusBar.addClass( 'element-invisible' );
                                                                uploader.refresh();
                                                                break;

                                                            case 'ready':
                                                                placeHolder.addClass( 'element-invisible' );
                                                                $( '#filePicker2' ).removeClass( 'element-invisible');
                                                                queue.show();
                                                                statusBar.removeClass('element-invisible');
                                                                uploader.refresh();
                                                                break;

                                                            case 'uploading':
                                                                $( '#filePicker2' ).addClass( 'element-invisible' );
                                                                progress.show();
                                                                upload.text( '暂停上传' );
                                                                break;

                                                            case 'paused':
                                                                progress.show();
                                                                upload.text( '继续上传' );
                                                                break;

                                                            case 'confirm':
                                                                progress.hide();
                                                                $( '#filePicker2' ).removeClass( 'element-invisible' );
                                                                upload.text( '开始上传' );

                                                                stats = uploader.getStats();
                                                                if ( stats.successNum && !stats.uploadFailNum ) {
                                                                    setState( 'finish' );
                                                                    return;
                                                                }
                                                                break;
                                                            case 'finish':
                                                                stats = uploader.getStats();
                                                                if ( stats.successNum ) {
                                                                    //layer.alert( '上传成功' );
                                                                } else {
                                                                    // 没有成功的图片，重设
                                                                    state = 'done';
                                                                    location.reload();
                                                                }
                                                                break;
                                                        }

                                                        updateStatus();
                                                    }

                                                    uploader.onUploadProgress = function( file, percentage ) {
                                                        var li = $('#'+file.id),
                                                            percent = li.find('.progress span');

                                                        percent.css( 'width', percentage * 100 + '%' );
                                                        percentages[ file.id ][ 1 ] = percentage;
                                                        updateTotalProgress();
                                                    };

                                                    uploader.onFileQueued = function( file ) {
                                                        fileCount++;
                                                        fileSize += file.size;

                                                        if ( fileCount === 1 ) {
                                                            placeHolder.addClass( 'element-invisible' );
                                                            statusBar.show();
                                                        }

                                                        addFile( file );
                                                        setState( 'ready' );
                                                        updateTotalProgress();
                                                    };

                                                    uploader.onFileDequeued = function( file ) {
                                                        fileCount--;
                                                        fileSize -= file.size;

                                                        if ( !fileCount ) {
                                                            setState( 'pedding' );
                                                        }

                                                        removeFile( file );
                                                        updateTotalProgress();

                                                    };

                                                    uploader.on( 'all', function( type ) {
                                                        var stats;
                                                        switch( type ) {
                                                            case 'uploadFinished':
                                                                setState( 'confirm' );
                                                                break;

                                                            case 'startUpload':
                                                                setState( 'uploading' );
                                                                break;

                                                            case 'stopUpload':
                                                                setState( 'paused' );
                                                                break;

                                                        }
                                                    });

                                                    uploader.onError = function( code ) {
                                                        if(code == "Q_EXCEED_NUM_LIMIT") {
                                                           layer.alert("只能上传 10 张图片");
                                                        } else if(code == "F_DUPLICATE") {
                                                           layer.alert("重复上传");
                                                        } else {
                                                            layer.alert("错误代码：" + code);
                                                        }
                                                    };

                                                    upload.on('click', function() {
                                                        if ( $(this).hasClass( 'disabled' ) ) {
                                                            return false;
                                                        }

                                                        if ( state === 'ready' ) {
                                                            uploader.upload();
                                                        } else if ( state === 'paused' ) {
                                                            uploader.upload();
                                                        } else if ( state === 'uploading' ) {
                                                            uploader.stop();
                                                        }
                                                    });

                                                    info.on( 'click', '.retry', function() {
                                                        uploader.retry();
                                                    } );

                                                    info.on( 'click', '.ignore', function() {
                                                        alert( 'todo' );
                                                    } );

                                                    upload.addClass( 'state-' + state );
                                                    updateTotalProgress();
                                                });

                                            })( jQuery );
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
