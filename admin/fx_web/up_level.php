<!DOCTYPE html>
<html>
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
        <title>创想范分销平台--版本升级</title>
        <link rel="stylesheet" type="text/css" href="css/zengli.css" />
        <link rel="stylesheet" type="text/css" href="css/common.css"/>
        <link rel="stylesheet" type="text/css" href="css/goodsList.css"/>
        <link rel="shortcut icon" href="images/64x64.ico" type="image/x-icon" />
        <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
        <script src="//cdn.bootcss.com/knockout/3.3.0/knockout-min.js"></script>
        <script src="js/pseudo.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/plus.js"></script>
        <script src="js/public.js"></script>
    </head>
    <body>
        <?php include_once 'base/vip_top.php'; ?>
        <div class="capital">
            <?php include_once 'base/vip_top_1.php'; ?>

            <div class="capital-box clearfix">
                <?php include_once 'base/vip_left.php'; ?>

                <div class="capital-body">
                    <div class="capital-cont">
                        <div class="cont-box">
                            <div class="cont-box-title">
                                <h2>账户升级</h2>
                            </div>
                            <div class="cont-box-body" id="leve_up">
                                <div class="cont-box-text bg-color">
                                    <span>当前版本：</span>
                                    <strong><i class="price-icon"><img src="images/userCenter/upgrade-icon1.png"/></i><span id="up_level_name"></span></strong>
                                </div>
                                <div class="cont-box-text" id="virtual_id">
                                    <span>升级版本：</span>
                                    <select name="" data-bind = "foreach:list,as:'auto'">
                                        <option value="" data-bind = "text:name,attr:{id:id,value:price}">——请选择——</option>
                                    </select>
                                    <span class="price">版本价格:<i class="level-price">200.00元</i></span>
                                </div>
                                <div class="cont-box-text bg-color">
                                    <span>升级费用：</span>
                                    <strong class="up-price">200.00元</strong>
                                </div>
                                <div class="cont-box-text">
                                    <span>验证：</span>
                                    <strong class="auth"><div id="drag" style="color: rgb(255, 255, 255);"></div></strong>
                                </div>
                                <div class="cont-box-text">
                                    <p><input type="button" class="btn btn-up" id="level_sub" value="提交" /></p>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <?php include_once 'base/vip_right.php'; ?>
            </div>
        </div>
        <?php include_once 'base/vip_footer.php'; ?>
    </body>

    <script type="text/javascript">
	$('#drag').drag();
    var level = getCookieValue('user_level'), levelStr = "";
    switch (level) {
        case "0":
            levelStr = "基础版";
            break;
        case "1":
            levelStr = "初级版";
            break;
        case "2":
            levelStr = "中级版";
            break;
        case "3":
            levelStr = "高级版";
            break;
    }
	$('#up_level_name').html(levelStr);
        X.bindModel(requestUrl.virtual, 1, {}, 'body', ['virtual_id'], function () {
        	 $('#closepay').click(function(){
	            	$('#pay_leve_up').fadeOut()
	            	$('#pay_leve_up>div').fadeOut()
	            })
        	var xx = $('.cont-box-text select').find('option:selected').attr('id');
        	addCookie('virtual_goods_id', xx);
            $('#virtual_id select').change(function () {
            	xx = $('.cont-box-text select').find('option:selected').attr('id');
        		addCookie('virtual_goods_id', xx);
                var level = {
                    'user_id': getCookieValue('user_id'),
                    'type': 1,
                    'virtual_goods_id': getCookieValue('virtual_goods_id')
                }
                X.Post(requestUrl.level, 1, level, function (result) {
                    if (result.header.stats == '9007') {
                        X.notice(result.header.msg, 3);
                    } else {
                        $('.level-price').html(result.body.list.to_leavel_price+'元');
                        $('.up-price').html((result.body.list.up_level_money).toFixed(2)+'元');
                    }
                })
            });
            //提交订单
            $('#level_sub').click(function () {
            	if (!dragyz) {
		            X.notice('您需要先验证', 3);
		            return false;
		        }
            	var level2 = {
	                'user_id': getCookieValue('user_id'),
	                'type': 2,
	                'virtual_goods_id': getCookieValue('virtual_goods_id')
	            };
	            if(dragyz) {
                    X.Post(requestUrl.level, 1, level2, function (result) {
                        if(result.header.stats==0){
                            var loca = result.body.list;
                            var buyOrder = {
                                order: loca.order_id,
                                orderSn: loca.order_num,
                                pay_amount: loca.up_level_money,
                                type:1
                            };
                            sessionStorage.setItem('orderInfo', JSON.stringify(buyOrder));
                            window.location.href = 'pay_order.php';
                        }else{
                            X.notice(result.header.msg,3)
                        }
                    })
                }else {
                    X.notice("您需要先验证", 1);
                }
            })
        })
    </script>
</html>