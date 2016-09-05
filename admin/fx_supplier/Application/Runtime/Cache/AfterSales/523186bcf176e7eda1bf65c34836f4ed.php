<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html><html>    <head>        <meta charset="utf-8">        <meta name="viewport" content="width=device-width, initial-scale=1">        <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">        <meta http-equiv="X-UA-Compatible" content="IE=9">        <title>创想范供应商管理后台</title>        <meta name="description" content="{if $page_description}{/if}">        <link rel="stylesheet" href="/Public/css/bootstrap.min.css">        <link rel="stylesheet" href="/Public/css/AdminLTE.css">        <link rel="stylesheet" href="/Public/css/font-awesome.min.css">        <link rel="stylesheet" href="/Public/css/skins/_all-skins.min.css">        <link rel="stylesheet" href="/Public/css/skins/skin-red.css">        <link rel="stylesheet" href="/Public/css/skins/skin-red-light.css">        <link rel="stylesheet" href="/Public/css/bootstrap3-wysihtml5.min.css">        <link rel="stylesheet" href="/Public/css/bootstrap-datetimepicker.min.css">        <link rel="stylesheet" href="/Public/css/my.css">        <link rel="stylesheet" href="/Public/css/layer.css" id="layui_layer_skinlayercss">        <link rel="stylesheet" href="/Public/css/global.css">        <link rel="shortcut icon" href="/Public/images/64x64.ico" type="image/x-icon" />         <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>        <script src="/Public/js/global.js" type="text/javascript" charset="utf-8"></script>        <script src="/Public/js/kkpager.min.js" type="text/javascript" charset="utf-8"></script>        <script src="//cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>        <script src="/Public/js/WdatePicker.js" type="text/javascript"></script>        <style type="text/css">            .sidebar-menu>li{display: none;}            .navbar-static-top li{cursor: pointer;}        </style>    </head>    <body class="skin-yellow-light sidebar-mini">        <!--header start-->        <header class="main-header">            <a href="#" class="logo">                <span class="logo-mini"><b>创想范</b></span>                <span class="logo-lg"><b>创想范</b><small> 供货商管理后台</small></span>            </a>            <nav class="navbar navbar-static-top">                <div class="navbar-nav top-bar">                    <ul class="nav navbar-nav first-nav">                        <li data-cate = "goods">                            <a class="" href="<?php echo U('goods/goods/index');?>"><b>商品</b></a>                        </li>                        <li data-cate = "order">                            <a class="" href="<?php echo U('orders/orders/index');?>"><b>订单</b></a>                        </li>						                        <li data-cate = "storage">                            <a class="" href="<?php echo U('storage/storage/index');?>"><b>仓储</b></a>                        </li>                        <li data-cate = "finance">                            <a  href="<?php echo U('finance/finance/index');?>"><b>财务</b></a>                        </li>                        <li data-cate = "after-sales">                            <a class="" href="<?php echo U('afterSales/index/index');?>"><b>售后</b></a>                        </li><!--                        <li data-cate = "user">                            <a class="" href="<?php echo U('user/user/index');?>"><b>用户管理</b></a>                        </li>-->                        <li data-cate = "system">                            <a class="" href="<?php echo U('system/index/index');?>"><b>系统</b></a>                        </li>                    </ul>                </div>                <div class="navbar-custom-menu">                    <ul class="nav navbar-nav">                        <li class=" user user-menu">                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">                                <span class="hidden-xs"><?php echo ($username); ?></span>                            </a>                        </li>                        <li>                            <a href="<?php echo U('user/login/logout');?>">                                <span class="hidden-xs">退出登录</span>                            </a>                        </li>                    </ul>                </div>            </nav>        </header>        <!--header end-->        <!--wrapper start-->        <div class="content-wrapper" style="min-height: 368px;">            <aside class="main-sidebar">                <section class="sidebar">                    <ul class="sidebar-menu">                        <li data-cate="goods">                            <a class="active" href="<?php echo U('goods/goods/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 商品列表</a>                        </li><!--                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/goodsRelease');?>"> <i class="fa fa-fw  fa-circle-o"></i> 商品发布</a>                        </li>-->                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/importGoods');?>"> <i class="fa fa-fw  fa-circle-o"></i> 新增商品</a>                        </li><!--                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/goodsNoList');?>"> <i class="fa fa-fw  fa-circle-o"></i> 货号列表</a>                        </li>-->                        <li data-cate="order" >                            <a class="" href="<?php echo U('orders/orders/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 订单列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 发货列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storage/slist');?>"> <i class="fa fa-fw  fa-circle-o"></i> 仓库设置</a>                        </li>                                                <!--li data-cate="storage" >                            <a class="" href="<?php echo U('storage/cusManage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 售后收货</a>                        </li-->                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storageManage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 库存列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storageManage/logEdit');?>"> <i class="fa fa-fw  fa-circle-o"></i> 库存修改日志</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/freight/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 物流模板</a>                        </li>                        <li data-cate="finance" >                            <a class="" href="<?php echo U('finance/finance/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 收款账户</a>                        </li>                        <li data-cate="finance" >                            <a class="" href="<?php echo U('finance/finance/endOrder');?>"> <i class="fa fa-fw  fa-circle-o"></i> 完结订单</a>                        </li>                        <li data-cate="finance">                            <a class="" href="<?php echo U('finance/finance/paymentDetails');?>"> <i class="fa fa-fw  fa-circle-o"></i> 收支明细</a>                        </li>                        <li data-cate="after-sales" >                            <a class="" href="<?php echo U('afterSales/index/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>售后列表</a>                        </li>                        <li data-cate="after-sales" >                            <a class="" href="<?php echo U('afterSales/index/arbitrationList');?>"> <i class="fa fa-fw  fa-circle-o"></i>仲裁结果</a>                        </li><!--                        <li data-cate="user" >                            <a class="" href="<?php echo U('user/user/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>用户设置</a>                        </li>-->                        <li data-cate="system" >                            <a class="" href="<?php echo U('system/index/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>操作记录</a>                        </li>                        <li data-cate="system" >                            <a class="" href="<?php echo U('system/user/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 用户信息</a>                        </li>                    </ul>                </section>            </aside>            <script>                showMenu();                function showMenu() {                    var target = "<?php echo U(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME); ?>";                    target = target.toUpperCase();                    var selected = _show(target);                     //二级菜单选中标记                    if (!selected) {                //三级菜单选择                            var refUrl = $.cookie('__refUrl');                        var tmp = refUrl.split('/');                        var _target = tmp[1] + '/' + tmp[2];                        if (target.indexOf(_target) > 0) {                            _show(refUrl);                        }                        ;                    }                    function _show(target) {                        var r = 0;                                //选中标记                        $('.sidebar-menu a').removeClass('active');     //顶级菜单显示                        $('.sidebar-menu a').each(function () {                            var tmp = $(this).attr('href');                            tmp = tmp.toUpperCase();                            if (tmp == target) {                                $(this).addClass('active');                 //二级菜单显示                                var cate = $(this).parent().data('cate');                                $('.sidebar-menu').find("[data-cate='" + cate + "']").show();                                $('.navbar-static-top').find('[data-cate="' + cate + '"]').addClass('active');      //顶级菜单显示                                                            r = 1;                                return;                            }                        });                        if (r) {                                                    //二级菜单选中，记录refurl                              $.cookie('__refUrl', target, {expires: 30, path: '/'});                        }                        ;                        return r;                    }                }            </script>            <section class="content">                <section class="content">
	<ol class="breadcrumb">
		<li><i class="fa fa-dashboard"></i> 位置</li>
		<li>
			售后管理	        
		</li>
		<li>售后列表</li>
		<li>售后详情</li>
	</ol>

	<div class=" order_detail box">
		<div class="box-body table-responsive no-padding ">
			<h4 class="order_type"> 
				售后状态: <span class="text-red"><strong><?php echo ($info['status']); ?></strong></span> 
			</h4>
			<h4 class="order_type"> 订单状态: <?php echo ($order_status); ?>			
			</h4>
		</div>
	</div>
			<!--发货信息-->
	<div class=" order_detail box" style="padding-bottom:20px;">
		<div class="box-header">
			<h4 class="order_type">退货信息</h4>
		</div>
		<div class="box-body table-responsive no-padding ship_border"> 
			<div class="order_type">
				<div class="shipping_info">
					<table cellspacing="0" cellpadding="0">
						<tr>
							<td rowspan="2" colspan="1" style="padding:0;"><img src="<?php echo ($a["img_path"]); ?>"></td>
							<td colspan="4" style="padding:0 10px;"><?php echo ($goods["goods_name"]); ?></td>
						</tr>
						<tr>
							<td colspan="4" style="padding:0 10px;"><?php echo ($goods["buyer_goods_no"]); ?></td>
						</tr>
					</table>
					<table cellspacing="0" cellpadding="0">
						<tr>
							<td style="padding:0 10px;"><?php echo ($goods["sku"]); ?> </td>
							<td> 单价：￥<?php echo ($goods["shop_price"]); ?>；</td>
							<td> 数量：<?php echo ($goods["goods_num"]); ?> </td>
						</tr>
					</table>
				</div>			
			</div>
			<div class="order_type order_type_padding">
				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>发货时间：</td>
						<td><?php echo ($info["return_time"]); ?></td>
					</tr>
					<tr>
						<td>物流公司：</td>
						<td><?php echo ($info["company_name"]); ?></td>
					</tr>
					<tr>
						<td>运&nbsp;&nbsp;单&nbsp;&nbsp;号：</td>
						<td><?php echo ($info["shipping_code"]); ?></a> &nbsp;&nbsp; 
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class=" order_detail box">
		<div class="box-header">
			<h4 class="order_type">售后信息:</h4>
			<h4 class="order_type"></h4>
		</div>
		<div class="box-body table-responsive no-padding ">
			<div class="order_type">
				<p>售后单号：<?php echo ($info["id"]); ?></p>
				<p>售后时间：<?php echo ($info["addtime"]); ?></p>
				<p>售后类别：<?php echo ($info["cus_type"]); ?></p>
				<p>退货数量：<?php echo ($goods["goods_num"]); ?></p>
				<p style="color:red">退款金额：<?php echo ($info["show_refund"]); ?>元</p>
				<p>售后理由：<?php echo ($info["refund_reason"]); ?></p>
				<p>售后凭证:
					<?php if(is_array($imgs)): foreach($imgs as $key=>$q): ?><a href="<?php echo ($q["img_path"]); ?>" target="_blank"><img src="<?php echo ($q["img_thumb"]); ?>"></a><?php endforeach; endif; ?>
				</p>
				<p>
					<span style="float: left">申请说明：</span><textarea disabled="disabled" style="min-height:50px;background:#fff;border:1px solid #efefef"><?php echo ($info["remark"]); ?></textarea>
				</p>
			</div>
            <div class="order_type ">
                <p>平台审核时间：<?php echo ($info["verify_time"]); ?></p>   
                <p>供应商确认时间: <?php echo ($info["conf_time"]); ?></p>               
                <p>买家发货时间：<?php echo ($info["return_time"]); ?></p>   
                <p>供应商收货时间: <?php echo ($info["receipt_time"]); ?></p>                    
                <p>收到商品后：
                    <?php if($goods['goods_status']): ?><span><?php echo ($goods["goods_status"]); ?>；</span>
                        <span><span style="color:red">责任方</span>：<?php echo ($goods["responsible"]); ?>；</span>               
                        <span><span style="color:red">说明</span>：<?php echo ($goods["damaged"]); ?></span><?php endif; ?>   
                </p>
                <p>退款时间：<?php echo ($info["refund_money_time"]); ?></p>   <!--此处应该加一个字段，让财务来写入-->
                <p>平台仲裁时间: <?php echo ($info["arbitration_time"]); ?></p>
                <p>完成时间：<?php echo ($info["close_time"]); ?></p>
            </div> 
		</div>
	</div>


	<div class="box order_detail">
		<div class="box-header">
			<h3 class="box-title">售后操作日志</h3>
			<div class="box-tools">
				<div class="input-group order"></div>
			</div>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive no-padding">
			<table class="table table-hover">
				<tr>
					<th>操作人</th>
					<th>操作内容</th>
					<th>操作时间</th>
					<th>系统备注</th>
				</tr>
				<?php if(is_array($logs)): foreach($logs as $key=>$q): ?><tr>
						<td><?php echo ($q["user_name"]); ?></td>
						<td><?php echo ($q["action"]); ?></td>
						<td><?php echo ($q["add_time"]); ?></td>
						<td><?php echo ($q["remark"]); ?></td>
					</tr><?php endforeach; endif; ?>			
			</table>
		</div>
	</div>
</section>            </section>        </div>        <!--wrapper end-->        <script src="/Public/js/bootstrap.min.js"></script>        <script src="/Public/js/app.min.js"></script>        <script type="text/javascript" src="/Public/js/moment.js"></script><!--         // <script src="/Public/js/bootstrap-datetimepicker.min.js"></script>        // <script src="/Public/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script> -->        <script type="text/javascript" src="/Public/js/custom.js"></script>        <script type="text/javascript" src="/Public/js/layer.js"></script>    </body></html>