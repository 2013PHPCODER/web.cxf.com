<!DOCTYPE html>
<html>
    <head>
    <head>
        <meta charset="UTF-8">
        <!-- 设置360浏览器渲染模式,webkit 为极速内核，ie-comp 为 IE 兼容内核，ie-stand 为 IE 标准内核。 -->
        <meta name="renderer" content="webkit">
        <meta name="google" value="notranslate">
        <!-- 禁止Chrome 浏览器中自动提示翻译 -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <!-- 禁止百度转码 -->
        <meta name="Description" content="" />
        <meta name="Keywords" content="" />
        <meta name="author" content="">
        <meta name="Copyright" content="" />
        <title>创想范分销平台--会员中心</title>
        <link rel="shortcut icon" href="images/64x64.ico" type="image/x-icon" /> 
        <link rel="stylesheet" type="text/css" href="css/common.css" />
        <link rel="stylesheet" type="text/css" href="css/zengli.css" />
        <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
        <script src="//cdn.bootcss.com/knockout/3.3.0/knockout-min.js"></script>
        <script src="js/pseudo.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/public.js"></script>
        <script src="js/plus.js"></script>
    </head>
</head>
<body>
    <?php include_once 'base/vip_top.php'; ?>
    <div class="capital">
        <?php include_once 'base/vip_top_1.php'; ?>

        <div class="capital-box clearfix">
            <?php include_once 'base/vip_left.php'; ?>
            <div class="capital-body">
                <div class="capital-cont without">
                    <div class="capital-cont-box">
                        <div class="information-box clearfix">
                            <div class="information" id="get_user">
                                <h2>账户信息<span>(<i class="VIP"></i>创想范会员)</span></h2>
                                <!--<p><i class="user-email"></i><strong>邮箱：<span data-bind="text:email == ''? '未绑定' : email"></span></strong></p>-->
                                <p><i class="telphone"></i><strong>手机号：<span data-bind="text:mobile == ''? '未绑定' : mobile"></span></strong></p>
                                <!--<p><i class="money"></i><strong>支付宝：<span  data-bind="text:receiver_account == null ? '未绑定': receiver_account" ></span></strong></p>-->
                            </div>
                            <div class="shop" id="shop_survey_totol">
                                <h2>绑定店铺<span>数量：<b data-bind = "text:shop.shop_list.length"></b>/5</span><a onclick="openTB()">绑定</a></h2>
                                <div data-bind="foreach:{data:shop.shop_list,as:'auto'}">
                                    <p><i class="shop-name"></i><strong><span data-bind="text:nick "></span></strong></p>
                                </div>                               
                            </div>
                        </div>
                        <div class="shop-survey" id="shop_survey">
                            <div class="shop-survey-box clearfix">
                                <div class="shop-num">
                                    <h3>店铺概况</h3>
                                    <p><i class="shop-dw"></i>店铺商品总数：<span data-bind='text:shop.ck_count_total'></span></p>
                                    <p><i class="shop-up"></i>店铺商品总数：<span data-bind='text:shop.ck_count_total'></span></p>
                                </div>
                                <div class="shop-survey-name" data-bind="foreach:{data:shop.shop_list,as:'auto'}" >
                                    <p><i></i><span data-bind="text:nick,attr:{'tb_user_id':tb_user_id}">店铺名称1</span> <a data-bind="text:'商品数：'+goods_count">标签</a></p>
                                </div>
                            </div>
                            <div class="shop-indent clearfix">
                                <div class="shop-indent-lf">
                                    <ul>
                                        <li>待付款订单：（<span data-bind = "text:order_count[1]"></span>）</li>
                                        <li>异常款订单：（<span data-bind = "text:order_count[2]">4</span>）</li>
                                    </ul>
                                </div>
                                <div class="shop-indent-rf">
                                    <ul>
                                        <li>待发货订单：（<span data-bind = "text:order_count[3]">4</span>）</li>
                                        <li>售后货订单：（<span data-bind = "text:order_count[4]">4</span>）</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="user-ad">
                        <a href=""><img src="images/userCenter/user-ad.png"/></a>
                    </div>
                </div>
            </div>
            <?php include_once 'base/vip_right.php'; ?>
        </div>
    </div>
    <?php include_once 'base/vip_footer.php'; ?>

    <!--    <div class="marks" id="apply" style="display: block">-->
    <!--        <div class="PopDiv" style="width: 598px;min-width: 598px;margin: 200px auto 0;">-->
    <!--            <div class="PopHeader">-->
    <!--                <span class="PopTitle"><i class="PopDetails"></i>绑定店铺</span>-->
    <!--                <div class="PopColse"></div>-->
    <!--            </div>-->
    <!--            <div class="PopBody deposit">-->
    <!--                -->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
</body>
<script type="text/javascript">
    $('.capital-nav li').click(function () {
        $(this).addClass('active').siblings().removeClass('active')
    });
    $('.nav-sm-li').click(function () {
        $(this).addClass('act').siblings().removeClass('act');
    });
    $(function () {
        X.bindModel(requestUrl.get_user, 1, {'user_id': getCookieValue('user_id')}, 'body.list', ['get_user'], function () {

        });
        X.bindModel(requestUrl.shop_survey, 1, {'user_id': getCookieValue('user_id')}, 'body.list', ['shop_survey', 'shop_survey_totol'], function () {

        })
    })
</script>
</html>
