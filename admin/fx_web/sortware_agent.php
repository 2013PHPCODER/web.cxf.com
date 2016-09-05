<!DOCTYPE html>
<html lang="zh-CN">

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
        <title>创想范分销平台--软件介绍与下载页</title>
        <link rel="shortcut icon" href="images/64x64.ico" type="image/x-icon" /> 
        <link rel="stylesheet" type="text/css" href="css/common.css" />
        <link rel="stylesheet" type="text/css" href="css/yz.css"/>
        <link rel="stylesheet" type="text/css" href="css/zengli.css"/>
        <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
        <style>
            .nav .nav-box .classify-box{display: none;}
            .top .top-box{width: 1360px;}
        </style>
    </head>

    <body style="overflow-x: hidden;">
        <!--header-->
        <div class="header">
            <?php include_once 'base/index_top.php'; ?>
            <?php include_once 'base/index_top_1.php'; ?>
        </div>        
        <!--body-->
        <div class="sor-wrapper">
        	<div class="fc9e24fc9e24" style="position: relative;">
        		<img src="http://maihoho.b0.upaiyun.com//top/4877366769770032923.jpg"/>
        		<a id="download" href="http://maihoho.b0.upaiyun.com//top/4897208356537409423.exe"></a>
        	</div>
        	<div class="sor-goods">
                <img src="images/qwr.png" alt="">
            </div>
        	<div class="sor-shop">
                <img src="images/qwt.png" alt="">
            </div>
            <div class="sor-last">
                <img src="images/qwy.png" alt="">
            </div>
        	<div class="sor-yb">
                <img src="images/qwu.png" alt="">
            </div>
        	</div>
        </div>
        <!--footer-->
        <?php include_once 'base/index_footer.php'; ?>
        <?php include_once 'base/index_footer_kefu.php';?>
    </body>
    <script>
        $(function () {
        	var xx =false;
        	$('input[name="check"]:checkbox').click(function(){
	           	xx =$(this).is(':checked')
	    	});
            $('.e-applyAgent').click(function () {
                $('#agent').show();
            })
            $('#agent .PopColse').click(function(){
            	$('#agent').hide();
            })
            $('#apply-agent').click(function(){  		
	    		if(xx){
	    			X.Post(requestUrl.agent,1,{'user_id':getCookieValue('user_id')},function(e){
	    				$('#agent').fadeOut();
	    				X.notice(e.body.list.msg,3)
	    			})
	    		}else{
	    			X.notice('您需要先同意该协议！',3)
	    		}
	    	})
            
        })
    </script>
</html>