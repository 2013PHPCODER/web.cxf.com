

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
        <title>创想范分销平台--售后列表</title>
        <link rel="stylesheet" type="text/css" href="css/zengli.css" />
        <link rel="stylesheet" type="text/css" href="css/common.css"/>
        <link rel="shortcut icon" href="images/64x64.ico" type="image/x-icon" />
        <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
        <script src="//cdn.bootcss.com/knockout/3.3.0/knockout-min.js"></script>
        <script src="js/plus.js"></script>
        <script src="js/public.js"></script>
        <script src="js/pseudo.js" type="text/javascript" charset="utf-8"></script>
        <style>
        	/*.PopDiv{display: none;}*/ 
        	.sm-tab-title td.platform_name>span{display: inline;}
        </style>
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
                    <div class="cont-box" style="height: 100%;overflow-y: auto">
                        <div class="cont-box-title">
                            <div class="title-box sale-tab">
                                <a class="select" href="javascript:pickDate(1);">待确定</a>
                                <a href="javascript:pickDate(2);">待退货</a>
                                <a href="javascript:pickDate(10);">待处理</a>
                                <a href="javascript:pickDate(3);">待退款</a>
                                <a href="javascript:pickDate(4);">已完成</a>
                                <a href="javascript:pickDate(5);">已拒绝</a>
                                <a href="javascript:pickDate(6);">待仲裁</a>
                            </div>
                            <!--<div class="title-box title-search">
                                <span>关键字：</span>
                                <input type="text" name="" class="keyword" placeholder="请输入关键字">
                                <input class="btn btn-search-center" type="button" id="" value="搜索" />
                            </div>-->
                        </div>
                        <div class="cont-box-body" id="after_sale" >
                            <table>
                                <thead>
                                    <tr>
                                        <th>
                                           <!-- <input type="checkbox" name="" id="" value="" />-->
                                            商品
                                        </th>
                                        <th>单价</th>
                                        <th>数量</th>
                                        <th>支付金额</th>
                                        <th>申请金额</th>
                                        <th>售后类别</th>
                                        <th>售后理由</th>
                                        <th>退货信息</th>
                                        <th>售后状态</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody data-bind = "foreach:{data:item,as:'auto'}">
                                    <tr class="sm-tab-title">
                                        <td>
                                            
                                            售后单号：<label data-bind="text:cus_id">687987987987</label>
                                        </td>
                                        <td colspan="3" >售后时间：<span style="display:inline" data-bind="text:add_time">2016-7-28 09:55:43</span></td>
                                        <td>订单号：<label data-bind="text:order_sn">687987987987</label></td>
                                        <td colspan="5" class="platform_name"><span data-bind="text:platform_name">第三方单号</span>： <span data-bind="text:other_order_sn"></span></td>
                                    </tr>
                                    <tr>
                                        <td data-bind = "foreach:{data:goods,as:'auto'}">
                                        	<span data-bind="text:goods_name,attr:{'data-id':goods_id}">SKU属性1/SKU属性2/SKU属性3</span>
                                        </td>
                                        <td data-bind="text:goods[0].price"></td>
                                        <td data-bind="text:goods[0].goods_num">1</td>
                                        <td><span data-bind="text:order_amount"></span></td>
                                        <td data-bind="text:refund_amount"></td>
                                        <td data-bind="text:cus_type">退款</td>
                                        <td><span class="hue" data-bind="text:refund_reason">七天无理由</span></td>
                                        <td><span data-bind="text:freight_company">中通</span><span data-bind="text:freight_code">13546581188</span></td>
                                        <td data-bind="text:status">待确认</td>
                                        <td><p><a class="e-click" data-bind="attr:{'data-id':cus_id}">查看</a></p></td>
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

    <div class="marksDetail marks">
    	<div class="PopDiv go-delivery" style="width: 400px;min-width: 400px;display: none;">
    		<div class="PopHeader">
                <span class="PopTitle"><i class="PopDetails"></i>发货</span>
                <div class="PopColse"></div>
            </div>
            <div class="PopBody">
            	<p style="width: 296px;margin-top: 8px;">快递公司:  <input id="freight_company" type="text"></p>
            	<p style="width: 296px;">快递单号: <input type="text" id="freight_no"></p>
            </div>
            <div class="PopFooter">
            	<button>确定</button>
            </div>
    	</div>
        <div class="PopDiv sale_detail" style="width: 624px;min-width: 624px;margin: 200px auto 0;display: none;">
            <div class="PopHeader">
                <span class="PopTitle"><i class="PopDetails"></i>售后详情（待退款）</span>
                <div class="PopColse"></div>
            </div>
            <div class="PopBody PopBodyDetails" id="sale_Detail">
                <div class="popbox clearfix">
                    <div class="popbox-lf">
                        <p>售后单号：<span data-bind = "text:cus_id">9797958</span></p>
                        <p>订单单号：<span data-bind = "text:order_sn">9797958</span></p>
                    </div>
                    <div class="popbox-rf">
<!--                        <p>平台单号：<span data-bind = "text:order_sn">687987987987</span></p>-->
                        <p><span data-bind = "text:platform_name">第三方单号</span>：<span data-bind = "text:other_order_sn">2035487865138532</span></p>
                    </div>
                </div>
                <div class="popbox-body">
                    <h2>售后商品信息</h2>
                    <div class="pop-information clearfix">
                        <div class="information-lf">
                            <p data-bind = "text:goods.length>0?goods[0].goods_name:''">BNN*ASB*WG137*39</p>
                            <p>单价：<span class="information-num" data-bind = "text:goods.length>0?goods[0].price:''">88.00</span>数量：<span data-bind = "text:goods.length>0?goods[0].goods_num:''">1</span></p>
                            <p>售后类别：<span data-bind = "text:cus_type">退款</span></p>
                            <p>售后金额：<span data-bind = "text:refund_amount">88.00</span></p>
                            <!--<p>总计金额：<span data-bind = "text:refund_amount">98.00</span></p>-->
                            <p>售后时间：<span data-bind = "text:add_time">2016-7-25 14:36:12</span></p>
                            <p>退货物流公司：<span data-bind = "text:freight_company">中通</span></p>
                            <p>退款时间：<span data-bind = "text:refund_money_time">2016-7-28 14:36:12</span></p>
                        </div>
                        <div class="information-rf">
                            <p data-bind = "text:goods.length>0?(goods[0].sku.length>0 ? goods[0].sku[0].sku_str_zh : ''):''">SKU属性1/SKU属性2/SKU属性3</p>
                            <p >订单总额：<span data-bind = "text:refund_amount">88.00</span></p>
                            <p class="information-mag">售后理由：<span data-bind = "text:refund_reason">质量问题</span></p>
                            <!--<p>运费补贴：<span>10.00</span></p>-->
                            <p class="information-mag">退货时间：<span data-bind = "text:return_time">2016-7-28 14:36:12</span></p>
                            <p>物流单号：<span data-bind = "text:freight_code">135894984987498</span></p>
                            <p>完成时间：<span data-bind = "text:close_time">2016-7-28 14:36:12</span></p>
                        </div>
                    </div>
                    <div class="information-img">
                        <p>提交凭证：
                        	<span data-bind="foreach:{data:imgs,as:'auto'}">
                        		 <a target="_blank" data-bind="attr:{href:auto}">
	                                <img src="" alt="" data-bind="attr:{src:auto+'!thumb100'}"/>
	<!--                                <i class="remove-img">-</i>-->
	                           </a>
                        	</span>                          
                        </p>
                    </div>
                </div>
                <div class="information-words">
                    <h2>售后留言</h2>
                    <textarea data-bind="text:remark" disabled=""></textarea>
                </div>
            </div>
        </div>
    </div>    

</body>
</html>


<script>
    $(function () {
        var oUrl = getUrlParam('loc');	
		if( oUrl ==  ''){
			pickDate(1);
		}else{
			pickDate(parseInt(oUrl));
			$('.sale-tab>a').eq(oUrl-1).addClass('select').siblings().removeClass('select');
		}	    
		$('.sale-tab>a').click(function(){
			$(this).addClass('select').siblings().removeClass('select');
		})
    });
    var oHtml = $('#after_sale tbody').html(), //主内容
            oHtmlD = $('#sale_Detail').html();     //售后详情
	var data = {
            'user_id': getCookieValue('user_id'), 'page': 1
       };
    var oCus_id;   
    function pickDate(num) {
    	var data = {
            'user_id': getCookieValue('user_id'), 'page': 1
        };
        ko.cleanNode(document.getElementById("after_sale"));
        $('#after_sale tbody').html(oHtml);
        
        switch (num) {
            case 1:
                var html = '<p><a class="cancel_sale" data-bind="attr:{'+"'data-id'"+':cus_id}">取消售后</a></p>';
			    $(html).insertBefore($('.e-click'));
                $.extend(data, { 'return_status': after_good_status.wait_admin_confirm});
                break;
            case 2:
                var html = '<p><a class="delivery" data-bind="attr:{'+"'data-id'"+':cus_id}">退货</a></p>';
			    $(html).insertBefore($('.e-click'));
                $.extend(data, { 'return_status': after_good_status.wait_buyer_sendgoods});
                break;
            case 3:
                    $.extend(data,{'refund_status':after_sale_status.wait_admin_pay,'return_status':after_good_status.wait_admin_repay});
                    break;	
            case 4:
                    $.extend(data,{'refund_status':after_sale_status.success,'return_status':after_good_status.success});
                    break;	
            case 5:
                    $.extend(data,{'return_status':after_good_status.refuse})
                    break;	       			
            case 6:
                    $.extend(data,{'return_status':after_good_status.wait_admin_kill})
                    break;	
            case 10:
                    $.extend(data,{'return_status':after_good_status.wait_admin_kill,'wait':1,})
                    break;	
		    } 
		    X.bindModel(requestUrl.after_sale_list,1,data,'body.list',['after_sale'],function(){
                $('.e-click').click(function(){
                    $('.marksDetail').show();                   
                    $('.sale_detail').show();
                    ko.cleanNode(document.getElementById("sale_Detail"));
                    $('#sale_Detail').html(oHtmlD); 
                    X.bindModel(requestUrl.after_sale_detail,1,{'user_id':getCookieValue('user_id'),'cus_id':$(this).attr('data-id')},'body.list',['sale_Detail'],function(){
//                          $('.PopColse').on('click',function(){
//                                  $('.marks,.marksDetail').hide();
//                              })
                    });
                })
                	//取消售后
				$('.cancel_sale').click(function(){
					X.Post(requestUrl.after_sale_operate,1,{'cus_id':$(this).attr('data-id'),'user_id':getCookieValue('user_id'),'type':'cancel'},function(e){
					   if(e.header.stats == 0 ){
	            	   	  X.notice(e.body.list,3)
	            	   	  setTimeout(function(){
	            	   	  	 window.location.href = 'after_sale_list.php?loc='+($('.sale-tab>a.select').index()+1); 
	            	   	  },1000)
	            	   }else{
	            	   	 X.notice(e.header.msg,3)
	            	   }
					})
				});
				
				//弹框关闭
				$('.PopDiv .PopColse').on('click',function(){
				   $(this).parent().parent().hide();
				   $('.marks').hide()
				})
				
				//退货				
				$('.delivery').click(function(){	
					oCus_id =	$(this).attr('data-id');							
				    $('.marksDetail').show();
	                $('.go-delivery').show();	                
				})				
		    })
        }  
        $('.go-delivery button').on('click',function(){
            var reg = /^\w*$/;
        	var data = {
    		        'cus_id':oCus_id,
                	'user_id':getCookieValue('user_id'),
                	'type':'deliver',
                	'freight_company':$('#freight_company').val(),			                	
                	'freight_no': $('#freight_no').val()
                };
           if(data.freight_company == ''){
          	  X.notice('请填写物流公司',3);
          	  return false;
           }else if(data.freight_no == ''){
              X.notice('请填写快递单号',3);
              return false;
           }else if(!reg.test(data.freight_no)){
              X.notice('快递单号由数字/字母组成',3);
              return false;
           }
           X.Post(requestUrl.after_sale_operate,1,data,function(e){
        	   if(e.header.stats == 0 ){
        	   	  X.notice('退货成功',3);
        	   	  setTimeout(function(){
        	   	  	 window.location.href = 'after_sale_list.php?loc='+($('.sale-tab>a.select').index()+1); 
        	   	  },1000)
        	   }else{
        	   	 X.notice(e.header.msg,3)
        	   }
           })
        })   		
</script>
