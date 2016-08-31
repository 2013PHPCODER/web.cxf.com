<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html><html>    <head>        <meta charset="utf-8">        <meta name="viewport" content="width=device-width, initial-scale=1">        <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">        <meta http-equiv="X-UA-Compatible" content="IE=9">        <title>创想范供应商管理后台</title>        <meta name="description" content="{if $page_description}{/if}">        <link rel="stylesheet" href="/Public/css/bootstrap.min.css">        <link rel="stylesheet" href="/Public/css/AdminLTE.css">        <link rel="stylesheet" href="/Public/css/font-awesome.min.css">        <link rel="stylesheet" href="/Public/css/skins/_all-skins.min.css">        <link rel="stylesheet" href="/Public/css/skins/skin-red.css">        <link rel="stylesheet" href="/Public/css/skins/skin-red-light.css">        <link rel="stylesheet" href="/Public/css/bootstrap3-wysihtml5.min.css">        <link rel="stylesheet" href="/Public/css/bootstrap-datetimepicker.min.css">        <link rel="stylesheet" href="/Public/css/my.css">        <link rel="stylesheet" href="/Public/css/layer.css" id="layui_layer_skinlayercss">        <link rel="stylesheet" href="/Public/css/global.css">        <link rel="shortcut icon" href="/Public/images/64x64.ico" type="image/x-icon" />         <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>        <script src="/Public/js/global.js" type="text/javascript" charset="utf-8"></script>        <script src="/Public/js/kkpager.min.js" type="text/javascript" charset="utf-8"></script>        <script src="//cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>        <script src="/Public/js/WdatePicker.js" type="text/javascript"></script>        <style type="text/css">            .sidebar-menu>li{display: none;}            .navbar-static-top li{cursor: pointer;}        </style>    </head>    <body class="skin-yellow-light sidebar-mini">        <!--header start-->        <header class="main-header">            <a href="#" class="logo">                <span class="logo-mini"><b>创想范</b></span>                <span class="logo-lg"><b>创想范</b><small> 供货商管理后台</small></span>            </a>            <nav class="navbar navbar-static-top">                <div class="navbar-nav top-bar">                    <ul class="nav navbar-nav first-nav">                        <li data-cate = "goods">                            <a class="" href="<?php echo U('goods/goods/index');?>"><b>商品</b></a>                        </li>                        <li data-cate = "order">                            <a class="" href="<?php echo U('orders/orders/index');?>"><b>订单</b></a>                        </li>						                        <li data-cate = "storage">                            <a class="" href="<?php echo U('storage/storage/index');?>"><b>仓储</b></a>                        </li>                        <li data-cate = "finance">                            <a  href="<?php echo U('finance/finance/index');?>"><b>财务</b></a>                        </li>                        <li data-cate = "after-sales">                            <a class="" href="<?php echo U('afterSales/index/index');?>"><b>售后</b></a>                        </li><!--                        <li data-cate = "user">                            <a class="" href="<?php echo U('user/user/index');?>"><b>用户管理</b></a>                        </li>-->                        <li data-cate = "system">                            <a class="" href="<?php echo U('system/index/index');?>"><b>系统</b></a>                        </li>                    </ul>                </div>                <div class="navbar-custom-menu">                    <ul class="nav navbar-nav">                        <li class=" user user-menu">                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">                                <span class="hidden-xs"><?php echo ($username); ?></span>                            </a>                        </li>                        <li>                            <a href="<?php echo U('user/login/logout');?>">                                <span class="hidden-xs">退出登录</span>                            </a>                        </li>                    </ul>                </div>            </nav>        </header>        <!--header end-->        <!--wrapper start-->        <div class="content-wrapper" style="min-height: 368px;">            <aside class="main-sidebar">                <section class="sidebar">                    <ul class="sidebar-menu">                        <li data-cate="goods">                            <a class="active" href="<?php echo U('goods/goods/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 商品列表</a>                        </li><!--                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/goodsRelease');?>"> <i class="fa fa-fw  fa-circle-o"></i> 商品发布</a>                        </li>-->                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/importGoods');?>"> <i class="fa fa-fw  fa-circle-o"></i> 新增商品</a>                        </li><!--                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/goodsNoList');?>"> <i class="fa fa-fw  fa-circle-o"></i> 货号列表</a>                        </li>-->                        <li data-cate="order" >                            <a class="" href="<?php echo U('orders/orders/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 订单列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 发货列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storage/slist');?>"> <i class="fa fa-fw  fa-circle-o"></i> 仓库设置</a>                        </li>                                                <!--li data-cate="storage" >                            <a class="" href="<?php echo U('storage/cusManage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 售后收货</a>                        </li-->                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storageManage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 库存列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storageManage/logEdit');?>"> <i class="fa fa-fw  fa-circle-o"></i> 库存修改日志</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/freight/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 物流模板</a>                        </li>                        <li data-cate="finance" >                            <a class="" href="<?php echo U('finance/finance/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 收款账户</a>                        </li>                        <li data-cate="finance" >                            <a class="" href="<?php echo U('finance/finance/endOrder');?>"> <i class="fa fa-fw  fa-circle-o"></i> 完结订单</a>                        </li>                        <li data-cate="finance">                            <a class="" href="<?php echo U('finance/finance/paymentDetails');?>"> <i class="fa fa-fw  fa-circle-o"></i> 收支明细</a>                        </li>                        <li data-cate="after-sales" >                            <a class="" href="<?php echo U('afterSales/index/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>售后列表</a>                        </li>                        <li data-cate="after-sales" >                            <a class="" href="<?php echo U('afterSales/index/arbitrationList');?>"> <i class="fa fa-fw  fa-circle-o"></i>仲裁结果</a>                        </li><!--                        <li data-cate="user" >                            <a class="" href="<?php echo U('user/user/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>用户设置</a>                        </li>-->                        <li data-cate="system" >                            <a class="" href="<?php echo U('system/index/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>操作记录</a>                        </li>                        <li data-cate="system" >                            <a class="" href="<?php echo U('system/user/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 用户信息</a>                        </li>                    </ul>                </section>            </aside>            <script>                showMenu();                function showMenu() {                    var target = "<?php echo U(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME); ?>";                    target = target.toUpperCase();                    var selected = _show(target);                     //二级菜单选中标记                    if (!selected) {                //三级菜单选择                            var refUrl = $.cookie('__refUrl');                        var tmp = refUrl.split('/');                        var _target = tmp[1] + '/' + tmp[2];                        if (target.indexOf(_target) > 0) {                            _show(refUrl);                        }                        ;                    }                    function _show(target) {                        var r = 0;                                //选中标记                        $('.sidebar-menu a').removeClass('active');     //顶级菜单显示                        $('.sidebar-menu a').each(function () {                            var tmp = $(this).attr('href');                            tmp = tmp.toUpperCase();                            if (tmp == target) {                                $(this).addClass('active');                 //二级菜单显示                                var cate = $(this).parent().data('cate');                                $('.sidebar-menu').find("[data-cate='" + cate + "']").show();                                $('.navbar-static-top').find('[data-cate="' + cate + '"]').addClass('active');      //顶级菜单显示                                                            r = 1;                                return;                            }                        });                        if (r) {                                                    //二级菜单选中，记录refurl                              $.cookie('__refUrl', target, {expires: 30, path: '/'});                        }                        ;                        return r;                    }                }            </script>            <section class="content">                <style>
	.btn-active{color:white;background: #f39c12; padding: 2px 5px;border-radius: 5px}
	.btn-active:hover{background: #f2c374;color: white}
	.choose_ul > li{width: 120px}
	.e-amount{font-size: 20px;color: red}
	.e-bukuan-info{display: none;}

	#browse_img {
		height: 50px;
		background: url(../images/news-icon3.png) no-repeat left center;
	}
	#browse_img li {
		float: left;
		width: 50px;
		height: 50px;
		list-style: none;
		position: relative;
		overflow: hidden;
		margin-right: 5px;
	}
	#browse_img img {
		width: 50px;
		height: 50px;
	}
	#browse_img li>b {
		position: absolute;
		z-index: 7;
		bottom: 0;
		right: 0;
		display: inline-block;
		background: #ff6537;
		color: #fff;
		width: 15px;
		height: 15px;
		line-height: 15px;
		text-align: center;
		border-radius: 100%;
		cursor: pointer;
	}



</style>

<section class="content">
	<ol class="breadcrumb">
		<li><i class="fa fa-dashboard"></i> 位置</li>
		<li>
			售后管理	        
		</li>
		<li>售后列表</li>
	</ol>

	<div class="box box-warning">
		<div class="box-header with-border">
			<div class="box-title">
				<ul class="choose_ul" id="e-menu">
					<li>
						<a class="" href="<?php echo U('afterSales/index/index');?>">所有售后</a>
					</li>
					<li>
						<a class="" href="<?php echo U('afterSales/index/index', ['return'=>3]);?>"  data-return="3">等待分销商发货</a>
					</li>
					<li>
						<a class="" href="<?php echo U('afterSales/index/index', ['return'=>4]);?>"  data-return="4">等待我收货</a>
					</li>					
					<li>
						<a class="" href="<?php echo U('afterSales/index/index', ['refund'=>3, 'return'=>9]);?>"   data-refund="3" data-return="9">等待我审核</a>
					</li>
					<li>
						<a class="" href="<?php echo U('afterSales/index/index', ['return'=>7, 'operator=>2']);?>"   data-return="7">等待平台仲裁</a>
					</li>

					<li>
						<a class="" href="<?php echo U('afterSales/index/index', ['return'=>6]);?>"  data-return="6">等待我补款</a>
					</li>
					<li>
						<a class="" href="<?php echo U('afterSales/index/index', [ 'return'=>5, 'refund'=>5]);?>"  data-return="5"  data-refund="5">等待平台退款</a>
					</li>					

					<li>
						<a class="" href="<?php echo U('afterSales/index/index', ['refund'=>6, 'return'=>8]);?>"  data-refund="6" data-return="8">售后已完成</a>
					</li>
					<li>
						<a class="" href="<?php echo U('afterSales/index/index', ['return'=>2]);?>"  data-return="2">仲裁后平台拒绝</a>
					</li>
				</ul>
			</div>
			<div class="box-tools pull-left"></div>
		</div>
		<div class="box-body">
			<div class="row">
				<form class="form-inline" action="<?php echo U('afterSales/index/index');?>" method="get" id="aftersale-form">
					<div class="form-group ">
						<label for="exampleInputName2">售后理由:</label>
						<select class="form-control input-xs" name="condition[refund_reason]">
							<option value="">全部</option>
							<option value="1">买家信息有误</option>
							<option value="2">买家不想要</option>
							<option value="3">7天无理由退货</option>
							<option value="4">质量问题</option>
							<option value="6">缺件，漏发</option>
							<option value="7">卖家发错货</option>
						</select>
					</div>
					<div class="form-group ">
						<label for="exampleInputName2">售后类别:</label>
						<select class="form-control input-xs" name="condition[cus_type]">
							<option value="">全部</option>
							<option value="2">退款</option>
							<option value="1">退货</option>
						</select>
					</div>
					<div class="row">
						<div class="form-group">
							<label>申请时间:</label>
							<input type="text" class="form-control input-xs e-date1" value="" placeholder="开始时间" name="condition[addtime][0]" onClick="WdatePicker()">
						</div>
						<div class="form-group">
							<label>结束时间:</label>
							<input type="text" class="form-control input-xs  e-date2" value="" placeholder="结束时间" name="condition[addtime][1]" onClick="WdatePicker()">
						</div>

						<div class="form-group">
							<select class="form-control input-xs" name="condition[key_type]">
								<option value="">选择关键字</option>
								<option value="id">售后单号</option>
								<option value="receiver_name">收件人姓名</option>
								<option value="receiver_mobile">收件人电话</option>
								<option value="shipping_code">退货物流单号</option>
								<option value="buyer_goods_no">商家编码</option>
								<option value="goods_id"> 商品ID</option>
								<option value="order_id">订单号</option>
							</select>
						</div>
						<div class="form-group">
							<input type="text" name="condition[key]"  class="form-control input-xs" value="" placeholder="商品名称、货号、收件人姓名、电话">
						</div>
						<div class="form-group">
							<input type="hidden" name="return">
							<input type="hidden" name="refund">
							<input type="button" class="btn btn-block btn-warning btn-xs" value="搜索" id="btn-search">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">&nbsp;</h3>
	<!-- 			批量操作				<div class="box-tools">
									<div class="input-group order ">
										<ul>
											<li>
												<a href="javascript:" class="btn btn-default btn-xs cusConfirm e-btn-batch">批量审核</a>
											</li>

										</ul>
									</div>
								</div> -->
							</form>	
						</div>
						<!-- /.box-header -->
						<div class="box-body table-responsive no-padding">
							<table class="table table-hover">
								<tr>
<!-- 									<th align="middle">
										<input type="checkbox" id="checkAll">
									</th> -->
									<th>售后单号</th>
									<th>售后时间</th>
									<th>订单号</th>
									<th>收件人姓名</th>
									<th>收件人电话</th>						
									<th>售后类别</th>
									<th>售后理由</th>
									<th width="100" style="word-break:break-all">售后留言</th>
									<th>退货物流单号</th>
									<th>商品ID</th>
									<th>商家编码</th>						
									<th>售后状态</th>
									<th>操作</th>
								</tr>
								<?php if(is_array($list)): foreach($list as $key=>$q): ?><tr>
										<!-- <td><input type="checkbox" class="choose" name="cus_order_id[]" value="<?php echo ($q["id"]); ?>"></td> -->
										<td><?php echo ($q["id"]); ?></td>
										<td><?php echo ($q["addtime"]); ?></td>
										<td><a target="_blank" href="<?php echo U('Orders/orders/orderDetail', ['order_id'=>$q['order_id']]);?>"><?php echo ($q["order_sn"]); ?></a></td>
										<td><?php echo ($q["receiver_name"]); ?></td>
										<td><?php echo ($q["receiver_mobile"]); ?></td>							
										<td><?php echo ($q["cus_type"]); ?></td>
										<td><?php echo ($q["refund_reason"]); ?></td>
										<td><?php echo ($q["remark"]); ?></td>
										<td><?php echo ($q["shipping_code"]); ?></td>
										<td><?php echo ($q["goods_id"]); ?></td>
										<td><?php echo ($q["buyer_goods_no"]); ?></td>							
										<td><?php echo ($q["status"]); ?></td>
										<td>
											<?php if($q['is_arbitration'] or $q['been_arbitrated']): ?><p><a href="<?php echo U('/afterSales/index/detailArbitration', ['id'=>$q['id'],'order_id'=>$q['order_id']]);?>" target="_blank">详情</a>&nbsp;</p>
												<?php else: ?>
												<p><a href="<?php echo U('/afterSales/index/detail', ['id'=>$q['id'],'order_id'=>$q['order_id']]);?>" target="_blank">详情</a>&nbsp;</p><?php endif; ?>
											<?php switch($q["operator"]): case "shouhuo": ?><p><a href="#e-shouhuo" data-id="<?php echo ($q["id"]); ?>" data-type="<?php echo ($q['type']); ?>" data-status="<?php echo ($q["status_code"]); ?>" data-reason="<?php echo ($q["reason"]); ?>" data-toggle="modal" class="e-single">确认收货</a></p><?php break;?>
												<?php case "shenhe": if($q['cus_type_code'] == 1): ?><!--退货 -->
														<p><a href="#e-shenhe" data-id="<?php echo ($q["id"]); ?>" data-type="<?php echo ($q['type']); ?>" data-status="<?php echo ($q["status_code"]); ?>" data-reason="<?php echo ($q["reason"]); ?>" data-toggle="modal" class="e-single">退货审核</a></p>
														<?php else: ?>
														<p><a href="#e-fahuo" data-id="<?php echo ($q["id"]); ?>" data-type="<?php echo ($q['type']); ?>" data-status="<?php echo ($q["status_code"]); ?>" data-reason="<?php echo ($q["reason"]); ?>" data-toggle="modal" class="e-single">退款审核</a></p><?php endif; break;?>
												<?php case "bukuan": if($q['have_replenished'] != 1): ?><p><a href="#e-bukuan" data-id="<?php echo ($q["id"]); ?>" data-type="<?php echo ($q['type']); ?>" data-status="<?php echo ($q["status_code"]); ?>" data-reason="<?php echo ($q["reason"]); ?>" data-order-id="<?php echo ($q["order_id"]); ?>" data-toggle="modal" class="e-single e-btn-bukuan">补款</a></p><?php endif; break; endswitch;?>	
										</td>
									</tr><?php endforeach; endif; ?>				
							</table>
						</div>
						<div class="box-footer">
							<div id="kkpager"></div>
						</div>
					</div>
				</div>		
			</section>


			<!-- 确认收货 -->
			<div class="modal fade" id="e-shouhuo" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog">
					<div class="modal-content row">
						<div class="modal-header col-sm-12">
							<form class="modal-body" action="<?php echo U('afterSales/ChangeStatus/comfirmReceiptGoods');?>" method="post">
								<h4 class="center e-title">收到货后，请您确认收货</h3>
									<div id="s-goods">	
										<div class="s-item">
											<span>商品是否完整</span>					
											<select name="goods_status">
												<option value="1">商品完整</option>
												<option value="2">商品有问题</option>
											</select>								
										</div>

										<div id="s-goods-detail">
											<div class="s-item">									
												<span>选择责任方</span>
												<select name="duty">
													<option value="1">仓库</option>
													<option value="2">物流</option>
													<option value="3">分销商</option>
												</select>
											</div>	
											<div class="s-item">
												<span>原因说明</span>
												<textarea name="damaged" cols="30" rows="10"></textarea>
											</div>
										</div>
									</div>
									<input type="hidden" name="id" >
									<input type="hidden" name="status">
									<input type="hidden" name="type">
									<input type="hidden" name="reason"  value="">

									<div class="modal-footer col-sm-12">
										<div class="front">
											<button class="btn btn-success" type="submit">确认</button>	
											<button class="btn" data-dismiss="modal">关闭</button>
										</div>
									</div>
								</form> 
							</div>
						</div>
					</div>
				</div>  	


				<!-- 等待我审核 -->
				<div class="modal fade" id="e-shenhe" data-backdrop="static" data-keyboard="false"><div class="modal-dialog"><div class="modal-content row">
					<div class="modal-header col-sm-12">
						<h4 class="center e-title">审核售后订单</h3>
						</div>
						<form class="modal-body" action="<?php echo U('afterSales/ChangeStatus/waitMyCheck');?>" method="post">
							<h4>您需要确认该售后申请成立，或是拒绝该售后申请。拒绝后将交由平台仲裁</h4>
							<div style="padding: 10% 30%">
								<button class="btn btn-success e-btn-approve ">同意</button>
								<button class="btn btn-danger e-btn-cancel pull-right" type="button">拒绝</button>				
							</div>
							<p>拒绝请输入拒绝的理由，同意请忽略此处</p>
							<textarea name="reason_refuse"  class="e-refuse" style="width:100%"></textarea>
							<input type="hidden" name="id" >
							<input type="hidden" name="status">
							<input type="hidden" name="type">
							<input type="hidden" name="action" id="e-input-action" value="1">
							<input type="hidden" name="reason"  value="">
							<input type="hidden" name="reason_refuse_img"  value="" id="e-input-img">
							<ul id="browse_img">
							</ul>

						</form> 
						<div class="modal-footer col-sm-12">
							<div class="front">
								<button class="btn btn-warning" id="browse">上传拒绝的凭证</button>
								<button class="btn" data-dismiss="modal">关闭</button>
							</div>
						</div>
					</div></div></div>


					<div class="modal fade" id="e-bukuan" data-backdrop="static" data-keyboard="false"><div class="modal-dialog"><div class="modal-content row">
						<div class="modal-header col-sm-12">
							<h4 class="center e-title">售后补款</h3>
							</div>
							<form class="modal-body" action="<?php echo U('afterSales/ChangeStatus/waitReplishment');?>" method="post" >
								<h4>请您填写补款给平台的凭证信息（用转款的方式转给平台，并请一次性转完后，填写转款信息）</h4>
								<div style="padding: 10% 30%">
									<div class="row clearfix">
										<span>补款金额为：</span><span class="e-amount"></span>元
									</div>
									<div class="row clearfix">
										<span>收款账号：</span>
										<select name="pay[type]" class="e-bukuan-select">
											<?php if(is_array($bukuan)): foreach($bukuan as $key=>$q): ?><option value="<?php echo ($q["platform_code"]); ?>" data-account="<?php echo ($q["account"]); ?>"><?php echo ($q["platform"]); ?></option><?php endforeach; endif; ?>	
										</select>
									</div>
									<?php if(is_array($bukuan)): foreach($bukuan as $key=>$q): ?><div class="e-bukuan-info" data-platform="<?php echo ($q["platform_code"]); ?>">
											<div class="row clearfix">
												<span><?php echo ($q["platform"]); ?>收款账号：</span><span style="color:red"><?php echo ($q["account"]); ?></span>
											</div>
											<div class="row clearfix">
												<span>收款人：</span><span style="color:red" ><?php echo ($q["name"]); ?></span>
											</div>
										</div><?php endforeach; endif; ?>
									<p>填写您的打款信息</p>								
									<div class="row clearfix">
										<span>打款账户：</span><input type="text" name="pay[account]" placeholder="您付款的账户名" />
									</div>
									<div class="row clearfix">
										<span>打款交易号：</span><input type="text" name="pay[sn]" placeholder="您付款的交易号码" />
									</div>

								</div>
								<input type="hidden" name="id" >
								<input type="hidden" name="status">
								<input type="hidden" name="type">
								<input type="hidden" name="reason">
								<input type="hidden" name="pay[target_account]" class="e-pay-target" >
								<input type="hidden" name="pay[type]" class="e-pay-type">
							</form> 
							<div class="modal-footer col-sm-12">
								<div class="front">
									<button class="btn btn-success e-btn-confirm " type="button">提交</button>	
									<button class="btn" data-dismiss="modal">关闭</button>
								</div>
							</div>
						</div></div></div>


						<div class="modal fade" id="e-fahuo" data-backdrop="static" data-keyboard="false"><div class="modal-dialog"><div class="modal-content row">
							<div class="modal-header col-sm-12">
								<h4 class="center e-title">确认是否发货</h3>
								</div>
								<form class="modal-body" action="<?php echo U('afterSales/ChangeStatus/refundLine');?>" method="post" >
									<h4>请确认您是否发货，</h4>
									<div style="padding: 10% 30%">
										<div class="row clearfix">
											<select name="is_send" id="">是否发货：
												<option value="0" selected="">没有</option>
												<option value="1" >已发货</option>
											</select>
										</div>

										<div class="e-shipping" style="display:none">
											<p>填写您的发货信息</p>								
											<div class="row clearfix">
												<select name="shipping_id" >
													<?php if(is_array($shipping)): foreach($shipping as $key=>$q): ?><option value="<?php echo ($q["shipping_id"]); ?>" data-shipping-name="<?php echo ($q["shipping_name"]); ?>"><?php echo ($q["shipping_name"]); ?></option><?php endforeach; endif; ?>	
												</select>
											</div>
											<div class="row clearfix">
												<span>物流单号：</span><input type="text" name="shipping_code" placeholder="您发货的物流单号" />
											</div>
										</div>		
									</div>
									<input type="hidden" name="id" >
									<input type="hidden" name="status">
									<input type="hidden" name="type">
									<input type="hidden" name="reason">
									<input type="hidden" name="shipping_name">
								</form> 
								<div class="modal-footer col-sm-12">
									<div class="front">
										<button class="btn btn-success e-btn-confirm " type="button">提交</button>	
										<button class="btn" data-dismiss="modal">关闭</button>
									</div>
								</div>
							</div></div></div>





							<style>
								.modal-body p{text-align: center}
								.modal-body p span{margin-right: 20px}
								#s-goods{margin: 10px;}
								#s-goods *{font-size: 15px}
								#s-goods select{width: 100px;margin: 0 auto}
								.s-item{width: 100%;margin: 10px;}
								.s-item span{width: 30%;text-align: right;display: inline-block;padding-right: 10%;color: rgb(150,150,150);}
								.s-item textarea{display: block;margin-left: 30%}
								#s-goods-detail{display: none}
							</style>

<script>

	$('#s-goods [name="goods_status"]').change(function(){
		if($(this).val() ==2){
			$('#s-goods-detail').show();
		}else{
			$('#s-goods-detail').hide();
		}
	})


	$("#btn-search").click(function(){					//搜索按钮
		var href=$('#e-menu .btn-active').attr('href');
		$(this).parents('form').attr('action', href);
		$(this).parents('form').submit();
	})

	var path=window.location.pathname;
	$('#e-menu').find('a').each(function(){
		if ($(this).attr('href')==path) {
			$(this).addClass('btn-active');
			$('#aftersale-form input[name="return"]').val($(this).data('return'));
			$('#aftersale-form input[name="refund"]').val($(this).data('refund'));				
		};
	});
	pager(<?php echo ($total); ?>);


	$('.e-btn-confirm').click(function(){
		var form=$(this).find('form');
		form.submit();
	})



	$('.e-btn-approve').click(function(){				//等待我审核的事件
		var form=$(this).parents('form');
		form.find('#e-input-action').val(1);
		form.submit();
	})


	$('.e-single').click(function(){				//单个审核的数据处理
		var modal=$(this).attr('href');
		var form=$(modal).find('form');

		var id=$(this).data('id');
		var status=$(this).data('status');	
		var reason=$(this).data('reason');
		var type=$(this).data('type');			


		form.find('input[name="id"]').val(id);		
		form.find('input[name="status"]').val(status);
		form.find('input[name="reason"]').val(reason);
		form.find('input[name="type"]').val(type);	
	})

	//补款按钮
	$('.e-btn-bukuan').click(function(){				
		$.ajax({
			type:'post', url:'<?php echo U("AfterSales/ChangeStatus/getReplishmentInfo");?>',data:{id:$(this).data('order-id')},
			success:function(data){
				$('#e-bukuan .e-amount').html(data);
			}
		})
	})

	//显示补款信息
	$('.e-bukuan-select').change(function(){
		var a=$(this).find('option:selected');
		$('.e-bukuan-info').hide();
		$('.e-bukuan-info[data-platform="'+a.val()+'"]').show();
		$('.e-pay-type').val(a.val());
		$('.e-pay-target').val(a.data('account'));

	})
	//初始化补款账户信息
	var option=$('.e-bukuan-select').find('option').eq(0);
	option.attr('selected', true);
	$('.e-bukuan-info').eq(0).show();
	$('.e-pay-type').val(option.val());
	$('.e-pay-target').val(option.data('account'));	
	
	//补款按钮专用
	$('#e-bukuan .e-btn-confirm').off('click');
	$('#e-bukuan .e-btn-confirm').click(function(){
		var invalid=$('#e-bukuan [name="pay[account]"]').val() == '' || $('#e-bukuan [name="pay[sn]"]').val() == '';
		if (invalid) {
			alert('请填写补款信息');
		}else{
			$('#e-bukuan form').submit();
		}
	})


	// 退款时候填写物流单号专用

	$('#e-fahuo .e-btn-confirm').click(function(){
		var modal=$("#e-fahuo");
		var is_send=modal.find('[name="is_send"]').val();
		if (is_send != 0) {
			if (!modal.find('[name="shipping_code"]').val()){
				alert('请填写物流信息');
				return;
			}
			var name=modal.find('[name="shipping_id"]').find('option:selected').data('shipping-name');
			modal.find('[name="shipping_name"]').val(name);
		}
		modal.find('form').submit();
	})

	$("#e-fahuo [name='is_send']").change(function(){
		if ($(this).val() != 1) {
			$('.e-shipping').hide();
		}else{
			$('.e-shipping').show();
		}	
	});

</script>


<script type="text/javascript" src="/Public/plupload-2.1.2/js/plupload.full.min.js"></script>
<script type="text/javascript" src="/Public/js/md5.js"></script>

<script>		//上传图片相关

var X = {
notice:function(mes,time){  	
    	var div = document.createElement("div");
    	div.innerHTML = mes;
    	var times = time+'000';
    	div.style.cssText+='position:fixed;z-index: 9999; top: 20%;left: 50%;opacity:0;filter: alpha(opacity:0);padding: 20px 25px;border:2px solid #fb2653; border-radius: 5px;background: #fff; color: #fb2653;font-size: 20px';
    	document.body.appendChild(div);
    	div.style.cssText+='margin-left: -'+$(div).width()*0.5+'px';
    	$(div).stop().animate({'opacity':1,'filter': 'alpha(opacity:1)'},600)	    
		setTimeout(function(){
    		 $(div).fadeOut(600);
    		 setTimeout(function(){
    		 	 document.body.removeChild(div);
    		 },600);
    	},times)
    }
}


$('.e-btn-cancel').click(function(){
	var reg =/^[\s]+$/;
	if (!$('.e-refuse').val() || reg.test($('.e-refuse').val()) || idd1.file.length == 0) {
		alert('请填写拒绝的理由以及上传拒绝凭证');
	}else{
		if (uploading) {
			alert('正在上传图片，请上传完后提交');
			return;
		};
		var form=$(this).parents('form');
		form.find('#e-input-action').val(0);		
		form.find('#e-input-img').val(idd1.file.join('|'));	
		form.submit();
	}
	
})




var uploading=0;
var idd1 = upLoadImg(['browse',true,'#browse_img','#browse',1]); 
function upLoadImg(arr,fun,callback){    //arr[btn,多传ture:单传false,图片放置位置id或class,]
	var upParameter={           
		browse_button:arr[0],             /*默认的浏览文件按钮id*/
            // resize : {width : 1000, height : 750,quality : 80},
            runtimes : 'html5,flash,silverlight,html4',
            url : 'http://v0.api.upyun.com/cxf-img-new/',
            flash_swf_url : 'plupload-2.1.2/js/Moxie.swf',
            multi_selection:arr[1],
            silverlight_xap_url : 'plupload-2.1.2/js/Moxie.xap',
            filters:{max_file_size:'10mb',prevent_duplicates:true},
            preserve_headers: true,
            multipart_params: {'policy': '','signature': ''}
        };
        var my={
        	i:0,
        	ii:0,
        	file:[],
        	previewImage:function(file,callback){
        		if(!file || !/image\//.test(file.type)) return; 
        		if(file.type=='image/gif'){
        			var fr = new mOxie.FileReader();
        			fr.onload = function(){
        				callback(fr.result);
        				fr.destroy();
        				fr = null;
        			}
        			fr.readAsDataURL(file.getSource());
        		}else{
        			var preloader = new mOxie.Image();
        			preloader.onload = function() {
        				preloader.downsize( 160, 120);
        				var imgsrc = preloader.type=='image/jpeg' ? preloader.getAsDataURL('image/jpeg',60) : preloader.getAsDataURL(); 
        				callback && callback(imgsrc);
        				preloader.destroy();
        				preloader = null;
        			};
        			preloader.load(file.getSource());
        		}	
        	},
        	del:function(n){
        		for(var i in uploader.files){
        			if(uploader.files[i].id == n){
        				var nn = i;  	  	 	 
        			}
        		}
        		uploader.removeFile(uploader.files[nn]);	   	  					  
        	},delView:function(n){
        		my.file.splice(n,1);
        		$(arr[2]+' .img-wrap').eq(n).remove();
        	}
        };	  

        var uploader=new plupload.Uploader(upParameter);
        uploader.init();
        uploader.bind('FilesAdded',function(uploader,files){
        	uploading=1;
        	if (! arr[1] && uploader.files.length>1) {
        		return false;
        	}
        	if(arr[3]){$(arr[3]).fadeOut()};
        	var data = new Date().getTime();
        	for(var i = 0;i<files.length;i++){   
        		my.file.push(md5(data+Math.random().toString()+Math.random())+'.'+files[i].type.split('/')[1])
        		!function(i){
        			my.previewImage(files[i],function(imgsrc){
        				if(arr[2] !=''){$(arr[2]).append('<li class="img-wrap"><span class="upImgMask" style="position:absolute;z-index:2;display:block;width:100%;height:100%;background:rgba(0,0,0,.5);color:#fff;line-height:50px;text-align: center;font-size: 12px;"></span><img id="'+files[i].id+'" src="'+ imgsrc +'" ><b class="imgDelete" data-id="'+files[i].id+'">-</b></li>');
//										$(arr[2]).append('<div class="col-sm-3 img-wrap" style="position: relative;"><span class="upImgMask" style="position:absolute;z-index:2;display:block;width:100%;height:100%;background:rgba(0,0,0,.5);color:#fff;line-height:120px;text-align: center;font-size: 30px;"></span><p class="imgDelete" data-id="'+files[i].id+'" style="position:absolute;right:0;top:0;width:20px;height:20px;font-size:25px;z-index:5;">X</p><img id="'+files[i].id+'" src="'+ imgsrc +'" /></div>');
//										$('#'+files[i].id).height($('#'+files[i].id).width()*3/4);	//固定高宽比
} 
})
        		}(i);
        	}            
        	var datar = {
        		'file_type':'other','file_name':my.file,'secret':false
        	}
        	$.post("<?php echo U('afterSales/ChangeStatus/getImgToken');?>",datar,function(data){
        		my.crede = data;       
//          	   uploader.settings.url = 'http://v0.api.upyun.com/imgscret';
uploader.settings.multipart_params.policy=my.crede.policy[my.i];
uploader.settings.multipart_params.signature=my.crede.sign[my.i];	
uploader.start();
})          
        });   	  
uploader.bind('UploadProgress',function(uploader,file){
	$(arr[2]+' .img-wrap').eq(my.ii).children('.upImgMask').html(file.percent + '%')
});
uploader.bind('FileUploaded',function(){
	$(arr[2]+' .img-wrap').eq(my.ii).children('.imgDelete').removeClass('imgDelete').addClass('imgOverDelete');
	$(arr[2]+' .img-wrap').eq(my.ii).children('.upImgMask').remove();
	my.i++;
	my.ii++;
	uploader.settings.multipart_params.policy=my.crede.policy[my.i];
	uploader.settings.multipart_params.signature=my.crede.sign[my.i];									
});	
uploader.bind('UploadComplete',function(uploader,file){
	uploading=0;
	X.notice('上传完成',2);
	if(arr[3]){$(arr[3]).fadeIn()};
	$('.moxie-shim').hide();          
});
uploader.bind('Error',function(uploader,file){
	X.notice('上传失败',3);
//					  my.delView(my.i);
if(arr[3]){$(arr[3]).fadeIn()};
my.del(my.i);
my.delView(my.i);
});
$(arr[2]).delegate('.imgDelete','click',function(){
	var oIndex = $(this).parent().index();
	var n = $(this).attr('data-id');
	my.del(n);
	my.delView(oIndex);						 
})
$(arr[2]).delegate('.imgOverDelete','click',function(){
	var oIndex = $(this).parent().index();
	var n = $(this).attr('data-id');
	my.delView(oIndex);
	my.del(n);
	my.i--;
	my.ii--;
})	
return my;
}

</script>            </section>        </div>        <!--wrapper end-->        <script src="/Public/js/bootstrap.min.js"></script>        <script src="/Public/js/app.min.js"></script>        <script type="text/javascript" src="/Public/js/moment.js"></script><!--         // <script src="/Public/js/bootstrap-datetimepicker.min.js"></script>        // <script src="/Public/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script> -->        <script type="text/javascript" src="/Public/js/custom.js"></script>        <script type="text/javascript" src="/Public/js/layer.js"></script>    </body></html>