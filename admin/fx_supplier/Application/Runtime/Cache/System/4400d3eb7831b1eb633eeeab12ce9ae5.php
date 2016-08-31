<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html><html>    <head>        <meta charset="utf-8">        <meta name="viewport" content="width=device-width, initial-scale=1">        <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">        <meta http-equiv="X-UA-Compatible" content="IE=9">        <title>创想范供应商管理后台</title>        <meta name="description" content="{if $page_description}{/if}">        <link rel="stylesheet" href="/Public/css/bootstrap.min.css">        <link rel="stylesheet" href="/Public/css/AdminLTE.css">        <link rel="stylesheet" href="/Public/css/font-awesome.min.css">        <link rel="stylesheet" href="/Public/css/skins/_all-skins.min.css">        <link rel="stylesheet" href="/Public/css/skins/skin-red.css">        <link rel="stylesheet" href="/Public/css/skins/skin-red-light.css">        <link rel="stylesheet" href="/Public/css/bootstrap3-wysihtml5.min.css">        <link rel="stylesheet" href="/Public/css/bootstrap-datetimepicker.min.css">        <link rel="stylesheet" href="/Public/css/my.css">        <link rel="stylesheet" href="/Public/css/layer.css" id="layui_layer_skinlayercss">        <link rel="stylesheet" href="/Public/css/global.css">        <link rel="shortcut icon" href="/Public/images/64x64.ico" type="image/x-icon" />         <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>        <script src="/Public/js/global.js" type="text/javascript" charset="utf-8"></script>        <script src="/Public/js/kkpager.min.js" type="text/javascript" charset="utf-8"></script>        <script src="//cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>        <script src="/Public/js/WdatePicker.js" type="text/javascript"></script>        <style type="text/css">            .sidebar-menu>li{display: none;}            .navbar-static-top li{cursor: pointer;}        </style>    </head>    <body class="skin-yellow-light sidebar-mini">        <!--header start-->        <header class="main-header">            <a href="#" class="logo">                <span class="logo-mini"><b>创想范</b></span>                <span class="logo-lg"><b>创想范</b><small> 供货商管理后台</small></span>            </a>            <nav class="navbar navbar-static-top">                <div class="navbar-nav top-bar">                    <ul class="nav navbar-nav first-nav">                        <li data-cate = "goods">                            <a class="" href="<?php echo U('goods/goods/index');?>"><b>商品</b></a>                        </li>                        <li data-cate = "order">                            <a class="" href="<?php echo U('orders/orders/index');?>"><b>订单</b></a>                        </li>						                        <li data-cate = "storage">                            <a class="" href="<?php echo U('storage/storage/index');?>"><b>仓储</b></a>                        </li>                        <li data-cate = "finance">                            <a  href="<?php echo U('finance/finance/index');?>"><b>财务</b></a>                        </li>                        <li data-cate = "after-sales">                            <a class="" href="<?php echo U('afterSales/index/index');?>"><b>售后</b></a>                        </li><!--                        <li data-cate = "user">                            <a class="" href="<?php echo U('user/user/index');?>"><b>用户管理</b></a>                        </li>-->                        <li data-cate = "system">                            <a class="" href="<?php echo U('system/index/index');?>"><b>系统</b></a>                        </li>                    </ul>                </div>                <div class="navbar-custom-menu">                    <ul class="nav navbar-nav">                        <li class=" user user-menu">                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">                                <span class="hidden-xs"><?php echo ($username); ?></span>                            </a>                        </li>                        <li>                            <a href="<?php echo U('user/login/logout');?>">                                <span class="hidden-xs">退出登录</span>                            </a>                        </li>                    </ul>                </div>            </nav>        </header>        <!--header end-->        <!--wrapper start-->        <div class="content-wrapper" style="min-height: 368px;">            <aside class="main-sidebar">                <section class="sidebar">                    <ul class="sidebar-menu">                        <li data-cate="goods">                            <a class="active" href="<?php echo U('goods/goods/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 商品列表</a>                        </li><!--                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/goodsRelease');?>"> <i class="fa fa-fw  fa-circle-o"></i> 商品发布</a>                        </li>-->                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/importGoods');?>"> <i class="fa fa-fw  fa-circle-o"></i> 新增商品</a>                        </li><!--                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/goodsNoList');?>"> <i class="fa fa-fw  fa-circle-o"></i> 货号列表</a>                        </li>-->                        <li data-cate="order" >                            <a class="" href="<?php echo U('orders/orders/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 订单列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 发货列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storage/slist');?>"> <i class="fa fa-fw  fa-circle-o"></i> 仓库设置</a>                        </li>                                                <!--li data-cate="storage" >                            <a class="" href="<?php echo U('storage/cusManage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 售后收货</a>                        </li-->                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storageManage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 库存列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storageManage/logEdit');?>"> <i class="fa fa-fw  fa-circle-o"></i> 库存修改日志</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/freight/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 物流模板</a>                        </li>                        <li data-cate="finance" >                            <a class="" href="<?php echo U('finance/finance/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 收款账户</a>                        </li>                        <li data-cate="finance" >                            <a class="" href="<?php echo U('finance/finance/endOrder');?>"> <i class="fa fa-fw  fa-circle-o"></i> 完结订单</a>                        </li>                        <li data-cate="finance">                            <a class="" href="<?php echo U('finance/finance/paymentDetails');?>"> <i class="fa fa-fw  fa-circle-o"></i> 收支明细</a>                        </li>                        <li data-cate="after-sales" >                            <a class="" href="<?php echo U('afterSales/index/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>售后列表</a>                        </li>                        <li data-cate="after-sales" >                            <a class="" href="<?php echo U('afterSales/index/arbitrationList');?>"> <i class="fa fa-fw  fa-circle-o"></i>仲裁结果</a>                        </li><!--                        <li data-cate="user" >                            <a class="" href="<?php echo U('user/user/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>用户设置</a>                        </li>-->                        <li data-cate="system" >                            <a class="" href="<?php echo U('system/index/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>操作记录</a>                        </li>                        <li data-cate="system" >                            <a class="" href="<?php echo U('system/user/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 用户信息</a>                        </li>                    </ul>                </section>            </aside>            <script>                showMenu();                function showMenu() {                    var target = "<?php echo U(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME); ?>";                    target = target.toUpperCase();                    var selected = _show(target);                     //二级菜单选中标记                    if (!selected) {                //三级菜单选择                            var refUrl = $.cookie('__refUrl');                        var tmp = refUrl.split('/');                        var _target = tmp[1] + '/' + tmp[2];                        if (target.indexOf(_target) > 0) {                            _show(refUrl);                        }                        ;                    }                    function _show(target) {                        var r = 0;                                //选中标记                        $('.sidebar-menu a').removeClass('active');     //顶级菜单显示                        $('.sidebar-menu a').each(function () {                            var tmp = $(this).attr('href');                            tmp = tmp.toUpperCase();                            if (tmp == target) {                                $(this).addClass('active');                 //二级菜单显示                                var cate = $(this).parent().data('cate');                                $('.sidebar-menu').find("[data-cate='" + cate + "']").show();                                $('.navbar-static-top').find('[data-cate="' + cate + '"]').addClass('active');      //顶级菜单显示                                                            r = 1;                                return;                            }                        });                        if (r) {                                                    //二级菜单选中，记录refurl                              $.cookie('__refUrl', target, {expires: 30, path: '/'});                        }                        ;                        return r;                    }                }            </script>            <section class="content">                <style type="text/css">
	.user-modal{display:none;z-index: 999; width: 100%;position: absolute;top: 0;left: 0;height: 100%;background: rgba(0,0,0,0.5);}
	.user-modal-box{position: relative; width: 390px;border: 1px solid #555555;margin: 0 auto;background: #fff;margin-top: 300px;}
	.user-modal-box h2{margin: 0; width: 100%;height: 50px;line-height: 50px;color: #fff;background: #f39c12;font-family: "microsoft yahei";text-align: center;}
	.user-modal-box .row{padding: 10px 20px;}
	.user-modal-box .row span{height: 30px;line-height: 30px; display: block;float: left;width: 100px;text-align: right;}
	.user-modal-box .row input{line-height: 30px;border: 1px solid rgb(221,221,221); height:30px;outline: none;width: 195px;float: left;}
	.user-modal-box .row .user-code{width: 80px;}
	.user-modal-box .row strong{margin-left: 10px; display: block;float: left;height: 30px;line-height: 30px;}
	.user-modal-box .row strong img{width: 150px;height: 30px;cursor: pointer;}
	.user-modal-box .row a{display: block;float: left;height: 30px;line-height: 30px;margin-left: 8px;}
	.user-modal-box .row  .tel-code{width: 110px;}
	.user-modal-box .row  .up-tel{border: 1px solid rgb(221,221,221);width: 100px;text-align: center;}
	.user-modal-box .row  .user-submit{margin-left: 119px; width: 110px;background: #f39c12;border: none;color: #fff;letter-spacing: 5px;font-family: "microsoft yahei";font-size: 16px;}
	.user-modal-box .row  b{display: block;height: 30px;line-height: 30px;font-family: "microsoft yahei";font-size: 14px;font-weight: normal;}
	.btn.btn-primary{margin-left: 10px;}
	#user-btn{margin-left: 119px;display: none;}
	.row-box{display: none;}
	#abolish{position: absolute;right: 10px;top:10px;color: #fff;font-family: "microsoft yahei";font-size: 20px;}
	#new-abolish{position: absolute;right: 10px;top:10px;color: #fff;font-family: "microsoft yahei";font-size: 20px;}
</style>
<div class="row">
	<label for="">账号：<span><?php echo ($account); ?></span> </label>
</div>
<div class="row">
	<label for="">手机：<span><?php echo ($mobile); ?></span>
	<?php if($mobile): ?><input type="button" class="btn btn-primary" name="" id="e-amend" value="修改" />
	<?php else: ?>
		<input type="button" class="btn btn-primary" name="" id="e-tanchuang" value="绑定" /><?php endif; ?>	
</div>



<?php if($mobile): ?><!--修改手机绑定-->
	<div class="user-modal" id="amend-user-modal">
		<div class="user-modal-box">
			<div class="old-box">
				<h2>绑定手机</h2>
				<div class="row clearfix">
					<span>原绑定手机：</span><b><?php echo ($mobile); ?></b>
				</div>
				<div class="row clearfix">
					<span>验证码：</span><input type="text" class="user-code" name="" id="captcha" value="" maxlength="8"/><strong><img src="<?php echo U('system/user/picVerify');?>" id="codeimg"/></strong>
				</div>
				<div class="row clearfix">
					<span>短信验证码：</span><input type="text" class="tel-code" name="" id="tel-code" value="" maxlength="20"/><a href="javascript:;" id="get-code" class="up-tel">获取短信验证码</a>
				</div>
				<div class="row clearfix sumbit">
					<input type="button" class="user-submit" name="" id="old-btn" value="确定" />
					<!--<input type="button" name="user-submit" class="user-submit" id="abolish" value="取消" />-->
				</div>
			</div>
			<div class="row-box">
				<div class="row clearfix">
					<span>新手机：</span><input type="text" name="" id="tel-num" value="" />
				</div>
				<!--<div class="row clearfix">
					<span>新短信验证码：</span><input type="text" class="tel-code" name="" id="new-tel-code" value="" maxlength="20"/><a href="javascript:;" id="get-new-code" class="up-tel">获取新短信验证码</a>
				</div>-->
				<div class="row clearfix">
					<span>确认新手机：</span><input type="text" name="" id="tel-num-r" value="" />
				</div>
				<div class="row clearfix sumbit">
					<input type="button" class="user-submit" name="" id="bound" value="绑定" />
					<!--<input type="button" name="user-submit" class="user-submit" id="abolish" value="取消" />-->
				</div>
			</div>
			<span id="abolish">x</span>
		</div>
	</div>

<?php else: ?>
	<!--绑定新手机-->
	<div class="user-modal" id="new-user-modal">
		<div class="user-modal-box">
			<h2>绑定手机</h2>
			<div class="row clearfix">
				<span>手机号码：</span><input type="text" name="" id="new-tel" value="" maxlength="20"/>
			</div>
			<div class="row clearfix">
				<span>验证码：</span><input type="text" class="user-code" name="" id="old-code" value="" maxlength="8"/><strong><img src="<?php echo U('system/user/picVerify');?>"/></strong>
			</div>
			<div class="row clearfix">
				<span>短信验证码：</span><input type="text" class="tel-code" name="" id="tel-old-code" value="" maxlength="20"/><a href="javascript:;" class="up-tel" id="get-old-code">获取短信验证码</a>
			</div>
			<div class="row clearfix sumbit">
				<input type="button" class="user-submit" name="" id="old-bound" value="绑定" />
				<!--<input type="button" name="user-submit" class="user-submit" id="new-abolish" value="取消" />-->
			</div>
			<span id="new-abolish">x</span>
		</div>
	</div><?php endif; ?>


<script src="/Public/js/plus.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
	
	//图形验证码 点击刷新
	$('.row strong img').click(function(){
		$(this).attr('src', '<?php echo U("System/user/picVerify");?>' + '?'+Math.random());
	})
	//绑定新手机验证
	
	$('#e-tanchuang').click(function(){  //弹窗弹出/关闭事件
		$('#new-user-modal').show();
	});
	
	$('#new-abolish').click(function(){
		$('#new-user-modal').hide();
	});



	$('#old-bound').click(function(){
//		var code_val=$('#old-code').val();
		var tel_old_code=$('#tel-old-code').val()
		var tel_val=$('#new-tel').val();
		var data={
			"mobile":$('#new-tel').val(),
			"sms":$('#tel-old-code').val()
		};
		if($('#new-tel').val()==''){
			X.notice('手机号不能为空',3)
		}else if($("#tel-old-code").val()==''){
			X.notice('短信验证码不能为空',3)
		}else{
			$.post('<?php echo U("System/user/bindMobile");?>',data,function(result){				X.notice(result.msg,3);
				if(result.status == 'success'){
					$('#new-user-modal').hide();
				}else{
					$('.row strong img').click();
					X.notice(result.msg,3);
				}
			})
		}

	})
	
	
//修改绑定手机验证
	$('#e-amend').click(function(){  //弹窗弹出/关闭事件
		$('#amend-user-modal').show();
	});
	$('#abolish').click(function(){
		$('#amend-user-modal').hide();
	});
	


	//验证手机验证码  倒计时
//验证手机验证码  倒计时
	$('#get-old-code').click(function(){
		var tel_val=$('#new-tel').val();
		if(tel_val==''){
			X.notice('请输入手机号码',3)
		}else if(tel_val.length!==11 && !tel_val.match(/^1[3-9][0-9]+$/)){
			X.notice('请输入正确的手机号码',3)
		}else if($('#old-code').val() == ''){
			X.notice('请输入验证码',3)
		}else{
		var oData={'code': $('#old-code').val(),'mobile':$('#new-tel').val()}
		$.ajax({
			type:'post', url:'<?php echo U("system/user/smsFromForm");?>', data:oData,
			success:function(e){
					X.notice(e.msg,3);
					$('.row strong img').click();
				switch(e.status){
					case 'failed':
						break;
					case 'error':
						break;
						case 'success':		//成功后的逻辑
						var n=59;
						var timer=setInterval(function(){
							if($('#new-user-modal').css('display') == 'block'){
								if(n>=0){
									$('#get-old-code').html(n+'s');
									n--;
								}else{			
									$('#get-old-code').html('请重新获取');
									clearInterval(timer);
								}								
							}else{
								clearInterval(timer);
								$('#get-old-code').html('请重新获取');	
							}							
						},1000);
						break;												
				}
			}
		})
			}
		
	
		
	})
	/*例子*/
	//两个url    <?php echo U("system/user/smsFromDb");?>---不需要从表单获得手机。 <?php echo U("system/user/smsFromForm");?>	 手机字段：mobile，验证码字段：code	---需要从表单获得手机
	$('#get-code').click(function(){
		if($('#captcha').val() == ''){
			X.notice('请输入验证码',2);
			return false;
		}
		$.ajax({
			type:'post', url:'<?php echo U("system/user/smsFromDb");?>', data:{code: $('#captcha').val()},
			success:function(e){
				X.notice(e.msg,3);
				$('.row strong img').click();
				switch(e.status){
					case 'failed':
						break;
					case 'error':
						break;
					case 'success':  //成功后的逻辑
						var n=59;
				//		console.log("0");
						var timer=setInterval(function(){
				//			console.log("1");
							if($('#amend-user-modal').css('display') == 'block'){
				//				console.log("2");
								if(n>=0){
				//					console.log("3");
									$('#get-code').html(n+'s');
									n--;
								}else{		
				//					console.log("4");
									$('#get-code').html('请重新获取');
										clearInterval(timer);
								}
									
							}else{
								clearInterval(timer);
								$('#get-new-code').html('请重新获取');	
							}
							
						},1000);
						$('.row-box').show();
						break;												
				}
			}
		})
//		return;
		
	})
	$('#old-btn').click(function(){
		if($('#captcha').val()==''){
			X.notice('验证码不能为空',3)
		}else if($('#tel-code').val()==''){
			X.notice('手机验证码不能为空',3)
		}
//		$.post(url,tel_old_code,function(result){
//			if(tel_old_code==''){
//				X.notice('请输入手机验证码',3)
//			}else if(result==1){
//					$('.old-box').hide();
//					$('.row-box').show();
//				}else{
//					X.notice('输入验证码错误',3)
//				}
//		})
	})
	$('#bound').click(function(){
//		var code_val=$('#old-code').val();
		var tel_old_code=$('#tel-old-code').val()
		var tel_val=$('#tel-num').val();
		var tel_val_r=$('#tel-num-r').val();
		var data={
			"mobile":tel_val,
			"code":tel_old_code
		};
		if($('#tel_old_code').val()==''){
			X.notice('验证码不能为空',3)
		}else if(tel_val==''){
			X.notice('手机号不能为空',3)
		}else if(tel_val_r==''){
			X.notice('确认手机号不能为空',3)
		}else if(tel_val != tel_val_r){
			X.notice('两次输入手机不一致',3)
		}else{
			$.post('<?php echo U(system/user/bindMobile);?>',data,function(result){
				X.notice(result.msg,3);
				if(result.status == 'success'){
					$('#amend-user-modal').hide();
		}
	})
		}
	})
</script>            </section>        </div>        <!--wrapper end-->        <script src="/Public/js/bootstrap.min.js"></script>        <script src="/Public/js/app.min.js"></script>        <script type="text/javascript" src="/Public/js/moment.js"></script><!--         // <script src="/Public/js/bootstrap-datetimepicker.min.js"></script>        // <script src="/Public/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script> -->        <script type="text/javascript" src="/Public/js/custom.js"></script>        <script type="text/javascript" src="/Public/js/layer.js"></script>    </body></html>