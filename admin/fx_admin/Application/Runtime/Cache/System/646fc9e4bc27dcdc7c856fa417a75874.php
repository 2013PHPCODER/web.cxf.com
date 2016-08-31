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
        <link rel="stylesheet" href="/Public/css/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" href="/Public/css/my.css">
        <link rel="stylesheet" href="/Public/css/layer.css" id="layui_layer_skinlayercss">
        <link rel="stylesheet" href="/Public/css/global.css">
        <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
        <script src="/Public/js/global.js" type="text/javascript" charset="utf-8"></script>
        <script src="/Public/js/kkpager.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="//cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
        <script src="/Public/js/plus.js"></script>
        <style type="text/css">
            .sidebar-menu>li{display: none;}
            .navbar-static-top li{cursor: pointer;}
            .zhezhao{width: 100%;display: none; height: 100%;top: 0;left: 0; position: fixed;background: #000;opacity: .4;filter: alpha(opacity: 40);z-index: 5000;}
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
                    <ul class="nav navbar-nav first-nav">
                        <li data-cate = "goods">
                            <a class="" href="<?php echo U('goods/goods/index');?>"><b>商品</b></a>
                        </li>
                        <li data-cate = "orders">
                            <a class="" href="<?php echo U('orders/orders/index');?>"><b>订单</b></a>
                        </li>
                        <li data-cate = "afterSales">
                            <a class="" href="<?php echo U('afterSales/index/index');?>"><b>售后管理</b></a>
                        </li>
                        <li data-cate = "storage">
                            <a class="" href="<?php echo U('storage/storage/slist');?>"><b>仓储</b></a>
                        </li>
                        <li data-cate = "finance">
                            <a class="" href="<?php echo U('finance/accountManage/index');?>"><b>财务管理</b></a>
                        </li>
                        <li data-cate = "userManage">
                            <a class="" href="<?php echo U('user/user/index');?>"><b>用户管理</b></a>
                        </li>
                        <li data-cate = "systemManage">
                            <a class="" href="<?php echo U('system/Power/logs');?>"><b>系统管理</b></a>
                        </li>
                        <li data-cate = "pageManage">
                            <a class="" href="<?php echo U('system/pageManage/index');?>"><b>页面设置</b></a>
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
                    <ul class="sidebar-menu">
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
                            <a class="" href="<?php echo U('userManage/1');?>"> <i class="fa fa-fw  fa-circle-o"></i> 供应商管理</a>
                        </li>
                        <li data-cate="userManage" >
                            <a class="" href="<?php echo U('userManage/2');?>"> <i class="fa fa-fw  fa-circle-o"></i> 代理商管理</a>
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
                <ol class="breadcrumb">
    <li><i class="fa fa-dashboard"></i> 客服账号</li>
    <li>修改</li>
</ol> 				

<div class="dalog-modal" id="">
    <h3>修改客服</h3>
    <div class="g-modal-content">
        <form class="form-inline" method="post" action="<?php echo U('system/pageManage/editService');?>">
            <div class="row">
                <label for="exampleInputName2">账号:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="number" class="form-control input-xs" value="<?php echo ($list["qq"]); ?>" maxlength="15"   placeholder="(15个数字以内)" name="qq">
            </div>
            <div class="row">
                <label for="exampleInputName2">类型:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                <select class="form-control input-xs" name="type">
                    <option value="">请选择</option>
                    <option value="售前" <?php echo xeq($list['type'],"售前",'selected');?>>售前</option>
                    <option value="售后" <?php echo xeq($list['type'],"售后",'selected');?>>售后</option>
                </select>
            </div>				
            <div style="margin: 20px 0">
                <label for="exampleInputName2">状态:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                是<input type="radio" class="" value="1"  name="status" <?php if(($list["status"]) == "1"): ?>checked="checked"<?php endif; ?>>&nbsp;&nbsp;&nbsp;&nbsp;
                否<input type="radio" class="" value="-1"  name="status" <?php if(($list["status"]) == "-1"): ?>checked="checked"<?php endif; ?>>
            </div>
            {__TOKEN__}
            <input name="id" value="<?php echo ($list["id"]); ?>" type="hidden">
            <div class="sub-btn"><input type="submit" class="sumb btn1 btn btn-primary" value="确定"/><input type="button" class="sumb btn-cancel btn btn-primary" value="取消"/></div>
        </form>
    </div>
</div>
<style>
.dalog-modal{font-family: "microsoft yahei"; width: 500px;margin: 0 auto;text-align: center;padding: 10px;border: 1px solid #ECECEC;}
 .dalog-modal h3{font-family: "microsoft yahei"; margin: 0; width: 100%;height: 50px;line-height: 50px;color: #fff;background: #f39c12;}   
    .s-date ul, .s-date ol, .s-date li {
        list-style: none;
        padding: 0;
        margin: 0;
    }	
    .sub-btn input{margin-left: 20px;}
    .row{font-size: 18px;}
    .row .form-control.input-xs{width: 300px;height: 30px;line-height: 30px;font-size: 18px;}
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
</script>
            </section>
        </div>    
    </body>

    <script>
        showMenu();


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
                $('.sidebar-menu a').removeClass('active');     //顶级菜单显示
                $('.sidebar-menu a').each(function () {
                    var tmp = $(this).attr('href');
                    tmp = tmp.toUpperCase();
                    if (tmp == target) {
                        $(this).addClass('active');                 //二级菜单显示
                        var cate = $(this).parent().data('cate');
                        $('.sidebar-menu').find("[data-cate='" + cate + "']").show();
                        $('.navbar-static-top').find('[data-cate="' + cate + '"]').addClass('active');      //顶级菜单显示                            
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