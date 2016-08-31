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
                            <a class="" href="<?php echo U('finance/finance/3');?>"> <i class="fa fa-fw  fa-circle-o"></i> 付款管理</a>
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
                
    <link rel="stylesheet" type="text/css" href="/Public/css/bootstrap-datetimepicker.min.css">

<div class="box box-warning">
    <div class="box-header with-border">
        <div class="box-title"><ul class="choose_ul">
                <li><a <?php if(I('get.shop_id') <= 1): ?>class="btn btn-warning btn-xs"<?php endif; ?> href="<?php echo U('goods/goodsRelease',array('shop_id' => 1 ));?>" >所有商品</a></li>
                <li><a <?php if(I('get.shop_id') == 2): ?>class="btn btn-warning btn-xs"<?php endif; ?> href="<?php echo U('goods/goodsRelease',array('shop_id' => 2 ));?>">星密码</a></li>
                <li><a <?php if(I('get.shop_id') == 3): ?>class="btn btn-warning btn-xs"<?php endif; ?> href="<?php echo U('goods/goodsRelease',array('shop_id' => 3 ));?>">创想范</a></li>
                <li><a <?php if(I('get.shop_id') == 4): ?>class="btn btn-warning btn-xs"<?php endif; ?> href="<?php echo U('goods/goodsRelease',array('shop_id' => 4 ));?>">待发布</a></li>
            </ul></div>
        <div class="box-tools pull-left">  
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row" >
            <form class="form-inline" method="get" id="searchForm">
                <div class="form-group">
                    <label for="exampleInputName2">仓库名称:</label>
                    <select class="form-control input-xs" name="depot">
                        <option value="">选择仓库</option>
                        <?php if(is_array($depot)): $i = 0; $__LIST__ = $depot;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option <?php echo xeq(I('get.depot'),$vo['id'],'selected');?> value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["depot_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputName2">商品类目:</label>
                    <select class="form-control input-xs" name="goods_category">
                        <option value="0">主类目</option>
                        <?php if(is_array($goods_category)): $i = 0; $__LIST__ = $goods_category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option <?php echo xeq(I('get.goods_category'),$vo['cid'],'selected');?> value="<?php echo ($vo["cid"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>

                <?php if( 1 == I('get.group_id') ){ ?>
                <div class="form-group ">
                    <label for="exampleInputName2">商品状态:</label>
                    <select name="goods_status" class="form-control input-xs">
                        <option value="">全部</option>
                        <option <?php echo xeq(I('get.goods_status'),2,'selected');?> value="2">新上传</option>
                        <option <?php echo xeq(I('get.goods_status'),3,'selected');?> value="3">已下架</option>
                        <option <?php echo xeq(I('get.goods_status'),4,'selected');?> value="4">已上架</option>
                        <option <?php echo xeq(I('get.goods_status'),5,'selected');?> value="5">待审核</option>
                        <option <?php echo xeq(I('get.goods_status'),6,'selected');?> value="6">未通过</option>
                    </select>
                </div>
                <?php } ?>
                <div class="row" >
                    <div class="form-group">
                        <select class="form-control input-xs" name="time_type">
                            <option <?php echo xeq(I('get.time_type'),'sale_time','selected');?> value="sale_time">上架时间</option>
                            <option <?php echo xeq(I('get.time_type'),'addtime','selected');?> value="addtime">上传时间</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control input-xs" value="<?php echo I('get.startTime');?>" placeholder='开始时间' id="startTime" name="startTime">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control input-xs" value="<?php echo I('get.endTime');?>" id="endTime" name="endTime" placeholder='结束时间'>
                    </div>
                    <div class="form-group">
                        <select class="form-control input-xs" name="goods_search" >
                            <option value="">选择搜索内容</option>
                            <option <?php echo xeq(I('get.goods_search'),'goods_name','selected');?> value="goods_name">商品名称</option>
                            <option <?php echo xeq(I('get.goods_search'),'goods_no','selected');?> value="goods_no">商品ID</option>
                            <option <?php echo xeq(I('get.goods_search'),'buyer_goods_no','selected');?> value="buyer_goods_no">商家编码</option>
                        </select>

                    </div>
                    <div class="form-group">
                        <input type="text" name="search_word" value="<?php echo I('get.search_word');?>" class="form-control input-xs" <?php echo xeq(I('get.goods_search'),'','disabled');?>  placeholder="输入商品名称或者货号" >
                    </div>
                    <div class="form-group btnBox">
                        <input type="submit" class="btn btn-block btn-warning btn-xs" value="搜索">
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
        <h3 class="box-title">😃</h3> 

        <div class="box-tools">
            <div class="input-group order">
                <ul>
                    <li><a href="#" id="introduced_batch" class="btn btn-default btn-xs">发布</a></li>
                </ul>
            </div>
            <div class="form-group order">
                <form class="form-inline" id="sortForm" action="<?php echo U(ACTION_NAME, I('get.'));?>" method="get">
                    <select class="form-control input-xs sort" name="sort">
                        <option>商品排序</option>
                        <option <?php echo xeq(I('get.sort'), 'addtime~asc,goods_id~asc', 'selected');?> value="addtime~asc,goods_id~asc">上传时间升序</option>
                        <option <?php echo xeq(I('get.sort'), 'addtime~desc,goods_id~desc', 'selected');?> value="addtime~desc,goods_id~desc">上传时间降序</option>
                        <option <?php echo xeq(I('get.sort'), 'sale_time~asc,goods_id~asc', 'selected');?>  value="sale_time~asc,goods_id~asc">上架时间升序</option>
                        <option <?php echo xeq(I('get.sort'), 'sale_time~desc,goods_id~desc', 'selected');?>  value="sale_time~desc,goods_id~desc">上架时间降序</option>
                    </select>
                </form>	
            </div> 
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover" id="dataTable">
            <tbody>
                <tr>
                    <th align="middle"><input type="checkbox" id="checkAll"></th>
                    <th>商家ID/最新商家编码</th>
                    <th>主图</th>
                    <th>名称</th>
                    <th>商品类目</th>
                    <th>商品平台</th>
                    <th>操作</th>
                </tr>
            <?php if(is_array($datas["list"])): $i = 0; $__LIST__ = $datas["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td ><input type="checkbox"  class="checkbox_goods_id choose" value="<?php echo ($vo["goods_id"]); ?>" ></td>
                    <td>
                        <p>商品ID:<?php echo ($vo["goods_no"]); ?></p>
                        <p>商家编码：<?php echo ($vo["buyer_goods_no"]); ?></p>
                    </td>
                    <td style="width:30px;"><img class="table_img" src="
                                                 <?php echo img_url($vo['img_path']?$vo['img_path']:$vo['goods_id'],30,40);?>"></td>
                    <td>
                        <p>
                            <?php echo ($vo["goods_name"]); ?>
                        </p>
                    </td>
                    <td>
                        <?php echo getTreeCategory($vo['goods_category']);?>
                    </td>
                    <td><?php echo getShopStr($vo['goods_id']);?></td>
                    <td>
                <p><a class="introduced" data-url="<?php echo U('goods/goodsIntroduced',array('goods_id'=>$vo['goods_id']));?>" href="#">发布</a></p>
                </td>	
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>	
    </div>

    <div class="box-footer">
        <div class="left" >
            <form class="form-inline" id="pagesizeForm" action="<?php echo U(ACTION_NAME, I('get.'));?>" method="get">
                <div class="form-group">
                    <label for="exampleInputName2">全选结果页:  </label><input type="checkbox" class="allGoods" class="choose" name="allGoods" >
                </div>
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
            <div class="pagination">
                <?php echo ($datas["page"]); ?>
            </div>
        </div>
    </div>
</div>
<!-- /.box -->
</div>    
</block>
<block name="footerJs">
    <script type="text/javascript" src="/Public/js/moment.js"></script>
    <script src="/Public/js/bootstrap-datetimepicker.min.js"></script>
    <script src="/Public/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
    <script type="text/javascript" src="/Public/js/custom.js"></script>
    <script type="text/javascript" src="/Public/js/layer.js"></script>

    <script type="text/javascript">
        $('.sort').change(function () {
            $('#sortForm').submit();
        });

        $('select[name="goods_search"]').change(function (event) {
            /* Act on the event */
            if ('' == $(this).val()) {
                $('input[name="search_word"]').attr('disabled', true);
            } else {
                $('input[name="search_word"]').removeAttr('disabled');
            }
        });

        var refurbish = function () {
            location.reload();
        }

        $('.introduced').click(function (event) {
            var iframeUrl = $(this).data('url');
            layer.open({
                type: 2,
                area: ['300px', '150px'],
                fix: false, //不固定
                maxmin: true,
                content: iframeUrl,
                title: '选择要发布的平台'
            });
            return false;
        });


        var introducedBatch = function (mShop) {
            var postUrl = "<?php echo U('goods/introducedBatch',I('get.'));?>";
            var postData = getPostData();

            postData.shop = mShop;
            $.post(postUrl, postData, function (data, textStatus, xhr) {
                /*optional stuff to do after success */
                if (1 == data.status) {
                    location.reload();
                }
            }, 'json');
        };

        $('#introduced_batch').click(function (event) {
            var postData = getPostData();
            if (false == postData) {
                layer.alert('请选择商品', {icon: 6});
                return false;
            }
            /* Act on the event */
            layer.open({
                type: 2,
                area: ['300px', '150px'],
                fix: false, //不固定
                maxmin: true,
                content: "<?php echo U('goods/goodsIntroducedbatch');?>",
                title: '选择要发布的平台'
            });
            return false;
        });


        var getPostData = function () {
            var postData = new Object();
            postData.alldata = 0;
            var goods = new Array();
            if ($('.allGoods').is(":checked")) {
                postData.alldata = 1;
            } else {
                $("#dataTable").find('.checkbox_goods_id:checked').each(function (index, element) {
                    goods[index] = $(this).val();
                });
                if (0 == goods.length) {
                    return false;
                }
            }
            postData.goods = goods;
            return postData;
        };
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