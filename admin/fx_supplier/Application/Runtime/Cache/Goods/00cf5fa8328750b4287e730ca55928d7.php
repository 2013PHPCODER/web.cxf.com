<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html><html>    <head>        <meta charset="utf-8">        <meta name="viewport" content="width=device-width, initial-scale=1">        <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">        <meta http-equiv="X-UA-Compatible" content="IE=9">        <title>创想范供应商管理后台</title>        <meta name="description" content="{if $page_description}{/if}">        <link rel="stylesheet" href="/Public/css/bootstrap.min.css">        <link rel="stylesheet" href="/Public/css/AdminLTE.css">        <link rel="stylesheet" href="/Public/css/font-awesome.min.css">        <link rel="stylesheet" href="/Public/css/skins/_all-skins.min.css">        <link rel="stylesheet" href="/Public/css/skins/skin-red.css">        <link rel="stylesheet" href="/Public/css/skins/skin-red-light.css">        <link rel="stylesheet" href="/Public/css/bootstrap3-wysihtml5.min.css">        <link rel="stylesheet" href="/Public/css/bootstrap-datetimepicker.min.css">        <link rel="stylesheet" href="/Public/css/my.css">        <link rel="stylesheet" href="/Public/css/layer.css" id="layui_layer_skinlayercss">        <link rel="stylesheet" href="/Public/css/global.css">        <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>        <script src="/Public/js/global.js" type="text/javascript" charset="utf-8"></script>        <script src="/Public/js/kkpager.min.js" type="text/javascript" charset="utf-8"></script>        <script src="//cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>        <style type="text/css">            .sidebar-menu>li{display: none;}            .navbar-static-top li{cursor: pointer;}        </style>    </head>    <body class="skin-yellow-light sidebar-mini">        <!--header start-->        <header class="main-header">            <a href="#" class="logo">                <span class="logo-mini"><b>创想范</b></span>                <span class="logo-lg"><b>创想范</b><small> 供货商管理后台</small></span>            </a>            <nav class="navbar navbar-static-top">                <div class="navbar-nav top-bar">                    <ul class="nav navbar-nav first-nav">                        <li data-cate = "goods">                            <a class="" href="<?php echo U('goods/goods/index');?>"><b>商品</b></a>                        </li>                        <li data-cate = "order">                            <a class="" href="<?php echo U('orders/orders/index');?>"><b>订单</b></a>                        </li>						                        <li data-cate = "storage">                            <a class="" href="<?php echo U('storage/storage/index');?>"><b>仓储</b></a>                        </li>                        <li data-cate = "finance">                            <a  href="<?php echo U('finance/finance/index');?>"><b>财务管理</b></a>                        </li>                        <li data-cate = "after-sales">                            <a class="" href="<?php echo U('afterSales/index/index');?>"><b>售后管理</b></a>                        </li><!--                        <li data-cate = "user">                            <a class="" href="<?php echo U('user/user/index');?>"><b>用户管理</b></a>                        </li>-->                        <li data-cate = "system">                            <a class="" href="<?php echo U('system/index/index');?>"><b>系统设置</b></a>                        </li>                    </ul>                </div>                <div class="navbar-custom-menu">                    <ul class="nav navbar-nav">                        <li class=" user user-menu">                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">                                <span class="hidden-xs"><?php echo ($username); ?></span>                            </a>                        </li>                        <li>                            <a href="<?php echo U('user/login/logout');?>">                                <span class="hidden-xs">退出登录</span>                            </a>                        </li>                    </ul>                </div>            </nav>        </header>        <!--header end-->        <!--wrapper start-->        <div class="content-wrapper" style="min-height: 368px;">            <aside class="main-sidebar">                <section class="sidebar">                    <ul class="sidebar-menu">                        <li data-cate="goods">                            <a class="active" href="<?php echo U('goods/goods/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 商品列表</a>                        </li><!--                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/goodsRelease');?>"> <i class="fa fa-fw  fa-circle-o"></i> 商品发布</a>                        </li>-->                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/importGoods');?>"> <i class="fa fa-fw  fa-circle-o"></i> 新增商品</a>                        </li><!--                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/goodsNoList');?>"> <i class="fa fa-fw  fa-circle-o"></i> 货号列表</a>                        </li>-->                        <li data-cate="order" >                            <a class="" href="<?php echo U('orders/orders/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 订单列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 发货列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storage/slist');?>"> <i class="fa fa-fw  fa-circle-o"></i> 仓库设置</a>                        </li>                                                <!--li data-cate="storage" >                            <a class="" href="<?php echo U('storage/cusManage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 售后收货</a>                        </li-->                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storageManage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 库存列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storageManage/logEdit');?>"> <i class="fa fa-fw  fa-circle-o"></i> 库存修改日志</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/freight/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 物流模板</a>                        </li>                        <li data-cate="finance" >                            <a class="" href="<?php echo U('finance/finance/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 收款账户</a>                        </li>                        <li data-cate="finance" >                            <a class="" href="<?php echo U('finance/finance/endOrder');?>"> <i class="fa fa-fw  fa-circle-o"></i> 完结订单</a>                        </li>                        <li data-cate="finance">                            <a class="" href="<?php echo U('finance/finance/paymentDetails');?>"> <i class="fa fa-fw  fa-circle-o"></i> 收支明细</a>                        </li>                        <li data-cate="after-sales" >                            <a class="" href="<?php echo U('afterSales/index/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>售后列表</a>                        </li>                        <li data-cate="after-sales" >                            <a class="" href="<?php echo U('afterSales/index/arbitrationList');?>"> <i class="fa fa-fw  fa-circle-o"></i>仲裁结果</a>                        </li><!--                        <li data-cate="user" >                            <a class="" href="<?php echo U('user/user/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>用户设置</a>                        </li>-->                        <li data-cate="system" >                            <a class="" href="<?php echo U('system/index/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>操作记录</a>                        </li>                        <li data-cate="system" >                            <a class="" href="<?php echo U('system/user/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 用户信息</a>                        </li>                    </ul>                </section>            </aside>            <section class="content">                
    <link rel="stylesheet" type="text/css" href="/Public/js/webuploader/css/webuploader.css">

<?php  ?>
<style>
    #picker_img{
        background: #f2f2f2;
        boder:1px solid #e2e2e2
    }
</style>
<div class="box box-warning">
    <div class="box-body">
        <div class="row" >
            <form class="form-inline" >
                <div class="form-group">
                    csv文件：
                </div>  
                <div class="form-group">
                    <div id="uploader" class="wu-example"> 
                        <!--用来存放文件信息-->
                        <div class="btns">
                            <div id="picker">选择csv文件</div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputName2">选择商品仓库:</label>
                    <select class="form-control" name="depot">
                        <option value="">选择仓库</option>
                        <?php if(is_array($depot)): $i = 0; $__LIST__ = $depot;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$depot): $mod = ($i % 2 );++$i;?><option value="<?php echo ($depot["id"]); ?>"><?php echo ($depot["sname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div> 
                <div class="form-group">
                    <button id="ctlBtn" class="btn btn-default">开始上传</button>
                </div>
            </form>
        </div>
        <div class="row" >
            <div class="form-inline" >
                <div class="form-group">
                    图片tbi文件：
                </div>
                <div class="form-group">
                    <div id="uploader" class="wu-example"> 
                        <!--用来存放文件信息-->
                        <div class="btns">
                            <div id="picker_img" class="btn">选择图片文件-自动上传</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="uploader-list"> </div>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-header">
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <th align="middle"><input type="checkbox" id="checkAll"></th>
                        <th>商家编码</th>
                        <th>添加时间</th>
                        <th>商品类目</th>
                        <th>主图</th>
                        <th>标题</th>
                        <th>状态</th>
                        <th>提示</th>
                    </tr>
                <?php if(is_array($datas["list"])): $i = 0; $__LIST__ = $datas["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                        <td><input type="checkbox" class="choose" name="goods[]" value="<?php echo ($goods["id"]); ?>" ></td>
                        <td><?php echo ($vo["buyer_goods_no"]); ?></td>
                        <td><?php echo date('Y-m-d H:i',$vo[addtime]);?></td>
                        <td><p><?php echo getTreeCategory($vo['goods_category']);?></p></td>
                        <td><p><img class="table_img" src="<?php echo img_url($vo['img_path'],30,40);?>"></p></td>
                        <td><?php echo ($vo["goods_name"]); ?></td>
                        <td>上传失败</td>
                        <td><?php echo ($vo["goods_lack_momo"]); ?>[错误]</td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
        </div>
        <div class="box-footer">
            <div class="left" >
                <form class="form-inline" id="pagesizeForm" action="<?php echo U(ACTION_NAME, I('get.'));?>" method="get">

                    <div class="form-group">
                        <select name="pagesize" class="form-control input-xs pagesize">
                            <option <?php echo xeq(I('get.pagesize'), 20, 'selected');?> value="20">20条</option>
                            <option <?php echo xeq(I('get.pagesize'), 50, 'selected');?> value="50">50条</option>
                            <option <?php echo xeq(I('get.pagesize'), 100, 'selected');?> value="100">100条</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="right">
                <div class="pagination"> <?php echo ($datas["page"]); ?> </div>
            </div>
        </div>
    </div>
</block>
<block name="footerJs"> 
    <script type="text/javascript" src="/Public/js/webuploader/js/webuploader.min.js"></script> 
    <script type="text/javascript" src="/Public/js/layer.js"></script> 
    <script type="text/javascript" src="/Public/js/custom.js"></script>
    <script src="/Public/plupload-2.1.2/js/plupload.full.min.js"></script>
    <script src="/Public/js/md5.js"></script>
    <script type="text/javascript" src="/Public/js/plus.js"></script>
    <script type="text/javascript">
        var idd1 = X.upLoadImg(['picker_img', true, '.uploader-list', '#picker_img', 0]);
        var idd2 ='<?php echo U("goods/image/upyun_img");?>';
    </script>
    <script type="text/javascript">
        var uploader = WebUploader.create({
            // swf文件路径
            swf: '/js/Uploader.swf',
            // 文件接收服务端。
            server: "<?php echo U('goods/goods/addImportGoods');?>",
            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '#picker',
            fileNumLimit: 5000,
            // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
            resize: false,
            threads: 10,
            chunkRetry: 100,
            accept: {
                extensions: 'csv',
                mimeTypes: '.csv',
            }
        })

        var $list = $(".uploader-list"),
                $btn = $('#ctlBtn');
        // 当有文件被添加进队列的时候
        uploader.on('fileQueued', function (file) {
            $list.append('<div id="' + file.id + '" class="item">' +
                    '<span class="info">' + file.name + '</span>' +
                    '<span class="state">等待上传...</span>' +
                    '</div>');
        });

        // 文件上传过程中创建进度条实时显示。
        uploader.on('uploadProgress', function (file, percentage) {
            var $li = $('#' + file.id),
                    $percent = $li.find('.progress .progress-bar');

            // 避免重复创建
            if (!$percent.length) {
                $percent = $('<div class="progress progress-striped active">' +
                        '<div class="progress-bar" role="progressbar" style="width: 0%">' +
                        '</div>' +
                        '</div>').appendTo($li).find('.progress-bar');
            }

            $li.find('p.state').text('上传中');
            $percent.css('width', percentage * 100 + '%');
        });

        uploader.on('uploadBeforeSend', function (object, data, headers) {
            data.depot_id = $('select[name="depot"]').val();
            data._time = Math.floor(Math.random() * 999999 + 1);
        });

        $btn.on('click', function () {
            if (!$('select[name="depot"]').val()) {
                layer.alert("请选择商品仓库", {icon: 6});
                return false;
            }
            if (0 == uploader.getFiles().length) {
                layer.alert("请选择上传淘宝数据包", {icon: 6});
                return false;
            }
            uploader.upload();
            return false;
        });

        var uploadReturnData;

        uploader.on('uploadSuccess', function (file, response) {
            if (1 == response.status) {
                $('#' + file.id).find('.progress').fadeOut();
                $('#' + file.id).fadeOut();

                if (response.returnData == null) {
                    console.log('ok');
                } else {
                    uploadReturnData = response;
                    console.log('on');
                }
            }
        });

        uploader.on('uploadFinished', function (file) {

            if (uploadReturnData.returnData._total_num == 0) {
                layer.confirm('请检查数据包是否正确', {
                    btn: ['查看'] //按钮
                }, function () {
                    location.reload();
                });
                return false;
            }

            if (uploadReturnData.returnData._total_ok == 0) {
                layer.confirm('全部上传失败！', {
                    btn: ['查看'] //按钮
                }, function () {
                    location.reload();
                });
                return false;
            }

            if (uploadReturnData.returnData._total_num > uploadReturnData.returnData._total_ok) {
                layer.confirm('部分上传失败！', {
                    btn: ['查看', '关闭'] //按钮
                }, function () {
                    location.href = "<?php echo U('goods/index',array('group_id'=>2,'menu_id'=>1,'second_menu_id'=>4));?>";
                }, function () {
                    location.reload();
                });
                return
            }

            if (uploadReturnData.returnData._total_ok == uploadReturnData.returnData._total_num) {
                layer.confirm('全部上传成功', {
                    btn: ['查看', '关闭'] //按钮
                }, function () {
                    location.href = "<?php echo U('goods/index',array('group_id'=>2,'menu_id'=>1,'second_menu_id'=>4));?>";
                }, function () {
                    location.reload();
                });
                return
            }
        });


        uploader.on('uploadComplete', function (file) {
        });

    </script> 
            </section>        </div>        <script>            showMenu();            function showMenu() {                var target = "<?php echo U(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME); ?>";                target = target.toUpperCase();                var selected = _show(target);                     //二级菜单选中标记                if (!selected) {                //三级菜单选择                        var refUrl = $.cookie('__refUrl');                    var tmp = refUrl.split('/');                    var _target = tmp[1] + '/' + tmp[2];                    if (target.indexOf(_target) > 0) {                        _show(refUrl);                    }                    ;                }                function _show(target) {                    var r = 0;                                //选中标记                    $('.sidebar-menu a').removeClass('active');     //顶级菜单显示                    $('.sidebar-menu a').each(function () {                        var tmp = $(this).attr('href');                        tmp = tmp.toUpperCase();                        if (tmp == target) {                            $(this).addClass('active');                 //二级菜单显示                            var cate = $(this).parent().data('cate');                            $('.sidebar-menu').find("[data-cate='" + cate + "']").show();                            $('.navbar-static-top').find('[data-cate="' + cate + '"]').addClass('active');      //顶级菜单显示                                                        r = 1;                            return;                        }                    });                    if (r) {                                                    //二级菜单选中，记录refurl                          $.cookie('__refUrl', target, {expires: 30, path: '/'});                    }                    ;                    return r;                }            }        </script>        <!--wrapper end-->        <script src="/Public/js/bootstrap.min.js"></script>        <script src="/Public/js/app.min.js"></script>        <script type="text/javascript" src="/Public/js/moment.js"></script>        <script src="/Public/js/bootstrap-datetimepicker.min.js"></script>        <script src="/Public/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>        <script type="text/javascript" src="/Public/js/custom.js"></script>        <script type="text/javascript" src="/Public/js/layer.js"></script>    </body></html>