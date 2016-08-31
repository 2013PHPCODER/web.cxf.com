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
                            <a class="" href="<?php echo U('finance/finance/2');?>"> <i class="fa fa-fw  fa-circle-o"></i> 结算管理</a>
                        </li>
                        <li data-cate="financial" >
                            <a class="" href="<?php echo U('finance/Payment/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 付款管理</a>
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
                        <li data-cate="pageManage" >
                            <a class="" href="<?php echo U('system/pageManage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 文章列表</a>
                        </li>
                        <li data-cate="pageManage" >
                            <a class="" href="<?php echo U('system/pageManage/1');?>"> <i class="fa fa-fw  fa-circle-o"></i> 站内信管理</a>
                        </li>
                        <li data-cate="pageManage" >
                            <a class="" href="<?php echo U('system/pageManage/sensitive');?>"> <i class="fa fa-fw  fa-circle-o"></i> 敏感词库</a>
                        </li>
                        <li data-cate="pageManage" >
                            <a class="" href="<?php echo U('system/pageManage/service');?>"> <i class="fa fa-fw  fa-circle-o"></i> 客服账号列表</a>
                        </li>
                        <li data-cate="pageManage" >
                            <a class="" href="<?php echo U('system/pageManage/4');?>"> <i class="fa fa-fw  fa-circle-o"></i> 商品页面属性</a>
                        </li>
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
    <li><i class="fa fa-dashboard"></i> 位置</li>
    <li>个人中心</li>
</ol> 				
<div class="box-body">
    <div><a class="btn btn-success btn-xs" href="#e-modify" data-toggle="modal">修改密码</a></div>
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
                <input type="text" class="form-control input-xs e-date1" value="" name="time1">
            </div>
            <div class="form-group">
                <input type="text" class="form-control input-xs e-date2" value="" name="time2">
            </div>			
            <div id="date1" class="s-date"></div><div id="date2" class="s-date"></div>
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
                    <th>操作人</th>
                    <th>操作时间</th>
                </tr>	
            <?php if(is_array($list)): foreach($list as $key=>$q): ?><tr>
                    <th><?php echo ($q["module"]); ?></th>
                    <th><?php echo ($q["detail"]); ?></th>
                    <th><?php echo ($q["name"]); ?></th>
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