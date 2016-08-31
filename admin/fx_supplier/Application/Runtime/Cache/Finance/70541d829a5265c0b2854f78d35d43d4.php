<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html><html>    <head>        <meta charset="utf-8">        <meta name="viewport" content="width=device-width, initial-scale=1">        <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">        <meta http-equiv="X-UA-Compatible" content="IE=9">        <title>创想范供应商管理后台</title>        <meta name="description" content="{if $page_description}{/if}">        <link rel="stylesheet" href="/Public/css/bootstrap.min.css">        <link rel="stylesheet" href="/Public/css/AdminLTE.css">        <link rel="stylesheet" href="/Public/css/font-awesome.min.css">        <link rel="stylesheet" href="/Public/css/skins/_all-skins.min.css">        <link rel="stylesheet" href="/Public/css/skins/skin-red.css">        <link rel="stylesheet" href="/Public/css/skins/skin-red-light.css">        <link rel="stylesheet" href="/Public/css/bootstrap3-wysihtml5.min.css">        <link rel="stylesheet" href="/Public/css/bootstrap-datetimepicker.min.css">        <link rel="stylesheet" href="/Public/css/my.css">        <link rel="stylesheet" href="/Public/css/layer.css" id="layui_layer_skinlayercss">        <link rel="stylesheet" href="/Public/css/global.css">        <link rel="shortcut icon" href="/Public/images/64x64.ico" type="image/x-icon" />         <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>        <script src="/Public/js/global.js" type="text/javascript" charset="utf-8"></script>        <script src="/Public/js/kkpager.min.js" type="text/javascript" charset="utf-8"></script>        <script src="//cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>        <script src="/Public/js/WdatePicker.js" type="text/javascript"></script>        <style type="text/css">            .sidebar-menu>li{display: none;}            .navbar-static-top li{cursor: pointer;}        </style>    </head>    <body class="skin-yellow-light sidebar-mini">        <!--header start-->        <header class="main-header">            <a href="#" class="logo">                <span class="logo-mini"><b>创想范</b></span>                <span class="logo-lg"><b>创想范</b><small> 供货商管理后台</small></span>            </a>            <nav class="navbar navbar-static-top">                <div class="navbar-nav top-bar">                    <ul class="nav navbar-nav first-nav">                        <li data-cate = "goods">                            <a class="" href="<?php echo U('goods/goods/index');?>"><b>商品</b></a>                        </li>                        <li data-cate = "order">                            <a class="" href="<?php echo U('orders/orders/index');?>"><b>订单</b></a>                        </li>						                        <li data-cate = "storage">                            <a class="" href="<?php echo U('storage/storage/index');?>"><b>仓储</b></a>                        </li>                        <li data-cate = "finance">                            <a  href="<?php echo U('finance/finance/index');?>"><b>财务</b></a>                        </li>                        <li data-cate = "after-sales">                            <a class="" href="<?php echo U('afterSales/index/index');?>"><b>售后</b></a>                        </li><!--                        <li data-cate = "user">                            <a class="" href="<?php echo U('user/user/index');?>"><b>用户管理</b></a>                        </li>-->                        <li data-cate = "system">                            <a class="" href="<?php echo U('system/index/index');?>"><b>系统</b></a>                        </li>                    </ul>                </div>                <div class="navbar-custom-menu">                    <ul class="nav navbar-nav">                        <li class=" user user-menu">                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">                                <span class="hidden-xs"><?php echo ($username); ?></span>                            </a>                        </li>                        <li>                            <a href="<?php echo U('user/login/logout');?>">                                <span class="hidden-xs">退出登录</span>                            </a>                        </li>                    </ul>                </div>            </nav>        </header>        <!--header end-->        <!--wrapper start-->        <div class="content-wrapper" style="min-height: 368px;">            <aside class="main-sidebar">                <section class="sidebar">                    <ul class="sidebar-menu">                        <li data-cate="goods">                            <a class="active" href="<?php echo U('goods/goods/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 商品列表</a>                        </li><!--                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/goodsRelease');?>"> <i class="fa fa-fw  fa-circle-o"></i> 商品发布</a>                        </li>-->                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/importGoods');?>"> <i class="fa fa-fw  fa-circle-o"></i> 新增商品</a>                        </li><!--                        <li data-cate="goods" >                            <a class="" href="<?php echo U('goods/goods/goodsNoList');?>"> <i class="fa fa-fw  fa-circle-o"></i> 货号列表</a>                        </li>-->                        <li data-cate="order" >                            <a class="" href="<?php echo U('orders/orders/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 订单列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 发货列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storage/slist');?>"> <i class="fa fa-fw  fa-circle-o"></i> 仓库设置</a>                        </li>                                                <!--li data-cate="storage" >                            <a class="" href="<?php echo U('storage/cusManage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 售后收货</a>                        </li-->                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storageManage/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 库存列表</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/storageManage/logEdit');?>"> <i class="fa fa-fw  fa-circle-o"></i> 库存修改日志</a>                        </li>                        <li data-cate="storage" >                            <a class="" href="<?php echo U('storage/freight/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 物流模板</a>                        </li>                        <li data-cate="finance" >                            <a class="" href="<?php echo U('finance/finance/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 收款账户</a>                        </li>                        <li data-cate="finance" >                            <a class="" href="<?php echo U('finance/finance/endOrder');?>"> <i class="fa fa-fw  fa-circle-o"></i> 完结订单</a>                        </li>                        <li data-cate="finance">                            <a class="" href="<?php echo U('finance/finance/paymentDetails');?>"> <i class="fa fa-fw  fa-circle-o"></i> 收支明细</a>                        </li>                        <li data-cate="after-sales" >                            <a class="" href="<?php echo U('afterSales/index/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>售后列表</a>                        </li>                        <li data-cate="after-sales" >                            <a class="" href="<?php echo U('afterSales/index/arbitrationList');?>"> <i class="fa fa-fw  fa-circle-o"></i>仲裁结果</a>                        </li><!--                        <li data-cate="user" >                            <a class="" href="<?php echo U('user/user/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>用户设置</a>                        </li>-->                        <li data-cate="system" >                            <a class="" href="<?php echo U('system/index/index');?>"> <i class="fa fa-fw  fa-circle-o"></i>操作记录</a>                        </li>                        <li data-cate="system" >                            <a class="" href="<?php echo U('system/user/index');?>"> <i class="fa fa-fw  fa-circle-o"></i> 用户信息</a>                        </li>                    </ul>                </section>            </aside>            <script>                showMenu();                function showMenu() {                    var target = "<?php echo U(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME); ?>";                    target = target.toUpperCase();                    var selected = _show(target);                     //二级菜单选中标记                    if (!selected) {                //三级菜单选择                            var refUrl = $.cookie('__refUrl');                        var tmp = refUrl.split('/');                        var _target = tmp[1] + '/' + tmp[2];                        if (target.indexOf(_target) > 0) {                            _show(refUrl);                        }                        ;                    }                    function _show(target) {                        var r = 0;                                //选中标记                        $('.sidebar-menu a').removeClass('active');     //顶级菜单显示                        $('.sidebar-menu a').each(function () {                            var tmp = $(this).attr('href');                            tmp = tmp.toUpperCase();                            if (tmp == target) {                                $(this).addClass('active');                 //二级菜单显示                                var cate = $(this).parent().data('cate');                                $('.sidebar-menu').find("[data-cate='" + cate + "']").show();                                $('.navbar-static-top').find('[data-cate="' + cate + '"]').addClass('active');      //顶级菜单显示                                                            r = 1;                                return;                            }                        });                        if (r) {                                                    //二级菜单选中，记录refurl                              $.cookie('__refUrl', target, {expires: 30, path: '/'});                        }                        ;                        return r;                    }                }            </script>            <section class="content">                <section class="content">
    <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> 位置</li>
        <li>财务管理</li>
        <li>账户管理</li>
    </ol>
    <div class="box-body fqy_skzh">
        <p>账户余额：<span><?php echo number_format($supplier_info['balance'], 2, '.', '');?></span></p>
        <p>未结算订单总金额：<span><?php echo ($balance); ?></span></p>
        <?php if(empty($supplier_info['pay_pwd'])): ?><p>支付密码：<span>未设置</span><button class="fqy_Addbtn1 btn btn-default">添加</button></p>
            <?php else: ?><p>支付密码：<span>已设置</span><button class="fqy_Addbtn1 btn btn-default">修改</button><?php endif; ?>
        <?php if(empty($supplier_info['receiver_account_name'])): ?><p>收款账号：<span>未设置</span><button class="fqy_Addbtn2 btn btn-default" <?php if(empty($supplier_info['pay_pwd'])): ?>disabled="disabled"<?php endif; ?>>添加</button></p>
            <?php else: ?><p>收款账号：<span>已设置</span><button class="fqy_Addbtn2 btn btn-default" <?php if(empty($supplier_info['pay_pwd'])): ?>disabled="disabled"<?php endif; ?>>修改</button></p><?php endif; ?>
    </div>
    <!--弹窗Start-->
    <div class="fqy_Mask">
        <div class="fqy_Popup">
            <div class="fqy_aplay" style="display: none">
                <div class="fqy_popHead">
                    <b>设置支付密码</b>
                    <span class="fqy_popClose">×</span>
                </div>
                <div class="fqy_popContent">
                    <form action="<?php echo U('finance/editPayPwd');?>" method="post" id="set_pay_pwd">
                        <table>
                            <tr>
                                <td>登录密码：</td>
                                <td><input type="password" name="loginPass" class="loginPass" placeholder="请输入登陆密码"></td>
                                <td><span class="fqy_tips">登陆密码错误</span></td>
                            </tr>
                            <tr>
                                <td>支付密码：</td>
                                <td><input type="password" name="payPass"  class="payPass" placeholder="请输入支付密码"></td>
                                <td><span class="fqy_tips">支付密码错误</span></td>
                            </tr>
                            <tr>
                                <td>再次输入支付密码：</td>
                                <td><input type="password" name="againPayPass"  class="againPayPass" placeholder="请输入支付密码"></td>
                                <td><span class="fqy_tips">支付密码错误</span></td>
                            </tr>
                            <tr>
                                <td>已验证手机：</td>
                                <td class="fqy_phone"><input name="mobile" type="hidden" value="<?php echo ($supplier_info['mobile']); ?>"><?php echo ($supplier_info['mobile']); ?></td>
                            </tr>
                            <tr>
                                <td>请填写手机校验码：</td>
                                <td><input type="text" name="phoneCode"  class="phoneCode" placeholder="请输入手机校验码"></td>
                                <td><a class="btn btn-default getAccPayPass" href="#" role="button">获取短信校验码</a></td>
                                <td><span class="fqy_tips">短信校验码错误</span></td>
                            </tr>
                            <tr>
                                <td>请输入验证码：</td>
                                <td><input type="text" name="checkCode" placeholder="验证码" class='checkCode'></td>
                                <td>
                                    <img class="refreshCode" height="50" alt="验证码" src="<?php echo U('finance/finance/verify_c',array());?>" title="点击刷新"/>  
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center!important;" colspan="4"><input class="fqy_setPassBtn" type="button"  value="提交"></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>

            <div class="fqy_Account">
                <div class="fqy_popHead">
                    <b>设置收款账号</b>
                    <span class="fqy_popClose">×</span>
                </div>
                <div class="fqy_popContent">
                    <form id="set_account" action="<?php echo U('finance/editAccount');?>" method="post">
                        <table>
                            <tr>
                                <td>支付密码：</td>
                                <td><input type="password" name="accPayPass" class="accPayPass" placeholder="请输入支付密码"></td>
                                <td><span class="fqy_tips">请输入支付密码</span></td>
                            </tr>
                            <tr>
                                <td>收款账户类型：</td>
                                <td><label><input name="receiver_account_type" type="radio"
                                                  <?php if($supplier_info["receiver_account_type"] == '' || $supplier_info["receiver_account_type"] == 1): ?>checked="checked"<?php endif; ?> value="1" />支付宝 </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label><input name="receiver_account_type" type="radio" value="2" <?php if(($supplier_info["receiver_account_type"]) == "2"): ?>checked="checked"<?php endif; ?> />银行卡 </label> </td>
                                <td><span class="fqy_tips">请输入支付账号</span></td>
                            </tr>
                            <tr class="alipay">
                                <td>支付宝收款账号：</td>
                                <td><input type="text" name="receiver_account" value="<?php echo ($supplier_info["receiver_account"]); ?>" class="receiver_account" placeholder="请输入支付宝收款账号"></td>
                                <td><span class="fqy_tips">请输入收款账号</span></td>
                            </tr>
                            <tr class="bank">
                                <td>开户行：</td>
                                <td><input type="text" name="open_bank_address" value="<?php echo ($supplier_info["open_bank_address"]); ?>" class="open_bank_address" placeholder="例:河北大学保定支行"></td>
                                <td><span class="fqy_tips">请输入开户行</span></td>
                            </tr>
                            <tr class="bank"> 
                                <td>银行卡号：</td>
                                <td><input type="number" name="receiver_bank_card" value="<?php echo ($supplier_info["receiver_bank_card"]); ?>"  class="receiver_bank_card" maxlength="25" placeholder="请输入卡号"></td>
                                <td><span class="fqy_tips">请输入卡号</span></td>
                            </tr >
                            <tr> 
                                <td>收款人姓名：</td>
                                <td><input type="text" name="receiver_account_name" value="<?php echo ($supplier_info["receiver_account_name"]); ?>"  class="receiver_account_name" placeholder="收款账号对应收款人姓名"></td>
                                <td><span class="fqy_tips">请输入收款账户名</span></td>
                            </tr >
                            <tr>
                                <td>已验证手机：</td>
                                <td class="fqy_phone"><input name="mobile" type="hidden" value="<?php echo ($supplier_info['mobile']); ?>"><?php echo ($supplier_info['mobile']); ?></td>
                            </tr>
                            <tr>
                                <td>请填写手机校验码：</td>
                                <td><input type="text" name="accPhoneCode" class="accPhoneCode" placeholder="请输入手机校验码"></td>
                                <td><a class="btn btn-default getAccPayPass" href="#" role="button">获取短信校验码</a></td>
                            </tr>
                            <tr>
                                <td>请输入验证码：</td>
                                <td><input type="text" name="checkCode" placeholder="验证码" class='checkCode'></td>
                                <td>
                                    <img class="refreshCode" height="50" alt="验证码" src="<?php echo U('finance/finance/verify_c',array());?>" title="点击刷新"/>  
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center!important;" colspan="4"><input class="fqy_setAccountBtn" type="button"  value="提交"></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--弹窗End-->
</section>

<script type="text/javascript" src="/Public/static/layer/layer.js"></script> 
<script>
    var receiver_account_type = "<?php echo ($supplier_info["receiver_account_type"]); ?>";
    if(1 == receiver_account_type){
         $('.bank').hide();
    }else{
        $('.alipay').hide();
    }
   
    $("input[name='receiver_account_type']").click(function(){
        var v = $(this).val();
        if(1 == v){
            $('.bank').hide();
            $('.alipay').show();
        }else{
            $('.alipay').hide();
            $('.bank').show();
        }
    });
    //刷新验证码
    $('.refreshCode').click(function () {
        var verifyimg = $('.refreshCode').attr("src");
        if (verifyimg.indexOf('?') > 0) {
            $(this).attr("src", verifyimg + '&random=' + Math.random());
        } else {
            $(this).attr("src", verifyimg.replace(/\?.*$/, '') + '?' + Math.random());
        }
    });
    //添加支付账号及密码
    $('.fqy_skzh').on('click', '.fqy_Addbtn1', function () {
        fqy_yzm();
        $('.fqy_Mask').css('visibility', 'visible');
        $('.fqy_Account').hide();
        $('.fqy_aplay').show();
    });
    $('.fqy_skzh').on('click', '.fqy_Addbtn2', function () {
        fqy_yzm();
        $('.fqy_Mask').css('visibility', 'visible');
        $('.fqy_aplay').hide();
        $('.fqy_Account').show();
    });

    //    设置支付密码输入校验
    $('.fqy_setPassBtn').click(function () {
        var PaypassData = {
            loginPass: $('.loginPass').val(),
            payPass: $('.payPass').val(),
            againPayPass: $('.againPayPass').val(),
            phoneCode: $('.phoneCode').val(),
            checkCode: $('.checkCode').val(),
            fqy_yzmText: $('.fqy_yzmText').html()
        };
        if (PaypassData.loginPass == '') {
            showTips('loginPass', '登陆密码不能为空');
        } else if (PaypassData.loginPass.length < 6) {
            showTips('loginPass', '密码长度小于6位数');
        } else if (PaypassData.payPass == '') {
            showTips('payPass', '支付密码密码不能为空');
        } else if (PaypassData.payPass.length < 6) {
            showTips('payPass', '密码长度小于6位数');
        } else if (PaypassData.againPayPass == '' || PaypassData.againPayPass != PaypassData.payPass) {
            showTips('againPayPass', '两次密码不一致');
        } else {
            var data;
            data = $('#set_pay_pwd').serialize();
            $.post("<?php echo U('finance/finance/editPayPwd');?>", data, function (result) {
                if (result.status == 1) {
                    layer.alert(result.info, {btn: ['确定']}, function (index) {
                        layer.close(index);
                        window.location.reload();
                    });
                } else {
                    layer.alert(result.info, {btn: ['确定']}, function (index) {
                        $(".refreshCode").click();
                        layer.close(index);
                    });
                }
            });
        }
    });
    //    设置收款账号输入校验
    $('.fqy_setAccountBtn').click(function () {
        var AccountData = {
            accNum: $('.accNum').val(),
            accPayPass: $('.accPayPass').val(),
            accPhoneCode: $('.accPhoneCode').val(),
            accCheckCode: $('.accCheckCode').val(),
            fqy_yzmText: $('.fqy_yzmText').html()
        };
        if (AccountData.accNum == '') {
            showTips('accNum', '支付账号不能为空');
        } else if (AccountData.accPayPass == '') {
            showTips('accPayPass', '支付密码不能为空');
        } else {
            var data;
            data = $('#set_account').serialize();
            $.post("<?php echo U('finance/finance/editAccount');?>", data, function (result) {
                if (result.status == 1) {
                    layer.alert(result.info, {btn: ['确定']}, function (index) {
                        layer.close(index);
                        window.location.reload();
                    });
                } else {
                    layer.alert(result.info, {btn: ['确定']}, function (index) {
                        layer.close(index);
                    });
                }
            });
        }
    });

    $('.getAccPayPass').click(function () {
        var mobile = "<?php echo ($supplier_info['mobile']); ?>";
        if('' == mobile){
            layer.alert('手机号为空', {btn: ['确定']}, function (index) {
                    layer.close(index);
                });
                return false;
        }
        $.post("<?php echo U('finance/finance/getAccPayPass');?>", {phone: "<?php echo ($supplier_info['mobile']); ?>"}, function (result) {
            if (result.status == 1) {
                layer.alert(result.info, {btn: ['确定']}, function (index) {
                    layer.close(index);
                });
            }
            layer.alert(result.message, {btn: ['确定']}, function (index) {
                layer.close(index);
            });
        });
    });

    //提示信息
    function showTips(ele, text) {
        $('.' + ele).css('borderColor', '#cc3300');
        $('.' + ele).parent('td').next('td').find('.fqy_tips').text(text).fadeIn();
        setTimeout(function () {
            $('.' + ele).css('borderColor', '#ccc');
            $('.' + ele).parent('td').next('td').find('.fqy_tips').text(text).fadeOut();
        }, 2500);
    }
    //    验证码
    function fqy_yzm() {
        var arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'], str = '';
        for (var i = 0, j = 0; i < arr.length, j < 4; i++, j++) {
            str += arr[Math.ceil(Math.random() * 35)];
        }
        $('.fqy_yzmText').empty().text(str).css({'letter-spacing': Math.ceil(Math.random() * 29), 'font-size': Math.ceil(13 + Math.random() * 8), 'line-height': Math.ceil(10 + Math.random() * 40) + 'px'});
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
</script>            </section>        </div>        <!--wrapper end-->        <script src="/Public/js/bootstrap.min.js"></script>        <script src="/Public/js/app.min.js"></script>        <script type="text/javascript" src="/Public/js/moment.js"></script><!--         // <script src="/Public/js/bootstrap-datetimepicker.min.js"></script>        // <script src="/Public/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script> -->        <script type="text/javascript" src="/Public/js/custom.js"></script>        <script type="text/javascript" src="/Public/js/layer.js"></script>    </body></html>