<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html><html>    <head>        <meta charset="utf-8">        <meta name="viewport" content="width=device-width, initial-scale=1">        <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">        <meta http-equiv="X-UA-Compatible" content="IE=9">        <title>创想范供应商管理后台</title>        <meta name="description" content="{if $page_description}{/if}">        <link rel="stylesheet" href="/Public/css/bootstrap.min.css">        <link rel="stylesheet" href="/Public/css/AdminLTE.css">        <link rel="stylesheet" href="/Public/css/font-awesome.min.css">        <link rel="stylesheet" href="/Public/css/skins/_all-skins.min.css">        <link rel="stylesheet" href="/Public/css/skins/skin-red.css">        <link rel="stylesheet" href="/Public/css/skins/skin-red-light.css">        <link rel="stylesheet" href="/Public/css/bootstrap3-wysihtml5.min.css">        <link rel="stylesheet" href="/Public/css/bootstrap-datetimepicker.min.css">        <link rel="stylesheet" href="/Public/css/my.css">        <link rel="stylesheet" href="/Public/css/layer.css" id="layui_layer_skinlayercss">        <link rel="stylesheet" href="/Public/css/global.css">        <link rel="shortcut icon" href="/Public/images/64x64.ico" type="image/x-icon" />         <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>        <script src="/Public/js/global.js" type="text/javascript" charset="utf-8"></script>        <script src="/Public/js/kkpager.min.js" type="text/javascript" charset="utf-8"></script>        <script src="//cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>        <script src="/Public/js/WdatePicker.js" type="text/javascript"></script>        <style type="text/css">            .sidebar-menu>li{display: none;}            .navbar-static-top li{cursor: pointer;}        </style>    </head>    <body class="skin-yellow-light sidebar-mini">        <!--header start-->        <header class="main-header">            <a href="#" class="logo">                <span class="logo-mini"><b>创想范</b></span>                <span class="logo-lg"><b>创想范</b><small> 供货商管理后台</small></span>            </a>            <nav class="navbar navbar-static-top">                <div class="navbar-nav top-bar">                    <ul class="nav navbar-nav first-nav">                        <li data-cate = "goods">                            <a class="" href="<?php echo U('goods/goods/index');?>"><b>商品</b></a>                        </li>                        <li data-cate = "order">                            <a class="" href="<?php echo U('orders/orders/index');?>"><b>订单</b></a>                        </li>						                        <li data-cate = "storage">                            <a class="" href="<?php echo U('storage/storage/index');?>"><b>仓储</b></a>                        </li>                        <li data-cate = "finance">                            <a  href="<?php echo U('finance/finance/index');?>"><b>财务</b></a>                        </li>                        <li data-cate = "after-sales">                            <a class="" href="<?php echo U('afterSales/index/index');?>"><b>售后</b></a>                        </li><!--                        <li data-cate = "user">                            <a class="" href="<?php echo U('user/user/index');?>"><b>用户管理</b></a>                        </li>-->                        <li data-cate = "system">                            <a class="" href="<?php echo U('system/index/index');?>"><b>系统</b></a>                        </li>                    </ul>                </div>                <div class="navbar-custom-menu">                    <ul class="nav navbar-nav">                        <li class=" user user-menu">                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">                                <span class="hidden-xs"><?php echo ($username); ?></span>                            </a>                        </li>                        <li>                            <a href="<?php echo U('user/login/logout');?>">                                <span class="hidden-xs">退出登录</span>                            </a>                        </li>                    </ul>                </div>            </nav>        </header>        <!--header end-->        <!--wrapper start-->        <div class="content-wrapper" style="min-height: 368px;">            <aside class="main-sidebar">                <section class="sidebar">                    <ul class="sidebar-menu">                        <li data-cate="goods">                            <a class="active" href="<?php echo U('goods/goods/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 商品列表</a>                        </li><!--                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/goodsRelease');?>"> <i class="fa fa-fw  fa-circle-o"></i> 商品发布</a>                        </li>-->                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/importGoods');?>"> <i class="fa fa-fw  fa-circle-o"></i> 新增商品</a>                        </li><!--                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/goodsNoList');?>"> <i class="fa fa-fw  fa-circle-o"></i> 货号列表</a>                        </li>-->                        <li data-cate="order" >                            <a class="" href="<?php echo U('orders/orders/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 订单列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 发货列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storage/slist');?>"> <i class="fa fa-fw  fa-circle-o"></i> 仓库设置</a>                        </li>                                                <!--li data-cate="storage" >                            <a class="" href="<?php echo U('storage/cusManage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 售后收货</a>                        </li-->                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storageManage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 库存列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storageManage/logEdit');?>"> <i class="fa fa-fw  fa-circle-o"></i> 库存修改日志</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/freight/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 物流模板</a>                        </li>                        <li data-cate="finance" >                            <a class="" href="<?php echo U('finance/finance/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 收款账户</a>                        </li>                        <li data-cate="finance" >                            <a class="" href="<?php echo U('finance/finance/endOrder');?>"> <i class="fa fa-fw  fa-circle-o"></i> 完结订单</a>                        </li>                        <li data-cate="finance">                            <a class="" href="<?php echo U('finance/finance/paymentDetails');?>"> <i class="fa fa-fw  fa-circle-o"></i> 收支明细</a>                        </li>                        <li data-cate="after-sales" >                            <a class="" href="<?php echo U('afterSales/index/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>售后列表</a>                        </li>                        <li data-cate="after-sales" >                            <a class="" href="<?php echo U('afterSales/index/arbitrationList');?>"> <i class="fa fa-fw  fa-circle-o"></i>仲裁结果</a>                        </li><!--                        <li data-cate="user" >                            <a class="" href="<?php echo U('user/user/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>用户设置</a>                        </li>-->                        <li data-cate="system" >                            <a class="" href="<?php echo U('system/index/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>操作记录</a>                        </li>                        <li data-cate="system" >                            <a class="" href="<?php echo U('system/user/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 用户信息</a>                        </li>                    </ul>                </section>            </aside>            <script>                showMenu();                function showMenu() {                    var target = "<?php echo U(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME); ?>";                    target = target.toUpperCase();                    var selected = _show(target);                     //二级菜单选中标记                    if (!selected) {                //三级菜单选择                            var refUrl = $.cookie('__refUrl');                        var tmp = refUrl.split('/');                        var _target = tmp[1] + '/' + tmp[2];                        if (target.indexOf(_target) > 0) {                            _show(refUrl);                        }                        ;                    }                    function _show(target) {                        var r = 0;                                //选中标记                        $('.sidebar-menu a').removeClass('active');     //顶级菜单显示                        $('.sidebar-menu a').each(function () {                            var tmp = $(this).attr('href');                            tmp = tmp.toUpperCase();                            if (tmp == target) {                                $(this).addClass('active');                 //二级菜单显示                                var cate = $(this).parent().data('cate');                                $('.sidebar-menu').find("[data-cate='" + cate + "']").show();                                $('.navbar-static-top').find('[data-cate="' + cate + '"]').addClass('active');      //顶级菜单显示                                                            r = 1;                                return;                            }                        });                        if (r) {                                                    //二级菜单选中，记录refurl                              $.cookie('__refUrl', target, {expires: 30, path: '/'});                        }                        ;                        return r;                    }                }            </script>            <section class="content">                
    <style type="text/css">
        .dalog-modal{
            width: 100%;
            height: 100%;
            position: fixed;
            background: rgba(0,0,0,0.5);
            display: none;
            top: 0;
            left: 0;
            z-index: 999;
        }
        .dalog-container{
            width: 574px;
            position: absolute;
            top:300px;
            left: 50%;
            margin-left: -287px;
            margin-top: -200px;
            background: #fff;
            opacity: 1;
            z-index: 9999;
            border: 1px solid #ECECEC;
        }
        .dalog-container h2{margin: 0; width: 100%;height: 50px;background: #f39c12;color: #fff;font-family: "microsoft yahei";line-height: 50px;text-align: center;}
        .dalog-container span{
            display: inline-block;
            width: 100px;
            text-align: right;
        }
        .dalog-container label{margin-top: 20px;}
        .dalog-modal{
            display: none;
        }
        .dalog-modal .g-modal-content.add-entrepot input[type="text"]{
            margin: 0;
            position: relative;
        }
        .dalog-modal .g-modal-content.add-entrepot label strong{
            margin: 0 10px;
            color: #FF2015;
            display: inline;
        }
        .dalog-modal h2{
            padding: 10px 0;
            text-align: center;
        }
        .modal-content{
            padding: 10px 0;
            font-family: "microsoft yahei";
        }
        .dalog-modal  label{
            width: 200px;
            width: 100%;
            padding: 10px 40px;
            margin-top: 20px;
        }
        .dalog-modal label.error{
            width: 244px;
        }
        .modal-content label span{
            display: inline-block;
            width: 100px;
            text-align: right;
        }
        .dalog-modal .close{
            position: absolute;
            top: 0;
            right: 0;
            padding: 5px;
        }
        .dalog-modal .close:hover{
            cursor: pointer;
            width: 40px;
            height: 40px;
            background: #888888;
            border-radius: 5px;
            border-top-left-radius: 0;
            border-bottom-right-radius: 0;
        }
        .sub-btn{
            text-align: center;
            padding: 20px 0;
        }
        .sub-btn input{
            width: 150px;
            height: 40px;
            background: rgb(33,119,199);
            border: none;
            border-radius: 5px;
            box-shadow: 0 2px 2px #888888;
            color: #fff;
            font-family: "microsoft yahei";
            font-size: 20px;
            margin: 0 10px;
        }
        .sub-btn input:hover{
            box-shadow: 0 0 10px #888888;
            cursor: pointer;
        }
    </style>
    <div class="dalog-container">
        <h2>修改仓库</h2>
        <div class="g-modal-content add-entrepot">
            <form id="e_entrepot" action="<?php echo U(ACTION_NAME);?>" method="POST">
                <label><span>仓库名称：</span><input type="text" name="sname" id="" value="<?php echo ($list["sname"]); ?>" /></label>
                <label>
                    <span>仓库地区：</span>
                    <select name="province"></select><select name="city"></select><select name="area"></select>
                </label>
                <label><span>详细地址：</span><input class="freight" type="text" name="address" id="" value="<?php echo ($list["address"]); ?>" /></label>
                <label><span>仓库负责人：</span><input  name="functionary" type="text" id="e-person" value="<?php echo ($list["functionary"]); ?>" /></label>
                <label><span>手机号：</span><input type="text" name="mobile" value="<?php echo ($list["mobile"]); ?>"/></label>
                <label><span>运费模板：</span>
                    <select name="freight" id="">
                        <option value="">请选择</option>
                        <?php if(is_array($freight_template)): $i = 0; $__LIST__ = $freight_template;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["freight_template_id"]); ?>" <?php if($vo[freight_template_id] == $list[freight]): ?>selected="selected"<?php endif; ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </label>
                <input type="hidden" value="<?php echo ($list["id"]); ?>" name="id" />
                <div class="sub-btn"><input type="button" onclick="javascript:history.go(-1);" id="adress-btn1" class="sumb" value="取消"/><input type="submit" class="sumb" value="修改"/></div>
                {__TOKEN__}
            </form>
        </div>
    </div>
    <script type="text/javascript" src="/Public/js/jquery.validation.min.js"></script>
    <script type="text/javascript" src="/Public/js/cityClass.js"></script>
    <script type="text/javascript">
        $(function () {
            $('#clickMe').click(function () {
                $('.dalog-modal').show();
            })
            $('#add-adress').click(function () {
                $('.g-modal-content table').append('<tr><td></td>td></td>td></td>td></td>td></td></tr>');
            })
        });
    </script>
    <script type="text/javascript">
        $(function () {
           new PCAS("province","city","area",'<?php echo ($list["province"]); ?>','<?php echo ($list["city"]); ?>','<?php echo ($list["area"]); ?>');
            $('.removeTr').click(function () {
                $(this).parent().parent().remove();
            });
    //			$('.sumb').click(function(){
    //				document.getElementById('aleatMoudle').style.display = 'none'
    //			});
            $('#redact').click(function () {
                $('#aleatMoudle').show();
            })
            $('#adress-btn1').click(function () {
                $('#aleatMoudle').hide();
            })
            $('#dalogModalClose').click(function () {
                $('#aleatMoudle').hide();
            })
            $('#e_entrepot').validate({
                rules: {
                    e_person: {
                        required: true
                    },
                    e_telphone: {
                        required: true,
                        minlength: 11,
                        maxlength: 11,
                        checkarea: true
                    }
                },
                messages: {
                    e_person: {
                        required: '<strong>请输入负责人</strong>'
                    },
                    e_telphone: {
                        required: '<strong>请输入电话号码</strong>',
                        minlength: '<strong>请输入正确的电话号码位数</strong>',
                        max: '<strong>请输入正2确的电话号码位数</strong>'
                    }
                }
            });
        })
    </script>


            </section>        </div>        <!--wrapper end-->        <script src="/Public/js/bootstrap.min.js"></script>        <script src="/Public/js/app.min.js"></script>        <script type="text/javascript" src="/Public/js/moment.js"></script><!--         // <script src="/Public/js/bootstrap-datetimepicker.min.js"></script>        // <script src="/Public/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script> -->        <script type="text/javascript" src="/Public/js/custom.js"></script>        <script type="text/javascript" src="/Public/js/layer.js"></script>    </body></html>