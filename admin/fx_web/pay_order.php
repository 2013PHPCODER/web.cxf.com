<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="UTF-8">
        <!-- 设置360浏览器渲染模式,webkit 为极速内核，ie-comp 为 IE 兼容内核，ie-stand 为 IE 标准内核。 -->
        <meta name="renderer" content="webkit">
        <meta name="google" value="notranslate"><!-- 禁止Chrome 浏览器中自动提示翻译 -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta http-equiv="Cache-Control" content="no-siteapp" /><!-- 禁止百度转码 -->
        <meta name="Description" content=""/>
        <meta name="Keywords" content=""/>
        <meta name="author" content="">
        <meta name="Copyright" content="" />
        <title>创想范分销平台--订单支付</title>
        <link rel="stylesheet" type="text/css" href="css/common.css"/>
        <link rel="stylesheet" type="text/css" href="css/buy_orders.css"/>
        <link rel="stylesheet" type="text/css" href="css/goodsList.css"/>
        <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
        <script src="js/public.js"></script>
        <script src="//cdn.bootcss.com/knockout/3.3.0/knockout-min.js"></script>
        <script src="js/plus.js"></script>
    </head>
    <body>
        <!--header-->
        <div class="header">
            <?php include_once 'base/index_top.php'; ?>
        </div>
        <div class="g-top">
            <div class="order-stepbar clearfix">
                <h1 class="buy-logo">
                    <a target="_self" href="index.php" title=""><img src="images/goodsDetails/logo.png"/></a>
                </h1>
                <ol class="tb-stepbar">
                    <div class="s-line">
                        <p class="s-line-y"></p>
                    </div>
                    <li class="stepbar stepbar-current">
                        <p class="s-circle">1</p>
                        <p class="stepbar-name">填写核对订单</p>
                    </li>
                    <li class="stepbar">
                        <p class="s-circle">2</p>
                        <p class="stepbar-name">提交订单</p>
                    </li>
                    <li class="stepbar">
                        <p class="s-circle">3</p>
                        <p class="stepbar-name">订单付款</p>
                    </li>
                    <li class="" id="ddfh">
                        <p class="s-circle">4</p>
                        <p class="stepbar-name">等待发货</p>
                    </li>
                    <li class="stepbar-last">
                        <p class="s-circle"><i></i></p>
                        <p class="stepbar-name">确认收货</p>
                    </li>
                </ol>
            </div>
        </div>
        <div class="OrderOKDiv">
            <div class="orderTab">
                <h2>订单提交成功，请尽快付款</h2>
                <div class="orderContent">
                    <p>付款信息</p>
                    <p class="orderinfo">
                        <span style="float: left">订单号：<b id="orderID"></b></span>
                        <span style="float: right">应付金额：<b class="money"></b></span>
                    </p>
                    <div class="orderinfo2">
        <!--                <p>选择付款方式：</p>-->
                        <!--                <div class="Order_aplay_type">-->
                        <!--                    <p> &nbsp;&nbsp;&nbsp; <b>余额支付</b><span>可用余额：<span>888.00</span> 元</span></p>-->
                        <!--                    <div>-->
                        <!--                        <p><b>支付密码：</b><input type="text" placeholder=""><a href="">忘记密码？</a></p>-->
                        <!--                        <p class="centerP">-->
                        <!--                            <button class="aplayBtn">确认付款</button>-->
                        <!--                        </p>-->
                        <!--                    </div>-->
                        <!--                </div>-->
                        <!--                <div class="Order_aplay_type">-->
                        <!--                    <p> &nbsp;&nbsp;&nbsp; <b>在线支付</b><span>支持：微信和支付宝在线支付</span></p>-->
                        <!--                    <div>-->
                        <!--                        <ul>-->
                        <!--                            <li class="autoActiveSty">微信支付</li>-->
                        <!--                            <li>支付宝支付</li>-->
                        <!--                            <li>支付宝扫码支付</li>-->
                        <!--                        </ul>-->
                        <!--                    </div>-->
                        <!--                </div>-->
                        <div class="Order_aplay_type">
                            <p> &nbsp;&nbsp;&nbsp; <b>线下转账支付</b></p>
                            <div>
                                <p class="xxAplayType">
                                    <span class="xxActiveSty" type="3">微信转账</span>
                                    <span type="1">支付宝转账</span>
                                </p>
                                <div class="xxTabSty">
                                    <table>
                                        <tr>
                                            <td colspan="2">收款账户为：<span class="receiver_account"></span>  收款人：<span class="receiver_name"></span></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 70px">付款账户：</td>
                                            <td><input type="text" class="pay_account" placeholder=""></td>
                                        </tr>
                                        <tr>
                                            <td>交易单号：</td>
                                            <td><input type="text"  class="trade_no" placeholder=""></td>
                                        </tr>
                                    </table>
                                    <div>
                                        <img class="ewmImg" src="" alt="二维码">
                                        <p class="ewmText"></p>
                                    </div>
                                </div>
                                <p class="centerP">
                                    <button class="aplayBtn">提交订单</button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        include_once 'base/index_footer.php';
        ?>
    </body>
    <script type="text/javascript">
    //检查登录等
        CheckUserLogin();
        $(function () {
            if (getCookieValue('user_nickname') != '' && getCookieValue('user_nickname') != null) {
                $('.top-left').children('a').eq(0).html('您好，' + getCookieValue('user_nickname')).attr('href', '../vip_center.php');
                $('.top-left').children('a').eq(1).html('退出').attr('href', '../login.php').on('click', function () {
                    sessionStorage.removeItem('user_nickname');
                    sessionStorage.removeItem('user_id');
                });
                X.Post(requestUrl.top, 1, {'to_client': 1, 'page': 1}, function (e) {
                    $('.top-left').children('a').eq(2).find('.num-icon').html(e.body.list.list.length);
                });
//                t(requestUrl.top, 1, {'to_client': getCookieValue('user_id'), 'page': 1}, function (e) {
//                    $('.top-left').children('a').eq(2).find('.num-icon').html(e.body.list.list.length);
//                })

            } else {
                $('.num-icon').hide();
            }
        });
        $('.s-line-y').animate({'width': 435 + 'px'}, 600);
        var orderData = JSON.parse(sessionStorage.getItem('orderInfo'));
        $('#orderID').text(orderData.orderSn);
        $('.money').text('￥' + orderData.pay_amount);
        var payObj = {
            type: 3
        };
        
        account();
        function account() {
            X.Post(requestUrl.get_receiver_account, 1, '', function (res) {
                if (res.header.stats == 0) {
                    if (res.body.list.sucess == 1) {
                        $(res.body.list.data).each(function () {
                            if (this.receiver_platform == 1) {
                                payObj.zhifubao = this
                            } else if (this.receiver_platform == 2) {
                                payObj.yinghangka = this
                            } else if (this.receiver_platform == 3) {
                                payObj.weixin = this
                            }
                        });
                        //默认微信
                        $('.receiver_account').text(payObj.weixin.receiver_account);
                        $('.receiver_name').text(payObj.weixin.receiver_name);
                        $('.ewmImg').attr('src',payObj.weixin.img_path);
                        $('.ewmText').text('微信转账二维码');
                    } else {
                        X.notice('获取收款账户信息失败', 3);
                    }
                } else {
                    X.notice(res.header.msg, 3);
                }
            });
        }



        $('.xxAplayType').on('click', 'span', function () {
            $(this).siblings().removeClass('xxActiveSty').end().addClass('xxActiveSty');
            payObj.type = $(this).attr('type');
            var type = $(this).attr('type');
            if (type == 1) {
                $('.receiver_account,.receiver_name').text('');
                $('.receiver_account').text(payObj.zhifubao.receiver_account);
                $('.receiver_name').text(payObj.zhifubao.receiver_name);
                $('.ewmImg').attr('src',payObj.zhifubao.img_path);
                $('.ewmText').text('支付宝二维码');
            } else if (type == 2) {
                $('.receiver_account,.receiver_name').text('');
                $('.receiver_account').text(payObj.yinghangka.receiver_account);
                $('.receiver_name').text(payObj.yinghangka.receiver_name);
                $('.ewmImg').attr('src',payObj.yinghangka.img_path);
                $('.ewmText').text('银行卡转账二维码');
            } else if (type == 3) {
                $('.receiver_account,.receiver_name').text('');
                $('.receiver_account').text(payObj.weixin.receiver_account);
                $('.receiver_name').text(payObj.weixin.receiver_name);
                $('.ewmImg').attr('src',payObj.weixin.img_path);
                $('.ewmText').text('微信转账二维码');
            }
        });

        $('.aplayBtn').click(function () {
            var payData = {
                user_id: getCookieValue('user_id'), //用户ID
                user_name: getCookieValue('user_account'), //用户名
                order_id: orderData.order, //订单ID
                pay_account: $('.pay_account').val(), //付款账户
                receiver_account: $('.receiver_account').text(), //收款账户
                trade_no: $('.trade_no').val(), //交易单号
                pay_type: payObj.type    //支付类型
            };

            if (payData.pay_account == '') {
                X.notice('付款账户不能为空', 3);
            } else if (payData.trade_no == '') {
                X.notice('交易单号不能为空', 3);
            } else {
            	if(orderData.type == 1){
            		payData.confirm_money = orderData.pay_amount;   //虚拟订单支付金额   	
            		payData.order_sn = orderData.orderSn;      //虚拟订单编号
            		X.Post(requestUrl.pay_up_level, 1, payData, function (res) {
            			if(res.header.stats == 0){
            				if(res.body.list.sucess){
            					X.notice(res.body.list.msg, 3);
            					setTimeout(function(){
	            					window.location.href = 'up_level.php';
		                            //清空商品信息和订单信息
		                            sessionStorage.removeItem("goodsInfo");
            					},1500);
            				}
            				
            			}else{
            				X.notice(res.header.msg, 3);
            			}
            		})
            	}else{
            		X.Post(requestUrl.order_pay, 1, payData, function (res) {
                    if (res.header.stats == 0) {
                        $('#ddfh').addClass('stepbar');
                        $('.s-line-y').animate({'width': 610 + 'px'}, 600);
                        X.notice(res.body.list.message, 3);
                        setTimeout(function () {
                            window.location.href = 'orderlist.php';
                            //清空商品信息和订单信息
                            sessionStorage.removeItem("goodsInfo");
    //                        sessionStorage.removeItem("orderInfo");
                        }, 1000);
                    } else {
                        X.notice(res.header.msg, 3);
                    }
                });
            	}
                
            }
        })



    </script>
</html>
