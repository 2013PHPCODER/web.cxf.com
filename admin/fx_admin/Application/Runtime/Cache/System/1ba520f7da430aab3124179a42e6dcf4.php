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
            <section class="content">
                <script type="text/javascript" charset="utf-8" src="/Public/js/utf8-php/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/js/utf8-php/ueditor.all.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/js/utf8-php/lang/zh-cn/zh-cn.js"></script>
<style type="text/css">

    .g-modal-content{
        font-family: "microsoft yahei";
    }
    .g-modal-content label{
        float: left;
        width: 200px;
        width: 100%;
        padding: 10px 0;
    }
    .sub-btn{
        text-align: right;
    }
    .sub-btn .sumb{
        height: 28px;
        line-height: 28px;
        margin: 0 6px;
        padding: 0 15px;
        border: 1px solid #dedede;
        background-color: #f1f1f1;
        color: #333;
        border-radius: 2px;
        font-weight: 400;
        cursor: pointer;
        text-decoration: none;	
    }
    .sub-btn .btn1{
        border-color: #4898d5;
        background-color: #2e8ded;
        color: #fff;
    }
    .dalog-modal2{display: none;position: fixed;top: 10%;left: 15%;z-index: 1000;background: #fff;}
    .dalog-modal2>h3{font-size: 24px;text-align: center;}
    .dalog-modal-editor{display: none;position: fixed;top: 10%;left: 15%;z-index: 1000;}
    .dalog-add,.dalog-Modify{display: none;}
    .zhezhao1{position: fixed;display: none; background: #000;opacity: .3;z-index: 999; filter: alpha(opacity=30);width: 100%;height: 100%;top: 0;left: 0;}
    .dalog-modal{display: none;padding: 10px 0;position: fixed;top: 15%;left: 50%;margin-left: -250px; z-index: 1000;background: #fff;width: 600px;}
    .dalog-modal .artical-mes{width: 500px;margin-left: 50px;}
    .dalog-modal>h3{font-size: 24px;text-align: center;}
</style>

    <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> 位置</li>
        <li>
            页面管理</li>
        <li>文章管理</li>
    </ol> 
    <div class="zhezhao1"></div>
    <div class="box-body">
        <div class="row" >
            <form class="form-inline" method="get" action="" id="form_search" onsubmit="return X.toSerchVaild(this)">
                <div class="form-group">
                    <label for="exampleInputName2">发布者:</label>
                    <select class="form-control input-xs" name="adduser">
                        <option value="">——请选择——</option>
                        <?php if(is_array($adduser)): $i = 0; $__LIST__ = $adduser;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo); ?>"><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputName2">发布对象:</label>
                    <select class="form-control input-xs" name="show_platform">
                        <option value="">——请选择——</option>
                        <option value="1">Web端</option>
                        <option value="2">客户端</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputName2">排序:</label>
                    <select class="form-control input-xs" name="show_order">
                        <option value="">——请选择——</option>
                        <?php if(is_array($show_order)): $i = 0; $__LIST__ = $show_order;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo); ?>"><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputName2">发布时间:</label>
                    <select class="form-control input-xs" name="time">
                        <option value="">请选择</option>
                        <option value="1">今天</option>
                        <option value="2">最近7天</option>
                        <option value="3">最近一个月</option>
                        <option value="4">自定义</option>
                    </select>
                </div>		
                <div class="form-group">
                    <input type="submit"  class="btn btn-block btn-warning btn-xs" value="搜索">
                    <input type="hidden" name="is_close" value="1" id="is_close" >
                    <input type="hidden" name="is_cus" value="1" id="is_cus">
                </div>
            </form>
        </div>
        <div class="row">
            <div class="form-group">
                <button class="btn btn-default e-add-announ">新增公告</button>
            </div>
        </div>	
    </div>
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <tbody>
                <tr>
                    <th>标题</th>
                    <th>发布者</th>
                    <th>发布对象</th>
                    <th>发布时间</th>
                    <th>是否上线</th>
                    <th>排序</th>
                    <th>操作</th>
                </tr>
            <?php if(is_array($datas["list"])): $i = 0; $__LIST__ = $datas["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <th><?php echo ($vo["title"]); ?></th>
                    <th><?php echo ($vo["adduser"]); ?></th>
                    <th><?php echo ($vo["show_platform"]); ?></th>
                    <th><?php echo ($vo["addtime"]); ?></th>
                    <?php if(2==$vo['show_status']){ ?>
                    <th>否</th>
                    <?php }elseif(1==$vo['show_status']){?>
                    <th>是</th>
                    <?php } ?>
                    <th><?php echo ($vo["show_order"]); ?></th>
                    <?php if(2==$vo['show_status']){ ?>
                    <th data-id="<?php echo ($vo["id"]); ?>"><a href="javascript:;" class="e-preview" data-id="<?php echo ($vo["id"]); ?>" >预览</a>&nbsp;&nbsp;<a href="javascript:;" data-id="<?php echo ($vo["id"]); ?>"  class="e-editor">编辑</a></th>
                    <?php }elseif(1==$vo['show_status']){?>
                    <th  data-id="{$vo.id}"><a href="javascript:;" class="e-preview" data-id="<?php echo ($vo["id"]); ?>" >预览</a>&nbsp;&nbsp;<a href="javascript:;" data-id="<?php echo ($vo["id"]); ?>"  class="e-editor">编辑</a>&nbsp;&nbsp;<a data-id="<?php echo ($vo["id"]); ?>" href="javascript:;" class="e-offline">下线</a></th>
                    <?php } ?>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </div> 
    <div class="dalog-modal">
        <h3>文章标题</h3>
        <div class="artical-mes">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.
        </div>
        <div class="row" style="text-align: center">
            <button class="btn btn-default preview-confirm">确定</button>
        </div>
    </div>
    <div class="dalog-modal2">
        <a href="../../../../../../../../../../../../C:/Users/Administrator/Desktop/index.html"></a>
        <h3 class="dalog-add">新增文章</h3>
        <h3 class="dalog-Modify">修改文章</h3>
        <script id="editor" type="text/plain" style="width:1024px;height:500px;"></script>
        <div class="row dalog-add">
            <form class="form-inline" method="get" action="" id="form_search">
                <div class="form-group">
                    <label for="exampleInputName2">发布对象:</label>
                    <select class="form-control input-xs  fb-obj" name="depot">
                        <option value="">——请选择——</option>
                        <option value="1">WEB端</option>
                        <option value="2">客户端</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputName2">排序:</label>
                    <select class="form-control input-xs fb-sorting" name="depot">
                        <option value="">——请选择——</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                </div>
                <div class="row" style="text-align: center;">				
                    <input type="button" class="btn btn-default" id="btn-upLine-new" value="上线"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="btn btn-default e-scancel" value="取消"/>				
                </div>	
            </form>	
        </div>	
        <div class="row dalog-Modify">
            <form class="form-inline" method="get" action="" id="form_search">
                <div class="form-group">
                    <label for="exampleInputName2">发布对象:</label>
                    <select class="form-control input-xs  fb-obj" name="depot">
                        <option value="">——请选择——</option>
                        <option value="1">WEB端</option>
                        <option value="2">客户端</option>
                        <option value="-1" selected="selected">原平台</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputName2">排序:</label>
                    <select class="form-control input-xs fb-sorting" name="depot">
                        <option value="">——请选择——</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="-1" selected="selected">原排序</option>
                    </select>
                </div>
                <div class="row" style="text-align: center;">				
                    <input type="button" class="btn btn-default" id="btn-upLine-update"  value="上线"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="btn btn-default e-scancel" value="取消"/>				
                </div>	
            </form>	
        </div>	
    </div>
    <div class="box-footer">
        <div class="left" >
            <form class="form-inline" id="pagesizeForm" action="<?php echo U(ACTION_NAME, I('get.'));?>" method="get">
                <div class="form-group">
                    <label for="exampleInputName2">全选结果页: </label>
                    <input type="checkbox" id="selectall"  value="">
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

<script>
    $('select[name="order_search"]').change(function (event) {
        /* Act on the event */
        if ('' == $(this).val()) {
            $('input[name="search_word"]').attr('disabled', true);
            $('input[name="search_word"]').val('');
        }
        else {
            $('input[name="search_word"]').removeAttr('disabled');
        }
    });

//			全选
    var allCheake = false;
    $('#checkAll').click(function () {
        allCheake == true ? function () {
            $('.table-responsive').find('input[type="checkbox"]').prop('checked', false);
            allCheake = false
        }() : function () {
            $('.table-responsive').find('input[type="checkbox"]').prop('checked', true);
            allCheake = true;
        }();
    })
//    预览
    $('.e-preview').click(function () {
        $('.dalog-modal').show();
        $('.zhezhao1').show();
        var data = {
            'id': $(this).attr('data-id')
        }

        var p_url = "<?php echo U('pageManage/newsPreview',I('get.'));?>";
        $.post(p_url, data, function (e) {
            $('.dalog-modal>h3').html(e.title);
            $('.artical-mes').html(e.content);
        })

    });
    $('.preview-confirm').click(function () {
        $('.dalog-modal').hide();
        $('.zhezhao1').hide();
    })


// 新增公告
    $('.e-add-announ').click(function () {
        $('.dalog-modal2').show();
        $('.dalog-add').show();
        $('.dalog-Modify').hide();
        $('.zhezhao1').show();
        var data = {
            "id": -1
        }
        var e_url = "<?php echo U('pageManage/editNews',I('get.'));?>";
        $.post(e_url, data, function (e) {
            console.log(e);
            var oHtml = '<option value="">——请选择——</option>'
            for (var i in e.show_order) {
                oHtml += '<option value="' + e.show_order[i] + '">' + e.show_order[i] + '</option>';
            }
            $('select.fb-sorting').html(oHtml);
        });
    })
// 编辑
    var oId;
    $('.e-editor').click(function () {
        $('.dalog-modal2').show();
        $('.dalog-Modify').show();
        $('.dalog-add').hide();
        $('.zhezhao1').show();
        var data = {
            "id": $(this).attr('data-id')
        }
        oId = $(this).attr('data-id');
        var e_url = "<?php echo U('pageManage/editNews',I('get.'));?>";
        $.post(e_url, data, function (e) {
            console.log(e);
            $("#ueditor_0").contents().find("body").html(e.title + e.content);

            var oHtml = '<option value="">——请选择——</option>'
            for (var i in e.show_order) {
                oHtml += '<option value="' + e.show_order[i] + '">' + e.show_order[i] + '</option>';
            }
            oHtml += '<option value="-1"  selected="selected">原排序</option>';
            $('select.fb-sorting').html(oHtml);


            $("#ueditor_0").contents().find("body").html('<h1>' + e.title + '</h1>' + e.content);
//            $('.dalog-Modify').find('.fb-obj').find('option').each(function () {
//                if ($(this).html() == e.show_platform) {
//                    $(this).attr('selected', 'selected');
//                }
//            })
//            $('.dalog-Modify').find('.fb-sorting').find('option').each(function () {
//                if ($(this).html() == e.show_order) {
//                    $(this).attr('selected', 'selected');
//                }
//            })
        })
    })

    $('.e-scancel').click(function () {
        $('.dalog-modal2').hide();
        $('.dalog-modal-editor').hide();
        $('.zhezhao1').hide();
    })
    //  下线操作
    $('.e-offline').click(function () {
        var othis = $(this);
        layer.confirm('你确定要下线么？', {btn: ['确认', '取消']},
        function (index) {
            var data = {
                "id": othis.attr('data-id')
            }
//            console.log(data.id)
            var p_url = "<?php echo U('pageManage/changeStatus',I('get.'));?>";
            $.post(p_url, data, function (e) {
                X.notice(e, 3);
                setTimeout(function () {
                    window.location.reload()
                }, 1000);
            })
            layer.close(index);
        }, function (index) {
            layer.close(index);
            return false;
        });

    })

</script>
<script type="text/javascript">

    //实例化编辑器
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    var ue = UE.getEditor('editor');


    function isFocus(e) {
        alert(UE.getEditor('editor').isFocus());
        UE.dom.domUtils.preventDefault(e)
    }
    function setblur(e) {
        UE.getEditor('editor').blur();
        UE.dom.domUtils.preventDefault(e)
    }
    function insertHtml() {
        var value = prompt('插入html代码', '');
        UE.getEditor('editor').execCommand('insertHtml', value)
    }
    function createEditor() {
        enableBtn();
        UE.getEditor('editor');
    }
    function getAllHtml() {
        alert(UE.getEditor('editor').getAllHtml())
    }
    function getContent() {
        var arr = [];
        arr.push("使用editor.getContent()方法可以获得编辑器的内容");
        arr.push("内容为：");
        arr.push(UE.getEditor('editor').getContent());
        alert(arr.join("\n"));
    }
    function getPlainTxt() {
        var arr = [];
        arr.push("使用editor.getPlainTxt()方法可以获得编辑器的带格式的纯文本内容");
        arr.push("内容为：");
        arr.push(UE.getEditor('editor').getPlainTxt());
        alert(arr.join('\n'))
    }
    function setContent(isAppendTo) {
        var arr = [];
        arr.push("使用editor.setContent('欢迎使用ueditor')方法可以设置编辑器的内容");
        UE.getEditor('editor').setContent('欢迎使用ueditor', isAppendTo);
        alert(arr.join("\n"));
    }
    function setDisabled() {
        UE.getEditor('editor').setDisabled('fullscreen');
        disableBtn("enable");
    }

    function setEnabled() {
        UE.getEditor('editor').setEnabled();
        enableBtn();
    }

    function getText() {
        //当你点击按钮时编辑区域已经失去了焦点，如果直接用getText将不会得到内容，所以要在选回来，然后取得内容
        var range = UE.getEditor('editor').selection.getRange();
        range.select();
        var txt = UE.getEditor('editor').selection.getText();
        alert(txt)
    }

    function getContentTxt() {
        var arr = [];
        arr.push("使用editor.getContentTxt()方法可以获得编辑器的纯文本内容");
        arr.push("编辑器的纯文本内容为：");
        arr.push(UE.getEditor('editor').getContentTxt());
        alert(arr.join("\n"));
    }
    function hasContent() {
        var arr = [];
        arr.push("使用editor.hasContents()方法判断编辑器里是否有内容");
        arr.push("判断结果为：");
        arr.push(UE.getEditor('editor').hasContents());
        alert(arr.join("\n"));
    }
    function setFocus() {
        UE.getEditor('editor').focus();
    }
    function deleteEditor() {
        disableBtn();
        UE.getEditor('editor').destroy();
    }
    function disableBtn(str) {
        var div = document.getElementById('btns');
        var btns = UE.dom.domUtils.getElementsByTagName(div, "button");
        for (var i = 0, btn; btn = btns[i++]; ) {
            if (btn.id == str) {
                UE.dom.domUtils.removeAttributes(btn, ["disabled"]);
            } else {
                btn.setAttribute("disabled", "true");
            }
        }
    }
    function enableBtn() {
        var div = document.getElementById('btns');
        var btns = UE.dom.domUtils.getElementsByTagName(div, "button");
        for (var i = 0, btn; btn = btns[i++]; ) {
            UE.dom.domUtils.removeAttributes(btn, ["disabled"]);
        }
    }

    function getLocalData() {
        alert(UE.getEditor('editor').execCommand("getlocaldata"));
    }

    function clearLocalData() {
        UE.getEditor('editor').execCommand("clearlocaldata");
        alert("已清空草稿箱")
    }

//    新增
    $('#btn-upLine-new').click(function () {
        var data = {
            'title': $("#ueditor_0").contents().find("body").find('h1').html(),
            'content': $("#ueditor_0").contents().find("body").html().split('/h1>')[1],
            'order': $('.dalog-add').find('.fb-sorting').find('option:selected').val(),
            'platform': $('.dalog-add').find('.fb-obj').find('option:selected').val()
        }
        console.log(data);
        if (data.title == undefined) {
            X.notice('请输入标题', 3);
        } else if (data.content == '<p>​<br></p>' || data.content == '') {
            X.notice('不能少于两个字符', 3);
        } else if (data.platform == '' || data.order == '') {
            X.notice('请选择发布选项', 3);
        } else {
            var n_url = "<?php echo U('pageManage/newsAdd',I('get.'));?>";
            $.post(n_url, data, function (e) {
                if (e == '添加成功') {
                    X.notice('添加成功', 3);
//                    $('.dalog-modal2').hide();
//                    $('.zhezhao1').hide();
                    setTimeout(function () {
                        window.location.reload()
                    }, 1000);
                } else {
                    X.notice(e, 3)
                }
            });
        }
    })
//    编辑后更新
    $('#btn-upLine-update').click(function () {
        var data = {
            'title': $("#ueditor_0").contents().find("body").find('h1').html(),
            'content': $("#ueditor_0").contents().find("body").html().split('/h1>')[1],
            'order': $('.dalog-Modify').find('.fb-sorting').find('option:selected').val(),
            'platform': $('.dalog-Modify').find('.fb-obj').find('option:selected').val(),
            'id': oId
        }
        console.log(data);
        if (data.title == undefined) {
            X.notice('请输入标题', 3);
        } else if (data.content == '<p>​<br></p>' || data.content == '') {
            X.notice('不能少于两个字符', 3);
        } else if (data.obj == '' || data.sorting == '') {
            X.notice('请选择发布选项', 3);
        } else {
            var p_url = "<?php echo U('pageManage/newsUpdate',I('get.'));?>";
            $.post(p_url, data, function (e) {
                if (e == "更新成功") {
                    X.notice('上传成功', 3);

//                    $('.dalog-modal2').hide();
//                    $('.zhezhao1').hide();
                    setTimeout(function () {
                        window.location.reload()
                    }, 1000);
                } else {
                    X.notice(e, 3)

                }
            });
        }
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
<!--     // <script src="/Public/js/bootstrap-datetimepicker.min.js"></script>
    // <script src="/Public/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script> -->
    <script type="text/javascript" src="/Public/js/custom.js"></script>
    <script type="text/javascript" src="/Public/js/layer.js"></script>    
</html>