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
        <title>创想范分销平台--开通新账户</title>
        <link rel="stylesheet" type="text/css" href="css/zengli.css" />
        <link rel="stylesheet" type="text/css" href="css/common.css"/>
        <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
        <script src="//cdn.bootcss.com/knockout/3.3.0/knockout-min.js"></script>
        <script src="js/pseudo.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/public.js"></script>
        <script src="js/plus.js"></script> 
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
                                <h2>开通新账户</h2>
                            </div>
                            <div class="cont-box-body open" id="virtual_id">
                                <div class="cont-box-text">
                                    <span>账户类型：</span>
                                    <select name="" data-bind = "foreach:list,as:'auto'">
                                        <option data-bind = "text:name,attr:{id:id,value:price,'data-id':agent_price}"></option>
                                    </select>
                                    <span class="price">原价:<i class="ac_price">200.00元</i></span>
                                </div>
                                <div class="cont-box-text">
                                    <span>开通价：</span>
                                    <strong class="open-price"><b class="ac_price" id="op_price">200.00元</b></strong>
                                </div>
                                <div class="cont-box-text">
                                    <span>开通账户：</span>
                                    <input type="text" name="" id="vir_user" value="" />
                                    <span class="hint">*&nbsp;&nbsp;&nbsp;提醒：仅限手机号</span>
                                </div>
                                <div class="cont-box-text">
                                    <span>设置密码：</span>
                                    <input type="password" name="" id="new_pwd" value="" />
                                    <span class="hint">*&nbsp;&nbsp;&nbsp;此为：开通账户初始密码</span>
                                </div>
                                <div class="cont-box-text">
                                    <span>确认密码：</span>
                                    <input type="password" name="" id="rep_pwd" value="" />
                                    <span class="hint">*</span>
                                </div>
                                <div class="cont-box-text">
                                    <span>QQ：</span>
                                    <input type="text" name="" id="QQ" value="" />
                                    <span class="hint">*</span>
                                </div>
                                <div class="cont-box-text">
                                    <span>验证：</span>
                                    <strong class="auth"><div id="drag" style="color: rgb(255, 255, 255);"></div></strong>
                                </div>
                                <div class="cont-box-text">
                                    <span>备注：</span>
                                </div>
                                <textarea name="" class="leave" id="mark"></textarea>
                                <div class="cont-box-text open-btn">
                                    <p><input type="button" class="btn btn-up" id="vri_sub" value="提交" /></p>
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
</html>
<script type="text/javascript">
$(function(){
	
})

$('#drag').drag()
	X.bindModel(requestUrl.virtual,1,{},'body',['virtual_id'],function(){
		$('.cont-box-text select').find('option:selected').attr('data-id')+'元';
		$('#agent_id').html($('.cont-box-text select').find('option:selected').attr('data-id')+'元');
		var account_price = $('.cont-box-text select').find('option:selected').val() + '元';
        var xx = $('.cont-box-text select').find('option:selected').attr('id');
        var agent_id = $('.cont-box-text select').find('option:selected').attr('data-id')+'元'
        $('.ac_price').html(account_price);
         $('#op_price').html(agent_id)
		 $('.cont-box-text select').change(function () {
        var account_price = $('.cont-box-text select').find('option:selected').val() + '元';
        var xx = $('.cont-box-text select').find('option:selected').attr('id');
        var agent_id = $('.cont-box-text select').find('option:selected').attr('data-id')+'元'
        $('.ac_price').html(account_price);
        $('#op_price').html(agent_id)
   })
	})



	
        //提交订单
    $('#vri_sub').click(function () {
    	if (!dragyz) {
            X.notice('您需要先验证', 3);
            return false;
        }
    	var level2 = {
            'user_id':getCookieValue('user_id'),
			'virtual_goods_id':$('.cont-box-text option:selected').attr('id'),
			'new_account':$('#vir_user').val(),
			'pwd':$('#new_pwd').val(),
			're_pwd':$('#rep_pwd').val(),
			'qq':$('#QQ').val(),
			'mark':$('#mark').val()
        }
        X.Post(requestUrl.create_act, 1, level2, function (result) {
        	if(result.header.stats == 0){
    			var loca = result.body.list;
                var buyOrder = {
                    order: loca.order_id,
                    orderSn: loca.order_sn,
                    pay_amount: loca.money,
                    type:1
                };
                sessionStorage.setItem('orderInfo', JSON.stringify(buyOrder));
                window.location.href = 'pay_order.php';
        	}else{
        		X.notice(result.header.msg,3)
        	}
        })
    })
</script>

       
