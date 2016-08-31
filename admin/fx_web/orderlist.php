
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
        <title>创想范分销平台--订单管理</title>
        <link rel="stylesheet" type="text/css" href="css/common.css"/>
        <link rel="stylesheet" type="text/css" href="css/zengli.css" />
        <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
        <script src="//cdn.bootcss.com/knockout/3.3.0/knockout-min.js"></script>
        <script src="js/plus.js"></script>
        <script src="js/public.js"></script>
        <script src="js/pseudo.js" type="text/javascript" charset="utf-8"></script>
        <script src="plupload-2.1.2/js/plupload.full.min.js"></script>
    	<script src="js/MD5.js"></script>
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
                            	<a class="select" href="javascript:pickDate(0);">待付款</a>
                                <a href="javascript:pickDate(1);">待平台确认付款</a>
                                <a href="javascript:pickDate(2);">待发货</a>
                                <a href="javascript:pickDate(3);">待收货</a>
                                <a href="javascript:pickDate(4);">已完成</a>
                                <a href="javascript:pickDate(5);">已关闭</a>
                                <a href="javascript:pickDate(6);">订单异常</a>
                            </div>
                            <div class="title-box title-search">
                                <span>关键字：</span>
                                <input type="text" name="" class="keyword" id="or_keyword" placeholder="请输入关键字">
                                <input class="btn  order_btn-search" type="button" id="order_search" value="搜索" />
                            </div>
                        </div>
                        <div class="cont-box-body" id="order_list">
                            <table>
                                <thead>
                                    <tr>
                                        <th>
                                           	 商品
                                        </th>
                                        <th>商家编码</th>
                                        <th>采购价</th>
                                        <th>数量</th>
                                        <th>实付款</th>
                                        <th>第三方平台单号</th>
                                        <th>商品状态</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody data-bind = "foreach:{data:item,as:'auto'}">
                                    <tr class="sm-tab-title" data-bind = "attr:{'data-other':other_order_sn}">
                                        <td>
                                            	订单号：<label data-bind="text:order_sn">687987987987</label>
                                        </td>
                                        <td>下单时间：<label data-bind="text:add_time">2016-7-28 09:55:43</label></td>
										<td colspan="4"></td>
                                        <td style="text-align: -webkit-center"><img src="images/userCenter/youjian.png"/></td>
                                        <td>订单详情</td>
                                    </tr>
                                    <tr>
                                        <td>
                                        	<p data-bind="text:goods_name">韩版2016年夏季新款无袖连衣裙雪</p>
                                        	<span data-bind="text:sku_str_zh"></span>
                                        </td>
                                        <td data-bind="text:buyer_goods_no">BNN*ASB*WG137*39</td>
                                        <td data-bind="text:distribution_price">888.00</td>
                                        <td data-bind="text:goods_num">1</td>
                                        <td><span class="pay_a_price" data-bind="text:pay_amount">888.00 <strong>（含运费0.00）</strong></span></td>
                                        <td class="other_sn_l"><span data-bind="text:other_shop"></span> :<span data-bind="text:other_order_sn"></span></td>
                                        <td data-bind="text:order_state >=3 ? (order_state >= 5 ? (order_state == 5 ? '已关闭' : '异常' ) : (order_state == 4 ? '已完成' : '已确认已发货') ):( order_state >= 1 ? (order_state == 2 ? '已确认待发货' : '已付款待确认' ) : '待付款' )">已发货</td>
                                        <td><p><a class="e-click" data-bind="attr:{'order_id':order_id,'order_sn':order_sn}">查看</a></p></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
<!--                        <div class="cont-box-foot">-->
<!--                            <div class="cont-box-foot-lf">-->
<!--                                <input type="checkbox" name="" id="" value="" />-->
<!--                                全选-->
<!--                            </div>-->
<!--                            <div class="cont-box-foot-rf">-->
<!--                                <a href="">下架失效商品</a>-->
<!--                                <input type="button" id="" class="btn" value="上架" />-->
<!--                                <input type="button" id="" class="btn btn-w" value="下架" />-->
<!--                                <input type="button" id="" class="btn btn-w last-btn" value="删除" />-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                </div>
            </div>
            <?php include_once 'base/vip_right.php'; ?>
        </div>
    </div>
    <?php include_once 'base/vip_footer.php'; ?>

    <div class="marks" id="order_Detail" style="display: none">
        <div class="PopDiv" style="width: 920px;min-width: 624px;margin: 200px auto 0;">
            <div class="PopHeader">
                <span class="PopTitle"><i class="PopDetails"></i>订单详情</span>
                <div class="PopColse"></div>
            </div>
            <div class="PopBody PopBodyDetails">
                <div class="popbox poporder clearfix">
                    <div class="popbox-lf">
                        <p>当前订单状态：<span data-bind="text:order.order_state">已完成</span></p>
                    </div>
                    <div class="popbox-rf">
                        <p>售后状态：<span data-bind="text:order.is_cus == 0 ? '没有售后' : '有售后'">售后中</span></p>
                        <p>售后单号：<span class="order-num" data-bind="text:order.other_order_sn">1</span></p>
                    </div>
                </div>
                <div class="popbox-body popdeliver">
                    <h3>收货信息</h3>
                    <h2>收货人信息</h2>
                    <div class="pop-information clearfix">
                        <div class="info-box">
                            <p data-bind = "text:contact.contact_name + ',' + contact.tel + ',' + contact.city + '' + contact.province + ''+ contact.dist ">小强，1355555555，四川省 成都市 锦江区</p>
                            <p data-bind = "text:contact.contact_address">海椒市东一二三四五街巨人大厦四五六七八1号1栋楼</p>
                        </div>
                        <div class="popgoods-info">
                            <dl>
                                <dt>包裹1</dt>
                                <dd class="clearfix">
                                    <div class="popgoods-lf" data-bind = "foreach:{data:goods,as:'auto'}">
                                        <div class="float-box clearfix">
                                            <div class="img-box">
                                                <a href=""><img data-bind="attr:{src:img_path}" src=""/></a>
                                            </div>
                                            <div class="poptext-box">
                                                <h5 data-bind = "text:goods_name">女装欧美春夏韩版短袖宽松T恤透视雪纺衫罩衫蝙蝠衫套头大码</h5>
                                                <p data-bind = "text:buyer_goods_no">xcd-29-B-2#2123-1601</p>
                                            </div>
                                        </div>
                                        <p class="sm-info"><span data-bind = "text:sku_str_zh"><span>数量<span data-bind = "text:subtotal">1</span></p>
                                                    </div>	
                                                    <div class="popgoods-rf">
                                                        <p><span>发货时间：</span><strong data-bind="text:order.send_hub_time">2016-5-11&nbsp;&nbsp;11:18:39</strong></p>
                                                        <p><span>运单类型：</span><strong data-bind="text:order.hub_type == 1 ? '普通运单' : '电子运单' ">传统单号</strong></p>
                                                        <p><span>物流公司：</span><strong data-bind="text:order.shipping_name">中通</strong></p>
                                                        <p><span>运单号：</span><strong data-bind="text:order.shipping_code">46565455488996</strong></p>
                                                    </div>
                                                    </dd>
                                            </dl>                          
                                     </div>
                                  </div>
                            </div>
                            </div>
                     </div>
                  </div>	
 </body>
<div class="marks" id="saleAfter" style="display: none;">
    <div class="PopDiv" style="width: 624px;min-width: 624px;margin: 200px auto 0;">
        <div class="PopHeader">
            <span class="PopTitle"><i class="PopDetails"></i>申请售后</span>
            <div class="PopColse" id="sale-close"></div>
        </div>
        <div class="PopBody PopBodyDetails">
        	<div class="popbox-body">
        		<div class="apply-box clearfix">
        			<div class="popbox-lf">
        				<p>平台单号：<span class="pt_ord_h">9797958</span></p>
	        		</div>
	        		<div class="popbox-rf">
	        			<p>第三方单号：<span class="thr_ord_h">2035487865138532</span></p>
	        		</div>
        		</div>
        		<h2>售后商品信息</h2>
        		<div class="pop-information clearfix">
        			<div class="information-lf">
        				<p class="buyer_goods_no">BNN*ASB*WG137*39</p>
        				<p>单价：<span class="information-num order_price" >88.00</span>数量：<span class="order_num">1</span></p>
        				<p>总计金额：<span class="order_price">98.00</span></p>
        			</div>
        			<div class="information-rf">
        				<p class="order_sku">SKU属性1/SKU属性2/SKU属性3</p>
        				<p>订单总额：<span class="order_price">88.00</span></p>
        				<p class="information-mag">售后理由：
        					<select class="sale-reason">
                            	<option >---请选择---</option>
                            	<option value="1">拍错/订单信息有误</option>
                            	<option value="2">不想要了</option>
                            	<option value="3">7天无理由退货</option>
                            	<option value="4">质量问题</option>
                            	<option value="5">与商品描述不一致</option>
                            	<option value="6">缺件，漏发</option>
                            	<option value="7">卖家发错货</option>
	                        </select>
	                   </p>
        			</div>
        		</div>
        		<div class="information-img">
        			<p>提交凭证：
        				<a id="pinzheng_img">
        					
        				</a>
        				<input type="button" class="btn btn-disabled" name="" id="pinzheng" value="提交" />
        			</p>
        		</div>
        	</div>
        	<div class="information-words">
        		<h2>售后留言</h2>
        		<textarea></textarea>
        	</div>
        	<div class="btn-box">
        		<input type="button" id="sub_sale" class="btn btn-updata" value="提交售后" />	
        	</div>
        </div>
    </div>
</div>


<script>
	$(function () {
		var oUrl = getUrlParam('loc');	
		if( oUrl ==  ''){
			pickDate(0);
		}else{
			pickDate(parseInt(oUrl));
			$('.sale-tab>a').eq(oUrl).addClass('select').siblings().removeClass('select');
		}	    
	    $('#sale-close').click(function(){
	    	$('#pinzheng_img').html('');
	    	idd1.file = [];
	    })
	})
	var idd1 = X.upLoadImg(['pinzheng',true,'#pinzheng_img','.imgBtn',0,'shou']);
	var oHtml = $('#order_list tbody').html(), //主内容
	oHtmlD = $('#order_Detail').html();     //售后详情
	
	function pickDate(num,val) {
	    ko.cleanNode(document.getElementById("order_list"));
		$('#order_list tbody').html(oHtml);
		var data = {
		    'user_id': getCookieValue('user_id'), 'page': 1,
		    'keyword': val == undefined ? '' : val
		}	
		switch (num) {
			case 0:
		        var html = '<p><a class="pay-money" data-bind="attr:{' + "'order_id'" + ':order_id,' + "'order_sn'" + ':order_sn}">付款</a></p>';
				$(html).insertBefore($('.e-click'));
				$.extend(data,{'order_state':order_state.wait_pay})
			    break;
		    case 1:
				$.extend(data,{'order_state':order_state.wait_confirm_pay})
			    break;
			case 2:
			    var html = '<p><a data-bind="text:is_cus == 0 ?'+"'申请售后 ':'已售后'"+',attr:{' +"'order_id'" + ':order_id,' + "'order_sn'" + ':order_sn,' + "'class'" + ':is_cus == 0 ? '+"'apply-after-sale' :"+"''}"+'"></a></p>';
			    $('.sale-reason>option').eq(1).show();
			    $('.sale-reason>option').eq(2).show();
			    $('.sale-reason option').eq(3).hide();
			    $('.sale-reason option').eq(4).hide();
			    $('.sale-reason option').eq(5).hide();
			    $('.sale-reason option').eq(6).hide();
			    $('.sale-reason option').eq(7).hide();			    
				$(html).insertBefore($('.e-click'));
				$.extend(data,{'order_state':order_state.wait_send_goods})
			    break;
			case 3:
				$('.sale-reason>option').eq(1).hide();
			    $('.sale-reason>option').eq(2).hide();
			    $('.sale-reason option').eq(3).show();
			    $('.sale-reason option').eq(4).show();
			    $('.sale-reason option').eq(5).show();
			    $('.sale-reason option').eq(6).show();
			    $('.sale-reason option').eq(7).show();
			    var html = '<p><a class="confirm-get" data-bind="attr:{' + "'order_id'" + ':order_id,' + "'order_sn'" + ':order_sn}">确认收货</a></p><p><a data-bind="text:is_cus == 0 ?'+"'申请售后 ':'已售后'"+',attr:{' + "'order_id'" + ':order_id,' + "'order_sn'" + ':order_sn,' + "'class'" + ':is_cus == 0 ? '+"'apply-after-sale' :"+"''}"+'">申请售后</a></p>';
				$(html).insertBefore($('.e-click'));
				$.extend(data,{'order_state':order_state.wait_receive_goods})
			    break;
			case 4:
				$('.sale-reason>option').eq(1).hide();
			    $('.sale-reason>option').eq(2).hide();
			    $('.sale-reason option').eq(3).show();
			    $('.sale-reason option').eq(4).show();
			    $('.sale-reason option').eq(5).show();
			    $('.sale-reason option').eq(6).show();
			    $('.sale-reason option').eq(7).show();
			    var html = '<p><a data-bind="text:is_cus == 0 ?'+"'申请售后 ':'已售后'"+',attr:{' + "'order_id'" + ':order_id,' + "'order_sn'" + ':order_sn,' + "'class'" + ':is_cus == 0 ? '+"'apply-after-sale' :"+"''}"+'">申请售后</a></p>';
				$(html).insertBefore($('.e-click'));
				$.extend(data,{'order_state':order_state.success})
			    break;
			case 5:
				$.extend(data,{'order_state':order_state.closeq})
			    break;    
			case 6:
				$.extend(data,{'order_state':order_state.errorq})
			    break;    
			}
			X.bindModel(requestUrl.order_list, 1, data, 'body.list', ['order_list'], function () {
				$('.e-click').click(function () {
					$('#order_Detail').show();
					ko.cleanNode(document.getElementById("order_Detail"));
					X.bindModel(requestUrl.order_details, 1, {'order_id': $(this).attr('order_id'), 'order_sn': $(this).attr('order_sn')}, 'body.list', ['order_Detail'], function () {
							$('.PopColse').on('click', function () {
								$('#order_Detail').hide();
					        })
				    },function(e){
				    	var a,x = e;
				    	switch(e.order.order_state){				    		
				    		case '0' :
				    		   a = '待付款' 
				    		   break;
				    		case '1' :
				    		   a = '待平台确认付款' 
				    		   break;
				    		case '2' :
				    		   a = '已确定待发货' 
				    		   break;
				    		case '3' :
				    		   a = '待收货' 
				    		   break;
				    		case '4' :
				    		   a = '已完成' 
				    		   break;
				    	    case '5' :
				    		   a = '已关闭' 
				    		   break;
				    		case '6' :
				    		   a = '订单异常' 
				    		   break;
				    	}
                        x.order.order_state = a
				    	return x;
				    });
				})
				$('.pay-money').click(function () {
					var data = {'order':$(this).attr('order_id'),'orderSn':$(this).attr('order_sn'),'pay_amount':$(this).parents('tr').find('.pay_a_price').html()}
				    sessionStorage.setItem('orderInfo',JSON.stringify(data));
				    window.location.href = 'pay_order.php';
				});
				$('.apply-after-sale').click(function () {
					$('#saleAfter').fadeIn();
					$('#saleAfter>div').fadeIn();
					$('.PopColse').click(function(){
						$('#saleAfter').fadeOut();
					})
					var order=$(this).attr('order_id');
					$('.pt_ord_h').html($(this).parents('tr').prev().children('td').eq(0).children('label').html());
					$('.thr_ord_h').html($(this).parents('tr').prev().attr('data-other'))
					$('.buyer_goods_no').html($(this).parents('tr').children('td').eq(0).children('p').html())
					$('.order_sku').html($(this).parents('tr').children('td').eq(1).children('p').html())
					$('.order_price').html($(this).parents('tr').children('td').eq(2).html())
					$('.order_num').html($(this).parents('tr').children('td').eq(3).html())
					$('.all-price').html($(this).parents('tr').children('td').eq(5).children('p').eq(0).html())
					$('.freight').html($(this).parents('tr').children('td').eq(5).children('p').eq(1).html())
					$('.sale-reason').change(function(){
						var after_sale_reason=$(this).find('option:selected').val();
						addCookie('reason',after_sale_reason)
					})
					addCookie('order',order);
					
				});
				$('.confirm-get').click(function () {
			          X.Post(requestUrl.confirm_good,1,{'order_id':$(this).attr('order_id'),'order_sn':$(this).attr('order_sn')},function(e){
						   if(e.header.stats == 0 ){
			            	   	  X.notice(e.body.list,3)
			            	   	  setTimeout(function(){			            	   	  	
			            	   	  	  window.location.href = 'orderlist.php?loc='+($('.sale-tab>a.select').index()+1); 
			            	   	  },1000)
		            	   }else{
		            	   	  X.notice(e.header.msg,3);
		            	   }
						})		  
			    });
			})
			$('.e-take').click(function(){
				
			});
	   }
				//提交售后
				$('#sub_sale').click(function(){
			    		var data ={
			    			'user_id':getCookieValue('user_id'),
			    			'order_id':getCookieValue('order'),
			    			'after_sale_reason':getCookieValue('reason'),
			    			'after_sale_remark':$('.information-words textarea').val(),
			    			'img':idd1.file
			    		}
			    		console.log(data.after_sale_remark);
						X.Post(requestUrl.sale,1,data,function(e){
							if(e.header.stats==0){
								X.notice(e.body.list.success,3)
								$('#saleAfter').fadeOut();								
							}else{
								X.notice(e.header.msg,3)
							}
						})	
					})
			
	function order_s(e){
		console.log(typeof e);
		switch (e){
			case '0':
			   return '待付款'
			   break;
			case '1':
			   return '已付款待确认'
			   break; 
			case '2':
			   return '已确认待发货'
			   break;
			case '3':
			   return '已确认已发货'
			   break;
			case '4':
			   return '已完成'
			   break;
			case '5':
			   return '已关闭'	  
			   break;
			case '6':
			   return '异常'
			   break;  
		}
	}		
	$('.sale-tab>a').click(function(){
		$(this).addClass('select').siblings().removeClass('select');
	})
	
	$('#order_search').click(function(){
		if($('#or_keyword').val() == ''){
			pickDate($('.sale-tab .select').index())
		}else{
			pickDate($('.sale-tab .select').index(),$('#or_keyword').val());
		}		
	})
	
</script>
