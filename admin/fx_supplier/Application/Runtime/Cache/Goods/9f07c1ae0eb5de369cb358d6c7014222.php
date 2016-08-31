<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html><html>    <head>        <meta charset="utf-8">        <meta name="viewport" content="width=device-width, initial-scale=1">        <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">        <meta http-equiv="X-UA-Compatible" content="IE=9">        <title>创想范供应商管理后台</title>        <meta name="description" content="{if $page_description}{/if}">        <link rel="stylesheet" href="/Public/css/bootstrap.min.css">        <link rel="stylesheet" href="/Public/css/AdminLTE.css">        <link rel="stylesheet" href="/Public/css/font-awesome.min.css">        <link rel="stylesheet" href="/Public/css/skins/_all-skins.min.css">        <link rel="stylesheet" href="/Public/css/skins/skin-red.css">        <link rel="stylesheet" href="/Public/css/skins/skin-red-light.css">        <link rel="stylesheet" href="/Public/css/bootstrap3-wysihtml5.min.css">        <link rel="stylesheet" href="/Public/css/bootstrap-datetimepicker.min.css">        <link rel="stylesheet" href="/Public/css/my.css">        <link rel="stylesheet" href="/Public/css/layer.css" id="layui_layer_skinlayercss">        <link rel="stylesheet" href="/Public/css/global.css">        <link rel="shortcut icon" href="/Public/images/64x64.ico" type="image/x-icon" />         <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>        <script src="/Public/js/global.js" type="text/javascript" charset="utf-8"></script>        <script src="/Public/js/kkpager.min.js" type="text/javascript" charset="utf-8"></script>        <script src="//cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>        <script src="/Public/js/WdatePicker.js" type="text/javascript"></script>        <style type="text/css">            .sidebar-menu>li{display: none;}            .navbar-static-top li{cursor: pointer;}        </style>    </head>    <body class="skin-yellow-light sidebar-mini">        <!--header start-->        <header class="main-header">            <a href="#" class="logo">                <span class="logo-mini"><b>创想范</b></span>                <span class="logo-lg"><b>创想范</b><small> 供货商管理后台</small></span>            </a>            <nav class="navbar navbar-static-top">                <div class="navbar-nav top-bar">                    <ul class="nav navbar-nav first-nav">                        <li data-cate = "goods">                            <a class="" href="<?php echo U('goods/goods/index');?>"><b>商品</b></a>                        </li>                        <li data-cate = "order">                            <a class="" href="<?php echo U('orders/orders/index');?>"><b>订单</b></a>                        </li>						                        <li data-cate = "storage">                            <a class="" href="<?php echo U('storage/storage/index');?>"><b>仓储</b></a>                        </li>                        <li data-cate = "finance">                            <a  href="<?php echo U('finance/finance/index');?>"><b>财务</b></a>                        </li>                        <li data-cate = "after-sales">                            <a class="" href="<?php echo U('afterSales/index/index');?>"><b>售后</b></a>                        </li><!--                        <li data-cate = "user">                            <a class="" href="<?php echo U('user/user/index');?>"><b>用户管理</b></a>                        </li>-->                        <li data-cate = "system">                            <a class="" href="<?php echo U('system/index/index');?>"><b>系统</b></a>                        </li>                    </ul>                </div>                <div class="navbar-custom-menu">                    <ul class="nav navbar-nav">                        <li class=" user user-menu">                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">                                <span class="hidden-xs"><?php echo ($username); ?></span>                            </a>                        </li>                        <li>                            <a href="<?php echo U('user/login/logout');?>">                                <span class="hidden-xs">退出登录</span>                            </a>                        </li>                    </ul>                </div>            </nav>        </header>        <!--header end-->        <!--wrapper start-->        <div class="content-wrapper" style="min-height: 368px;">            <aside class="main-sidebar">                <section class="sidebar">                    <ul class="sidebar-menu">                        <li data-cate="goods">                            <a class="active" href="<?php echo U('goods/goods/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 商品列表</a>                        </li><!--                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/goodsRelease');?>"> <i class="fa fa-fw  fa-circle-o"></i> 商品发布</a>                        </li>-->                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/importGoods');?>"> <i class="fa fa-fw  fa-circle-o"></i> 新增商品</a>                        </li><!--                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/goodsNoList');?>"> <i class="fa fa-fw  fa-circle-o"></i> 货号列表</a>                        </li>-->                        <li data-cate="order" >                            <a class="" href="<?php echo U('orders/orders/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 订单列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 发货列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storage/slist');?>"> <i class="fa fa-fw  fa-circle-o"></i> 仓库设置</a>                        </li>                                                <!--li data-cate="storage" >                            <a class="" href="<?php echo U('storage/cusManage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 售后收货</a>                        </li-->                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storageManage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 库存列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storageManage/logEdit');?>"> <i class="fa fa-fw  fa-circle-o"></i> 库存修改日志</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/freight/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 物流模板</a>                        </li>                        <li data-cate="finance" >                            <a class="" href="<?php echo U('finance/finance/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 收款账户</a>                        </li>                        <li data-cate="finance" >                            <a class="" href="<?php echo U('finance/finance/endOrder');?>"> <i class="fa fa-fw  fa-circle-o"></i> 完结订单</a>                        </li>                        <li data-cate="finance">                            <a class="" href="<?php echo U('finance/finance/paymentDetails');?>"> <i class="fa fa-fw  fa-circle-o"></i> 收支明细</a>                        </li>                        <li data-cate="after-sales" >                            <a class="" href="<?php echo U('afterSales/index/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>售后列表</a>                        </li>                        <li data-cate="after-sales" >                            <a class="" href="<?php echo U('afterSales/index/arbitrationList');?>"> <i class="fa fa-fw  fa-circle-o"></i>仲裁结果</a>                        </li><!--                        <li data-cate="user" >                            <a class="" href="<?php echo U('user/user/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>用户设置</a>                        </li>-->                        <li data-cate="system" >                            <a class="" href="<?php echo U('system/index/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>操作记录</a>                        </li>                        <li data-cate="system" >                            <a class="" href="<?php echo U('system/user/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 用户信息</a>                        </li>                    </ul>                </section>            </aside>            <script>                showMenu();                function showMenu() {                    var target = "<?php echo U(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME); ?>";                    target = target.toUpperCase();                    var selected = _show(target);                     //二级菜单选中标记                    if (!selected) {                //三级菜单选择                            var refUrl = $.cookie('__refUrl');                        var tmp = refUrl.split('/');                        var _target = tmp[1] + '/' + tmp[2];                        if (target.indexOf(_target) > 0) {                            _show(refUrl);                        }                        ;                    }                    function _show(target) {                        var r = 0;                                //选中标记                        $('.sidebar-menu a').removeClass('active');     //顶级菜单显示                        $('.sidebar-menu a').each(function () {                            var tmp = $(this).attr('href');                            tmp = tmp.toUpperCase();                            if (tmp == target) {                                $(this).addClass('active');                 //二级菜单显示                                var cate = $(this).parent().data('cate');                                $('.sidebar-menu').find("[data-cate='" + cate + "']").show();                                $('.navbar-static-top').find('[data-cate="' + cate + '"]').addClass('active');      //顶级菜单显示                                                            r = 1;                                return;                            }                        });                        if (r) {                                                    //二级菜单选中，记录refurl                              $.cookie('__refUrl', target, {expires: 30, path: '/'});                        }                        ;                        return r;                    }                }            </script>            <section class="content">                
    <link rel="stylesheet" type="text/css" href="/Public/css/bootstrap-datetimepicker.min.css">

<div class="box box-warning">
    <div class="box-header with-border">
        <div class="box-title">
            <ul class="choose_ul">

                <li><a class="<?php echo xeq(I('get.group_id',1),1,'btn btn-warning btn-xs');?>" href="<?php echo U('goods/index',array('group_id' => 1 ));?>" >所有商品</a></li>
                <li><a class="<?php echo xeq(I('get.group_id'),2,'btn btn-warning btn-xs');?>" href="<?php echo U('goods/index',array('group_id' => 2 ));?>">新上传</a></li>
                <li><a class="<?php echo xeq(I('get.group_id'),3,'btn btn-warning btn-xs');?>" href="<?php echo U('goods/index',array('group_id' => 3 ));?>">已下架</a></li>
                <li><a class="<?php echo xeq(I('get.group_id'),4,'btn btn-warning btn-xs');?>" href="<?php echo U('goods/index',array('group_id' => 4 ));?>">已上架</a></li>
                <li><a class="<?php echo xeq(I('get.group_id'),5,'btn btn-warning btn-xs');?>" href="<?php echo U('goods/index',array('group_id' => 5 ));?>">待审核</a></li>
                <li><a class="<?php echo xeq(I('get.group_id'),6,'btn btn-warning btn-xs');?>" href="<?php echo U('goods/index',array('group_id' => 6 ));?>">未通过</a></li>
            </ul>
        </div>
        <div class="box-tools pull-left"> </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row" >
            <form class="form-inline" method="get" action="<?php echo U('goods/index',array('group_id'=>I('get.group_id')));;?>" id="searchForm">
                <div class="form-group">
                    <label for="exampleInputName2">仓库名称:</label>
                    <select class="form-control input-xs" name="depot">
                        <option value="">选择仓库</option>
                        <?php if(is_array($depot)): $i = 0; $__LIST__ = $depot;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option <?php echo xeq(I('get.depot'),$vo['id'],'selected');?> value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["sname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputName2">商品类目:</label>
                    <select class="form-control input-xs" name="goods_category">
                        <option value="0">主类目</option>
                        <?php if(is_array($goods_category)): $i = 0; $__LIST__ = $goods_category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option <?php echo xeq(I('get.goods_category'),$vo['cid'],'selected');?> value="<?php echo ($vo["cid"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>	
                    </select>
                </div>

                <?php if( 1 == I('get.group_id',1) ){ ?>
                <div class="form-group ">
                    <label for="exampleInputName2">商品状态:</label>
                    <select name="goods_status" class="form-control input-xs">
                        <option value="">全部</option>
                        <option <?php echo xeq(I('get.goods_status'),2,'selected');?> value="2">新上传</option>
                        <option <?php echo xeq(I('get.goods_status'),3,'selected');?> value="3">已下架</option>
                        <option <?php echo xeq(I('get.goods_status'),4,'selected');?> value="4">已上架</option>
                        <option <?php echo xeq(I('get.goods_status'),5,'selected');?> value="5">待审核</option>
                        <option <?php echo xeq(I('get.goods_status'),6,'selected');?> value="6">未通过</option>
                    </select>
                </div>
                <?php } ?>

                <div class="row">
                    <div class="form-group">
                        <select class="form-control input-xs" name="time_type">
                            <?php switch($_GET['group_id']): case "2": ?><option <?php echo xeq(I('get.time_type'),'addtime','selected');?> value="addtime">上传时间</option><?php break;?>
                            <?php default: ?>
                            <option <?php echo xeq(I('get.time_type'),'sale_time','selected');?> value="sale_time" >上架时间</option>
                            <option <?php echo xeq(I('get.time_type'),'addtime','selected');?> value="addtime">上传时间</option><?php endswitch;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control input-xs" value="<?php echo I('get.startTime');?>" onClick="WdatePicker()" placeholder='开始时间' name="startTime">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control input-xs" value="<?php echo I('get.endTime');?>" onClick="WdatePicker()" name="endTime" placeholder='结束时间'>
                    </div>
                    <div class="form-group">
                        <select class="form-control input-xs" name="goods_search" >
                            <option value="">选择搜索内容</option>
                            <option <?php echo xeq(I('get.goods_search'),'goods_name','selected');?> value="goods_name">商品名称</option>
                            <option <?php echo xeq(I('get.goods_search'),'goods_no','selected');?> value="goods_no">商品ID</option>
                            <option <?php echo xeq(I('get.goods_search'),'buyer_goods_no','selected');?> value="buyer_goods_no">商家编码</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" name="search_word" value="<?php echo I('get.search_word');?>" class="form-control input-xs" <?php echo xeq(I('get.goods_search'),'','disabled');?>  placeholder="输入商品名称或者货号" >
                    </div>
                    <div class="form-group btnBox">
                        <input type="submit" class="btn btn-block btn-warning btn-xs" value="搜索">
                        <input type="hidden" name="allData" value="0" />
                        <input type="hidden" class="explode_goods_input" name="explodeGoods[]" value="0" />
                        <input type="hidden" name="explode_goods" value="0" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-header">
        <h3 class="box-title">
            <div>
                <form class="form-inline" id="sortForm" action="<?php echo U(ACTION_NAME, I('get.'));?>" method="get">
                    <select class="form-control input-xs sort" name="sort">
                        <option value="">商品排序</option>
                        <option <?php echo xeq(I('get.sort'), 'addtime~asc,goods_id~asc', 'selected');?>  value="addtime~asc,goods_id~asc">上传时间升序</option>
                        <option <?php echo xeq(I('get.sort'), 'addtime~desc,goods_id~desc', 'selected');?> value="addtime~desc,goods_id~desc">上传时间降序</option>
                        <?php switch($_GET['group_id']): case "3": ?><option <?php echo xeq(I('get.sort'), 'off_sale_time~asc', 'selected');?> value="off_sale_time~asc">下架时间升序</option>
                            <option <?php echo xeq(I('get.sort'), 'off_sale_time~desc', 'selected');?> value="off_sale_time~desc">下架时间降序</option><?php break;?>
                        <?php case "4": ?><option <?php echo xeq(I('get.sort'), 'sale_time~asc', 'selected');?> value="sale_time~asc">上架时间升序</option>
                            <option <?php echo xeq(I('get.sort'), 'sale_time~desc', 'selected');?> value="sale_time~desc">上架时间降序</option><?php break;?>	
                        <?php case "6": ?><option <?php echo xeq(I('get.sort'), 'off_sale_time~asc', 'selected');?> value="off_sale_time~asc">下架时间升序</option>
                            <option <?php echo xeq(I('get.sort'), 'off_sale_time~desc', 'selected');?> value="off_sale_time~desc">下架时间降序</option><?php break; endswitch;?>
                    </select>
                </form>
            </div> </h3>

        <div class="box-tools">
            <div class="input-group order">
                <ul>
                    <?php switch($_GET['group_id']): case "1": ?><li><a href="#" class="btn btn-default btn-xs" id="cancel_passed_batch">取消审核申请</a></li> 
                        <li><a href="#" data-id="1" class="btn btn-default btn-xs" id="update_goods_sale_batch" >提交上架审核</a></li>
                        <li><a href="#" data-id="2" class="btn btn-default btn-xs" id="off_goods_sale_batch">下架</a></li>
                        <!--                        <li><a href="#" class="btn btn-default btn-xs" id="passed_batch">审核</a></li>-->
                        <li><a href="#" class="btn btn-default btn-xs" id="goods_delete_batch">删除</a></li><?php break;?>
                    <?php case "2": ?><!--                        <li><a href="#" class="btn btn-default btn-xs import_price">导入更新</a></li>
                                                <li><a href="#" class="btn btn-default btn-xs" id="exportPriceExecl">导出</a></li>-->
                        <li><a href="#" class="btn btn-default btn-xs" id="update_goods_sale_batch">提交上架审核</a></li><?php break;?>
                    <?php case "3": ?><li><a href="#" data-id="1" class="btn btn-default btn-xs" id="update_goods_sale_batch">提交上架审核</a></li><?php break;?>
                    <?php case "4": ?><li><a href="#" data-id="2" class="btn btn-default btn-xs" id="off_goods_sale_batch">下架</a></li><?php break;?>
                    <?php case "5": ?><li><a href="#" class="btn btn-default btn-xs" id="cancel_passed_batch" >取消审核申请</a></li>
                        <!--                        <li><a href="#" class="btn btn-default btn-xs" id="passed_batch">审核</a></li>--><?php break;?>
                    <?php case "6": ?><li><a href="#" class="btn btn-default btn-xs" id="goods_delete_batch">删除</a></li><?php break;?>
                    <?php default: ?>
                    <li><a href="#" class="btn btn-default btn-xs" id="cancel_passed_batch" >取消审核申请</a></li>
                    <li><a href="#" data-id="1" class="btn btn-default btn-xs" id="update_goods_sale_batch">提交上架审核</a></li>
                    <li><a href="#" data-id="2" class="btn btn-default btn-xs" id="off_goods_sale_batch">下架</a></li>
                    <!--                    <li><a href="#" class="btn btn-default btn-xs" id="passed_batch">审核</a></li>-->
                    <li><a href="#" class="btn btn-default btn-xs" id="goods_delete_batch">删除</a></li><?php endswitch;?>
                </ul>
            </div>

        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover" id="dataTable">
            <tbody>
                <tr>
                    <th align="middle"><input type="checkbox" id="checkAll"></th>
                    <th align="middle"></th>
                    <th>商家ID/最新商家编码</th>
                    <th>主图</th>
                    <th>名称</th>
                    <th>商品类目</th>
                    <th>成本价</th>
<!--                    <th>建议零售价</th>-->
                    <!--                    <th>市场价</th>-->
                    <th>商品状态</th>
                    <th>操作</th>
                </tr>
            <?php if(is_array($datas["list"])): $i = 0; $__LIST__ = $datas["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td ><input type="checkbox"  class="checkbox_goods_id choose" value="<?php echo ($vo["goods_id"]); ?>" ></td>
                    <td><i class="glyphicon glyphicon-plus-sign sku_tab"></i></td>
                    <td><p>商品ID:<?php echo ($vo["goods_no"]); ?></p><p>商家编码：<?php echo ($vo["buyer_goods_no"]); ?></p></td>
                    <td style="width:30px;"><img class="table_img" src="<?php echo ($vo['upyun_path']); ?>!upyun123/fwfh/60x60" /></td>
                    <td>
                        <p>
                            <?php echo ($vo["goods_name"]); ?>
                        </p>
                        <p> 上传时间：<?php echo date('Y-m-d H:i',$vo['addtime']);?>  <?php if(($vo["conf_time"]) != "0"): ?>上架时间：<?php echo date('Y-m-d H:i',$vo['conf_time']); endif; ?>
                        </p>
                    </td>
                    <td>
                        <?php echo getTreeCategory($vo['goods_category']);?>
                    </td>
                    <td>
                        <?php echo ($vo["price"]); ?>
                    </td>
<!--                    <td>
                        <?php echo ($vo["distribution_price"]); ?>
                    </td>-->
                    <!--                <td>
                                        <?php echo ($vo["sku_list"]["0"]["market_price"]); ?>
                                    </td>-->
                    <td>
                        <?php if(($vo["new_upload"]) == "1"): switch($vo["goods_status"]): case "1": if(($vo["goods_sale"]) == "2"): ?>已下架
                    <?php else: ?>
                    待审核<?php endif; break;?>
                <?php case "2": ?>未通过<?php break;?>
                <?php case "3": ?>已上架<?php break; endswitch;?>
                <?php else: ?>
                新上传<?php endif; ?>
                </td>
                <td>
                    <?php switch($_GET['group_id']): case "": if(($vo["new_upload"]) == "1"): if(($vo["goods_status"]) == "1"): if(($vo["goods_sale"]) == "2"): ?><p><a  class="goods_sale" data-id="<?php echo ($vo["goods_id"]); ?>" href="#">提交上架审核</a></p>
                    <?php else: ?>
                    <!--                    <p><a class="passed" data-id="<?php echo ($vo["goods_id"]); ?>" href="#">审核</a></p>--><?php endif; ?>

                    <?php if(($vo["goods_sale"]) == "1"): ?><p><a class="cancel_goods_sale" data-id="<?php echo ($vo["goods_id"]); ?>" href="#">取消上架申请</a></p><?php endif; endif; ?>
                    <?php if(($vo["goods_status"]) == "2"): ?><p><a class="goods_delete" data-id="<?php echo ($vo["goods_id"]); ?>"  href="#">删除</a></p><?php endif; ?>
                    <?php if(($vo["goods_status"]) == "3"): ?><p><a class="off_goods_sale" data-id="<?php echo ($vo["goods_id"]); ?>" href="#">下架</a></p><?php endif; ?>
                    <?php else: ?>
                    <p><a class="goods_sale" data-id="<?php echo ($vo["goods_id"]); ?>" href="#">提交上架审核</a></p><?php endif; break;?>
                <?php case "1": if(($vo["new_upload"]) == "1"): if(($vo["goods_status"]) == "1"): if(($vo["goods_sale"]) == "2"): ?><p><a  class="goods_sale" data-id="<?php echo ($vo["goods_id"]); ?>" href="#">提交上架审核</a></p>
                    <?php else: ?>
                    <!--                    <p><a class="passed" data-id="<?php echo ($vo["goods_id"]); ?>" href="#">审核</a></p>--><?php endif; ?>

                    <?php if(($vo["goods_sale"]) == "1"): ?><p><a class="cancel_goods_sale" data-id="<?php echo ($vo["goods_id"]); ?>" href="#">取消上架申请</a></p><?php endif; endif; ?>
                    <?php if(($vo["goods_status"]) == "2"): ?><p><a class="goods_delete" data-id="<?php echo ($vo["goods_id"]); ?>"  href="#">删除</a></p><?php endif; ?>
                    <?php if(($vo["goods_status"]) == "3"): ?><p><a class="off_goods_sale" data-id="<?php echo ($vo["goods_id"]); ?>" href="#">下架</a></p><?php endif; ?>
                    <?php else: ?>
                    <p><a class="goods_sale" data-id="<?php echo ($vo["goods_id"]); ?>" href="#">提交上架审核</a></p><?php endif; break;?>
                <?php case "2": ?><p><a class="goods_sale" data-id="<?php echo ($vo["goods_id"]); ?>" href="#">提交上架审核</a></p>
                    <?php if(($vo["new_upload"]) == "0"): ?><p><a class="goods_delete" data-id="<?php echo ($vo["goods_id"]); ?>"  href="#">删除</a></p><?php endif; break;?>
                <?php case "3": ?><p><a class="goods_sale" data-id="<?php echo ($vo["goods_id"]); ?>" href="#">提交上架审核</a></p><?php break;?>
                <?php case "4": ?><p><a class="off_goods_sale" data-id="<?php echo ($vo["goods_id"]); ?>" href="#">下架</a></p><?php break;?>
                <?php case "5": ?><!--                    <p><a class="passed" data-id="<?php echo ($vo["goods_id"]); ?>" href="#">审核</a></p>-->
                    <p><a class="cancel_goods_sale" data-id="<?php echo ($vo["goods_id"]); ?>" href="#">取消上架申请</a></p><?php break;?>
                <?php case "6": ?><p><a class="goods_delete" data-id="<?php echo ($vo["goods_id"]); ?>"  href="#">删除</a></p><?php break; endswitch;?>
                </ul>
                </td>	
                </tr>
                <tr class="hidden">
                    <td colspan="11">
                        <table class="table">
                            <tr><th>商品SKU属性</th>
                                <th>库存（合计：<?php echo ($vo["stock_num"]); ?>）</th>
                            </tr>
                            <?php if(is_array($vo["sku_list"])): $i = 0; $__LIST__ = $vo["sku_list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sl): $mod = ($i % 2 );++$i;?><tr>
                                    <td><?php echo ($sl["sku_str_zh"]); ?></td>
                                    <td><?php echo ($sl["stock_num"]); ?></td>
                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        </table>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
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
            <div class="pagination">
                <?php echo ($datas["page"]); ?>
            </div>
        </div>
    </div>
</block>
<block name="footerJs">
    <script type="text/javascript" src="/Public/js/moment.js"></script>
    <script src="/Public/js/bootstrap-datetimepicker.min.js"></script>
    <script src="/Public/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
    <script type="text/javascript" src="/Public/js/custom.js"></script>
    <script type="text/javascript" src="/Public/js/layer.js"></script>
    <script type="text/javascript">
        var refurbish = function () {
            location.reload();
        };
        $(document).ready(function () {
            $('select[name="goods_search"]').change(function (event) {
                /* Act on the event */
                if ('' == $(this).val()) {
                    $('input[name="search_word"]').attr('disabled', true);
                } else {
                    $('input[name="search_word"]').removeAttr('disabled');
                }
            });

//            $('.import_price').click(function (event) {
//                layer.open({
//                    type: 2,
//                    area: ['500px', '150px'],
//                    fix: false, //不固定
//                    maxmin: true,
//                    content: "<?php echo U('goods/importPrice');?>",
//                    title: '导入价格'
//                });
//                return false;
//            });

            //单个商品上架
            $('.goods_sale').click(function (event) {
                var postData = new Object(),
                        postUrl = "<?php echo U('goods/goods/goodsSaleAjax');?>";
                postData.goods_id = $(this).data('id');
                layer.confirm('你确定要上架么？', {btn: ['确认', '取消']},
                function (index) {
                    layer.close(index);
                    /* Act on the event */
                    $.post(postUrl, postData, function (data, textStatus, xhr) {
                        /*optional stuff to do after success */
                        layer.open({
                            content: data.message,
                            scrollbar: false,
                            yes: function (index) {
                                layer.close(index);
                                if (1 == data.status) {
                                    location.reload();
                                }
                            }
                        });
                    }, 'json');
                }, function (index) {
                    layer.close(index);
                    return false;
                });
                return false;
            });



            //单个商品下架
            $('.off_goods_sale').click(function (event) {
                /* Act on the event */
                var postData = new Object(),
                        postUrl = "<?php echo U('goods/goodsOffSaleAjax');?>";
                postData.goods_id = $(this).data('id');
                layer.confirm('你确定要下架么？', {btn: ['确认', '取消']},
                function (index) {
                    layer.close(index);
                    $.post(postUrl, postData, function (data, textStatus, xhr) {
                        /*optional stuff to do after success */

                        layer.open({
                            content: data.message,
                            scrollbar: false,
                            yes: function (index) {
                                layer.close(index);
                                if (1 == data.status) {
                                    location.reload();
                                }
                            }
                        });
                    }, 'json');
                    return false;
                }, function (index) {
                    layer.close(index);
                });
                return false;
            });


            //单个商品取消
            $('.cancel_goods_sale').click(function (event) {
                var postData = new Object(),
                        postUrl = "<?php echo U('goods/goodsCancelSale');?>";
                postData.goods_id = $(this).data('id');
                layer.confirm('你确定要取消么？', {btn: ['确认', '取消']},
                function (index) {
                    layer.close(index);
                    $.post(postUrl, postData, function (data, textStatus, xhr) {
                        /*optional stuff to do after success */
                        layer.open({
                            content: data.message,
                            scrollbar: false,
                            yes: function (index) {
                                layer.close(index);
                                if (1 == data.status) {
                                    location.reload();
                                }
                            }
                        });
                    }, 'json');
                    return false;
                }, function (index) {
                    layer.close(index);
                    return false;
                });
            });



            //删除单个商品
            $('.goods_delete').click(function (event) {
                var postData = new Object(),
                        postUrl = "<?php echo U('goods/goodsDelete');?>";
                postData.goods_id = $(this).data('id');
                layer.confirm('你确定要删除么？', {btn: ['确认', '取消']},
                function (index) {
                    layer.close(index);
                    $.post(postUrl, postData, function (data, textStatus, xhr) {
                        /*optional stuff to do after success */
                        layer.open({
                            content: data.message,
                            scrollbar: false,
                            yes: function (index) {
                                layer.close(index);
                                if (1 == data.status) {
                                    location.reload();
                                }
                            }
                        });
                        
                    }, 'json');
                    return false;
                }, function (index) {
                    layer.close(index);
                    return false;
                });
                return false;
            });



            var goodsDeleteBatch = function (mPostData) {
                var postUrl = "<?php echo U('goods/goodsDeleteBatch',I('get.'));?>";
                $.post(postUrl, mPostData, function (data, textStatus, xhr) {
                    /*optional stuff to do after success */
                    layer.open({
                        content: data.message,
                        scrollbar: false,
                        yes: function (index) {
                            layer.close(index);
                            if (1 == data.status) {
                                location.reload();
                            }
                        }
                    });
                }, 'json');
            };

            /**
             * 商品批量删除ajax操作
             */
            $('#goods_delete_batch').click(function (event) {
                var postData = new Object();
                postData = getPostData();

                if (false == postData) {
                    layer.alert('请选择商品', {icon: 6});
                    return false;
                }
                layer.confirm('确定需要删除商品么？', {btn: ['确认', '取消']},
                function (index) {
                    goodsDeleteBatch(postData);
                }, function (index) {
                    layer.close(index);
                }
                );
                return false;
            });



            var passed = function (mPostData) {
                postUrl = "<?php echo U('goods/goodsPassed');?>";
                $.post(postUrl, mPostData, function (data, textStatus, xhr) {
                    /*optional stuff to do after success */
                    layer.open({
                        content: data.message,
                        scrollbar: false,
                        yes: function (index) {
                            layer.close(index);
                            if (1 == data.status) {
                                location.reload();
                            }
                        }
                    });
                }, 'json');
            };

//            $('.passed').click(function (event) {
//                var postData = new Object();
//                postData.goods_id = $(this).data('id');
//                layer.confirm('请选择是通过或拒绝审核', {
//                    btn: ['通过', '拒绝'] //按钮
//                }, function () {
//                    postData.goods_status = 3;
//                    passed(postData);
//                }, function () {
//                    postData.goods_status = 2;
//                    passed(postData);
//                });
//                return false;
//            });



//            var passedBatch = function (mPostData) {
//                var postUrl = "<?php echo U('goods/passedBatch',I('get.'));?>";
//                $.post(postUrl, mPostData, function (data, textStatus, xhr) {
//                    /*optional stuff to do after success */
//                    layer.open({
//                        content: data.message,
//                        scrollbar: false,
//                        yes: function (index) {
//                            layer.close(index);
//                            if (1 == data.status) {
//                                location.reload();
//                            }
//                        }
//                    });
//                }, 'json');
//            };

            /**
             * 商品批量审核ajax操作
             */
//            $('#passed_batch').click(function (event) {
//                var postData = new Object();
//                postData = getPostData();
//                if (postData == false) {
//                    layer.alert('请选择商品', {icon: 6});
//                    return false;
//                }
//                layer.confirm('请选择是通过或拒绝审核', {btn: ['通过', '拒绝']},
//                function (index) {
//                    postData.goods_status = 3;
//                    passedBatch(postData);
//                }, function () {
//                    postData.goods_status = 2;
//                    passedBatch(postData);
//                }
//                );
//                return false;
//            });


            var cancelPassedBatch = function (mPostData) {
                var postUrl = "<?php echo U('goods/cancelPassedBatch',I('get.'));?>";
                $.post(postUrl, mPostData, function (data, textStatus, xhr) {
                    /*optional stuff to do after success */
                    layer.open({
                        content: data.message,
                        scrollbar: false,
                        yes: function (index) {
                            layer.close(index);
                            if (1 == data.status) {
                                location.reload();
                            }
                        }
                    });
                }, 'json');
            };


            var offGoodsSaleBatch = function (mPostData) {
                var postUrl = "<?php echo U('goods/offGoodsSaleBatch',I('get.'));?>";
                $.post(postUrl, mPostData, function (data, textStatus, xhr) {
                    /*optional stuff to do after success */
                    layer.open({
                        content: data.message,
                        scrollbar: false,
                        yes: function (index) {
                            layer.close(index);
                            if (1 == data.status) {
                                location.reload();
                            }
                        }
                    });
                }, 'json');
            };


            /**
             * 商品批量下架ajax操作
             */
            $('#off_goods_sale_batch').click(function (event) {
                var postData = new Object();
                postData = getPostData();
                if (false == postData) {
                    layer.alert('请选择商品', {icon: 6});
                    return false;
                }
                layer.confirm('您确定要将已选的商品下架么？', {btn: ['确认', '取消']},
                function (index) {
                    offGoodsSaleBatch(postData);
                }, function (index) {
                    layer.close(index);
                }
                );
                return false;
            });

            /**
             * 商品批量取消ajax操作
             */
            $('#cancel_passed_batch').click(function (event) {
                var postData = new Object();

                postData = getPostData();

                if (false == postData) {
                    layer.alert('请选择商品', {icon: 6});
                    return false;
                }
                layer.confirm('确定需要取消审核么？', {btn: ['确认', '取消']},
                function (index) {
                    cancelPassedBatch(postData);
                }, function (index) {
                    layer.close(index);
                }
                );
                return false;
            });



            var updateGoodsSaleBatch = function (mPostData) {
                var postUrl = "<?php echo U('goods/updateGoodsSaleBatch',I('get.'));?>";
                $.post(postUrl, mPostData, function (data, textStatus, xhr) {
                    /*optional stuff to do after success */
                    layer.open({
                        content: data.message,
                        scrollbar: false,
                        yes: function (index) {
                            layer.close(index);
                            if (1 == data.status) {
                                location.reload();
                            }
                        }
                    });
                }, 'json');
            }

            /**
             * 商品批量上架ajax操作
             */
            $('#update_goods_sale_batch').click(function (event) {
                var postData = new Object();
                postData = getPostData();
                if (false == postData) {
                    layer.alert('请选择商品', {icon: 6});
                    return false;
                }
                layer.confirm('确定要将商品上架审核么', {btn: ['确认', '取消']},
                function (index) {
                    updateGoodsSaleBatch(postData);
                }, function (index) {
                    layer.close(index);
                }
                );
                return false;
            });


            $('.cancel_passed').click(function (event) {
                /* Act on the event */
                var postData = new Object(),
                        postUrl = "<?php echo U('goods/goodsPassed');?>";
                postData.goods_id = $(this).data('id');
                $.post(postUrl, postData, function (data, textStatus, xhr) {
                    /*optional stuff to do after success */
                    layer.open({
                        content: data.message,
                        scrollbar: false,
                        yes: function (index) {
                            layer.close(index);
                            if (1 == data.status) {
                                location.reload();
                            }
                        }
                    });
                }, 'json');
                return false;
            });

            $('.sort').change(function () {
                $('#sortForm').submit();
            });

            $('.allGoods').click(function (event) {
                $('input[name="allData"]').val($(this).is(':checked') ? 1 : 0);
            });

            //导出商品价格
//            $("#exportPriceExecl").click(function (event) {
//                /* Act on the event */
//                if ($('.allGoods').is(':checked')) {
//                    $("input[name='allData']").val(1)
//                } else {
//                    $("#dataTable").find('.checkbox_goods_id:checked').each(function (index, element) {
//                        var cloneInput = $('.explode_goods_input:first()').clone();
//                        cloneInput.val($(this).val()).appendTo('.btnBox')
//                    });
//                    if (1 == $('.explode_goods_input').length) {
//                        layer.alert('请选择商品', {icon: 6});
//                        return false;
//                    }
//                }
//                $('.explode_goods_input:first()').remove();
//                $('input[name="explode_goods"]').val(1);
//                $("#searchForm").submit();
//                $('input[name="explode_goods"]').val(0);
//                return false;
//            });

            var getPostData = function () {
                var postData = new Object();
                postData.alldata = 0;
                var goods = new Array();
                if ($('.allGoods').is(":checked")) {
                    postData.alldata = 1;
                } else {
                    $("#dataTable").find('.checkbox_goods_id:checked').each(function (index, element) {
                        goods[index] = $(this).val();
                    });
                    if (0 == goods.length) {
                        return false;
                    }
                }
                postData.goods = goods;
                return postData;
            };



            //商品上架
            $('＃update_goods_sale').click(function () {
                var postUrl = "<?php echo U('goods/goodsSale', I('get.'));?>";
                var postData = getPostData();
                if (0 == postData.alldata) {
                    if (0 == postData.goods.length)
                        return false;
                }
                $.post(postUrl, postData, function (rData) {
                    layer.open({
                        content: rData.message,
                        scrollbar: false,
                        yes: function (index) {
                            layer.close(index);
                            if (1 == rData.status) {
                                location.reload();
                            }
                        }
                    });
                }, 'json');
                return false;
            });

            $('.sku_tab').click(function (event) {
                /* Act on the event */
                if ($(this).hasClass('glyphicon-plus-sign')) {
                    $(this).removeClass('glyphicon-plus-sign');
                    $(this).addClass('glyphicon-minus-sign');
                    $(this).parents("tr").next().removeClass('hidden');
                } else {
                    $(this).removeClass('glyphicon-minus-sign');
                    $(this).addClass('glyphicon-plus-sign');
                    $(this).parents("tr").next().addClass('hidden');
                }
            });
        });



    </script>            </section>        </div>        <!--wrapper end-->        <script src="/Public/js/bootstrap.min.js"></script>        <script src="/Public/js/app.min.js"></script>        <script type="text/javascript" src="/Public/js/moment.js"></script><!--         // <script src="/Public/js/bootstrap-datetimepicker.min.js"></script>        // <script src="/Public/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script> -->        <script type="text/javascript" src="/Public/js/custom.js"></script>        <script type="text/javascript" src="/Public/js/layer.js"></script>    </body></html>