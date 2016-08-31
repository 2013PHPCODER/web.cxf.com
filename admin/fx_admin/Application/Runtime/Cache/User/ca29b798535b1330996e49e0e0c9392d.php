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
                <style type="text/css">

    .box-title .choose_ul>li {
        width: 98px;
    }

</style>

    <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> 位置</li>
        <li>用户管理</li>
        <li>分销商管理</li>
        <li>分销商列表</li>
    </ol>
    <?php echo ($disUserDetail["usernick"]); ?>
    <div class="box-body">
        <form class="form-inline" method="get" action="" id="form_search" onsubmit="return X.toSerchVaild(this)">
            <div class="row" >
                <div class="form-group">
                    <label for="exampleInputName2">用户等级:</label>
                    <select class="form-control input-xs" name="dengji">
                        <option value="">——请选择——</option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputName2">状态:</label>
                    <select class="form-control input-xs" name="zhaungtai">
                        <option value="">——请选择——</option>
                        <option value="1">禁用</option>
                        <option value="2">启用</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputName2">来源:</label>
                    <select class="form-control input-xs" name="laiyuan">
                        <option value="">——请选择——</option>
                        <option value="1">星密码</option>
                        <option value="2">创想范</option>
                        <option value="3">代理商</option>
                    </select>
                </div>
            </div>
            <div class="row" >
                <div class="form-group ">
                    <label for="exampleInputName2">选择时间范围:</label>
                    <select class="form-control input-xs" name="time" id="fqy_time">
                        <option value="">——请选择——</option>
                        <option value="1">今天</option>
                        <option value="2">最近七天</option>
                        <option value="3">最近一个月</option>
                        <option value="4">自定义</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text"  name="startTime" class="form-control input-xs" onClick="WdatePicker()" value="<?php echo I('get.startTime');?>" style="display: none"  placeholder="开始时间">
                </div>
                <div class="form-group">
                    <input type="text"  name="endTime" class="form-control input-xs" onClick="WdatePicker()" value="<?php echo I('get.endTime');?>" style="display: none"  placeholder="结束时间">
                </div>

                <div class="form-group ">
                    <label for="exampleInputName2">搜索条件:</label>
                    <select class="form-control input-xs" name="order_search">
                        <option value="">——请选择——</option>
                        <option value="1">邮箱</option>
                        <option value="2">昵称</option>
                        <option value="3">手机号</option>
                    </select>
                </div>

                <div class="form-group">
                    <input type="text" <?php echo xeq(I('get.order_search'),'','disabled');?> name="search_word" class="form-control input-xs" value="<?php echo I('get.search_word');?>"  placeholder="邮箱/昵称/手机号">
                </div>
                <div class="form-group">
                    <input type="submit"  class="btn btn-block btn-warning btn-xs" value="搜索">
                    <input type="hidden" name="is_close" value="1" id="is_close" >
                    <input type="hidden" name="is_cus" value="1" id="is_cus">
                </div>
            </div>
        </form>
    </div>
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <tbody>
                <tr>
                    <th>开通时间</th>
                    <th>邮箱</th>
                    <th>昵称</th>
                    <th>手机号</th>
                    <th>QQ</th>
                    <th>旺旺</th>
                    <th>来源</th>
                    <th>用户等级</th>
                    <th>操作</th>
                </tr>
            <?php if(is_array($datas["list"])): $i = 0; $__LIST__ = $datas["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td><?php echo ($vo["addtime"]); ?></td>
                    <td><?php echo ($vo["email"]); ?></td>
                    <td><?php echo ($vo["usernick"]); ?></td>
                    <td><?php echo ($vo["mobile"]); ?></td>
                    <td><?php echo ($vo["qq"]); ?></td>
                    <td><?php echo ($vo["wangwang"]); ?></td>
                    <?php if (1 == $vo['source']){ ?>
                    <td>星密码</td>
                    <?php } elseif (2 == $vo['source']){ ?>
                    <td>创想范</td>
                    <?php } else{?>
                    <td>代理商</td>
                    <?php } ?>
                    <td><?php echo ($vo["leavel"]); ?></td>                  
                    <td><a class="fqy_gysLook" onclick="open_detail('<?php echo ($vo["id"]); ?>')">查看</a></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
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
            <div class="pagination"> <?php echo ($datas["page"]); ?> </div>
        </div>
    </div>
</div>

<!--弹窗Start-->
<div class="fqy_Mask">
    <div class="fqy_Popup">
        <div class="fqy_upOldPass">
            <div class="fqy_popHead">
                <b>代理商资料</b>
                <span class="fqy_popClose">×</span>
            </div>
            <div class="fqy_popContent">
                <div class="fqy_fxsPOP">
                    <b>基本信息</b>
                    <table>
                        <tr>
                            <td>昵称：</td> 
                            <td class="fq-m-nc"><?php echo ($disUserDetail["usernick"]); ?></td>
                        </tr>
                        <tr>
                            <td>真实姓名：</td>
                            <td class="fq-m-name"><?php echo ($disUserDetail["realname"]); ?></td>
                            <td>身份证：</td>
                            <td class="fq-m-idcard"><?php echo ($disUserDetail["idcard"]); ?></td>
                        </tr>
                        <tr>
                            <td>邮箱：</td>
                            <td class="fq-m-email"><?php echo ($disUserDetail["email"]); ?></td>
                            <td>手机：</td>
                            <td class="fq-m-phone"><?php echo ($disUserDetail["mobile"]); ?></td>
                        </tr>
                        <tr>
                            <td>QQ：</td>
                            <td class="fq-m-qq"><?php echo ($disUserDetail["qq"]); ?></td>
                            <td>旺旺：</td>
                            <td class="fq-m-ww"><?php echo ($disUserDetail["wangwang"]); ?></td>
                        </tr>
                        <tr>
                            <td>账号来源：</td>
                            <td class="fq-m-ret"><?php echo ($disUserDetail["source"]); ?></td>
                            <td>代理商账号：</td>
                            <td class="fq-m-dl"><?php echo ($disUserDetail["agentaccount"]); ?></td>
                        </tr>
                        <tr></tr>
                    </table>
                    <p class="fqy_canlce"><button>确认</button></p>

                </div>
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
        }
        else {
            $('input[name="search_word"]').removeAttr('disabled');
        }
    });


    $('table').on('click', '.fqy_gysLook', function () {
        $('.fqy_Mask').css('visibility', 'visible');
        autocenter();
    });

    //    选择自定义时间 显示隐藏
    $('#fqy_time').change(function () {
        var val = $('#fqy_time  option:selected').val();

        if (val == 4) {
            $('#startTime,#endTime').show();
        } else {
            $('#startTime,#endTime').hide();
        }
    });
    
    function open_detail(did){
        $.post("/user/user/distributeDetail?userid="+did,function(result){
        	console.log(result);
            var data = result,
                q = $('.fqy_fxsPOP');
          q.find('.fq-m-nc').html(data.usernick);
          q.find('.fq-m-name').html(data.realname)
          q.find('.fq-m-idcard').html(data.idcard);
          q.find('.fq-m-email').html(data.email)
          q.find('.fq-m-phone').html(data.mobile);
          q.find('.fq-m-qq').html(data.qq)
          q.find('.fq-m-ww').html(data.wangwang);
          q.find('.fq-m-ret').html(data.source)
          q.find('.fq-m-dl').html(data.acting_account)
        });
    }


    //弹出层
    function autocenter() {
        var W = $(window).width() / 2;
        var H = $(window).height() / 2;
        var eleW = $('.fqy_Popup').width();
        var eleH = $('.fqy_Popup').height();
//        alert(eleH);

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