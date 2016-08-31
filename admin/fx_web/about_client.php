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
        <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
        <style>
            .nav .nav-box .classify-box{display: none;}
        </style>
    </head>

    <body>
        <!--header-->
        <div class="header">
            <?php include_once 'base/index_top.php'; ?>
            <?php include_once 'base/index_top_1.php'; ?>
        </div>        
        <!--body-->
        <div class="g-main main-agent">
            <div class="g-applyAgent clearfix">
                <a href="javascript:;" class="">软件下载</a>
                <a href="javascript:;" 	>软件介绍</a>
                <a href="javascript:;" class="e-applyAgent">申请代理</a>
            </div>
            <div class="Ag-banner">
                <p class="p-title">创想范开店管家</p>
                <p class="p-mes">创想范开店管家主要解决实物供销问题，
                    <br/>供货商无需为货物销路发愁，只需要平台上进行供货即可。而分销商亦无须为货源发愁，
                    <br/>只需要在平台上进行下单即可。开店管家可以实现自动铺货，
                    <br/>一件代发。平台上的所有货品均经过官方严格审核，并且全场包邮。</p>
            </div>
            <div class="Ag-main">				
                <div class="Ag-main-info">
                    <p class="p-title">自动铺货</p>
                    <p class="p-mes">问：有几千件商品要上传，一件件的手动点击，而且上传
                        速度非常慢，等得砸电脑的心都有了？
                    </p>
                    <p class="p-mes">答：创想范独家批量处理功能，支持一键铺货；系统采用
                        独立服务器，全自动急速铺货，再多商品也不怕，您只需
                        轻轻点击一下鼠标，客户达瞬间帮您搞定。
                    </p>
                </div>

            </div>
        </div>
        <div class="marks Agmarks" id="agent">
            <div class="PopDiv" style="width: 770px;">
                <div class="PopHeader tx_c">
                    <span class="PopTitle">开通代理</span>
                    <div class="PopColse"></div>
                </div>
                <div class="PopBody Ag-PopBody">
                    <div class="Ag-agreement">
                        <p>1.2    平台开放平台有权根据包括但不限于品牌需求、公司经营状况、服务水平等其他因素退回卖家申请。</p>
                        <p>1.3    平台开放平台有权在申请入驻及后续经营阶段要求卖家提供其他资质。</p>
                        <p>1.4    平台开放平台将结合各行业发展动态、国家相关规定及消费者购买需求，不定期更新招商标准。</p>
                        <p>1.5    卖家必须如实提供资料和信息：</p>
                        <p>1.5.1 请务必确保申请入驻及后续经营阶段提供的相关资质和信息的真实性、完整性、有效性（若卖家提供的相关资质为第三方提供，包括但不限于商标注册证、授权书 等，请务必先行核实文件的真实有效完整性），一旦发现虚假资质或信息的，平台开放平台将不再与卖家进行合作并有权根据平台开放平台规则及与卖家签署的相关 协议之约定进行处理；</p>
                        <p>1.5.2  卖家应如实提供其店铺运营的主体及相关信息，包括但不限于店铺实际经营主体、代理运营公司等信息；</p>
                        <p>1.5.3  平台开放平台关于卖家信息和资料变更有相关规定的从其规定，但卖家如变更1.5.2项所列信息，应提前十日书面告知平台；如未提前告知平台，平台将根据平台开放平台规则进行处理。</p>
                        <p>1.6    平台开放平台暂不接受个体工商户的入驻申请，卖家须为正式注册企业，亦暂时不接受非中国大陆注册企业的入驻申请。</p>
                    </div>
                    <p class="p-agreed"><input type="checkbox" name="check" style="width: 20px"> 已阅读，并同意代理协议</p>
                    <div class="PopFooter Ag-PopFooter">
                        <button id="apply-agent">申请代理</button>
                    </div>
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
            	var user_id = getCookieValue('user_id');
            	if(user_id == '' || user_id == null){
            		X.notice('请先登录！',3);
            		return false;
            	}
	    		if(xx){
	    			X.Post(requestUrl.agent,1,{'user_id':user_id},function(e){
	    				$('#agent').fadeOut();
	    				X.notice(e.body.list.msg,3)
	    			})
	    		}else{
	    			X.notice('您需要先同意此协议',3)
	    		}
	    	})
            
        })
    </script>
</html>