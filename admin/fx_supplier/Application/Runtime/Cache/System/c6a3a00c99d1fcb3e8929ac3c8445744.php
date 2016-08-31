<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html><html>    <head>        <meta charset="utf-8">        <meta name="viewport" content="width=device-width, initial-scale=1">        <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">        <meta http-equiv="X-UA-Compatible" content="IE=9">        <title>创想范供应商管理后台</title>        <meta name="description" content="{if $page_description}{/if}">        <link rel="stylesheet" href="/Public/css/bootstrap.min.css">        <link rel="stylesheet" href="/Public/css/AdminLTE.css">        <link rel="stylesheet" href="/Public/css/font-awesome.min.css">        <link rel="stylesheet" href="/Public/css/skins/_all-skins.min.css">        <link rel="stylesheet" href="/Public/css/skins/skin-red.css">        <link rel="stylesheet" href="/Public/css/skins/skin-red-light.css">        <link rel="stylesheet" href="/Public/css/bootstrap3-wysihtml5.min.css">        <link rel="stylesheet" href="/Public/css/bootstrap-datetimepicker.min.css">        <link rel="stylesheet" href="/Public/css/my.css">        <link rel="stylesheet" href="/Public/css/layer.css" id="layui_layer_skinlayercss">        <link rel="stylesheet" href="/Public/css/global.css">        <link rel="shortcut icon" href="/Public/images/64x64.ico" type="image/x-icon" />         <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>        <script src="/Public/js/global.js" type="text/javascript" charset="utf-8"></script>        <script src="/Public/js/kkpager.min.js" type="text/javascript" charset="utf-8"></script>        <script src="//cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>        <script src="/Public/js/WdatePicker.js" type="text/javascript"></script>        <style type="text/css">            .sidebar-menu>li{display: none;}            .navbar-static-top li{cursor: pointer;}        </style>    </head>    <body class="skin-yellow-light sidebar-mini">        <!--header start-->        <header class="main-header">            <a href="#" class="logo">                <span class="logo-mini"><b>创想范</b></span>                <span class="logo-lg"><b>创想范</b><small> 供货商管理后台</small></span>            </a>            <nav class="navbar navbar-static-top">                <div class="navbar-nav top-bar">                    <ul class="nav navbar-nav first-nav">                        <li data-cate = "goods">                            <a class="" href="<?php echo U('goods/goods/index');?>"><b>商品</b></a>                        </li>                        <li data-cate = "order">                            <a class="" href="<?php echo U('orders/orders/index');?>"><b>订单</b></a>                        </li>						                        <li data-cate = "storage">                            <a class="" href="<?php echo U('storage/storage/index');?>"><b>仓储</b></a>                        </li>                        <li data-cate = "finance">                            <a  href="<?php echo U('finance/finance/index');?>"><b>财务</b></a>                        </li>                        <li data-cate = "after-sales">                            <a class="" href="<?php echo U('afterSales/index/index');?>"><b>售后</b></a>                        </li><!--                        <li data-cate = "user">                            <a class="" href="<?php echo U('user/user/index');?>"><b>用户管理</b></a>                        </li>-->                        <li data-cate = "system">                            <a class="" href="<?php echo U('system/index/index');?>"><b>系统</b></a>                        </li>                    </ul>                </div>                <div class="navbar-custom-menu">                    <ul class="nav navbar-nav">                        <li class=" user user-menu">                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">                                <span class="hidden-xs"><?php echo ($username); ?></span>                            </a>                        </li>                        <li>                            <a href="<?php echo U('user/login/logout');?>">                                <span class="hidden-xs">退出登录</span>                            </a>                        </li>                    </ul>                </div>            </nav>        </header>        <!--header end-->        <!--wrapper start-->        <div class="content-wrapper" style="min-height: 368px;">            <aside class="main-sidebar">                <section class="sidebar">                    <ul class="sidebar-menu">                        <li data-cate="goods">                            <a class="active" href="<?php echo U('goods/goods/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 商品列表</a>                        </li><!--                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/goodsRelease');?>"> <i class="fa fa-fw  fa-circle-o"></i> 商品发布</a>                        </li>-->                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/importGoods');?>"> <i class="fa fa-fw  fa-circle-o"></i> 新增商品</a>                        </li><!--                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/goodsNoList');?>"> <i class="fa fa-fw  fa-circle-o"></i> 货号列表</a>                        </li>-->                        <li data-cate="order" >                            <a class="" href="<?php echo U('orders/orders/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 订单列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 发货列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storage/slist');?>"> <i class="fa fa-fw  fa-circle-o"></i> 仓库设置</a>                        </li>                                                <!--li data-cate="storage" >                            <a class="" href="<?php echo U('storage/cusManage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 售后收货</a>                        </li-->                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storageManage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 库存列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storageManage/logEdit');?>"> <i class="fa fa-fw  fa-circle-o"></i> 库存修改日志</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/freight/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 物流模板</a>                        </li>                        <li data-cate="finance" >                            <a class="" href="<?php echo U('finance/finance/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 收款账户</a>                        </li>                        <li data-cate="finance" >                            <a class="" href="<?php echo U('finance/finance/endOrder');?>"> <i class="fa fa-fw  fa-circle-o"></i> 完结订单</a>                        </li>                        <li data-cate="finance">                            <a class="" href="<?php echo U('finance/finance/paymentDetails');?>"> <i class="fa fa-fw  fa-circle-o"></i> 收支明细</a>                        </li>                        <li data-cate="after-sales" >                            <a class="" href="<?php echo U('afterSales/index/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>售后列表</a>                        </li>                        <li data-cate="after-sales" >                            <a class="" href="<?php echo U('afterSales/index/arbitrationList');?>"> <i class="fa fa-fw  fa-circle-o"></i>仲裁结果</a>                        </li><!--                        <li data-cate="user" >                            <a class="" href="<?php echo U('user/user/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>用户设置</a>                        </li>-->                        <li data-cate="system" >                            <a class="" href="<?php echo U('system/index/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>操作记录</a>                        </li>                        <li data-cate="system" >                            <a class="" href="<?php echo U('system/user/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 用户信息</a>                        </li>                    </ul>                </section>            </aside>            <script>                showMenu();                function showMenu() {                    var target = "<?php echo U(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME); ?>";                    target = target.toUpperCase();                    var selected = _show(target);                     //二级菜单选中标记                    if (!selected) {                //三级菜单选择                            var refUrl = $.cookie('__refUrl');                        var tmp = refUrl.split('/');                        var _target = tmp[1] + '/' + tmp[2];                        if (target.indexOf(_target) > 0) {                            _show(refUrl);                        }                        ;                    }                    function _show(target) {                        var r = 0;                                //选中标记                        $('.sidebar-menu a').removeClass('active');     //顶级菜单显示                        $('.sidebar-menu a').each(function () {                            var tmp = $(this).attr('href');                            tmp = tmp.toUpperCase();                            if (tmp == target) {                                $(this).addClass('active');                 //二级菜单显示                                var cate = $(this).parent().data('cate');                                $('.sidebar-menu').find("[data-cate='" + cate + "']").show();                                $('.navbar-static-top').find('[data-cate="' + cate + '"]').addClass('active');      //顶级菜单显示                                                            r = 1;                                return;                            }                        });                        if (r) {                                                    //二级菜单选中，记录refurl                              $.cookie('__refUrl', target, {expires: 30, path: '/'});                        }                        ;                        return r;                    }                }            </script>            <section class="content">                <ol class="breadcrumb">
    <li><i class="fa fa-dashboard"></i> 系统位置</li>
    <li>操作记录</li>
</ol> 				
<div class="box-body">
    <div class="row" >
        <form class="form-inline" method="get" action="<?php echo U('system/index/index');?>" id="form_search" onsubmit="return X.toSerchVaild(this)">
            <div class="form-group">
                <select class="form-control input-xs" name="module">
                    <option value="">选择操作模块</option>
                    <?php if(is_array($modules)): foreach($modules as $k=>$v): ?><option value="<?php echo ($k); ?>"><?php echo ($v); ?></option><?php endforeach; endif; ?>    
                </select>
            </div>

            <div class="form-group">
                <label for="exampleInputName2">操作时间:&nbsp;&nbsp;&nbsp;&nbsp;</label>
            </div>
            <div class="form-group">
                <label>开始时间:</label>
                <input type="text" class="form-control input-xs" onClick="WdatePicker()" value="<?php echo I('get.time1');?>" name="time1">
            </div>
            <div class="form-group">
                <label>结束时间:</label>
                <input type="text" class="form-control input-xs" onClick="WdatePicker()" value="<?php echo I('get.time2');?>" name="time2">
            </div>	
            <div class="form-group">
                <input type="submit"  class="btn btn-block btn-warning btn-xs" value="筛选">
            </div>
        </form>

    </div>
    <div class="row table-responsive no-padding">
        <table class="table table-hover">
            <tbody>
                <tr>
                    <th>操作模块</th>
                    <th>操作内容</th>
                    <th>操作时间</th>
                </tr>	
            <?php if(is_array($list)): foreach($list as $key=>$q): ?><tr>
                    <th><?php echo ($q["module"]); ?></th>
                    <th><?php echo ($q["detail"]); ?></th>
                    <th><?php echo ($q["add_time"]); ?></th>
                </tr><?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>	
    <div class="box-footer">
        <div id="kkpager"></div>
    </div>
</div>


<div class="modal fade" id="e-modify" data-backdrop="static" data-keyboard="false"><div class="modal-dialog"><div class="modal-content row">
            <div class="modal-header col-sm-12">
                <h4 class="center">修改密码</h3>
            </div>
            <form class="modal-body">
                <p><span>原密码：</span><input type="text" placeholder="请输入原密码" name="old"></p>
                <p><span>新密码：</span><input type="password" placeholder="请输入新密码" name="pw1"></p>
                <p><span>确认新密码：</span><input type="password" placeholder="请再次输入新密码" name="pw2"></p>
            </form> 
            <div class="modal-footer col-sm-12">
                <div class="front">
                    <button class="btn btn-success btn-confirm ">保存</button>
                    <button class="btn" data-dismiss="modal">关闭</button>
                </div>
            </div>
        </div></div></div>  	



<script src="/Public/js/calendar.js"></script> 
<style>
    .s-date ul, .s-date ol, .s-date li {
        list-style: none;
        padding: 0;
        margin: 0;
    }	
    .modal-body p{text-align: center}
    .modal-body p span{margin-right: 20px}
</style>
<script>
            pager(<?php echo ($total); ?>);

            $('#date1').calendar({
                trigger: '.e-date1',
                zIndex: 999,
                format: 'yyyy-mm-dd',
            });
            $('#date2').calendar({
                trigger: '.e-date2',
                zIndex: 999,
                format: 'yyyy-mm-dd',
            });

            var q = $('#e-modify');

            $('.btn-confirm').click(function () {

                $.ajax({
                    type: 'post', url: '<?php echo U("system/index/edit");?>', data: q.find('form').serialize(), async: false,
                    success: function (e) {
                        switch (e.status) {
                            case 'error':
                                X.notice(e.msg);
                                break;
                            case 'failed':
                                X.notice(e.msg);
                                break;
                            case 'success':
                                X.notice(e.msg);
                                window.location.reload();
                                break;
                            default:
                                X.notice('未知系统错误');
                                break;
                        }
                    }
                })
            })
</script>            </section>        </div>        <!--wrapper end-->        <script src="/Public/js/bootstrap.min.js"></script>        <script src="/Public/js/app.min.js"></script>        <script type="text/javascript" src="/Public/js/moment.js"></script><!--         // <script src="/Public/js/bootstrap-datetimepicker.min.js"></script>        // <script src="/Public/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script> -->        <script type="text/javascript" src="/Public/js/custom.js"></script>        <script type="text/javascript" src="/Public/js/layer.js"></script>    </body></html>