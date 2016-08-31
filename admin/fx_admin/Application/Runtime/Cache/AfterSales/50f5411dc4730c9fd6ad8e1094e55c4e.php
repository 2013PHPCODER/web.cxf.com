<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">
        <meta http-equiv="X-UA-Compatible" content="IE=9">
        <!-- <meta name="description" content="{if $page_description}{/if}"> -->
        <link rel="stylesheet" href="/Public/css/bootstrap.min.css">
        <link rel="stylesheet" href="/Public/css/AdminLTE.css">
        <link rel="stylesheet" href="/Public/css/font-awesome.min.css">
        <!--  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"> -->
        <link rel="stylesheet" href="/Public/css/skins/_all-skins.min.css">
        <link rel="stylesheet" href="/Public/css/skins/skin-red.css">
        <link rel="stylesheet" href="/Public/css/skins/skin-red-light.css">
        <link rel="stylesheet" href="/Public/css/bootstrap3-wysihtml5.min.css">
        
        <link rel="stylesheet" href="/Public/css/my.css">
        <link rel="stylesheet" href="/Public/css/layer.css" id="layui_layer_skinlayercss">
        <link rel="stylesheet" href="/Public/css/global.css">
        <link rel="shortcut icon" href="/Public/images/64x64.ico" type="image/x-icon" /> 
        <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
        <script src="/Public/js/global.js" type="text/javascript" charset="utf-8"></script>
        <script src="/Public/js/kkpager.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="/Public/js/WdatePicker.js" type="text/javascript" charset="utf-8"></script>
        <script src="//cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
        <script src="/Public/js/plus.js"></script>
        <style type="text/css">
            .sidebar-menu>li{display: none;}
            .navbar-static-top li{cursor: pointer;}
            .zhezhao{width: 100%;display: none; height: 100%;top: 0;left: 0; position: fixed;background: #000;opacity: .4;filter: alpha(opacity: 40);z-index: 5000;}
            .e-show-auth-main li {display: none}
        </style>
    </head>
    <div class="zhezhao"></div>
    <body class="skin-yellow-light sidebar-mini">
        <!--header start-->
        <header class="main-header">
            <a href="#" class="logo">
                <span class="logo-mini"><b>创想范</b></span>
                <span class="logo-lg"><b>创想范</b><small> 总管理后台</small></span>
            </a>
            <nav class="navbar navbar-static-top">
                <div class="navbar-nav top-bar">
                    <ul class="nav navbar-nav first-nav e-show-auth-main">
                        <li data-cate = "goods" data-show="0">
                            <a class="" href="<?php echo U('goods/goods/index');?>"><b>商品</b></a>
                        </li>
                        <li data-cate = "orders" data-show="0">
                            <a class="" href="<?php echo U('orders/orders/index');?>"><b>订单</b></a>
                        </li>
                        <li data-cate = "afterSales" data-show="0">
                            <a class="" href="<?php echo U('afterSales/index/index');?>"><b>售后</b></a>
                        </li>
                        <li data-cate = "storage" data-show="0">
                            <a class="" href="<?php echo U('storage/storage/slist');?>"><b>仓储</b></a>
                        </li>
                    <li data-cate = "finance" data-show="0">
                            <a class="" href="<?php echo U('finance/accountManage/index');?>"><b>财务</b></a>
                        </li>
                        <li data-cate = "userManage" data-show="0">
                            <a class="" href="<?php echo U('user/user/index');?>"><b>用户</b></a>
                        </li>
                        <li data-cate = "systemManage" data-show="0">
                            <a class="" href="<?php echo U('system/Power/logs');?>"><b>系统</b></a>
                        </li>
                        <li data-cate = "pageManage" data-show="0">
                            <a class="" href="<?php echo U('system/pageManage/index');?>"><b>页面</b></a>
                        </li>
                    </ul>
                </div>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class=" user user-menu"  data-cate = "home">
                            <a href="<?php echo U('system/index/index');?>" class="dropdown-toggle" >
                                <span class="hidden-xs"><?php echo session('user.name');?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo U('system/login/logout');?>">
                                <span class="hidden-xs">退出登录</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!--header end-->
        <!--wrapper start-->
        <div class="content-wrapper" style="min-height: 368px;">
            <aside class="main-sidebar">
                <section class="sidebar">
                    <ul class="sidebar-menu e-show-auth-sub">
                        <li data-cate="goods">
                            <a class="active" href="<?php echo U('goods/goods/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 商品列表</a>
                        </li>
                        <li data-cate="goods">
                            <a class="" href="<?php echo U('goods/goods/goodsRelease');?>"> <i class="fa fa-fw  fa-circle-o"></i> 发布管理</a>
                        </li>
                        <li data-cate="orders" >
                            <a class="" href="<?php echo U('orders/orders/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 订单列表</a>
                        </li>
                        <li data-cate="orders" >
                            <a class="" href="<?php echo U('orders/VirtualOrders/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 虚拟订单</a>
                        </li>
                        <li data-cate="afterSales" >
                            <a class="" href="<?php echo U('afterSales/index/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 售后列表</a>
                        </li>
                        <li data-cate="afterSales" >
                            <a class="" href="<?php echo U('afterSales/freight/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 退运费模板</a>
                        </li>
                        <li data-cate="storage" >
                            <a class="" href="<?php echo U('storage/storage/slist');?>"> <i class="fa fa-fw  fa-circle-o"></i> 仓库列表</a>
                        </li>
                        <li data-cate="storage" >
                            <a class="" href="<?php echo U('storage/storage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 发货管理</a>
                        </li>
                        <li data-cate="storage" >
                            <a class="" href="<?php echo U('storage/storage/storageManger');?>"> <i class="fa fa-fw  fa-circle-o"></i> 库存管理</a>
                        </li>
                        <li data-cate="storage" >
                            <a class="" href="<?php echo U('storage/storage/logEdit');?>"> <i class="fa fa-fw  fa-circle-o"></i> 库存变动日志</a>
                        </li>
                        <li data-cate="financial" >
                            <a class="" href="<?php echo U('finance/accountManage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 账户管理</a>
                        </li>
                        <li data-cate="financial" >
                            <a class="" href="<?php echo U('finance/collection/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 收款管理</a>
                        </li>
                        <li data-cate="financial" >
                            <a class="" href="<?php echo U('finance/payment/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 付款管理</a>
                        </li>
                        <li data-cate="userManage" >
                            <a class="" href="<?php echo U('user/user/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 分销商管理</a>
                        </li>
                        <li data-cate="userManage" >
                            <a class="" href="<?php echo U('user/user/supplierList');?>"> <i class="fa fa-fw  fa-circle-o"></i> 供应商管理</a>
                        </li>
                        <li data-cate="userManage" >
                            <a class="" href="<?php echo U('user/user/actingList');?>"> <i class="fa fa-fw  fa-circle-o"></i> 代理商管理</a>
                        </li>
                        <li data-cate="systemManage" >
                            <a class="" href="<?php echo U('system/Power/logs');?>"> <i class="fa fa-fw  fa-circle-o"></i> 操作记录</a>
                        </li>
                        <li data-cate="systemManage" >
                            <a class="" href="<?php echo U('system/Power/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 员工管理</a>
                        </li>
                        <li data-cate="systemManage" >
                            <a class="" href="<?php echo U('system/Setting/level');?>"> <i class="fa fa-fw  fa-circle-o"></i> 用户等级设置</a>
                        </li>
                        <li data-cate="systemManage" >
                            <a class="" href="<?php echo U('system/Setting/finance');?>"> <i class="fa fa-fw  fa-circle-o"></i> 财务设置</a>
                        </li>
                        <li data-cate="systemManage" >
                            <a class="" href="<?php echo U('system/Power/supplierLogs');?>"> <i class="fa fa-fw  fa-circle-o"></i> 供应商日志</a>
                        </li>                        
                        <li data-cate="pageManage" >
                            <a class="" href="<?php echo U('system/pageManage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 文章列表</a>
                        </li>
                        <li data-cate="pageManage" >
                            <a class="" href="<?php echo U('system/message/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 站内信管理</a>
                        </li>
                        <li data-cate="pageManage" >
                            <a class="" href="<?php echo U('system/pageManage/sensitive');?>"> <i class="fa fa-fw  fa-circle-o"></i> 敏感词库</a>
                        </li>
                        <li data-cate="pageManage" >
                            <a class="" href="<?php echo U('system/pageManage/service');?>"> <i class="fa fa-fw  fa-circle-o"></i> 客服账号列表</a>
                        </li>
<!--                         <li data-cate="pageManage" >
                            <a class="" href="<?php echo U('system/message/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 商品页面属性</a>
                        </li> -->
                        <li data-cate="home" >
                            <a class="" href="<?php echo U('system/index/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 个人中心</a>
                        </li>
                        <li data-cate="home" >
                            <a class="" href="<?php echo U('system/index/showAuth');?>"> <i class="fa fa-fw  fa-circle-o"></i> 我的权限</a>
                        </li>                                                                 
                    </ul>
                </section>
            </aside>
            <section class="content">
                <style>
    .btn-active{color:white;background: #f39c12; padding: 2px 5px;border-radius: 5px}
    .btn-active:hover{background: #f2c374;color: white}
    .choose_ul > li{width: 120px}
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
                        <a class="" href="<?php echo U('afterSales/index/index', ['refund'=>1, 'return'=>1, 'operator=>1']);?>" data-refund="1" data-return="1" >待平台确认</a>
                    </li>
                    <li>
                        <a class="" href="<?php echo U('afterSales/index/index', ['return'=>3]);?>" data-refund="3"> 待分销商发货</a>
                    </li>
                    <li>
                        <a class="" href="<?php echo U('afterSales/index/index', ['refund'=>9]);?>" data-refund="9">待供应商审核</a>
                    </li>
                    <li>
                        <a class="" href="<?php echo U('afterSales/index/index', ['refund'=>4, 'return'=>7, 'operator=>2']);?>" data-refund="4" data-return="7" >待平台仲裁</a>
                    </li>
                    <li>
                        <a class="" href="<?php echo U('afterSales/index/index', ['return'=>4]);?>" data-return="4" >待供应商收货</a>
                    </li>	
                    <li>
                        <a class="" href="<?php echo U('afterSales/index/index', ['return'=>6]);?>" data-return="6" >待供应商补款</a>
                    </li>
                    <li>
                        <a class="" href="<?php echo U('afterSales/index/index', ['refund'=>5, 'return'=>5]);?>" data-refund="5" data-return="5" >待平台退款</a>
                    </li>					

                    <li>
                        <a class="" href="<?php echo U('afterSales/index/index', ['refund'=>6, 'return'=>8]);?>" data-refund="6" data-return="8" >售后已完成</a>
                    </li>
                    <li>
                        <a class="" href="<?php echo U('afterSales/index/index', ['refund'=>2, 'return'=>2]);?>" data-refund="2" data-return="2" >平台已拒绝</a>
                    </li>
                </ul>
            </div>
            <div class="box-tools pull-left"></div>
        </div>
        <div class="box-body">
            <div class="row">
                <form class="form-inline" action="<?php echo U('afterSales/index/index');?>" method="get" id="aftersale-form">
                    <div class="form-group ">
                        <label for="exampleInputName2">分销商:</label>
                        <input type="text" class="form-control input-xs" name="condition[buyer_name]" value="" placeholder="输入分销商账号"></div>
                    <div class="form-group ">
                        <label for="exampleInputName2">售后理由:</label>
                        <select class="form-control input-xs" name="condition[refund_reason]">
                            <option value="">全部</option>
                            <option value="1">七天无理由</option>
                            <option value="2">质量问题</option>
                            <option value="3">其他原因</option>
                        </select>
                    </div>
                    <div class="form-group ">
                        <label for="exampleInputName2">售后类别:</label>
                        <select class="form-control input-xs" name="condition[cus_type]">
                            <option value="">全部</option>
                            <option value="2">退款</option>
                            <option value="1">退货退款</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label>申请时间:</label>
                            <input type="text" class="form-control input-xs" value="" placeholder="开始时间" id="startTime" name="condition[addtime][0]"></div>
                        <div class="form-group">
                            <label>结束时间:</label>
                            <input type="text" class="form-control input-xs" value="" placeholder="结束时间" id="endTime" name="condition[addtime][1]"></div>
                        <div class="form-group ">
                            <label for="exampleInputName2">平台:</label>
                            <select class="form-control input-xs" name="condition[shop_id]">
                                <option value="">全部</option>
                                <option value="1">星密码</option>
                                <option value="2">创想范</option>
                            </select>
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
                            <input type="button" class="btn btn-block btn-warning btn-xs" value="搜索" id="btn-search"></div>
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
                    <th>分销商账号</th>
                    <th>联系方式</th>
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
                        <td><a target="_blank" href="<?php echo U('Orders/orders/orderDetail', ['order_id'=>$q['order_id']]);?>"><?php echo ($q["order_id"]); ?></a></td>
                        <td><?php echo ($q["buyer_name"]); ?></td>
                        <td>
                            <p>QQ:<?php echo ($q["distributors_qq"]); ?></p>
                            <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo ($q["distributors_qq"]); ?>&amp;site=qq&amp;menu=yes">
                                <img border="0" src="/Public/images/qq.png" alt="点击这里给我发消息" title="点击这里给我发消息">
                            </a>
                        </td>
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
                    <?php if($q['is_arbitration']): ?><p><a href="<?php echo U('/afterSales/index/detailArbitration', ['id'=>$q['id'],'order_id'=>$q['order_id']]);?>" target="_blank">详情</a>&nbsp;</p>
                        <?php else: ?>
                        <p><a href="<?php echo U('/afterSales/index/detail', ['id'=>$q['id'],'order_id'=>$q['order_id']]);?>" target="_blank">详情</a>&nbsp;</p><?php endif; ?>
                    <?php if($q['operator']): ?><p><a href="#e-modal" data-id="<?php echo ($q["id"]); ?>" data-type="<?php echo ($q['type']); ?>" data-toggle="modal" class="e-single">审核</a></p><?php endif; ?>	
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


<div class="modal fade" id="e-modal" data-backdrop="static" data-keyboard="false"><div class="modal-dialog"><div class="modal-content row">
            <div class="modal-header col-sm-12">
                <h4 class="center e-title">审核售后订单</h3>
            </div>
            <form class="modal-body" action="<?php echo U('afterSales/index/changeStatus');?>" method="post">
                <h4>您需要确认该售后申请成立，或是拒绝该售后申请。</h4>
                <div style="padding: 10% 30%">
                    <button class="btn btn-success e-btn-confirm ">确认</button>
                    <button class="btn btn-danger e-btn-cancel pull-right">拒绝</button>				
                </div>
                <input type="hidden" name="action" id="e-input-action" value="1">

            </form> 
            <div class="modal-footer col-sm-12">
                <div class="front">

                    <button class="btn" data-dismiss="modal">关闭</button>
                </div>
            </div>
        </div></div></div>  	





<script>

    $("#btn-search").click(function () {					//搜索按钮
        var href = $('#e-menu .btn-active').attr('href');
        $(this).parents('form').attr('action', href);
        $(this).parents('form').submit();
    })

    var path = window.location.pathname;
    $('#e-menu').find('a').each(function () {						//选中三级菜单
        if ($(this).attr('href') == path) {
            $(this).addClass('btn-active');
            $('#aftersale-form input[name="return"]').val($(this).data('return'));
            $('#aftersale-form input[name="refund"]').val($(this).data('refund'));
        }
        ;
    });
    pager(<?php echo ($total); ?>);


    $('.e-btn-confirm').click(function () {
        $('#e-modal #e-input-action').val(1);
        $('#e-modal form').submit();
    })
    $('.e-btn-cancel').click(function () {
        $('#e-modal #e-input-action').val(0);
        $('#e-modal form').submit();
    })

    $('.e-single').click(function () {				//单个审核的数据处理
        var form = $('#e-modal form');
        form.find('input[name="id[]"]').remove();				//每次单审核必须清空之前数据
        form.find('input[name="type[]"]').remove();
        form.append('<input type="hidden" name="id[]" value="' + $(this).data('id') + '"/>');
        form.append('<input type="hidden" name="type[]" value="' + $(this).data('type') + '"/>');
    })

</script>
            </section>
        </div>    
    </body>



    <script>
        showMenu();
        showAuth(<?php echo json_encode(session('auth_show'));?>);
        var target = "<?php echo U(); ?>";
        target=target.toUpperCase();
        if (target.indexOf('SYSTEM/INDEX')>=0) {
            $('.user-menu').addClass('active');
        };



        function showAuth(auth){
            if (auth.all==='all') {                 //超级用户显示所有
                $('.e-show-auth-main li').show();
                return;
            };
            var target = "<?php echo U(); ?>";
            target=target.toUpperCase();
            var current_cate;

            $('.e-show-auth-main a').each(function(){
                var url=$(this).attr('href').toUpperCase();
                if (target.indexOf(url)>=0) {
                    current_cate=$(this).parent('li').data('cate');
                };
                for (var i = 0; i < auth.length; i++) {
                    if (url.indexOf(auth[i])>=0) {
                        $(this).parent('li').show();
                        $(this).parent('li').data('show', 1); 
                    };
                };
            })

            $('.e-show-auth-sub a').each(function(){
                var url=$(this).attr('href').toUpperCase();
                for (var i = 0; i < auth.length; i++) {
                    if (url.indexOf(auth[i])>=0) {                                  //拥有权限
                        var cate=$(this).parent('li').data('cate');                 //获得分类
                        $(this).parent('li').data('show', 1);                       //标记                            
                        var main=$('.e-show-auth-main [data-cate="'+cate+'"]');         
                        if (main.length>0 && main.data('show') !=1) {           //子菜单对应主菜单，如果没有显示
                           main.find('a').attr('href',$(this).attr('href'));
                           main.show();
                        };              
                    };
                if (target.indexOf(url)>=0) {
                    current_cate=$(this).parent('li').data('cate');
                };                    
                };
            })
            var sub=$('.e-show-auth-sub [data-cate="'+current_cate+'"]'); 
            sub.hide();
            sub.each(function(){
                if ($(this).data('show')) {
                    $(this).show();
                }
            })
        }

        function showMenu() {
            var target = "<?php echo U(); ?>";
            target = target.toUpperCase();

            var selected = _show(target);                     //二级菜单选中标记

            if (!selected) {                //三级菜单选择    
                var refUrl = $.cookie('__refUrl');
                var tmp = refUrl.split('/');
                var _target = tmp[1] + '/' + tmp[2];
                if (target.indexOf(_target) > 0) {
                    _show(refUrl);
                }
                ;
            }

            function _show(target) {
                var r = 0;                                //选中标记
                $('.e-show-auth-sub a').removeClass('active');     //顶级菜单显示
                $('.e-show-auth-sub a').each(function () {
                    var tmp = $(this).attr('href');
                    tmp = tmp.toUpperCase();
                    if (tmp == target) {
                        $(this).addClass('active');                 //二级菜单显示
                        var cate = $(this).parent().data('cate');
                        $('.e-show-auth-sub').find("[data-cate='" + cate + "']").show();
                        $('.e-show-auth-main').find('[data-cate="' + cate + '"]').addClass('active');      //顶级菜单显示                            
                        r = 1;
                        return;
                    }
                });
                if (r) {                                                    //二级菜单选中，记录refurl  
                    $.cookie('__refUrl', target, {expires: 30, path: '/'});
                }
                ;
                return r;
            }
        }


    </script>


    <!--wrapper end-->
    <script src="/Public/js/bootstrap.min.js"></script>
    <script src="/Public/js/app.min.js"></script>
    <script type="text/javascript" src="/Public/js/moment.js"></script>
    <script src="/Public/js/bootstrap-datetimepicker.min.js"></script>
    <script src="/Public/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
    <script type="text/javascript" src="/Public/js/custom.js"></script>
    <script type="text/javascript" src="/Public/js/layer.js"></script>    
</html>