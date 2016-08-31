<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html><html>    <head>        <meta charset="utf-8">        <meta name="viewport" content="width=device-width, initial-scale=1">        <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">        <meta http-equiv="X-UA-Compatible" content="IE=9">        <title>创想范供应商管理后台</title>        <meta name="description" content="{if $page_description}{/if}">        <link rel="stylesheet" href="/Public/css/bootstrap.min.css">        <link rel="stylesheet" href="/Public/css/AdminLTE.css">        <link rel="stylesheet" href="/Public/css/font-awesome.min.css">        <link rel="stylesheet" href="/Public/css/skins/_all-skins.min.css">        <link rel="stylesheet" href="/Public/css/skins/skin-red.css">        <link rel="stylesheet" href="/Public/css/skins/skin-red-light.css">        <link rel="stylesheet" href="/Public/css/bootstrap3-wysihtml5.min.css">        <link rel="stylesheet" href="/Public/css/bootstrap-datetimepicker.min.css">        <link rel="stylesheet" href="/Public/css/my.css">        <link rel="stylesheet" href="/Public/css/layer.css" id="layui_layer_skinlayercss">        <link rel="stylesheet" href="/Public/css/global.css">        <link rel="shortcut icon" href="/Public/images/64x64.ico" type="image/x-icon" />         <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>        <script src="/Public/js/global.js" type="text/javascript" charset="utf-8"></script>        <script src="/Public/js/kkpager.min.js" type="text/javascript" charset="utf-8"></script>        <script src="//cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>        <script src="/Public/js/WdatePicker.js" type="text/javascript"></script>        <style type="text/css">            .sidebar-menu>li{display: none;}            .navbar-static-top li{cursor: pointer;}        </style>    </head>    <body class="skin-yellow-light sidebar-mini">        <!--header start-->        <header class="main-header">            <a href="#" class="logo">                <span class="logo-mini"><b>创想范</b></span>                <span class="logo-lg"><b>创想范</b><small> 供货商管理后台</small></span>            </a>            <nav class="navbar navbar-static-top">                <div class="navbar-nav top-bar">                    <ul class="nav navbar-nav first-nav">                        <li data-cate = "goods">                            <a class="" href="<?php echo U('goods/goods/index');?>"><b>商品</b></a>                        </li>                        <li data-cate = "order">                            <a class="" href="<?php echo U('orders/orders/index');?>"><b>订单</b></a>                        </li>						                        <li data-cate = "storage">                            <a class="" href="<?php echo U('storage/storage/index');?>"><b>仓储</b></a>                        </li>                        <li data-cate = "finance">                            <a  href="<?php echo U('finance/finance/index');?>"><b>财务</b></a>                        </li>                        <li data-cate = "after-sales">                            <a class="" href="<?php echo U('afterSales/index/index');?>"><b>售后</b></a>                        </li><!--                        <li data-cate = "user">                            <a class="" href="<?php echo U('user/user/index');?>"><b>用户管理</b></a>                        </li>-->                        <li data-cate = "system">                            <a class="" href="<?php echo U('system/index/index');?>"><b>系统</b></a>                        </li>                    </ul>                </div>                <div class="navbar-custom-menu">                    <ul class="nav navbar-nav">                        <li class=" user user-menu">                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">                                <span class="hidden-xs"><?php echo ($username); ?></span>                            </a>                        </li>                        <li>                            <a href="<?php echo U('user/login/logout');?>">                                <span class="hidden-xs">退出登录</span>                            </a>                        </li>                    </ul>                </div>            </nav>        </header>        <!--header end-->        <!--wrapper start-->        <div class="content-wrapper" style="min-height: 368px;">            <aside class="main-sidebar">                <section class="sidebar">                    <ul class="sidebar-menu">                        <li data-cate="goods">                            <a class="active" href="<?php echo U('goods/goods/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 商品列表</a>                        </li><!--                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/goodsRelease');?>"> <i class="fa fa-fw  fa-circle-o"></i> 商品发布</a>                        </li>-->                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/importGoods');?>"> <i class="fa fa-fw  fa-circle-o"></i> 新增商品</a>                        </li><!--                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/goodsNoList');?>"> <i class="fa fa-fw  fa-circle-o"></i> 货号列表</a>                        </li>-->                        <li data-cate="order" >                            <a class="" href="<?php echo U('orders/orders/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 订单列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 发货列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storage/slist');?>"> <i class="fa fa-fw  fa-circle-o"></i> 仓库设置</a>                        </li>                                                <!--li data-cate="storage" >                            <a class="" href="<?php echo U('storage/cusManage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 售后收货</a>                        </li-->                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storageManage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 库存列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storageManage/logEdit');?>"> <i class="fa fa-fw  fa-circle-o"></i> 库存修改日志</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/freight/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 物流模板</a>                        </li>                        <li data-cate="finance" >                            <a class="" href="<?php echo U('finance/finance/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 收款账户</a>                        </li>                        <li data-cate="finance" >                            <a class="" href="<?php echo U('finance/finance/endOrder');?>"> <i class="fa fa-fw  fa-circle-o"></i> 完结订单</a>                        </li>                        <li data-cate="finance">                            <a class="" href="<?php echo U('finance/finance/paymentDetails');?>"> <i class="fa fa-fw  fa-circle-o"></i> 收支明细</a>                        </li>                        <li data-cate="after-sales" >                            <a class="" href="<?php echo U('afterSales/index/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>售后列表</a>                        </li>                        <li data-cate="after-sales" >                            <a class="" href="<?php echo U('afterSales/index/arbitrationList');?>"> <i class="fa fa-fw  fa-circle-o"></i>仲裁结果</a>                        </li><!--                        <li data-cate="user" >                            <a class="" href="<?php echo U('user/user/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>用户设置</a>                        </li>-->                        <li data-cate="system" >                            <a class="" href="<?php echo U('system/index/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>操作记录</a>                        </li>                        <li data-cate="system" >                            <a class="" href="<?php echo U('system/user/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 用户信息</a>                        </li>                    </ul>                </section>            </aside>            <script>                showMenu();                function showMenu() {                    var target = "<?php echo U(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME); ?>";                    target = target.toUpperCase();                    var selected = _show(target);                     //二级菜单选中标记                    if (!selected) {                //三级菜单选择                            var refUrl = $.cookie('__refUrl');                        var tmp = refUrl.split('/');                        var _target = tmp[1] + '/' + tmp[2];                        if (target.indexOf(_target) > 0) {                            _show(refUrl);                        }                        ;                    }                    function _show(target) {                        var r = 0;                                //选中标记                        $('.sidebar-menu a').removeClass('active');     //顶级菜单显示                        $('.sidebar-menu a').each(function () {                            var tmp = $(this).attr('href');                            tmp = tmp.toUpperCase();                            if (tmp == target) {                                $(this).addClass('active');                 //二级菜单显示                                var cate = $(this).parent().data('cate');                                $('.sidebar-menu').find("[data-cate='" + cate + "']").show();                                $('.navbar-static-top').find('[data-cate="' + cate + '"]').addClass('active');      //顶级菜单显示                                                            r = 1;                                return;                            }                        });                        if (r) {                                                    //二级菜单选中，记录refurl                              $.cookie('__refUrl', target, {expires: 30, path: '/'});                        }                        ;                        return r;                    }                }            </script>            <section class="content">                <style type="text/css">
    .box-title .choose_ul>li {
        width: 98px;
    }
</style>

    <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> 位置</li>
        <li>结算管理</li>
        <li>结算单据列表</li>
    </ol>
    <div class="box-body">
        <form class="form-inline" method="get" action="" id="form_search" onsubmit="return X.toSerchVaild(this)">
            <div class="row" >
                <div class="form-group">
                    <label for="exampleInputName2">完成时间:</label>
                    <div class="form-group tmp-time-div">
                        <input type="text" class="form-control input-xs" value="<?php echo I('get.startTime');?>" placeholder='开始时间' onClick="WdatePicker()" name="startTime">
                    </div>
                    <div class="form-group tmp-time-div">
                        <input type="text" class="form-control input-xs" value="<?php echo I('get.endTime');?>" onClick="WdatePicker()" name="endTime" placeholder='结束时间'>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputName2">状态:</label>
                    <select class="form-control input-xs" name="c_status">
                        <option value="">——请选择——</option>
                        <option value="1" <?php echo xeq(I('get.c_status'), 1, 'selected');?>>未打款</option>
                        <option value="2" <?php echo xeq(I('get.c_status'), 2, 'selected');?>>已打款</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputName2">订单号</label>
                    <input type="text" class="form-control input-xs" name="order_sn" value="<?php echo I('get.order_sn');?>"  placeholder="请输入订单号">
                </div>
                <div class="form-group">
                    <input type="submit"  class="btn btn-block btn-warning btn-xs" value="搜索">
                </div>
            </div>
        </form>
    </div>
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <tbody>
                <tr>
                    <th>订单号</th>
                    <th>结算金额</th>
                    <th>完成时间</th>
                    <th>状态</th>
                    <th>下单时间</th>
                    <th>打款时间</th>
                    <th>操作</th>
                </tr>
            <?php if(is_array($datas["list"])): $i = 0; $__LIST__ = $datas["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr>
                    <td><?php echo ($list["source_sn"]); ?></td>
                    <td><?php echo number_format($list['repay'], 2, '.', '');?></td>
                    <td><?php if(!empty($list['finnshed_time'])){ echo date('Y-m-d H:i:s',$list['finnshed_time']);}else{ echo '--'; }?></td>
                    <td>
                        <?php if(($list["status"]) == "1"): ?>待打款<?php endif; ?>
                        <?php if(($list["status"]) == "2"): ?>已打款<?php endif; ?>
                        <?php if(($list["status"]) == "3"): ?>打款失败<?php endif; ?>
                    </td>
                    <td><?php echo date('Y-m-d H:i:s',$list['add_time']);?></td>
                    <td><?php if(!empty($list['deal_time'])){ echo date('Y-m-d H:i:s',$list['deal_time']);}else{ echo '--'; }?></td>
                    <td><a onclick="fqy_gysLook('<?php echo ($list["source_sn"]); ?>')">查看</a></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
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
            <div class="pagination"> <?php echo ($datas["page"]); ?> </div>
        </div>
    </div>
</div>
<!--弹窗Start-->
<div class="fqy_Mask">
    <div class="fqy_Popup">
        <div class="fqy_wjdd">
            <div class="fqy_popHead">
                <b>查看订单</b>
                <span class="fqy_popClose">×</span>
            </div>
            <div class="fqy_popContent">
                <div class="box-body fqy_wjdd">
                    <div class="fqy_setTab">
                        <p><b>商品详情</b></p>
                        <div class="row">
                            <table class="table table-hover details-table">
                                <tbody>
                                    <tr>
                                        <th>商品ID</th>
                                        <th>商品名称</th>
                                        <th>商品数量</th>
                                        <th>成本价（单价）</th>
                                        <th>小计</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <p class="fqy_canlce"><button>确认</button></p>
            </div>
        </div>
        <div class="fqy_qrdd">
            <div class="fqy_popHead">
                <b>确认订单</b>
                <span class="fqy_popClose">×</span>
            </div>
            <div class="fqy_popContent">
                <p class="fqy_qrdd">已确认该业务单据无误，可打款？</p>
                <p class="fqy_canlce"><button>确认</button> &nbsp;&nbsp;&nbsp; <button>取消</button></p>
            </div>
        </div>
    </div>
</div>
<!--弹窗End-->

<script>    
    $('select[name="order_search"]').change(function (event) {
        /* Act on the event */
        if ('' == $(this).val()) {
            $('input[name="search_word"]').attr('disabled', true);
            $('input[name="search_word"]').val('');
        } else {
            $('input[name="search_word"]').removeAttr('disabled');
        }
    });

    var i = 1;
    function fqy_gysLook(order_sn) {
        $.get("<?php echo U('finance/finance/getOrderInfo');?>", {order_sn: order_sn}, function (result) {
            //查看订单-商品详情
            var goods = result.returnData.goods;
            var str_goods = '';
            var tmp_goods;
            $.each(goods, function (n, value) {
                var total = value.distribution_price * value.goods_num;
                str_goods = "<tr class='tmp_tr_goods'><td>" + value.goods_id + "</td><td>" + value.goods_name + "</td><td>"
                        + value.goods_num + "</td><td>" + value.distribution_price + "</td><td>" + total + "</td></tr>";
                tmp_goods += str_goods;
            });
            $(".tmp_tr_goods").remove();
            $(".details-table").children('tbody').append(tmp_goods);
            //查看订单-订单详情
            i++;

            var order = result.returnData.order;
            var str_order = "<div class='tmp_div_order'><p><b>订单号：" + order.order_sn
                    + "</b></p><p><b>生成时间：" + getLocalTime(order.pay_time) + "</b></p><p><b>打款时间："
                    + getLocalTime(order.pay_time) + "</b></p><p><b style='font - size: 12px'>结算金额：" + order.pay_amount + "=（商品：" + order.order_amount + "）+（运费：" + order.shipping_fee + "）</b></p></div>";
            $(".tmp_div_order").remove();
            $(".fqy_setTab").before(str_order);
        });

        $('.fqy_Mask').css('visibility', 'visible');
        $('.fqy_wjdd').css('display', 'block');
        $('.fqy_qrdd').css('display', 'none');
        autocenter();
    }

    $('table').on('click', '.fqy_gysReview', function () {
        $('.fqy_Mask').css('visibility', 'visible');
        $('.fqy_wjdd').css('display', 'none');
        $('.fqy_qrdd').css('display', 'block');
        autocenter();
    });
    //弹出层
    function autocenter() {
        var W = $(window).width() / 2;
        var H = $(window).height() / 2;
        var eleW = $('.fqy_Popup').width();
        var eleH = $('.fqy_Popup').height();
        $('.fqy_Popup').css({left: (W - eleW / 2) + 'px', top: (H - eleH / 2) + 'px'});
        //关闭弹出层
        $('.fqy_popClose,.fqy_canlce').click(function () {
            $('.fqy_Mask').css('visibility', 'hidden');
        });
    }
    window.onload = function () {
        autocenter();
    };
    window.onresize = function () {
        autocenter();
    };

    function getLocalTime(nS) {
        return new Date(parseInt(nS) * 1000).toLocaleString().substr(0, 17)
    }
</script>                       </section>        </div>        <!--wrapper end-->        <script src="/Public/js/bootstrap.min.js"></script>        <script src="/Public/js/app.min.js"></script>        <script type="text/javascript" src="/Public/js/moment.js"></script><!--         // <script src="/Public/js/bootstrap-datetimepicker.min.js"></script>        // <script src="/Public/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script> -->        <script type="text/javascript" src="/Public/js/custom.js"></script>        <script type="text/javascript" src="/Public/js/layer.js"></script>    </body></html>