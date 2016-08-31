<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html><html>    <head>        <meta charset="utf-8">        <meta name="viewport" content="width=device-width, initial-scale=1">        <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">        <meta http-equiv="X-UA-Compatible" content="IE=9">        <title>创想范供应商管理后台</title>        <meta name="description" content="{if $page_description}{/if}">        <link rel="stylesheet" href="/Public/css/bootstrap.min.css">        <link rel="stylesheet" href="/Public/css/AdminLTE.css">        <link rel="stylesheet" href="/Public/css/font-awesome.min.css">        <link rel="stylesheet" href="/Public/css/skins/_all-skins.min.css">        <link rel="stylesheet" href="/Public/css/skins/skin-red.css">        <link rel="stylesheet" href="/Public/css/skins/skin-red-light.css">        <link rel="stylesheet" href="/Public/css/bootstrap3-wysihtml5.min.css">        <link rel="stylesheet" href="/Public/css/bootstrap-datetimepicker.min.css">        <link rel="stylesheet" href="/Public/css/my.css">        <link rel="stylesheet" href="/Public/css/layer.css" id="layui_layer_skinlayercss">        <link rel="stylesheet" href="/Public/css/global.css">        <link rel="shortcut icon" href="/Public/images/64x64.ico" type="image/x-icon" />         <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>        <script src="/Public/js/global.js" type="text/javascript" charset="utf-8"></script>        <script src="/Public/js/kkpager.min.js" type="text/javascript" charset="utf-8"></script>        <script src="//cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>        <script src="/Public/js/WdatePicker.js" type="text/javascript"></script>        <style type="text/css">            .sidebar-menu>li{display: none;}            .navbar-static-top li{cursor: pointer;}        </style>    </head>    <body class="skin-yellow-light sidebar-mini">        <!--header start-->        <header class="main-header">            <a href="#" class="logo">                <span class="logo-mini"><b>创想范</b></span>                <span class="logo-lg"><b>创想范</b><small> 供货商管理后台</small></span>            </a>            <nav class="navbar navbar-static-top">                <div class="navbar-nav top-bar">                    <ul class="nav navbar-nav first-nav">                        <li data-cate = "goods">                            <a class="" href="<?php echo U('goods/goods/index');?>"><b>商品</b></a>                        </li>                        <li data-cate = "order">                            <a class="" href="<?php echo U('orders/orders/index');?>"><b>订单</b></a>                        </li>						                        <li data-cate = "storage">                            <a class="" href="<?php echo U('storage/storage/index');?>"><b>仓储</b></a>                        </li>                        <li data-cate = "finance">                            <a  href="<?php echo U('finance/finance/index');?>"><b>财务</b></a>                        </li>                        <li data-cate = "after-sales">                            <a class="" href="<?php echo U('afterSales/index/index');?>"><b>售后</b></a>                        </li><!--                        <li data-cate = "user">                            <a class="" href="<?php echo U('user/user/index');?>"><b>用户管理</b></a>                        </li>-->                        <li data-cate = "system">                            <a class="" href="<?php echo U('system/index/index');?>"><b>系统</b></a>                        </li>                    </ul>                </div>                <div class="navbar-custom-menu">                    <ul class="nav navbar-nav">                        <li class=" user user-menu">                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">                                <span class="hidden-xs"><?php echo ($username); ?></span>                            </a>                        </li>                        <li>                            <a href="<?php echo U('user/login/logout');?>">                                <span class="hidden-xs">退出登录</span>                            </a>                        </li>                    </ul>                </div>            </nav>        </header>        <!--header end-->        <!--wrapper start-->        <div class="content-wrapper" style="min-height: 368px;">            <aside class="main-sidebar">                <section class="sidebar">                    <ul class="sidebar-menu">                        <li data-cate="goods">                            <a class="active" href="<?php echo U('goods/goods/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 商品列表</a>                        </li><!--                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/goodsRelease');?>"> <i class="fa fa-fw  fa-circle-o"></i> 商品发布</a>                        </li>-->                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/importGoods');?>"> <i class="fa fa-fw  fa-circle-o"></i> 新增商品</a>                        </li><!--                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/goodsNoList');?>"> <i class="fa fa-fw  fa-circle-o"></i> 货号列表</a>                        </li>-->                        <li data-cate="order" >                            <a class="" href="<?php echo U('orders/orders/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 订单列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 发货列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storage/slist');?>"> <i class="fa fa-fw  fa-circle-o"></i> 仓库设置</a>                        </li>                                                <!--li data-cate="storage" >                            <a class="" href="<?php echo U('storage/cusManage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 售后收货</a>                        </li-->                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storageManage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 库存列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storageManage/logEdit');?>"> <i class="fa fa-fw  fa-circle-o"></i> 库存修改日志</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/freight/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 物流模板</a>                        </li>                        <li data-cate="finance" >                            <a class="" href="<?php echo U('finance/finance/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 收款账户</a>                        </li>                        <li data-cate="finance" >                            <a class="" href="<?php echo U('finance/finance/endOrder');?>"> <i class="fa fa-fw  fa-circle-o"></i> 完结订单</a>                        </li>                        <li data-cate="finance">                            <a class="" href="<?php echo U('finance/finance/paymentDetails');?>"> <i class="fa fa-fw  fa-circle-o"></i> 收支明细</a>                        </li>                        <li data-cate="after-sales" >                            <a class="" href="<?php echo U('afterSales/index/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>售后列表</a>                        </li>                        <li data-cate="after-sales" >                            <a class="" href="<?php echo U('afterSales/index/arbitrationList');?>"> <i class="fa fa-fw  fa-circle-o"></i>仲裁结果</a>                        </li><!--                        <li data-cate="user" >                            <a class="" href="<?php echo U('user/user/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>用户设置</a>                        </li>-->                        <li data-cate="system" >                            <a class="" href="<?php echo U('system/index/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>操作记录</a>                        </li>                        <li data-cate="system" >                            <a class="" href="<?php echo U('system/user/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 用户信息</a>                        </li>                    </ul>                </section>            </aside>            <script>                showMenu();                function showMenu() {                    var target = "<?php echo U(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME); ?>";                    target = target.toUpperCase();                    var selected = _show(target);                     //二级菜单选中标记                    if (!selected) {                //三级菜单选择                            var refUrl = $.cookie('__refUrl');                        var tmp = refUrl.split('/');                        var _target = tmp[1] + '/' + tmp[2];                        if (target.indexOf(_target) > 0) {                            _show(refUrl);                        }                        ;                    }                    function _show(target) {                        var r = 0;                                //选中标记                        $('.sidebar-menu a').removeClass('active');     //顶级菜单显示                        $('.sidebar-menu a').each(function () {                            var tmp = $(this).attr('href');                            tmp = tmp.toUpperCase();                            if (tmp == target) {                                $(this).addClass('active');                 //二级菜单显示                                var cate = $(this).parent().data('cate');                                $('.sidebar-menu').find("[data-cate='" + cate + "']").show();                                $('.navbar-static-top').find('[data-cate="' + cate + '"]').addClass('active');      //顶级菜单显示                                                            r = 1;                                return;                            }                        });                        if (r) {                                                    //二级菜单选中，记录refurl                              $.cookie('__refUrl', target, {expires: 30, path: '/'});                        }                        ;                        return r;                    }                }            </script>            <section class="content">                <style type="text/css">
	.dalog-modal{
		width: 100%;
		height: 100%;
		position: fixed;
		background: rgba(0,0,0,0.5);
		display: none;
		top: 0;
		left: 0;
		z-index: 999;
	}
	.dalog-container{
		width: 1000px;
		position: absolute;
		top:50%;
		left: 50%;
		margin-left: -500px;
		margin-top: -200px;
		background: #fff;
		opacity: 1;
		z-index: 9999;
	}
	.dalog-container table{
		width: 100%;
	}
	.dalog-container table th{
		height: 40px;
		background: #f39c12;
		text-align: center;
		color: #fff;
	}
	.dalog-container table td{
		height: 40px;
		text-align: center;
	}
	.dalog-container span{
		display: inline-block;
		text-align: right;
	}
	.dalog-modal{
		display: none;
	}
	.dalog-modal .g-modal-content.add-entrepot input[type="text"]{
		margin: 0;
		position: relative;
	}
	.dalog-modal .g-modal-content.add-entrepot label strong{
		margin: 0 10px;
		color: #FF2015;
		display: inline;
	}
	.dalog-modal h2{
		padding: 10px 0;
		text-align: center;
	}
	.modal-content{
		padding: 10px 0;
		font-family: "microsoft yahei";
	}
	.dalog-modal  label{
		width: 200px;
		width: 100%;
		padding: 10px 40px;
	}
	.dalog-modal label.error{
		width: 244px;
	}
	.modal-content label span{
		display: inline-block;
		width: 100px;
		text-align: right;
	}
	.dalog-modal .close{
		position: absolute;
		top: 0;
		right: 0;
		padding: 5px;
	}
	.dalog-modal .close:hover{
		cursor: pointer;
		width: 40px;
		height: 40px;
		background: #888888;
		border-radius: 5px;
		border-top-left-radius: 0;
		border-bottom-right-radius: 0;
	}
	.sub-btn{
		text-align: center;
		padding: 20px 0;
	}
	.sub-btn input{
		width: 150px;
		height: 40px;
		background: rgb(33,119,199);
		border: none;
		border-radius: 5px;
		box-shadow: 0 2px 2px #888888;
		color: #fff;
		font-family: "microsoft yahei";
		font-size: 20px;
		margin: 0 10px;
	}
	.sub-btn .abolish{background: #0097BC;}
	.sub-btn input:hover{
		box-shadow: 0 0 10px #888888;
		cursor: pointer;
	}
	.redact span{display: block;float: left;}
	.redact a{display: block;float: left;margin-left: 10px;}
.redact-adress{display: none; width: 300px;background: #fff;/*border: 1px solid #555555;*/}
.redact-adress input{margin-left: 10px;}
.s-select{width: 100%;}
.data-peaker{margin-bottom: 10px}
#add-new{position: absolute;top:-40px;right: 20px}
#e-must{display:none;}
</style>
<div class="box-body">
	<div class="row">
		<form class="form-inline" method="get" action="<?php echo U('storage/freight/index');?>" id="searchForm">
			<div class="form-group">模板名称:
				<input type="text" name="key" value="<?php if($_GET['key']){echo $_GET['key'];}?>" class="form-control input-xs" placeholder="请输入模板名称">
			</div>
			<div class="form-group btnBox">
				<input type="submit" class="btn btn-block btn-warning btn-xs" value="搜索">
			</div>
		</form>	
	</div>
	<div class="row" style="position:relative">
		<a id="add-new" href="#aleatMoudle" class="btn btn-success" >新增模板</a>
		<table class="table table-hover">
			<tbody>
				<tr>
					<th>名称</th>
					<th>计价方式</th>
					<th>是否包邮</th>
					<th>默认首重（kg）</th>
					<th>默认首重（元）</th>
					<th>默认续重（kg）</th>
					<th>默认续重（元）</th>
					<th>是否有特殊计费区域</th>
					<th>操作</th>
				</tr>
				<?php if(is_array($list)): foreach($list as $key=>$q): ?><tr>
						<td><?php echo ($q["name"]); ?></td>
						<td>重量</td>
						<td><?php echo ($q["is_free"]); ?></td>
						<td><?php echo ($q["start_heavy"]); ?></td>
						<td><?php echo ($q["start_freight"]); ?></td>
						<td><?php echo ($q["continue_heavy"]); ?></td>
						<td><?php echo ($q["continue_freight"]); ?></td>
						<td><?php echo ($q["special"]); ?></td>
						<td><a href="<?php echo U('storage/freight/detail', ['id'=>$q['id']]);?>">详情</a>	</td>
					</tr><?php endforeach; endif; ?>	
			</tbody>	
		</table>
	</div>
	<div class="box-footer">
		<div id="kkpager">
		</div>
	</div>
</div>


<div class="dalog-modal" id="aleatMoudle">
	<div class="dalog-container">
		<h2>新增物流模板</h2>
		<div class="g-modal-content">
			<form method="post" action="<?php echo U('storage/freight/add');?>" >
				<label><span>模板名称：</span><input type="text" name="name" value="" />计价方式：<sapn>按重量</sapn></label>
				<label><span>是否包邮：</span>
				<input type="radio" name="is_free" value="1" class="e-free" />是
				<input type="radio" name="is_free" value="0" checked="checked" class="e-not-free" />否</label>
				<label id="e-must"><span>默认运费：</span>
					<input class="freight" type="text" name="start_heavy" id="" value="" />
					kg以内，<input class="freight" type="text" name="start_freight" id="" value="" />
					元;
					&nbsp;&nbsp;&nbsp;&nbsp;每增加<input class="freight" type="text" name="continue_heavy" id="" value="" />
					kg，增加运费<input class="freight" type="text" name="continue_freight" id="" value="" />
					元
				</label>
				<label for="">
					<table class="red-table">
						<tr>
							<th style="width:30%">配送地区</th>
							<th>首重（kg）</th>
							<th>首费（元）</th>
							<th>续重（kg）</th>
							<th>续费（元）</th>
							<th>操作</th>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						<td ><a href="javascript:;" id="Darea" style="float:right">增加特殊地区</a></td>	
						</tr>						
 						<!--<tr>
							<td class="redact" style="width:30%">
								<div data-toggle="distpicker" class="data-peaker">
								  	<select class="form-control" id="province2" data-province="---- 选择省 ----"></select>
								  	<select class="form-control" id="city2" data-city="---- 选择市 ----"></select>
								  	<select class="form-control" id="district2" data-district="---- 选择区 ----"></select>
								</div>
							</td>
							<td><input name="sub[sub_start_heavy][]"></td>
							<td><input name="sub[sub_start_freight][]"></td>
							<td><input name="sub[sub_continue_heavy][]"></td>
							<td><input name="sub[sub_continue_freight][]"></td>
							<td><a href="javascript:;" class="removeTr">删除</a></td>
						</tr> -->
					</table>
				</label>
				<label for="">
					<div class="special">
						<div class="special-content">
							<div class="redact-adress" id="adress-group">

							</div>
						</div>
					</div>
				</label>
				<div class="sub-btn"><input type="button" class="abolish e-btn-submit btn-success" value="保存"/><input type="button" class="sumb" id="adress-btn1" value="取消" style="background:grey" /></div>
			</form>
		</div>
		<span class="close" id="dalogModalClose">×</span>
	</div>
</div>



<script src="/Public/js/distpicker.data.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/distpicker.js" type="text/javascript" charset="utf-8"></script>

<script>

	pager(<?php echo ($total); ?>);		//分页
	$('.removeTr').click(function(){
		$(this).parent().parent().remove();
	});
	$('.sumb').click(function(){
		$('#aleatMoudle').hide();
	})
	$('#add-new').click(function(){
		$('#aleatMoudle').show();
	})


$('#adress-btn2').click(function(){
	$('#adress-group').hide();
});
$('#dalogModalClose').click(function(){
	$('#aleatMoudle').hide();
});
var Oid;
$('.redactA').click(function(){
	Oid=$(this).parent().parent().index();

	$('#adress-group').fadeIn();
	$('.special').fadeIn();
})
$('#Darea').click(function(){
	var html='<tr class="e-select"><td class="redact" style="width:30%"><div data-toggle="distpicker" class="data-peaker"><select class="form-control" name="sub[province][]"></select><select class="form-control"  name="sub[city][]"></select><select class="form-control" name="sub[district][]"></select></div></td><td><input name="sub[sub_start_heavy][]"></td><td><input name="sub[sub_start_freight][]"></td><td><input name="sub[sub_continue_heavy][]"></td><td><input name="sub[sub_continue_freight][]"></td><td><a href="javascript:;" class="removeTr">删除</a></td></tr> ';
	$('.red-table>tbody').append(html)
	$(".data-peaker").distpicker();
})
$('#aleatMoudle').delegate('.removeTr', 'click', function(){
	$(this).parent().parent().remove();
});
$('#aleatMoudle').delegate('.redactA', 'click', function(){
	Oid=$(this).parent().parent().index();
	$('#adress-group').fadeIn();
	$('.special').fadeIn();
})

$('.e-not-free').click(function(){			//主信息隐藏或显示
	$('#e-must').show();
})
$('.e-free').click(function(){
	$('#e-must').hide();
})

$('.e-btn-submit').click(function(){
	if ($('input[name="name"]').val() == '') {
		alert('请填写模板名称');
		return;
	};	
	var j=0;
	if ($('input[name="is_free"]:checked').val()!= 1)  {				//包邮时候不验证物流主信息
		$('#e-must :input').each(function(){
			if ($(this).val() != '') {
				j++;
			};		
		})
		if (j !=4) {
			alert('运费信息填写不完整');
			return;
		};		
	}


	var j=1;
	$('.e-select').each(function(){
		var i=0;
		$(this).find('input').each(function(){
			if ($(this).val() != '') {
				i++;
			};
		})
		if (i != 4) {
			alert('特殊地区信息填写不完整');
			j=0;
			return;
		};
	})
	if (j) {$('#aleatMoudle form').submit();};
	
})
</script>


            </section>        </div>        <!--wrapper end-->        <script src="/Public/js/bootstrap.min.js"></script>        <script src="/Public/js/app.min.js"></script>        <script type="text/javascript" src="/Public/js/moment.js"></script><!--         // <script src="/Public/js/bootstrap-datetimepicker.min.js"></script>        // <script src="/Public/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script> -->        <script type="text/javascript" src="/Public/js/custom.js"></script>        <script type="text/javascript" src="/Public/js/layer.js"></script>    </body></html>