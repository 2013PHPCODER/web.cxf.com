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
        <title>创想范分销平台--资金明细</title>
        <link rel="shortcut icon" href="images/64x64.ico" type="image/x-icon" /> 
        <link rel="stylesheet" type="text/css" href="css/common.css" />
        <link rel="stylesheet" type="text/css" href="css/zengli.css" />
        <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
        <script src="//cdn.bootcss.com/knockout/3.3.0/knockout-min.js"></script>
        <script src="js/pseudo.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/public.js"></script>
        <script src="js/plus.js"></script> 
        <script src="js/laydate.js" type="text/javascript" charset="utf-8"></script>
    </head>
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
                            <span>选择交易类型：</span>
                            <select name="" id="selecType">
                                <option value="">——请选择——</option>
                                <option value="5">订单付款</option>
                                <option value="3">售后退款</option>
                                <option value="2">售后补款</option>
                                <option value="1">余额提现</option>
                            </select>
                            <span>选择时间：</span>
                            <input type="text" id="start" value="" />至
                            <input type="text" id="end" value="" />
                            <!--<span>关键字：</span>-->
                            <!--<input type="text" name="" class="keyword" placeholder="请输入关键字">
                            <input class="btn btn-search" type="button" id="" value="搜索" />-->
                        </div>
                        <div class="cont-box-body" id="statement">
                            <table>
                                <tr>
                                    <th>时间</th>
                                    <th>交易类型</th>
                                    <th>单号<span>(订单号/售后单号)</span></th>
                                    <th>金额</th>
                                    <th>方式</th>
                                    <th class="account">收款账户</th>
                                    <th>账户余额</th>
                                    <th>备注</th>
                                </tr>
                                <tbody id="statement-body" data-bind= "foreach:list,as:'auto'">
                                    <tr>
                                        <td data-bind = "text:add_time"><span>2016-7-27</span><span>21:39:42</span></td>
                                        <td data-bind = "text:trade_type_str">售后退款</td>
                                        <td data-bind = "text:trade_no">5656566565665</td>
                                        <td data-bind = "text:out_money">+278.00</td>
                                        <td data-bind = "text:remark">余额</td>
                                        <td><span data-bind = "text:trade_account">退款至余额</span></td>
                                        <td data-bind = "text:now_balance">278.00</td>
                                        <td data-bind = "text:remark">备注</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php include_once 'base/vip_right.php'; ?>
        </div>
    </div>
    <?php include_once 'base/vip_footer.php'; ?>
</body><script type="text/javascript">

var start = {
elem: '#start',
format: 'YYYY-MM-DD',
istime: true,
istoday: false,
choose: function(datas){
     end.min = datas; //开始日选好后，重置结束日的最小日期
     end.start = datas //将结束日的初始值设定为开始日
	}
};
	
var end = {
    elem: '#end',
    format: 'YYYY-MM-DD',
    istime: true,
    istoday: false,

};
laydate.skin('molv');
laydate(start);
laydate(end);
    var stats = {
        'user_id': getCookieValue('user_id'),
        'user_name': getCookieValue('user_account'),
        'page':1
        }
        X.bindModel(requestUrl.stats,1,stats,'body.list',['statement-body'],function(){
        })
        var ohtml=$('#statement-body').html();
        $('#selecType').change(function(){
        	ko.cleanNode(document.getElementById("statement-body"));
        	$('#statement-body').html(ohtml)
        	var data={
        		'user_id': getCookieValue('user_id'),
        		'user_name': getCookieValue('user_account'),
        		'page':1,
        		'trade_type':$('#selecType option:selected').val()
        	}
        	X.bindModel(requestUrl.stats,1,data,'body.list',['statement-body'],function(){})
        })
        //开始时间
        $('#start').blur(function(){
        	setTimeout(function(){
	        	ko.cleanNode(document.getElementById("statement-body"));
	        	$('#statement-body').html(ohtml)
	        	var data={
	        		'user_id': getCookieValue('user_id'),
	        		'user_name': getCookieValue('user_account'),
	        		'page':1,
	        		'start_time':$('#start').val()
	        	};
	        	X.bindModel(requestUrl.stats,1,data,'body.list',['statement-body'],function(){})
        	},150)
        })
//      结束时间
        $('#end').blur(function(){    	
        	setTimeout(function(){
	        	ko.cleanNode(document.getElementById("statement-body"));
	        	$('#statement-body').html(ohtml)
	        	var data={
	        		'user_id': getCookieValue('user_id'),
	        		'user_name': getCookieValue('user_account'),
	        		'page':1,
	        		'start_time':$('#end').val()
	        	};
	        	X.bindModel(requestUrl.stats,1,data,'body.list',['statement-body'],function(){})
        	},150) 
        })
        
</script>

</html>