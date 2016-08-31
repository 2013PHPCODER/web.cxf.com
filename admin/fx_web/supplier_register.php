<!DOCTYPE html>
<html>
    <head lang="en">
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
        <title>创想范分销平台--供货商注册</title>
        <link rel="shortcut icon" href="images/64x64.ico" type="image/x-icon" /> 
        <link rel="stylesheet" type="text/css" href="css/common.css" />
        <link rel="stylesheet" type="text/css" href="css/main.css"/>
        <link rel="stylesheet" type="text/css" href="css/goodsList.css"/>
        <link rel="stylesheet" type="text/css" href="css/buy_orders.css"/>
        <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
        <script src="//cdn.bootcss.com/knockout/3.3.0/knockout-min.js"></script>
        <script src="js/pseudo.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/plus.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/public.js" type="text/javascript" charset="utf-8"></script>
    </head>
</head>
<body style="background: #fff">
    <!--header-->
    <div class="header">
        <?php include_once 'base/index_top.php'; ?>
        <?php include_once 'base/detail_top.php'; ?>
    </div>
    <!--body-->
    <div class="fxs_register">
        <div class="registerDiv">
            <div class="register_header">供应商注册</div>
            <div class="register_content">
                <form id="gysRrgister">
                    <table>
                        <!--<tr>
                            <td></td>
                            <td colspan="2">
                                <label style="float: left"><input type="radio" name="radio" checked value="1">邮箱注册</label>
                                <label style="float: right"><input type="radio" name="radio" value="2">手机注册</label>
                            </td>
                            <td></td>
                        </tr>-->
                        <tr>
                            <td>电子邮箱：</td>
                            <td colspan="2"><input type="text" name="email" placeholder="" id="f_email"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>校验码：</td>
                            <td><input type="text" placeholder="" name="code"></td>
                            <td>
                             <div class='get_code'>
                            <span class="aginHq" id="send_auth_code">获取验证码</span>
                            <span class="send_success_tips"><strong id="show_times" class="red mr5">60</strong>秒后再次发送</span>
                            </div>
                            </td>
                        </tr>
                        <tr>
                            <td>设置密码：</td>
                            <td colspan="2"><input type="password" name="password" placeholder=""></td>
                        </tr>
                        <tr>
                            <td>确认密码：</td>
                            <td colspan="2"><input type="password" name="password2" placeholder=""></td>
                        </tr>
                        <!--<tr>
                            <td>联系QQ：</td>
                            <td colspan="2"><input type="text" placeholder=""></td>
                        </tr>-->
                        <tr>
                            <td>验证：</td>
                            <td colspan="2"><div id="drag"></div></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><label><input type="checkbox" name="checked">已阅读并且接受，<a href="">创想范服务条款</a></label></td>
                            <!--<td></td>-->
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="2" style="text-align: center"><input type="button" class="register" value="注册"></td>
                        </tr>
                    </table>
                </form>
                <p class="fxs_gys_href">
                    <a href="distribute_user_register.php">分销商注册</a>
                </p>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="footer-nav">
            <a target="_self" href="http://mycxf.org/shop/index.php?act=index&amp;op=index">首页</a>
            <a target="_self" href="http://mycxf.org/shop/index.php?act=article&amp;op=show&amp;article_id=16">招聘英才</a>
            <a target="_self" href="" style="display:none;">合作及洽谈</a>
            <a target="_self" href="http://mycxf.org/shop/index.php?act=article&amp;op=show&amp;article_id=29">联系我们</a>
            <a target="_self" href="http://mycxf.org/shop/index.php?act=article&amp;op=show&amp;article_id=16" style="display:none;">关于我们</a>
            <a target="_self" href="http://114.55.86.177:81/delivery/index.php">物流自取</a>
            <a target="_self" href="http://mycxf.org/shop/index.php?act=link&amp;op=index" class="nav-last">友情链接</a>
        </div>
        <div class="copyright-content">
            Copyright2016 创想范 All rights reserved
        </div>
    </div>
    
    
</body>
<script>
    $('#drag').drag();
    $('.register').click(function () {
        var data = $('#gysRrgister').serializeJson();
        var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
        if (!myreg.test(data.email)) {
            X.notice('请输入有效的E_mail！', 3);
            $('input[name = "email"]').focus();
            return false;
        }
        if (data.password != data.password2 || data.password.length <= 4) {
            X.notice('两次密码输如不一致或密码太短！', 3);
            $('input[name = "password2"]').focus();
            return false;
        }
        for (var i in data) {
            if (data[i] == '') {
                X.notice('请把信息填写完整', 3);
                return false;
            }
        }
        if (data.checked != 'on' || data.checked == undefined) {
            X.notice('您需要先同意条款', 3);
            return false;
        }
        if (!dragyz) {
            X.notice('您需要先验证', 3);
            return false;
        }
        delete data["checked"];
        X.Post(requestUrl.gh_register, 0, data, function (e) {
        	if(e.header.stats == 0){
        		X.notice(e.body.list.msg, 3);
        		setTimeout(function(){
        			window.location.href = 'supplier_submit_auth.php?user_id='+e.body.list.user_id        
        		},1000)
        	}else{
        	    X.notice(e.header.msg, 3);
        	}
        })
    })
//  发送验证码
        $('#send_auth_code').click(function () {
            	var data = {
            	   'to':$('#f_email').val(),
            	   'type':'email',
            	   'target':'gh_registe'
            	}
            	var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
                if (!myreg.test(data.to)) {
                    X.notice('请输入有效的E_mail！', 3);
                    $('#f_email').focus();
                    return false;
                }	
	            X.Post(requestUrl.paye_code,0,data,function(e){
	            	if (e.header.stats == 0) {
		                $('#send_auth_code').hide();
						$('.send_success_tips').addClass("show");
						var n = 59;	
						var timer=setInterval(function(){
							if(n>=0){
								$('.send_success_tips .mr5').html(n);
								n--;
							}else{			
								$('#send_auth_code').show();
					        $('.send_success_tips').removeClass("show");
					        $('.send_success_tips').find("strong").text('60');
								clearInterval(timer);
							}
					   },1000);				   					  					   
	                } else {
	                    X.notice(e.header.msg, 3)
	                }
	            })              
        })  
        $('#f_email').blur(function(){
	        if($(this).val() == ''){
	    		return false;
    	    }
        	var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
            if (!myreg.test($(this).val())) {
                X.notice('请输入有效的E_mail！', 3);
                return false;
            }	
        	X.Post(requestUrl.gh_regist_check,0,{'email':$(this).val()},function(e){
    		    if(e.header.stats == 0) {			   					  					   
	                X.notice(e.body.list, 3)
                }else {
                    X.notice(e.header.msg, 3)
                }
        	})
        })
        
</script>
</html>