
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
        <title>创想范分销平台--账户设置</title>
        <link rel="stylesheet" type="text/css" href="css/zengli.css" />
        <link rel="stylesheet" type="text/css" href="css/common.css"/>
        <link rel="shortcut icon" href="images/64x64.ico" type="image/x-icon" />
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
                <div class="capital-body" id="user_ifo">
                    <div class="capital-cont">
                        <div class="cont-box">
                            <div class="cont-box-title">
                                <h2>账户信息</h2>
                            </div>
                            <div class="cont-box-body">
                                <div class="cont-box-text">
                                    <span>用户名：</span>
                                    <strong data-bind = "text:list.user_account"></strong>
                                </div>
                                <div class="cont-box-text bg-color">
                                    <span>手机号：</span>
                                    <strong data-bind = "text:list.mobile"></strong>
                                    <i class="state">已验证</i>
                                    <a href="javascript:;" class="amend telp" id="click_tel">修改</a>
                                </div>
                                <div class="cont-box-text bg-color">
                                    <span>Q&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Q：</span>
                                    <strong data-bind = "text:list.qq"></strong>
                                </div>
                                <div class="cont-box-text bg-color">
                                    <span>注册时间：</span>
                                    <strong data-bind = "text:list.addtime"></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include_once 'base/vip_right.php'; ?>
            </div>
        </div>
        <?php include_once 'base/vip_footer.php'; ?>
        <!--修改手机-->
         <div class="marks" id="account_tel" style="display: none;">
            <div class="PopDiv" style="width: 485px;min-width: 485px;margin: 200px auto 0;">
                <div class="PopHeader">
                    <span class="PopTitle">验证新手机</span>
                    <div class="PopColse"></div>
                </div>
                <div class="PopBody">
                    <div class="change-box">
                        <label for="" class="next-telphone"><span>输入新手机号：</span><input type="text" name="" id="new-mobile" /></label>
                        <label for=""><span>输入新验证码：</span><input type="text" name=""  id="new_code"/><span class="s-send" id="new_up">发送验证码</span></label>
                        <label for=""><input type="button" class="btn pre-btn" id="" value="上一步" /><input type="button" class="btn next-btn" id="updata-sub" value="确认" /></label>
                    </div>
                </div>
            </div>
        </div>
        <!--验证弹窗-->
        <div class="marks" id="email_account" style="display: none;">
            <div class="PopDiv Security_yz" >
                <div class="PopHeader">
                    <img src="images/markicon01.png" alt="">
                    <span class="PopTitle">安全验证</span>
                    <div class="PopColse"></div>
                </div>
                <div class="PopBody">
                    <div class="mark-secVerify">
                        <p class="m-mobile">手机号<span data-bind = "text:list.mobile"></span></p>
                    </div>	    
                    <div class="sec-code">填写验证码：<input type="text" class="s-code" id="old_code"><span class="s-send"  id="old_up">发送验证码</span></div>
                </div>
                <div class="PopFooter">
                    <button id="next">下一步</button>
                </div>
            </div>
        </div>
    </body>
</html>


<script type="text/javascript">
$(function(){
	var user_info = {
        'user_id': getCookieValue('user_id')
   };
    X.bindModel(requestUrl.userinfo, 1, user_info, 'body', ['user_ifo'], function () {});
    $('');
  	$('.PopColse').click(function(){
  		$('.marks').fadeOut()
  	});
  	$('.marks').css('display','none');
});
//修改手机
  	$('#click_tel').click(function(){
  		X.bindModel(requestUrl.userinfo, 1, {'user_id':getCookieValue('user_id')}, 'body', ['email_account'], function () {});
  		$('#email_account').fadeIn();
  		$('#email_account>div').fadeIn();
    		$('#old_up').click(function(){
    			X.Post(requestUrl.mobile,1,{'field_data':getCookieValue('mobile'),'field':'mobile'},function(e){
    				addCookie('target',e.body.list.target);
    				if(e.header.stats==0){
    					X.notice(e.body.list.msg,3);
    					var n = 59;	
						var timer=setInterval(function(){
							if(n>=0){
								$('#old_up').html(n+'s后再次发送');
								n--;
							}else{			
								clearInterval(timer);
                                $('#old_up').html('发送验证码');
							}
					   },1000);	
    				}else{
    					X.notice(e.header.msg,3)
    				}
    			})
    			
    		});
    		//点击下一步
    		$('#next').click(function(){
    		    if(!$(".s-code").val()) {
                    X.notice("请输入验证码",3)
                }else {
                    X.Post(requestUrl.up_mobile,1,{'user_id':getCookieValue('user_id'),'field':'mobile','field_data':getCookieValue('mobile'),'code':$('#old_code').val(),'target':getCookieValue('target')},function(e){
                        if(e.header.stats==0){
                            $('#email_account').fadeOut();
                            $('#account_tel').fadeIn()
                        }else{
                            $('#email_account').fadeIn();
                            $('#account_tel').fadeOut();
                            X.notice(e.header.msg,3)
                        }
                    })
                }


			})
			//验证新手机获取验证码
			$('#new_up').click(function(){
    			X.Post(requestUrl.mobile,1,{'field_data':$('#new-mobile').val(),'field':'mobile'},function(e){
    				addCookie('target',e.body.list.target)
    				if(e.header.stats==0){
    					X.notice(e.body.list.msg,3)
    					var n = 59;	
						var timer=setInterval(function(){
							if(n>=0){
								$('#old_up').html(n+'s后再次发送');
								n--;
							}else{			
								clearInterval(timer);
							}
					   },1000);	
    				}else{
    					X.notice(e.header.msg,3)
    				}
    			})
    			
    		})
    		//修改
    		$('#updata-sub').click(function(){
			X.Post(requestUrl.up_mobile,1,{'update_data':$('#new-mobile').val(),'user_id':getCookieValue('user_id'),'field':'mobile','field_data':$('#new-mobile').val(),'code':$('#new_code').val(),'target':getCookieValue('target')},function(e){
				if(e.header.stats==0){
					X.notice(e.body.list.msg,3)
					$('.marks').fadeOut();
					window.location.reload()
				}else{
					X.notice(e.header.msg,3)
				}
			})
		})
	})
</script>