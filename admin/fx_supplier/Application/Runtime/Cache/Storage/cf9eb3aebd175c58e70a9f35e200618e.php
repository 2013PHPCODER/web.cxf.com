<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html><html>    <head>        <meta charset="utf-8">        <meta name="viewport" content="width=device-width, initial-scale=1">        <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">        <meta http-equiv="X-UA-Compatible" content="IE=9">        <title>创想范供应商管理后台</title>        <meta name="description" content="{if $page_description}{/if}">        <link rel="stylesheet" href="/Public/css/bootstrap.min.css">        <link rel="stylesheet" href="/Public/css/AdminLTE.css">        <link rel="stylesheet" href="/Public/css/font-awesome.min.css">        <link rel="stylesheet" href="/Public/css/skins/_all-skins.min.css">        <link rel="stylesheet" href="/Public/css/skins/skin-red.css">        <link rel="stylesheet" href="/Public/css/skins/skin-red-light.css">        <link rel="stylesheet" href="/Public/css/bootstrap3-wysihtml5.min.css">        <link rel="stylesheet" href="/Public/css/bootstrap-datetimepicker.min.css">        <link rel="stylesheet" href="/Public/css/my.css">        <link rel="stylesheet" href="/Public/css/layer.css" id="layui_layer_skinlayercss">        <link rel="stylesheet" href="/Public/css/global.css">        <link rel="shortcut icon" href="/Public/images/64x64.ico" type="image/x-icon" />         <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>        <script src="/Public/js/global.js" type="text/javascript" charset="utf-8"></script>        <script src="/Public/js/kkpager.min.js" type="text/javascript" charset="utf-8"></script>        <script src="//cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>        <script src="/Public/js/WdatePicker.js" type="text/javascript"></script>        <style type="text/css">            .sidebar-menu>li{display: none;}            .navbar-static-top li{cursor: pointer;}        </style>    </head>    <body class="skin-yellow-light sidebar-mini">        <!--header start-->        <header class="main-header">            <a href="#" class="logo">                <span class="logo-mini"><b>创想范</b></span>                <span class="logo-lg"><b>创想范</b><small> 供货商管理后台</small></span>            </a>            <nav class="navbar navbar-static-top">                <div class="navbar-nav top-bar">                    <ul class="nav navbar-nav first-nav">                        <li data-cate = "goods">                            <a class="" href="<?php echo U('goods/goods/index');?>"><b>商品</b></a>                        </li>                        <li data-cate = "order">                            <a class="" href="<?php echo U('orders/orders/index');?>"><b>订单</b></a>                        </li>						                        <li data-cate = "storage">                            <a class="" href="<?php echo U('storage/storage/index');?>"><b>仓储</b></a>                        </li>                        <li data-cate = "finance">                            <a  href="<?php echo U('finance/finance/index');?>"><b>财务</b></a>                        </li>                        <li data-cate = "after-sales">                            <a class="" href="<?php echo U('afterSales/index/index');?>"><b>售后</b></a>                        </li><!--                        <li data-cate = "user">                            <a class="" href="<?php echo U('user/user/index');?>"><b>用户管理</b></a>                        </li>-->                        <li data-cate = "system">                            <a class="" href="<?php echo U('system/index/index');?>"><b>系统</b></a>                        </li>                    </ul>                </div>                <div class="navbar-custom-menu">                    <ul class="nav navbar-nav">                        <li class=" user user-menu">                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">                                <span class="hidden-xs"><?php echo ($username); ?></span>                            </a>                        </li>                        <li>                            <a href="<?php echo U('user/login/logout');?>">                                <span class="hidden-xs">退出登录</span>                            </a>                        </li>                    </ul>                </div>            </nav>        </header>        <!--header end-->        <!--wrapper start-->        <div class="content-wrapper" style="min-height: 368px;">            <aside class="main-sidebar">                <section class="sidebar">                    <ul class="sidebar-menu">                        <li data-cate="goods">                            <a class="active" href="<?php echo U('goods/goods/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 商品列表</a>                        </li><!--                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/goodsRelease');?>"> <i class="fa fa-fw  fa-circle-o"></i> 商品发布</a>                        </li>-->                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/importGoods');?>"> <i class="fa fa-fw  fa-circle-o"></i> 新增商品</a>                        </li><!--                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/goodsNoList');?>"> <i class="fa fa-fw  fa-circle-o"></i> 货号列表</a>                        </li>-->                        <li data-cate="order" >                            <a class="" href="<?php echo U('orders/orders/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 订单列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 发货列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storage/slist');?>"> <i class="fa fa-fw  fa-circle-o"></i> 仓库设置</a>                        </li>                                                <!--li data-cate="storage" >                            <a class="" href="<?php echo U('storage/cusManage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 售后收货</a>                        </li-->                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storageManage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 库存列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storageManage/logEdit');?>"> <i class="fa fa-fw  fa-circle-o"></i> 库存修改日志</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/freight/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 物流模板</a>                        </li>                        <li data-cate="finance" >                            <a class="" href="<?php echo U('finance/finance/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 收款账户</a>                        </li>                        <li data-cate="finance" >                            <a class="" href="<?php echo U('finance/finance/endOrder');?>"> <i class="fa fa-fw  fa-circle-o"></i> 完结订单</a>                        </li>                        <li data-cate="finance">                            <a class="" href="<?php echo U('finance/finance/paymentDetails');?>"> <i class="fa fa-fw  fa-circle-o"></i> 收支明细</a>                        </li>                        <li data-cate="after-sales" >                            <a class="" href="<?php echo U('afterSales/index/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>售后列表</a>                        </li>                        <li data-cate="after-sales" >                            <a class="" href="<?php echo U('afterSales/index/arbitrationList');?>"> <i class="fa fa-fw  fa-circle-o"></i>仲裁结果</a>                        </li><!--                        <li data-cate="user" >                            <a class="" href="<?php echo U('user/user/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>用户设置</a>                        </li>-->                        <li data-cate="system" >                            <a class="" href="<?php echo U('system/index/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>操作记录</a>                        </li>                        <li data-cate="system" >                            <a class="" href="<?php echo U('system/user/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 用户信息</a>                        </li>                    </ul>                </section>            </aside>            <script>                showMenu();                function showMenu() {                    var target = "<?php echo U(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME); ?>";                    target = target.toUpperCase();                    var selected = _show(target);                     //二级菜单选中标记                    if (!selected) {                //三级菜单选择                            var refUrl = $.cookie('__refUrl');                        var tmp = refUrl.split('/');                        var _target = tmp[1] + '/' + tmp[2];                        if (target.indexOf(_target) > 0) {                            _show(refUrl);                        }                        ;                    }                    function _show(target) {                        var r = 0;                                //选中标记                        $('.sidebar-menu a').removeClass('active');     //顶级菜单显示                        $('.sidebar-menu a').each(function () {                            var tmp = $(this).attr('href');                            tmp = tmp.toUpperCase();                            if (tmp == target) {                                $(this).addClass('active');                 //二级菜单显示                                var cate = $(this).parent().data('cate');                                $('.sidebar-menu').find("[data-cate='" + cate + "']").show();                                $('.navbar-static-top').find('[data-cate="' + cate + '"]').addClass('active');      //顶级菜单显示                                                            r = 1;                                return;                            }                        });                        if (r) {                                                    //二级菜单选中，记录refurl                              $.cookie('__refUrl', target, {expires: 30, path: '/'});                        }                        ;                        return r;                    }                }            </script>            <section class="content">                
    <div class="box box-warning">
        <div class="box-header with-border">
            <div class="box-title">
                <ul class="choose_ul">
                    <li><a class="<?php echo xeq(I('get.group_id',1),1,'btn btn-warning btn-xs');?>" href="<?php echo U('storage/storageManage/index',array('group_id' => 1 ));?>" >所有商品</a></li>
                    <li><a class="<?php echo xeq(I('get.group_id'),2,'btn btn-warning btn-xs');?>" href="<?php echo U('storage/storageManage/index',array('group_id' => 2 ));?>">预警商品</a></li>
                </ul>
            </div>
            <div class="box-tools pull-left"> </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row" >
                <form class="form-inline" method="get" action="<?php echo U('storage/storageManage/index',array('group_id'=>I('get.group_id')));?>" id="searchForm">
                    <div class="form-group">
                        <label for="exampleInputName2">仓库名称:</label>
                        <select class="form-control input-xs" name="depot">
                            <option value="">选择仓库</option>
                            <?php if(is_array($depot)): $i = 0; $__LIST__ = $depot;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$depot): $mod = ($i % 2 );++$i;?><option <?php echo xeq(I('get.depot'),$depot['id'],'selected');?> value="<?php echo ($depot["id"]); ?>"><?php echo ($depot["sname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                    <div class="form-group ">
                        <label for="exampleInputName2">商品类目:</label>
                        <select class="form-control input-xs" name="goods_category">
                            <option value="">主类目</option>
                            <?php if(is_array($goods_category)): $i = 0; $__LIST__ = $goods_category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option <?php echo xeq(I('get.goods_category'),$vo['cid'],'selected');?> value="<?php echo ($vo["cid"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                    <div class="form-group ">
                        <label for="exampleInputName2">商品状态:</label>
                        <select class="form-control input-xs" name="goods_sale">
                            <option value="">全部</option>
                            <option <?php echo xeq(I('get.goods_sale'),1,'selected');?> value="1" >上架</option>
                            <option <?php echo xeq(I('get.goods_sale'),2,'selected');?> value="2" >下架</option>
                        </select>
                    </div>
                    <div class="row" >
                        <div class="form-group">
                            <select class="form-control input-xs" name="time_type">
                                <option <?php echo xeq(I('get.time_type'),'sale_time','selected');?> value="sale_time">上架时间</option>
                                <option <?php echo xeq(I('get.time_type'),'off_sale_time','selected');?> value="off_sale_time">下架时间</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control input-xs" value="<?php echo I('get.startTime');?>" onClick="WdatePicker()" name="startTime" placeholder="开始时间">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control input-xs" value="<?php echo I('get.endTime');?>" onClick="WdatePicker()" name="endTime" placeholder="结束时间">
                        </div>
                        <div class="form-group">
                            <select class="form-control input-xs" name="goods_search">
                                <option value="">选择关键字</option>
                                <option <?php echo xeq(I('get.goods_search'),'goods_no','selected');?> value="goods_no">商品ID</option>
                                <option <?php echo xeq(I('get.goods_search'),'buyer_goods_no','selected');?> value="buyer_goods_no">商家编码</option>
                                <option <?php echo xeq(I('get.goods_search'),'goods_name','selected');?> value="goods_name">商品名称</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" name="search_word" <?php echo xeq(I('get.goods_search'),'','disabled');?> value="<?php echo I('get.search_word');?>" class="form-control input-xs"  placeholder="商品名称、货号、收件人姓名、电话">
                        </div>
                        <div class="form-group btnBox" >
                            <input type="submit"  class="btn btn-block btn-warning btn-xs" value="搜索">
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
            <form id="sortForm" action="<?php echo U(ACTION_NAME,I('get.'));?>" method="get">
                <select class="form-control input-xs sort" name="sort">
                    <option value="">商品排序</option>
                    <option <?php echo xeq(I('get.sort'),'addtime~asc,goods_list.goods_id~asc','selected');?> value="addtime~asc,goods_list.goods_id~asc">上传时间升序</option>
                    <option <?php echo xeq(I('get.sort'),'addtime~desc,goods_list.goods_id~desc','selected');?> value="addtime~desc,goods_list.goods_id~desc">上传时间降序</option>
                    <option <?php echo xeq(I('get.sort'),'stock_update_time~asc,goods_list.goods_id~asc','selected');?> value="stock_update_time~asc,goods_list.goods_id~asc">修改时间升序</option>
                    <option <?php echo xeq(I('get.sort'),'stock_update_time~desc,goods_list.goods_id~desc','selected');?> value="stock_update_time~desc,goods_list.goods_id~desc">修改时间降序</option>
                </select>
            </form>
            <div class="box-tools">
                <div class="input-group order" >
                    <ul>
                        <li><a href="#" class="btn btn-default btn-xs all_warning">批量预警</a></li>
                        <li><a href="#" class="btn btn-default btn-xs import_stock" id="import_stock">导出库存表</a></li>
                        <li><a href="#" class="btn btn-default btn-xs add_stock">导入库存</a></li>
                        <li><a href="#" class="btn btn-default btn-xs all_edit">批量修改库存</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover" id ="dataTable">
                <tbody>
                    <tr>
                        <th align="middle"><input type="checkbox" id="checkAll"></th>
                        <th>商品ID</th>
                        <th>标题</th>
                        <th>最新商家编码</th>
                        <th>商品状态</th>
                        <th >SKU</th>
                        <th>SKU库存</th>
                        <th>预警库存</th>
                        <th>总库存</th>
                        <th>预警设置</th>
                    </tr>
                <?php if(is_array($datas["list"])): $i = 0; $__LIST__ = $datas["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr id="content">
                        <td ><input type="checkbox" class="choose checkbox_goods_id" name="goods_id[]" value="<?php echo ($vo["goods_id"]); ?>"></td>
                        <td ><?php echo ($vo["goods_no"]); ?></td>
                        <td ><?php echo ($vo["goods_name"]); ?></td>
                        <td ><?php echo ($vo["buyer_goods_no"]); ?></td>
                        <td ><?php switch($vo["goods_sale"]): case "1": ?>上架<?php break;?>
                    <?php case "2": ?>下架<?php break; endswitch;?></td>
                    <td><?php if(is_array($vo["sku_list"])): foreach($vo["sku_list"] as $key=>$item): ?><P> <?php echo ($item["sku_str_zh"]); ?></P><?php endforeach; endif; ?></td>
                    <td>
                        <?php foreach($vo['sku_list'] as $key =>$value){ ?>

                        <?php if($value['stock_num'] <= $value['stock_lock_num'] && $value['stock_lock_num'] > 0 ){ ?>
                        <!-- <p style="color: red;"><?php echo ($vo['stock_num'][$i]); ?></p> -->
                        <input type="text" style="color: red;" data-skuval="<?php echo ($value['stock_num']); ?>" data-skuid="<?php echo ($value["id"]); ?>"  class="form-control input-xs edit_input" name="" value="<?php echo ($value['stock_num']); ?>">
                        <?php } else{ ?>
                        <input type="text" class="form-control input-xs edit_input" data-skuval="<?php echo ($value['stock_num']); ?>"  data-skuid="<?php echo ($value["id"]); ?>"  value="<?php echo ($value['stock_num']); ?>">
                        <?php }} ?>
                    </td>
                    <td ><?php if(is_array($vo["sku_list"])): foreach($vo["sku_list"] as $key=>$item): ?><input type="text" class="form-control input-xs edit_input"  disabled="disabled" data-skuid="<?php echo ($item["id"]); ?>"  value="<?php echo ($item["stock_lock_num"]); ?>"><?php endforeach; endif; ?></td>
                    <td><?php echo ($vo["stock_num"]); ?></td>
                    <td >
                        <a href="#" class="btn btn-default btn-xs stock_lock_num">设置预警</a>
                        <input type="hidden" name="" id='stock_goods_id' value="<?php echo ($vo["goods_id"]); ?>"></td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
        </div>
        <div class="box-footer">
            <div class="left" >
                <form class="form-inline" id="pagesizeForm" action="<?php echo U(ACTION_NAME, I('get.'));?>" method="get">
                    <div class="form-group">
                        <select name="pagesize" class="form-control input-xs pagesize">
                            <option <?php echo xeq(I('get.pagesize'), 20, 'selected');?> value="20" >20条</option>
                            <option <?php echo xeq(I('get.pagesize'), 50, 'selected');?> value="50" >50条</option>
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
    </div>
    <!-- /.box -->
    <form action="<?php echo U('storage/loadStock');?>" method="post" enctype="multipart/form-data" id="form_stock">
        <input type="file" name="file" id='stock' style="visibility:hidden">
    </form>
</div>

 
    <script type="text/javascript">
        /*  弹窗   */
        var refurbish = function (response) {
            layer.open({
                content: response.message,
                scrollbar: false,
                yes: function (index) {
                    layer.close(index);
                    window.location.reload();
                }
            });
        };
        $(document).ready(function () {

            $('select[name="goods_search"]').change(function (event) {
                if ('' == $(this).val()) {
                    $('input[name="search_word"]').attr('disabled', true);
                    $('input[name="search_word"]').val('');
                } else {
                    $('input[name="search_word"]').removeAttr('disabled');
                }
            });


            $('.sort').change(function () {
                $('#sortForm').submit();
            });
//批量预警
            $('.all_warning').click(function () {
                if ($('.choose:checked').serialize() || $("#selectall").is(':checked')) {
                    var str = "设置每个SKU库存预警";
                    str += "<input type='text' min ='0' class='form-control input-xs' id='warning_val'>";
                    layer.confirm(str, {title: "批量预警库存设置", btn: ['确定', '取消']}, function (index) {
                        if (isNaN($('#warning_val').val())) {
                            layer.tips('请输入数值', '#warning_val', {
                                tips: [2, '#3595CC'],
                                time: 2000
                            });
                            return false;
                        }
                        if (parseInt($('#warning_val').val()) > 9999999) {
                            layer.tips('最大只能设置9999999', '#warning_val', {
                                tips: [2, '#3595CC'],
                                time: 2000
                            });
                            return false;
                        }
                        if (parseInt($('#warning_val').val()) < 0) {
                            layer.tips('预警库存不能小于0', '#warning_val', {
                                tips: [2, '#3595CC'],
                                time: 2000
                            });
                            return false;
                        }
                        if ($("#selectall").is(':checked') == true) {
                            data = {type: 'all', val: $('#warning_val').val()};
                        } else {
                            var id = new Array();
                            $('.choose:checked').each(function () {
                                id.push($(this).val());
                            })
                            data = {goods_id: id, val: $('#warning_val').val()}
                        }

                        var urlPost = "<?php echo U('storage/allWarning',I('get.'));?>";
                        $.post(urlPost, data, function (result) {
                            if (result.status == 'ok') {
                                layer.alert('设置成功');
                            } else {
                                // layer.msg(result);
                                label.alert(result);
                            }
                            layer.close(index);
                            window.location.reload();
                        });
                    });

                } else {

                    layer.alert('请选择要操作的订单');
                }

            });

//批量修改库存
            $('.all_edit').click(function () {
                if ($('.choose:checked').serialize() || $("#selectall").is(':checked')) {
                    var str = "录入库存修改";
                    str += "<input type='text' min ='0' class='form-control input-xs' id='warning_val'>";
                    layer.confirm(str, {title: "批量修改库存", btn: ['确定', '取消']}, function (index) {

                        /*******************限制库存******************************/
                        if (isNaN($('#warning_val').val())) {
                            layer.tips('请输入数值', '#warning_val', {
                                tips: [2, '#3595CC'],
                                time: 2000
                            });
                            return false;
                        }
                        if (parseInt($('#warning_val').val()) > 9999999) {
                            layer.tips('最大只能设置9999999', '#warning_val', {
                                tips: [2, '#3595CC'],
                                time: 2000
                            });
                            return false;
                        }
                        if (parseInt($('#warning_val').val()) < 0) {
                            layer.tips('库存不能小于0', '#warning_val', {
                                tips: [2, '#3595CC'],
                                time: 2000
                            });
                            return false;
                        }
                        /************************************************/
                        if ($("#selectall").is(':checked') == true) {
                            data = {type: 'all', val: $('#warning_val').val()};
                        } else {
                            var id = new Array();
                            $('.choose:checked').each(function () {
                                id.push($(this).val());
                            })
                            data = {goods_id: id, val: $('#warning_val').val()}
                        }

                        var urlPost = "<?php echo U('allEdit',I('get.'));?>";
                        $.post(urlPost, data, function (result) {
                            if (result.status == 'ok') {
                                layer.msg('修改成功');
                            } else {
                                layer.msg(result);
                            }
                            layer.close(index);
                            window.location.reload();
                        });
                    });

                } else {

                    layer.alert('请选择要操作的订单');
                }
            });

//导出库存表
//
            $('#selectall').click(function (event) {

                if (true == $(this).is(':checked')) {
                    $('input[name="allData"]').val(1);
                } else {
                    $('input[name="allData"]').val(0);
                }
            });

            $("#import_stock").click(function (event) {
                if ($('#selectall').is(':checked')) {
                    $("input[name='allData']").val(1)
                } else {
                    $("#dataTable").find('.checkbox_goods_id:checked').each(function (index, element) {
                        var cloneInput = $('.explode_goods_input:first()').clone();
                        cloneInput.val($(this).val()).appendTo('.btnBox')
                    });
                    if (1 == $('.explode_goods_input').length) {
                        layer.alert("请选择要操作的订单");
                        return false;
                    }
                }
                $('.explode_goods_input:first()').remove();
                $('input[name="explode_goods"]').val(1);
                $("#searchForm").submit();
                return false;
            });

            /****************************************/
//导入库存
// $('.add_stock').click(function(){
//     return $('#stock').click();
// })
            $('.add_stock').click(function (event) {
                layer.open({
                    type: 2,
                    id: 'import',
                    area: ['500px', '200px'],
                    fix: false, //不固定
                    maxmin: true,
                    content: "<?php echo U('storage/importStock');?>",
                    title: '导入库存'
                });
                return false;
            });


// $('#stock').change(function(){
//     if($(this).val()){
//       layer.confirm('确定要上传所选文件吗?',{title:'提醒',btn:['确定','取消']},function(){
//           $('#form_stock').submit();
//       });
//     }
// });  

//设置预警
            $('.stock_lock_num').click(function () {
                $.post("<?php echo U('storage/setStock_locak_num');?>", {goods_id: $(this).next().val()}, function (result) {
                    if (result) {
                        layer.confirm(result, {title: '设置预警', btn: ['确定', '取消'], area: ['800px', '500px']}, function (index) {
                            var flag = true;
                            $(".stock_lock").each(function () {
                                if (isNaN($(this).val())) {
                                    if ($(this).siblings('span').hasClass('number') == false) {
                                        $(this).next('span').remove();
                                        $(this).after("<span class='number' style='color:red'>请输入数值</span>");
                                    }
                                    flag = false
                                }
                                if (parseInt($(this).val()) > 9999999) {
                                    $(this).focus();
                                    if ($(this).siblings('span').hasClass('tip') == false) {
                                        $(this).next('span').remove();
                                        $(this).after("<span class='tip' style='color:red'>预警库最多只能设置9999999</span>");
                                    }
                                    flag = false
                                }
                                if (parseInt($(this).val()) < 0) {
                                    $(this).focus();
                                    if ($(this).siblings('span').hasClass('tip') == false) {
                                        $(this).next('span').remove();
                                        $(this).after("<span class='tip' style='color:red'>预警库存不能小于0</span>");
                                    }
                                    flag = false
                                }
                            });
                            if (flag == false) {
                                return;
                            }
                            var arr = new Array();
                            $('.first').each(function () {
                                var obj = new Object();
                                obj.id = $(this).find('#sku_id').val();
                                obj.val = $(this).find('#stock_lock_val').val();
                                arr.push(obj);
                            });
                            if (arr) {
                                $.post("<?php echo U('storage/saveStock_locak_num');?>", {data: arr}, function (result) {
                                    if (result) {
                                        layer.alert(result);
                                    } else {
                                        layer.msg('操作成功');
                                        window.location.reload();
                                    }
                                })
                            }
                        });
                        $(".stock_lock").change(function () {
                            if (isNaN($(this).val()) == false) {
                                $(this).next('span').remove();
                            }
                            if (parseInt($(this).val()) <= 9999999) {
                                $(this).next('span').remove();
                            }
                            if (parseInt($(this).val()) >= 0) {
                                $(this).next('span').remove();
                            }
                        });
                    }
                });
                return false;
            });

//修改库存
            $('.edit_input').blur(function () {
                var old_sku_val = $(this).data('skuval');
                var new_sku_val = $(this).val();
                var sku_id = $(this).data('skuid');
                if (new_sku_val != old_sku_val) {
                    if (isNaN(new_sku_val)) {
                        layer.tips('请输入数值', $(this), {
                            tips: [2, '#3595CC'],
                            time: 2000
                        });
                        $(this).val(old_sku_val);
                        return false;
                    }

                    if (parseInt(new_sku_val) > 9999999) {
                        layer.tips('最大只能设置9999999', $(this), {
                            tips: [2, '#3595CC'],
                            time: 2000
                        });
                        $(this).val(old_sku_val);
                        return false;
                    }
                    if (parseInt(new_sku_val) < 0) {
                        layer.tips('库存不能小于0', $(this), {
                            tips: [2, '#3595CC'],
                            time: 2000
                        });
                        $(this).val(old_sku_val);
                        return false;
                    }
                    var postUrl = "<?php echo U('storage/updateStock');?>";
                    var postData = {
                        sku_id: sku_id,
                        stock_num: new_sku_val,
                        old_stock: old_sku_val
                    }
                    $.post(postUrl, postData, function (data) {
                        //window.location.reload();
                    });
                }
            });
        });
    </script> 

            </section>        </div>        <!--wrapper end-->        <script src="/Public/js/bootstrap.min.js"></script>        <script src="/Public/js/app.min.js"></script>        <script type="text/javascript" src="/Public/js/moment.js"></script><!--         // <script src="/Public/js/bootstrap-datetimepicker.min.js"></script>        // <script src="/Public/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script> -->        <script type="text/javascript" src="/Public/js/custom.js"></script>        <script type="text/javascript" src="/Public/js/layer.js"></script>    </body></html>