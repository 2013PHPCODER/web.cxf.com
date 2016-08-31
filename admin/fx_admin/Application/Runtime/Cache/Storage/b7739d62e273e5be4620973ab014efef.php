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
<!--                        <li data-cate="goods">
                            <a class="" href="<?php echo U('goods/goods/goodsRelease');?>"> <i class="fa fa-fw  fa-circle-o"></i> 发布管理</a>
                        </li>-->
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


            
            <section class="content">
                
    <div class="box box-warning">
        <div class="box-header with-border">
            <div class="box-title">
                <ul class="choose_ul">
                    <li><a class="<?php echo xeq(I('get.group_id',1),1,'btn btn-warning btn-xs');?>" href="<?php echo U('storage/index',array('group_id' => 1 ));?>" >所有订单</a></li>
                    <li><a class="<?php echo xeq(I('get.group_id'),2,'btn btn-warning btn-xs');?>" href="<?php echo U('storage/index',array('group_id' => 2 ));?>">待配货</a></li>
                    <li><a class="<?php echo xeq(I('get.group_id'),3,'btn btn-warning btn-xs');?>" href="<?php echo U('storage/index',array('group_id' => 3 ));?>">待分配</a></li>
                    <li><a class="<?php echo xeq(I('get.group_id'),4,'btn btn-warning btn-xs');?>" href="<?php echo U('storage/index',array('group_id' => 4 ));?>">待发货</a></li>
                    <li><a class="<?php echo xeq(I('get.group_id'),5,'btn btn-warning btn-xs');?>" href="<?php echo U('storage/index',array('group_id' => 5 ));?>">已完成</a></li>
                </ul>
            </div>
            <div class="box-tools pull-left"> </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row" >
                <form class="form-inline"  action="<?php echo U('storage/index');?>" method="get">
                    <div class="form-group">
                        <label for="exampleInputName2">仓库名称:</label>
                        <select class="form-control input-xs" name="depot">
                            <option value="">选择仓库</option>
                            <?php if(is_array($depot)): $i = 0; $__LIST__ = $depot;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$depot): $mod = ($i % 2 );++$i;?><option <?php echo xeq(I('get.depot'),$depot['id'],'selected');?> value="<?php echo ($depot["id"]); ?>"><?php echo ($depot["sname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                    <!--div class="form-group">
                        <label for="exampleInputName2">商品类目:</label>
                        <select class="form-control input-xs" name="goods_category">
                            <option value="">主类目</option>
                            <?php if(is_array($goods_category)): $i = 0; $__LIST__ = $goods_category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option <?php echo xeq(I('get.goods_category'),$vo['cid'],'selected');?> value="<?php echo ($vo["cid"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div-->
                    <div class="form-group ">
                        <label for="exampleInputName2">分销商:</label>
                        <input type="text" class="form-control input-xs" name="buyer_id" value="<?php echo I('get.buyer_id');?>">
                    </div>
                    <div class="form-group ">
                        <label for="exampleInputName2">是否备注:</label>
                        <select class="form-control input-xs" name="remark">
                            <option value="">全部</option>
                            <option value="1" <?php echo xeq(I('get.remark'),1,'selected');?>  >有备注</option>
                            <option value="2" <?php echo xeq(I('get.remark'),2,'selected');?>>无备注</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="form-group ">
                            <label for="exampleInputName2">物流公司:</label>
                            <select class="form-control input-xs" name="shipping_id">
                                <option value="">全部</option>
                                <?php if(is_array($shipping)): $i = 0; $__LIST__ = $shipping;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$shipping): $mod = ($i % 2 );++$i;?><option <?php echo xeq(I('get.shipping_id'),$shipping['shipping_code'],'selected');?> value="<?php echo ($shipping["shipping_code"]); ?>"><?php echo ($shipping["shipping_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                        <div class="form-group ">
                            <label for="exampleInputName2">面单类型:</label>
                            <select class="form-control input-xs" name="hub_type">
                                <option value="">全部</option>
                                <option <?php echo xeq(I('get.hub_type'),1,'selected');?> value="1" >传统面单</option>
                                <option <?php echo xeq(I('get.hub_type'),2,'selected');?> value="2" >电子面单</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control input-xs" name="time_type">
                                <option <?php echo xeq(I('get.time_type'),'order_time','selected');?> value="order_time">下单时间</option>
                                <option <?php echo xeq(I('get.time_type'),'con_time','selected');?> value="con_time">确认时间</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control input-xs" onClick="WdatePicker()" value="<?php echo I('get.startTime');?>" name="startTime" placeholder="开始时间">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control input-xs" onClick="WdatePicker()" value="<?php echo I('get.endTime');?>" name="endTime" placeholder="结束时间">
                        </div>
                    </div>
                    <div class="row" >
                        <div class="form-group ">
                            <label for="exampleInputName2">选择来源:</label>
                            <select class="form-control input-xs" name="shop_id">
                                <option value="">全部</option>
                                <?php if(is_array($shop)): $i = 0; $__LIST__ = $shop;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$shop): $mod = ($i % 2 );++$i;?><option <?php echo xeq(I('get.shop_id'),$shop['shop_id'],'selected');?> value="<?php echo ($shop["shop_id"]); ?>"><?php echo ($shop["shop_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control input-xs"  name="hub_search">
                                <option value="">选择关键字</option>
                                <option <?php echo xeq(I('get.hub_search'),'hub_order.order_sn','selected');?> value="hub_order.order_sn">订单号</option>
                                <!--option <?php echo xeq(I('get.hub_search'),'goods_list.goods_name','selected');?> value="goods_list.goods_name">商品名称</option>
                                <option <?php echo xeq(I('get.hub_search'),'goods_list.goods_no','selected');?> value="goods_list.goods_no">商品ID</option>
                                <option <?php echo xeq(I('get.hub_search'),'goods_list.buyer_goods_no','selected');?> value="goods_list.buyer_goods_no">商家编码</option-->
                                <option <?php echo xeq(I('get.hub_search'),'order_contact.contact_name','selected');?>  value="order_contact.contact_name">收件人姓名</option>
                                <option <?php echo xeq(I('get.hub_search'),'order_contact.tel','selected');?> value="order_contact.tel">收件人手机号</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" name="search_word" <?php echo xeq(I('get.hub_search'),'','disabled');?> class="form-control input-xs" value="<?php echo I('get.search_word');?>"  placeholder="商品名称、货号、收件人姓名、电话">
                        </div>
                        <div class="form-group">
                            <input type="submit"  class="btn btn-block btn-warning btn-xs" value="搜索">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="box-header">
            <form method="get" action="<?php echo U(ACTION_NAME,I('get.'));?>" id="print" >
                <?php switch($_GET['group_id']): case "2": ?><select name="is_print" id="" class="form-control input-xs print_select">
                        <option  value="">全部</option>
                        <option <?php echo xeq(I('get.is_print'),'2','selected');?> value= "2" >未打印</option>
                        <option <?php echo xeq(I('get.is_print'),'1','selected');?> value= "1">已打印</option>
                    </select><?php break;?>
                <?php case "4": ?><select name="shipping_is_print" id="" class="form-control input-xs print_select">
                        <option value="">全部</option>
                        <option <?php echo xeq(I('get.shipping_is_print'),'2','selected');?> value= "2" >未打印</option>
                        <option <?php echo xeq(I('get.shipping_is_print'),'1','selected');?> value= "1" >已打印</option>
                    </select><?php break;?>
                <?php default: ?>
                &nbsp;<?php endswitch;?>
            </form>
            <div class="box-tools">
                <form method="get" action="<?php echo U(ACTION_NAME,I('get.'));?>" id="sortForm">
                    <div class="input-group order">
                    </div>
                    <div class="form-group order">
                        <?php if( 1 == getPower('sort_'.I('get.group_id',1)) ) { ?>
                        <select class="form-control input-xs sort" name="sort">
                            <option value="">订单排序</option>
                            <option <?php echo xeq(I('get.sort'),'order_time~asc','selected');?> value="order_time~asc">下单时间升序</option>
                            <option <?php echo xeq(I('get.sort'),'order_time~desc','selected');?> value="order_time~desc">下单时间降序</option>
                            <option <?php echo xeq(I('get.sort'),'con_time~asc','selected');?> value="con_time~asc">确认时间升序</option>
                            <option <?php echo xeq(I('get.sort'),'con_time~desc','selected');?> value="con_time~desc">确认时间降序</option>
                        </select>
                        <?php }else{echo '&nbsp;';} ?>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <tbody>
                <tr>
                    <th align="middle"><input type="checkbox" id="checkAll"></th>
                    <th>商品</th>
                    <th class="price">单价/元</th>
                    <th class="num">数&nbsp;&nbsp;&nbsp;&nbsp;量</th>
                    <th class="total_money">总金额/元</th>
                    <th>收件人信息</th>
                    <th>发货状态</th>
                    <th>操作</th>
                </tr>
            <?php if(is_array($datas["list"])): $i = 0; $__LIST__ = $datas["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr style="background-color: #fbfbfb;">
                    <td colspan="8"><ul class="table_li">
                            <li style="width: 2%">
                                <?php if(($list["is_cus"]) != "1"): ?><input type="checkbox" name="order_id[]" class="choose" value="<?php echo ($list["order_id"]); ?>"><?php endif; ?>
                            </li>
                            <li><?php echo ($list["order_sn"]); ?></li>
                            <li>确认时间: <?php echo date('Y-m-d H:i',$list['con_time']);?></li>
                            <li style="width:4%; color:red"><?php if(($list["is_cus"]) == "1"): ?>售后中<?php else: endif; ?></li>
                            <li>备注:<?php echo ($list["memo"]); ?></li>
                        </ul></td>
                    <!--<td></td>-->
                    <!--<td></td>-->
                </tr>
                <tr>
                    <!--td style="text-align: center"><img class="table_img" src="<?php echo img_url($list['img_path'],30,40);?>"></td-->
                    <td style="text-align: center"><img class="table_img" src="<?php echo ($list["img_path"]); ?>"></td>
                    <td ><p> <?php echo ($list["goods_name"]); ?> </p>
                        <p> <?php echo ($list["buyer_goods_no"]); ?>&nbsp;&nbsp;<?php echo ($list["sku"]); ?></p>
                </td>
                <td><?php echo ($list["price"]); ?></td>
                <td><p><?php echo ($list["goods_num"]); ?></p></td>
                <td><p><?php echo ($list["cost_price"]); ?></p>
                    <p>含运费:<?php echo ($list["shipping_fee"]); ?></p></td>
                <td>
                    <p>
                        收件人:
                        <?php echo ($list["contact_name"]); ?>,<?php echo ($list["tel"]); ?>&nbsp;,<?php echo ($list["province"]); echo ($list["city"]); echo ($list["dist"]); echo ($list["contact_address"]); ?>
                    </p>
                </td>
                <td><p>
                        <?php switch($list["ship_stats"]): case "0": ?>待配货<?php break;?>
                <?php case "1": ?>待分配<?php break;?>
                <?php case "2": ?>待发货<?php break;?>
                <?php case "3": ?>已完成<?php break; endswitch;?>
                </p></td>
                <td><p> <a href="<?php echo U('orders/orders/orderDetail',array('order_id'=>$list['order_id']));?>" target="_blank">详情</a></p>
                    <p>
                        <?php if(($list["is_cus"]) != "1"): switch($list["ship_stats"]): case "0": ?><a class="one_distribution" data-id="<?php echo ($list["order_id"]); ?>" style="cursor: pointer;">配货</a>
                    &nbsp;
                    <a style="cursor: pointer;" data-id=<?php echo ($list["order_id"]); ?> class="excep">异常</a><?php break;?>
                <?php case "1": ?><a class="assign" data-id=<?php echo ($list["order_id"]); ?> style="cursor: pointer;">分配</a>&nbsp;
                    <a style="cursor: pointer;" data-id=<?php echo ($list["order_id"]); ?> class="excep" >异常</a><?php break;?>
                <?php case "2": ?><a class="send_goods" data-id=<?php echo ($list["hub_id"]); ?> style="cursor: pointer;">发货</a>
                    &nbsp; <a style="cursor: pointer;" data-id=<?php echo ($list["order_id"]); ?> class="excep" >异常</a><?php break;?>
                <?php case "3": ?><a href="https://www.baidu.com/s?wd=<?php echo ($list["shipping_code"]); echo ($list["shipping_name"]); ?> "style="cursor: pointer;" target="_blank">查看物流</a><?php break; endswitch; endif; ?>
                </p></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </div>
        <!--div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <th align="middle">主图</th>
                        <th>商品</th>
                        <th class="price">单价/元</th>
                        <th class="num">数量</th>
                        <th class="total_money">总金额/元</th>
                        <th>收件人信息</th>
                        <th>发货状态</th>
                        <th>操作</th>
                    </tr>
                <?php if(is_array($datas["list"])): $i = 0; $__LIST__ = $datas["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr style="background-color: #fbfbfb;">
                        <td colspan="6"><ul class="table_li">
                                <li><?php echo ($list["order_sn"]); ?></li>
                                <li>确认时间: <?php echo date('Y-m-d H:i',$list['con_time']);?></li>
                                <li style="width:4%; color:red"><?php if(($list["is_cus"]) == "1"): ?>售后中<?php else: endif; ?></li>
                                <li>备注:<?php echo ($list["memo"]); ?></li>
                            </ul></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><img class="table_img" src="<?php echo ($list["img_path"]); ?>"></td>
                        <td ><p> <?php echo ($list["goods_name"]); ?> </p>
                            <p> <?php echo ($list["buyer_goods_no"]); ?>&nbsp;&nbsp;<?php echo ($list["sku"]); ?>
                    </td>
                    <td><?php echo ($list["price"]); ?></td>
                    <td><p><?php echo ($list["cost_price"]); ?></p></td>
                    <td><p><?php echo ($list["order_amount"]); ?></p>
                        <p>含运费:<?php echo ($list["shipping_fee"]); ?></p></td>
                    <td>
                        <p>
                            收件人:
                            <?php echo ($list["contact_name"]); ?>,<?php echo ($list["tel"]); ?>&nbsp;,<?php echo ($list["province"]); echo ($list["city"]); echo ($list["dist"]); echo ($list["contact_address"]); ?>
                        </p>
                    </td>
                    <td><p>
                            <?php switch($list["ship_stats"]): case "0": ?>待配货<?php break;?>
                            <?php case "1": ?>待分配<?php break;?>
                            <?php case "2": ?>待发货<?php break;?>
                            <?php case "3": ?>已完成<?php break; endswitch;?>
                    </p></td>
                    <td><p> <a href="<?php echo U('orders/orders/orderDetail',array('order_id'=>$list['order_id']));?>" target="_blank">详情</a></p>
                        <p>	
                            <?php if(($list["is_cus"]) != "1"): switch($list["ship_stats"]): case "0": ?><!--<a class="one_distribution" data-id="<?php echo ($list["order_id"]); ?>" style="cursor: pointer;">配货</a>
                        &nbsp; -->
                        <a style="cursor: pointer;" data-id=<?php echo ($list["order_id"]); ?> class="excep">异常</a><?php break;?>
                    <?php case "1": ?><!--<a class="assign" data-id=<?php echo ($list["order_id"]); ?> style="cursor: pointer;">分配</a>&nbsp;-->
                        <a style="cursor: pointer;" data-id=<?php echo ($list["order_id"]); ?> class="excep" >异常</a><?php break;?>
                    <?php case "2": if( 1 == getPower('shipments_'.I('get.group_id',1)) ) { ?>
<!--                        <a class="send_goods" data-id=<?php echo ($list["hub_id"]); ?> style="cursor: pointer;">发货</a>-->
                        <?php } ?>
                        &nbsp; <a style="cursor: pointer;" data-id=<?php echo ($list["order_id"]); ?> class="excep" >异常</a><?php break;?>
                    <?php case "3": ?><a href="https://www.baidu.com/s?wd=<?php echo ($list["shipping_code"]); echo ($list["shipping_name"]); ?> "style="cursor: pointer;" target="_blank">查看物流</a><?php break; endswitch; endif; ?>
                    </p></td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
        </div-->
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
    <!-- /.box -->
</div>
<div class="hidden">
    <form target="_blank" id="getcode" action="<?php echo U('TbApi/getCode');?>">

    </form>
</div>
<object id=" CaiNiaoPrint_OB'" classid="clsid:09896DB8-1189-44B5-BADC-D6DB5286AC57" width=0 height=0 >
    <embed id="'CaiNiaoPrint_EM" TYPE="application/x-cainiaoprint" width=0 height=0></embed>
</object>

 
    <script type="text/javascript">

        $('select[name="hub_search"]').change(function (event) {
            if ('' == $(this).val()) {
                $('input[name="search_word"]').attr('disabled', true);
                $('input[name="search_word"]').val('');
            } else {
                $('input[name="search_word"]').removeAttr('disabled');
            }
        });


        var checkTaobaoLogin = function () {
            $.post("<?php echo U('TbApi/checkAcess');?>", function (data, textStatus, xhr) {
                /*optional stuff to do after success */
                if (0 == data.status) {
                    $('#getcode').submit();
                    layer.alert('请先去获取授权！', function (index) {
                        layer.close(index);
                    });
                }
                return data.status
            });
        }

//自动获取单号ship_code
        var getconcat = function () {
            if ($('input:radio:checked').val()) {
                if (0 == checkTaobaoLogin()) {
                    return false;
                }
                var postData = new Object();
                postData.order = [$("#order_id").val()];
                postData.ship_id = $('.ship_name option:selected').val();
                $.post("<?php echo U('Storage/getShipCode');?>", postData, function (result) {
                    if (1 == result.status) {
                        $('#hub_one').val(result.returnData.data[0].shipping_code);
                    }
                    if (0 == result.status) {
                        layer.tips(result.message, '.getconcatBnt', {tips: [2, '#3595CC']});
                    }
                });
            }
        }

//radio按钮，切换
        var radiochange = function (e) {
            if (e.value == 1) {
                document.getElementById('hub_one').disabled = false;
                $('#hub_two').val('');
                document.getElementById('hub_two').disabled = true;
            }
            if (e.value == 2) {
                document.getElementById('hub_one').disabled = true;
                $('#hub_one').val('');
                document.getElementById('hub_two').disabled = false;
            }
        }
//手动录入运单号
        var one_ship_code = function () {
            var a = $('input:radio:checked').val();
//手动录入
            if (a == 2) {
                var patten = new RegExp('[a-zA-Z0-9]{1,14}');
                if (patten.test($('#hub_two').val())) {
                    $('#tip').css('display', 'none');
                    var dataPost = new Object(),
                            urlPost = "<?php echo U('storage/saveOneShip');?>";
                    dataPost.order_id = $('#order_id').val();
                    dataPost.ship_code = $('#hub_two').val();
                    dataPost.ship_name = $("#ship_name option:selected").text();
                    dataPost.ship_id = $("#ship_name").val();

                    $.post(urlPost, dataPost, function (result) {
                        if (1 == result.status) {
                            layer.alert(result.message, function (index) {
                                layer.close(index);
                                location.reload();
                            });
                        }

                        if (0 == result.status) {
                            layer.alert(result.message, function (index) {
                                layer.close(index);
                                location.reload();
                            });
                        }

                    });
                } else {
                    $('#tip').css('display', '');
                    $('#hub_two').val('');
                }
            }

//自动获取
            if (a == 1) {
                layer.close();
                window.location.reload();
            }

        }


//批量分配单号
        var allAssign = function () {
            if (0 == checkTaobaoLogin()) {
                return false;
            }

            var dataPost = new Object(),
                    order = new Array();
            dataPost.type = $("#selectall").is(':checked');
            dataPost.ship_id = $("select[name='ship_name']").val();
            $('.choose:checked').each(function (index, el) {
                order[index] = $(this).val();
            });
            dataPost.order = order;
            var urlPost = "<?php echo U('storage/getAllShipCode',I('get.'));?>";
            $.post(urlPost, dataPost, function (result) {
                console.log(result);
                if (result.status == 0) {
                    layer.tips(result.message, '#btn_assign', {
                        tips: [2, '#3595CC'],
                        time: 3000
                    });

                    return false;
                }
                $('#btn_assign').prop('disabled', true);
                for (var i = 0; i < result.returnData.data.length; i++) {
                    $('#shipping_code_' + result.returnData.data[i].order_id).text(result.returnData.data[i].shipping_code);
                    $('#message_' + result.returnData.data[i].order_id).text(result.returnData.data[i].status);
                }
            }, 'JSON');
        }

//发货事件
        var sendGoods = function (val) {
            $.post("<?php echo U('storage/sendGoods');?>", {ship_code: val}, function (result) {
                if (result.status == 'ok') {
                    ///layer.tips('发货成功', '#inputEnter',{ tips: 1,style: ['background-color:#FFF8ED']});
                    layer.tips('发货成功', '#inputEnter', {
                        tips: [2, '#3595CC'],
                        time: 1000
                    });

                } else {
                    layer.tips(result.content, '#inputEnter', {
                        tips: [2, '#3595CC'],
                        time: 3000
                    });
                }

                $('#inputEnter').val('');
            }, 'json');
        }

        $(document).ready(function () {
//排序选择
            $('.sort').change(function () {
                $('#sortForm').submit();
            });
//查看是否打印
            $('.print_select').change(function () {
                $('#print').submit();
            });
//打印配货单
            $('.print_distribution').click(function () {
                if (0 == $('.choose:checked').length && false == $("#selectall").is(':checked')) {
                    layer.alert('请选择要操作的发货单');
                    return false
                }
                var data
                if ($("#selectall").is(':checked') == true) {
                    data = {type: 'all'};
                } else {
                    data = $('.choose:checked').serialize();
                }
                var urlPost = "<?php echo U('storage/printDistribution',I('get.'));?>";
                $.post(urlPost, data, function (result) {
                    layer.confirm(result, {title: '打印配货单',
                        btn: ['打印', '取消'], area: ['1000px', '600px']},
                            function () {
                                $.post("<?php echo U('storage/resultDistribution');?>", $('.print_table').serialize(), function (status) {
                                    console.log(status);
                                    var newstr = $('.layui-layer-content').html();
                                    document.body.innerHTML = newstr;
                                    if (window.print()) {
                                        //window.location.reload();
                                    } else {
                                        //window.location.reload();
                                    }
                                });
                            });
                });
                return false;

            });

//单个配货
            $('.one_distribution').click(function () {
                var hub_order_id = new Array();
                hub_order_id.push($(this).data('id'));
                layer.confirm('确认对所选订单进行配货吗?', {title: '提醒', btn: ['确认', '取消']}, function (index) {
                    $.post("<?php echo U('storage/hubDistribution');?>", {order_id: hub_order_id}, function (result) {
                        if (1 == result.status) {
                            layer.alert(result.message, function (index) {
                                layer.close(index);
                                location.reload();
                            });
                        }
                    });
                });
            });

//批量配货
            $('.distribution').click(function () {
                if (0 == $('.choose:checked').length && false == $("#selectall").is(':checked')) {
                    layer.alert('请选择要操作的订单');
                    return false;
                }
                layer.confirm('确认对所选订单进行配货吗?', {title: '提醒', btn: ['确认', '取消']}, function (index) {
                    var data
                    if ($("#selectall").is(':checked') == true) {
                        data = {type: 'all'};
                    } else {
                        data = $('.choose:checked').serialize();
                    }
                    var urlPost = "<?php echo U('storage/hubDistribution',I('get.'));?>";
                    $.post(urlPost, data, function (result) {
                        if (1 == result.status) {
                            layer.alert(result.message, function (index) {
                                layer.close(index);
                                location.reload();
                            });
                        }
                    });
                });
                return false;
            });

//分配运单号
            $('.assign').click(function () {
                var order_id = $(this).data('id');
                if (0 == $('.choose:checked').length && false == $("#selectall").is(':checked') && typeof (order_id) == "undefined") {
                    layer.alert('请选择要操作的订单');
                    return false;
                }

                //单个分配
                if (($("#selectall").is(':checked') == false && $('.choose:checked').length == 1) || ($("#selectall").is(':checked') == false && order_id)) {
                    var order = new Array();
                    if ($('.choose:checked').val()) {
                        order[0] = $('.choose:checked').val()
                    } else if (order_id) {
                        order[0] = order_id;
                    }
                    var postData = new Object();
                    postData.order_id = order[0];
                    $.post("<?php echo U('Storage/assginship');?>", postData, function (result) {
                        if (1 == result.status) {
                            layer.confirm(result.returnData, {title: "提醒", btn: ["确定"], area: ['400px', '300px']}, function (index) {
                                one_ship_code();
                            });
                        } else {
                            layer.alert(result.message);
                        }
                    });
                    return false;
                }

                //批量分配
                if ($("#selectall").is(':checked') == false && $('.choose:checked').length < 2) {
                    return false;
                }
                var dataPost = new Object(),
                        order = new Array();
                dataPost.type = $("#selectall").is(':checked');

                $('.choose:checked').each(function (index, el) {
                    order[index] = $(this).val();
                });
                dataPost.order = order;

                var urlPost = "<?php echo U('storage/assginShipAll',I('get.'));?>";
                $.post(urlPost, dataPost, function (result) {
                    if (result) {
                        layer.confirm(result, {title: "分配运单号", btn: ["确定"], area: ['800px', '500px']}, function (index) {

                            layer.close(index);
                            window.location.reload();
                        });
                    }
                });
            });

//取消分配
            $('.cancel_assign').click(function () {
                if ($('.choose:checked').serialize() || $("#selectall").is(':checked')) {
                    if ($("#selectall").is(':checked') == true) {
                        data = {type: 'all'};
                    } else {
                        data = $('.choose:checked').serialize();
                    }
                    layer.confirm('你确定要取消分配吗?', {title: '提醒', btn: ['确定', '取消']}, function () {
                        var urlPost = "<?php echo U('storage/canceShipCode',I('get.'));?>";
                        $.post(urlPost, data, function (result) {
                            var result = JSON.parse(result);
                            console.log(result);
                            var success = 0;
                            var fail = 0;
                            var cus_num = 0;
                            for (var i = 0; i < result.length; i++) {
                                if (result[i].status == 'ok') {
                                    success++;
                                } else if (result[i].status == 'fail') {
                                    fail++;
                                }
                                if (result[i].cus_num == 'cus') {
                                    cus_num++;
                                }
                            }
                            layer.alert("取消成功" + success + "条,取消失败" + fail + "条,售后中" + cus_num + "条", function () {
                                window.location.reload();
                            });

                        });
                    });
                } else {

                    layer.alert('请选择要操作的订单');
                }
            });

//打印物流单
            $('.print_ship').click(function () {
                if (false == $("#selectall").is(':checked') && 0 == $('.choose:checked').length) {
                    layer.alert('请选择要操作的发货单');
                    return false;
                }
                var dataPost = new Object(),
                        order = new Array();
                dataPost.type = $("#selectall").is(':checked');
                $('.choose:checked').each(function (index, el) {
                    order[index] = $(this).val();
                });
                dataPost.order = order;
                var urlPost = "<?php echo U('Storage/printShippingCode',I('get.'));?>";
                $.post(urlPost, dataPost, function (result) {

                    layer.confirm(result, {title: '打印物流单', btn: ['打印', '取消'], area: ['1000px', '600px']}, function () {
                        if (0 == $('.print:checked').length) {
                            layer.tips('请选择要操作的发货单', '.layui-layer-btn0', {tips: [4, '#3595CC']});
                            return false;
                        }
                        var postData = new Object(),
                                order = new Array();
                        var _class = $('.print:checked').first().attr('class');
                        var flag = true;

                        $('.print:checked').each(function (index, el) {
                            if (_class != $(this).attr('class')) {
                                layer.tips('请选择同一种快递面单类型', '.layui-layer-btn0', {tips: [4, '#3595CC']});
                                flag = false;
                            }
                        });

                        if (!flag) {
                            return;
                        }
                        $('.print:checked').each(function (index, el) {
                            order[index] = $(this).val()
                        });

                        postData.order = order;

                        if ($(".print:checked").hasClass("c_ship")) {
                            var postUrl = "<?php echo U('Storage/printTraditional');?>";
                            $.post(postUrl, postData, function (data, textStatus, xhr) {
                                layer.confirm(data, {title: "打印物流单  <a href=<?php echo U('Api/Index/getParseXML');?> target='_blank'>设置模板</a>", btn: ['打印', '取消'], move: false, area: ['1000px', '600px']}, function (index) {
                                    var order_id = new Array();
                                    $('.template_one').each(function () {
                                        order_id.push($(this).data('orderid'));
                                    });
                                    //更改打印状态
                                    $.post("<?php echo U('Storage/saveTraditional');?>", {order_id: order_id}, function (data) {
                                        var newstr = $('.layui-layer-content').html();
                                        document.body.innerHTML = newstr;
                                        if (window.print()) {
                                            window.location.reload();
                                        } else {
                                            window.location.reload();
                                        }
                                    });
                                }, function (index) {
                                    layer.close(index);
                                });
                                /*optional stuff to do after success */
                            });
                        } else {
                            var postUrl = "<?php echo U('Storage/printSingle');?>";
                            $.post(postUrl, postData, function (data, textStatus, xhr) {
                                console.log(data);
                                if (1 == data.status) {
                                    printShip(data.returnData);
                                }
                                /*optional stuff to do after success */
                            });
                        }
                    });
                });
            });



            var printShip = function (shipData) {
                var AppKey = 23392048;
                var Seller_ID = 194418657;
                var CNPrint = getCaiNiaoPrint(document.getElementById('CaiNiaoPrint_OB'), document.getElementById('CaiNiaoPrint_EM'));
                CNPrint.SET_PRINT_IDENTITY("AppKey=" + AppKey + "98801&Seller_ID=" + Seller_ID);
                CNPrint.PRINT_INITA(0, 0, 400, 800, "菜鸟电子面单打印任务"); // 此处打印任务名要全程统一
                // CNPrint.SET_PRINT_STYLE(strStyleName,varStyleValue)
                CNPrint.SET_PRINT_STYLEA("ali_waybill_cp_logo_up", "PreviewOnly", 0);
                CNPrint.SET_PRINT_STYLEA("ali_waybill_cp_logo_down", "PreviewOnly", 0);
                // CNPrint.SET_PRINT_STYLEA(0, 'Offset2Top','1');
                for (var i = 0; i < shipData.length; i++) {
                    CNPrint.SET_PRINT_MODE("CAINIAOPRINT_MODE", "CP_CODE=" + shipData[i].shipping_no + "&CONFIG=" + shipData[i].shipping_info.print_config);
                    CNPrint.SET_PRINT_CONTENT("ali_waybill_product_type", "标准快件");
                    CNPrint.SET_PRINT_CONTENT("ali_waybill_short_address", shipData[i].shipping_info.short_address);
                    //CNPrint.SET_PRINT_CONTENT("ali_waybill_package_center_name","黑龙江齐齐哈尔集散"); //集散地名 称
                    //CNPrint.SET_PRINT_CONTENT("ali_waybill_package_center_code","053277886278"); 
                    CNPrint.SET_PRINT_CONTENT("ali_waybill_send_name", shipData[i].depot.receiver_name);
                    CNPrint.SET_PRINT_CONTENT("ali_waybill_send_phone", shipData[i].depot.receiver_tel);
                    CNPrint.SET_PRINT_CONTENT("ali_waybill_shipping_address", shipData[i].depot.receiver_address);
                    CNPrint.SET_PRINT_CONTENT("ali_waybill_consignee_name", shipData[i].shipping_info.trade_order_info.consignee_name);
                    CNPrint.SET_PRINT_CONTENT("ali_waybill_consignee_phone", shipData[i].shipping_info.trade_order_info.consignee_phone);
                    CNPrint.SET_PRINT_CONTENT("ali_waybill_consignee_address", shipData[i].shipping_info.trade_order_info.consignee_address.province + shipData[i].shipping_info.trade_order_info.consignee_address.city + shipData[i].shipping_info.trade_order_info.consignee_address.area);
                    CNPrint.SET_PRINT_CONTENT("ali_waybill_waybill_code", shipData[i].shipping_code);
                    CNPrint.SET_PRINT_CONTENT("ali_waybill_shipping_branch_name", shipData[i].shipping_info.shipping_branch_name);
                    CNPrint.SET_PRINT_CONTENT("ali_waybill_shipping_branch_code", shipData[i].shipping_info.shipping_branch_code);
                    CNPrint.SET_PRINT_CONTENT("ali_waybill_ext_send_date", shipData[i].send_date); // 发件日期
                    //CNPrint.SET_PRINT_CONTENT("ali_waybill_ext_sf_biz_type","顺丰特惠"); // 业务类型(顺丰
                    //CNPrint.SET_PRINT_CONTENT("ali_waybill_shipping_address_city",shipData[i].shipping_info.trade_order_info.consignee_address.city＋shipData); // 发件城市(中国邮政)
                    //CNPrint.SET_PRINT_CONTENT("ali_waybill_service","ali_waybill_serv_dest_amount=100 元;ali_waybill_serv_cod_amount=200 元");
                    //CNPrint.SET_PRINT_CONTENT("item_name ","眼镜");// 
                    //
                    CNPrint.ADD_PRINT_TEXT('155mm', '5mm', '100mm', '10mm', shipData[i].buyer_goods_no + ',' + shipData[i].sku_serialize + "*" + shipData[i].goods_num);
                    CNPrint.ADD_PRINT_TEXT('165mm', '5mm', '100mm', '10mm', "合计：" + shipData[i].goods_num + "；[全]");
                    CNPrint.ADD_PRINT_TEXT('175mm', '5mm', '45mm', '5mm', shipData[i].order_sn);
                    CNPrint.ADD_PRINT_TEXT('170mm', '50mm', '45mm', '5mm', shipData[i].shipping_info.shipping_branch_name + "已验视");
                    CNPrint.NewPageA();
                }

                CNPrint.PREVIEWA();
                //CNPrint.PRINT(); 
            };
//发货
            $('.send_goods').click(function () {
                var str = "<div class='row'> <div class='form-group'>";
                str += "<label>运单号:</label><input type='text' name='assign' id='inputEnter'  class='form-control input-xs' value=''>";
                str += "</div></div>";
                layer.confirm(str, {title: '提醒', btn: ['确定', '取消'], area: ['300px', '200px']}, function () {
                    var val = $('#inputEnter').val();
                    if (val) {
                        sendGoods(val);
                    } else {
                        layer.close();
                        window.location.reload();
                    }
                })
                $('#inputEnter').keydown(function (event) {
                    var e = event || window.event;
                    if (e.keyCode == 13) {
                        sendGoods($(this).val());
                    }

                });
            });

//订单异常
            $('.excep').click(function () {

                var order = new Array(),
                        postData = new Object();
                order[0] = $(this).data('id');
                postData.order_id = order;
                layer.confirm('点击确认后,进入异常状态,请确认', {title: '异常操作', btn: ['确认', '取消']}, function (index) {
                    $.post("<?php echo U('order/excepOrder');?>", postData, function (result) {
                        layer.alert(result.message, {btn: ['确定']}, function () {
                            layer.close();
                            location.reload();
                        });
                    });
                });
            });
        });
    </script> 


            </section>
        </div>    
    </body>






    <!--wrapper end-->
    <script src="/Public/js/bootstrap.min.js"></script>
    <script src="/Public/js/app.min.js"></script>
    <script type="text/javascript" src="/Public/js/moment.js"></script>
<!--     // <script src="/Public/js/bootstrap-datetimepicker.min.js"></script>
    // <script src="/Public/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script> -->
    <script type="text/javascript" src="/Public/js/custom.js"></script>
    <script type="text/javascript" src="/Public/js/layer.js"></script>    
</html>