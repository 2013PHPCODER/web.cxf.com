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
    <title>创想范分销平台--供货商提交资料审核</title>
    <link rel="stylesheet" type="text/css" href="css/common.css" />
    <link rel="stylesheet" type="text/css" href="css/main.css"/>
    <link rel="stylesheet" type="text/css" href="css/goodsList.css"/>
    <link rel="stylesheet" type="text/css" href="css/buy_orders.css"/>
    <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
    <script src="plupload-2.1.2/js/plupload.full.min.js"></script>
    <script src="js/MD5.js"></script>
    <script src="js/plus.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/public.js" type="text/javascript" charset="utf-8"></script>
    <style>
		.register_content >.register_type>span{
			border: 1px solid #d7d6d6;
		    border-radius: 3px;
		    padding: 5px 10px;
		    background: #fff;
		    color: #999999;
		    margin: 0 25px;
		    font-size: 14px;
		    cursor: pointer;
		}
	</style>
</head>
</head>
<body style="background: #fff">
<!--header-->
<div class="header">
    <div class="top">
        <div class="top-box clearfix">
            <div class="top-left">
                <a href="" class="welcome">您好，请登录</a>
                <a href="">注册</a>
                <a href="" class="clearfix"><i class="news-icon"></i><span>消息</span><i class="num-icon"></i></a>
            </div>
            <div class="top-right moseover">
                <a href=""><i class="my-icon1"></i><span>我的收藏夹</span></a>
                <a href=""><i class="my-icon2"></i><span>我的创想范</span></a>
                <a href=""><i class="my-icon3"></i><span>进货单</span></a>
                <a href=""><i class="my-icon4"></i><span>软件下载</span></a>
            </div>
        </div>
    </div>
    <div class="header-search clearfix">
        <div class="logo2">
            <a href="" class="logo-box"></a>
            <a href="" class="logo-img"></a>
        </div>
        <div class="trait2">
            <div class="a-group clearfix">
                <a href=""><i class="wholesale"></i><span>一件代发</span></a>
                <a href=""><i class="shipments"></i><span>48小时发货</span></a>
                <a href=""><i class="replacement"></i><span>15天包换</span></a>
            </div>
        </div>
    </div>

</div>
<!--body-->
<div class="fxs_register">
    <div class="registerDiv">
        <div class="register_header">供应商资料</div>
        <form id="sup_sub" autocomplete="on">
        <div class="register_content">
            <p class="tips_green">注册成功！还需完善供应商资料</p>
            <p class="register_type"><span class="autoActiveSty">个体工商户</span> &nbsp;&nbsp;&nbsp;&nbsp; <span>企业公司</span></p>
            <!--申请类型-->
            <div class="gys_fxs_info_div apply_div" style="display: block;">
                <table>
                    <tr>
                        <td>申请人姓名：</td>
                        <td><input type="text" placeholder="" id="apply_name"></td>
                    </tr>
                    <tr>
                        <td>申请人身份证号：</td>
                        <td><input type="text" placeholder="" id="apply_idcard"></td>
                    </tr>
                    <tr>
                        <td>主营类目：</td>
                        <td>
                            <select id="manager_category">
                                <option>1</option>
                                <option>2</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>申请人身份证：</td>
                        <td>
                            <label class="position_lable">
                                <a class="imgBtn" id="id_card">浏览并上传</a>
                                <span>&nbsp;&nbsp;（要求：正反面清晰）</span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="carPic">
                            <ul id="id_card_img">
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>手持身份证照：</td>
                        <td>
                            <label class="position_lable">
                                <a class="imgBtn" id="hand_id_card">浏览并上传</a>
                                <span>&nbsp;&nbsp;（要求：正反面清晰）</span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="carPic">
                            <ul id="hand_id_card_img">
                            </ul>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="gys_fxs_info_div apply_div">
                <table>
                    <tr>
                        <td>企业名称：</td>
                        <td><input type="text" placeholder="" id="company_name"></td>
                    </tr>
                    <tr>
                        <td>主营类目：</td>
                        <td>
                            <select id="manager_category_q">
                                <option>1</option>
                                <option>2</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>营业执照：</td>
                        <td>
                            <label class="position_lable">
                                <a class="imgBtn" id="bus_license">浏览并上传</a>
                                <span>&nbsp;&nbsp;（要求：正反面清晰）</span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="carPic">
                            <ul id="bus_license_img">                          	
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>法人身份证：</td>
                        <td>
                            <label class="position_lable">
                                <a class="imgBtn" id="legal_person">浏览并上传</a>
                                <span>&nbsp;&nbsp;（要求：正反面清晰）</span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="carPic">
                            <ul id="legal_person_img">
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>申请人姓名：</td>
                        <td><input type="text" placeholder="" id="apply_name_q"></td>
                    </tr>
                    <tr>
                        <td>申请人身份证号：</td>
                        <td><input type="text" placeholder="" id="apply_idcard_q"></td>
                    </tr>
                    <tr>
                        <td>申请人身份证：</td>
                        <td>
                            <label class="position_lable">
                                <a class="imgBtn" id="id_card_q">浏览并上传</a>
                                <span>&nbsp;&nbsp;（要求：正反面清晰）</span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="carPic">
                            <ul id="id_card_img_q">
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>手持身份证照：</td>
                        <td>
                            <label class="position_lable">
                                <a class="imgBtn" id="hand_id_card_q">浏览并上传</a>
                                <span>&nbsp;&nbsp;（要求：正反面清晰）</span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="carPic">
                            <ul id="hand_id_card_img_q">
                            	
                            </ul>
                        </td>
                    </tr>
                </table>
            </div>
            <!--支付类型-->
            <p class="aplay_type">
                <label><input type="radio" name="receiver_money_type" class="moeny_type_check" checked value="1">支付宝</label> &nbsp;&nbsp;&nbsp;&nbsp; <label><input class="moeny_type_check" type="radio" value="2"  name="receiver_money_type">银行卡</label>
            </p>
            <div class="gys_fxs_info_div moeny_type" style="display: block;">
                <table>
                    <tr>
                        <td>结算支付宝账户：</td>
                        <td><input type="text" placeholder="" id="zhbzh"></td>
                    </tr>
                    <tr>
                        <td>支付宝姓名：</td>
                        <td><input type="text" placeholder="" id="zhbname"></td>
                    </tr>
                </table>
            </div>
            <div class="gys_fxs_info_div moeny_type">
                <table>
                    <tr>
                        <td>填写开户行：</td>
                        <td><input type="text" placeholder="" id="yhname"></td>
                    </tr>
                    <tr>
                        <td>结算银行卡号：</td>
                        <td><input type="text" placeholder="" id="yhzh"></td>
                    </tr>
                    <tr>
                        <td>开户人姓名：</td>
                        <td><input type="text" placeholder="" id="yhrname"></td>
                    </tr>
                </table>
            </div>    
            <div class="gys_fxs_info_div">
                <table>   
                    <tr>
                        <td>手机号：</td>
                        <td><input type="text" placeholder="" name="mobile"></td>
                    </tr>
                    <tr>
                        <td>联系QQ：</td>
                        <td><input type="text" placeholder="" name="qq"></td>
                    </tr>
                    <tr>
                        <td>联系旺旺：</td>
                        <td><input type="text" placeholder="" name="wangwang"></td>
                    </tr>
                </table>
            </div>      
            <p class="centerP">
                <input type="button" class="autoBtn" value="提交审核">
            </p>
        </div>         
             	
        </form>
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
$(function(){
	$('.register_type>span').click(function(){
		var i = $(this).index();
		$(this).addClass('autoActiveSty').siblings().removeClass('autoActiveSty');
		$('.apply_div').hide();
		$('.apply_div').eq(i).show();
	})
	$('.moeny_type_check').click(function(){
		var i = $(this).parent().index();
		$('.moeny_type').hide();
		$('.moeny_type').eq(i).show();
	})
	$('.autoBtn').click(function(){
		var data = $('#sup_sub').serializeJson();
        data = $.extend(data,{
           'user_id':getUrlParam('user_id'),
           'apply_type':$('.autoActiveSty').index(),          
        });
        if(data.apply_type == 0){
        	data = $.extend(data,{
        	   'apply_name':$('#apply_name').val(),	 
        	   'apply_idcard':$('#apply_idcard').val(),
        	   'manager_category':$('#manager_category').children('option:checked').html(),
        	   'apply_idcard_img':idd1.file,
	           'apply_idcard_img_hand':idd2.file
        	});
        }else{
        	data = $.extend(data,{
        	   'company_name':$('#company_name').val(),
        	   'apply_name':$('#apply_name_q').val(),	 
        	   'apply_idcard':$('#apply_idcard_q').val(),
        	   'manager_category':$('#manager_category_q').children('option:checked').html(),
        	   'licence':idd3.file,
	           'legal_idcard_img':idd4.file,
	           'apply_idcard_img':idd1q.file,
	           'apply_idcard_img_hand':idd2q.file
        	});
        }
        if(data.receiver_money_type == 1){
        	data = $.extend(data,{
        	   'receiver_account':$('#zhbzh').val(),	 
        	   'receiver_account_name':$('#zhbname').val()
        	});
        }else{
        	data = $.extend(data,{
        	   'receiver_account':$('#yhzh').val(),
        	   'receiver_account_name':$('#yhrname').val(),
        	   'bank_address':$('#yhname').val()
        	});
        }
        var mobile=/^1[3-9][0-9]{9}$/;
        if(!mobile.test(data.mobile)){
              X.notice('手机号输入有误！',3);
              $('input[name = "mobile"]').focus();
              return false;
        }
//      var reg=/^[1-9]{1}[0-9]{14}$|^[1-9]{1}[0-9]{16}([0-9]|[xX])$/;
//      var reg=/^[1-9]{1}[0-9]{14}$|^[1-9]{1}[0-9]{16}([0-9]|[xX])$/;
//		if(!reg.test(data.apply_idcard)){
//			X.notice('身份证号码有误！',3);
//          return false;
//		}
		for(var i in data){
			if(data[i] == ''){
				if(data[i] != 0){
					X.notice('信息尚未填写完整',3);
				    return false
				}				
			}
			if(isArray(data[i]) && data[i].length <= 1){
				X.notice('图片上传不完整',3);
				return false
			}
		}
		
        X.Post(requestUrl.gh_auth,1,data,function(e){
        	if(e.header.stats == 0){
        	    X.notice(e.body.list,3);
        	    setTimeout(function(){
        	    	 window.location.href = 'index.php'
        	    },800)      	   
        	}else{
        		X.notice(e.header.msg,3);
        	}
        	
        })
	})	
	
	var idd1 = X.upLoadImg(['id_card',true,'#id_card_img','.imgBtn',1]);    	       //申请人身份证
	var idd2 = X.upLoadImg(['hand_id_card',true,'#hand_id_card_img','.imgBtn',1]);  //手持身份证照
	var idd3 = X.upLoadImg(['bus_license',true,'#bus_license_img','.imgBtn',1]);    //营业执照
	var idd4 = X.upLoadImg(['legal_person',true,'#legal_person_img','.imgBtn',1]);  //法人身份证
	var idd1q = X.upLoadImg(['id_card_q',true,'#id_card_img_q','.imgBtn',1]);    	       //申请人身份证
	var idd2q = X.upLoadImg(['hand_id_card_q',true,'#hand_id_card_img_q','.imgBtn',1]);  //手持身份证照
})	
function isArray(object){
    return object && typeof object==='object' &&
            Array == object.constructor;
}
</script>

</html>