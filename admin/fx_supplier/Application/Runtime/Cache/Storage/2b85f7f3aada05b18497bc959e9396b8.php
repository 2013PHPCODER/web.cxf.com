<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
			.dalog-modal{
			width: 100%;
			height: 100%;
			position: fixed;
			background: rgba(0,0,0,0.5);
			display: none;
			top: 0;
                        left: 0;
                        z-index: 999;
		}
                .dalog-container{
                    width: 1000px;
                    position: absolute;
                    top:50%;
                    left: 50%;
                    margin-left: -500px;
                    margin-top: -200px;
                    background: #fff;
                    opacity: 1;
                    z-index: 9999;
                }
                .dalog-container table{
                	width: 100%;
                }
                .dalog-container table th{
                	height: 40px;
                	background: #f39c12;
                	text-align: center;
                	color: #fff;
                }
                .dalog-container table td{
                	height: 40px;
                	text-align: center;
                }
                .dalog-container span{
                    display: inline-block;
                    text-align: right;
                }
		.dalog-modal{
			display: none;
		}
		.dalog-modal .g-modal-content.add-entrepot input[type="text"]{
			margin: 0;
			position: relative;
		}
		.dalog-modal .g-modal-content.add-entrepot label strong{
			margin: 0 10px;
			color: #FF2015;
			display: inline;
		}
		.dalog-modal h2{
			padding: 10px 0;
			text-align: center;
		}
		.modal-content{
			padding: 10px 0;
			font-family: "microsoft yahei";
		}
		.dalog-modal  label{
			width: 200px;
			width: 100%;
			padding: 10px 40px;
		}
		.dalog-modal label.error{
			width: 244px;
		}
		.modal-content label span{
			display: inline-block;
			width: 100px;
			text-align: right;
		}
		.dalog-modal .close{
			position: absolute;
			top: 0;
			right: 0;
			padding: 5px;
		}
		.dalog-modal .close:hover{
			cursor: pointer;
                        width: 40px;
                        height: 40px;
			background: #888888;
			border-radius: 5px;
			border-top-left-radius: 0;
			border-bottom-right-radius: 0;
		}
		.sub-btn{
			text-align: center;
                        padding: 20px 0;
		}
		.sub-btn input{
			width: 150px;
			height: 40px;
			background: rgb(33,119,199);
			border: none;
			border-radius: 5px;
			box-shadow: 0 2px 2px #888888;
			color: #fff;
			font-family: "microsoft yahei";
			font-size: 20px;
                        margin: 0 10px;
		}
		.sub-btn input:hover{
			box-shadow: 0 0 10px #888888;
			cursor: pointer;
		}
		.redact span{display: block;float: left;}
		.redact a{display: block;float: left;margin-left: 10px;}
		.redact-adress{display: none; width: 300px;background: #fff;/*border: 1px solid #555555;*/}
		.redact-adress input{margin-left: 10px;}
</style>

	<div class="box-header">
		模板名称：<?php echo ($main["name"]); ?>      按重量计价    <?php echo ($main["is_free"]); ?>
		<div class="box-tools">
			<div class="input-group order">
				<ul>
					<li><a href="#" id="introduced_batch" class="btn btn-default btn-xs">修改</a></li>
					<li><a href="#" id="goods_delete_batch" class="btn btn-default btn-xs">删除</a></li>
				</ul>
			</div>
			<div class="form-group order">				
			</div> 
		</div>
	</div>
	<div class="box-header">
		<div class="box-body table-responsive no-padding">

			<table class="table table-hover">
				<tbody>
					<tr>
						<th>配送地区</th>
						<th>首重（kg）</th>
						<th>首重（元）</th>
						<th>续重（kg）</th>
						<th>续重（元）</th>
					</tr>
					<tr>	
						<td>全国</td>
						<td><?php echo ($main["start_heavy"]); ?></td>
						<td><?php echo ($main["start_freight"]); ?></td>
						<td><?php echo ($main["continue_heavy"]); ?></td>
						<td><?php echo ($main["continue_freight"]); ?></td>
					</tr>					
					<?php if(is_array($sub)): foreach($sub as $key=>$q): ?><tr>	
						<td><?php echo ($q["name"]); ?></td>
						<td><?php echo ($q["start_heavy"]); ?></td>
						<td><?php echo ($q["start_freight"]); ?></td>
						<td><?php echo ($q["continue_heavy"]); ?></td>
						<td><?php echo ($q["continue_freight"]); ?></td>
					</tr><?php endforeach; endif; ?>
				</tbody>	
			</table>
		</div>	

<div class="dalog-modal" id="aleatMoudle">
	<div class="dalog-container">
	<h2>新增物流模板</h2>
	<div class="g-modal-content">
		<form method="post" action="<?php echo U('storage/freight/add');?>" >
			<input type="hidden" name="id" value="<?php echo ($main["id"]); ?>">
			<label><span>模板名称：</span><input type="text" name="name" value="<?php echo ($main["name"]); ?>" />计价方式：<sapn>按重量</sapn></label>
			<label id="e-free"><span>是否包邮：</span>
				<input type="radio" name="is_free" value="1" class="" />是
				<input type="radio" name="is_free" value="0"  class="" />否
			</label>
			<label><span>默认运费：</span>
				<input class="freight" type="text" name="start_heavy" id="" value="<?php echo ($main["start_heavy"]); ?>" />
				kg以内，<input class="freight" type="text" name="start_freight" id="" value="<?php echo ($main["start_freight"]); ?>" />
				元;
				&nbsp;&nbsp;&nbsp;&nbsp;每增加<input class="freight" type="text" name="continue_heavy" id="" value="<?php echo ($main["continue_heavy"]); ?>" />
				kg，增加运费<input class="freight" type="text" name="continue_freight" id="" value="<?php echo ($main["continue_freight"]); ?>" />
				元
			</label>
			<label for="">
				<table class="red-table">
				<tr>
					<th>配送地区</th>
					<th>首重（kg）</th>
					<th>首费（元）</th>
					<th>续重（kg）</th>
					<th>续费（元）</th>
					<th>操作</th>
				</tr>
				<tr>
					<td class="redact">
						<span>未添加地区</span><a href="javascript:;" class="redactA">编辑</a>
					</td>
					<td><input name="sub[sub_start_heavy][]"></td>
					<td><input name="sub[sub_start_freight][]"></td>
					<td><input name="sub[sub_continue_heavy][]"></td>
					<td><input name="sub[sub_continue_freight][]"></td>
					<td><a href="javascript:;" class="removeTr">删除</a></td>
				</tr>
				<tr>
					<td class="redact">
						<span>未添加地区</span><a href="javascript:;" class="redactA">编辑</a>
					</td>
					<td><input name="sub[sub_start_heavy][]"></td>
					<td><input name="sub[sub_start_freight][]"></td>
					<td><input name="sub[sub_continue_heavy][]"></td>
					<td><input name="sub[sub_continue_freight][]"></td>
					<td><a href="javascript:;" class="removeTr">删除</a></td>
				</tr>
			</table>
		</label>
		<label for="">
			<div class="special">
				<a href="javascript:;" id="Darea">新增一条</a>
				<div class="special-content">
					<div class="redact-adress" id="adress-group">
						<div data-toggle="distpicker">
					        <div class="form-group">
					          <label class="sr-only" for="province2">Province</label>
					          <select class="form-control" id="province2" data-province="---- 选择省 ----"><option value="" data-code="">---- 选择省 ----</option><option value="北京市" data-code="110000" selected="">北京市</option><option value="天津市" data-code="120000">天津市</option><option value="河北省" data-code="130000">河北省</option><option value="山西省" data-code="140000">山西省</option><option value="内蒙古自治区" data-code="150000">内蒙古自治区</option><option value="辽宁省" data-code="210000">辽宁省</option><option value="吉林省" data-code="220000">吉林省</option><option value="黑龙江省" data-code="230000">黑龙江省</option><option value="上海市" data-code="310000">上海市</option><option value="江苏省" data-code="320000">江苏省</option><option value="浙江省" data-code="330000">浙江省</option><option value="安徽省" data-code="340000">安徽省</option><option value="福建省" data-code="350000">福建省</option><option value="江西省" data-code="360000">江西省</option><option value="山东省" data-code="370000">山东省</option><option value="河南省" data-code="410000">河南省</option><option value="湖北省" data-code="420000">湖北省</option><option value="湖南省" data-code="430000">湖南省</option><option value="广东省" data-code="440000">广东省</option><option value="广西壮族自治区" data-code="450000">广西壮族自治区</option><option value="海南省" data-code="460000">海南省</option><option value="重庆市" data-code="500000">重庆市</option><option value="四川省" data-code="510000">四川省</option><option value="贵州省" data-code="520000">贵州省</option><option value="云南省" data-code="530000">云南省</option><option value="西藏自治区" data-code="540000">西藏自治区</option><option value="陕西省" data-code="610000">陕西省</option><option value="甘肃省" data-code="620000">甘肃省</option><option value="青海省" data-code="630000">青海省</option><option value="宁夏回族自治区" data-code="640000">宁夏回族自治区</option><option value="新疆维吾尔自治区" data-code="650000">新疆维吾尔自治区</option><option value="台湾省" data-code="710000">台湾省</option><option value="香港特别行政区" data-code="810000">香港特别行政区</option><option value="澳门特别行政区" data-code="820000">澳门特别行政区</option></select>
					        </div>
					        <div class="form-group">
					          <label class="sr-only" for="city2">City</label>
					          <select class="form-control" id="city2" data-city="---- 选择市 ----"><option value="" data-code="">---- 选择市 ----</option><option value="天津市市辖区" data-code="120100" selected="">天津市市辖区</option><option value="天津市郊县" data-code="120200">天津市郊县</option></select>
					        </div>
					        <div class="form-group">
					          <label class="sr-only" for="district2">District</label>
					          <select class="form-control" id="district2" data-district="---- 选择区 ----"><option value="" data-code="">---- 选择区 ----</option><option value="和平区" data-code="120101" selected="">和平区</option><option value="河东区" data-code="120102">河东区</option><option value="河西区" data-code="120103">河西区</option><option value="南开区" data-code="120104">南开区</option><option value="河北区" data-code="120105">河北区</option><option value="红桥区" data-code="120106">红桥区</option><option value="东丽区" data-code="120110">东丽区</option><option value="西青区" data-code="120111">西青区</option><option value="津南区" data-code="120112">津南区</option><option value="北辰区" data-code="120113">北辰区</option><option value="武清区" data-code="120114">武清区</option><option value="宝坻区" data-code="120115">宝坻区</option><option value="滨海新区" data-code="120116">滨海新区</option><option value="宁河区" data-code="120117">宁河区</option><option value="静海区" data-code="120118">静海区</option><option value="蓟县" data-code="120225">蓟县</option></select>
					        </div>
					    </div>
						<label for=""><input type="button" id="adress-btn1" class="btn btn-facebook" value="确定" /><input type="button" class="btn btn-primary" id="adress-btn2" value="取消" /></label>
					</div>
				</div>
		</div>
		</label>
		<div class="sub-btn"><input type="submit" class="sumb abolish" id="adress-btn2" value="保存"/><input type="button" class="sumb" id="adress-btn1" value="取消"/></div>
	</form>
</div>
<span class="close" id="dalogModalClose">×</span>
</div>
</div>

<script src="/Public/js/distpicker.data.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/js/distpicker.js" type="text/javascript" charset="utf-8"></script>


<form action='<?php echo U("storage/freight/del");?>' method="post" id="del-form">
	<input type="hidden" name="id" value="<?php echo ($main["id"]); ?>">
</form>
<script src="/Public/js/cityClass.js"></script>
<script src="/Public/js/region.js"></script>

<script>
$(function(){
	pager(<?php echo ($total); ?>);		//分页
//	loadData(selProvance,selCity,selArea);		//读取数据
	
  'use strict';

  var $distpicker = $('#distpicker');

  $distpicker.distpicker({
    province: '福建省',
    city: '厦门市',
    district: '思明区'
  });

  $('#distpicker2').distpicker({
    province: '所在省 ',
    city: '所在市',
    district: '所在区'
  });
;

})
	
</script>
<script type="text/javascript">
<<<<<<< .mine
//	 new PCAS("province3","city3","area3");
=======
	var val='<?php echo ($main["is_free_code"]); ?>';
	$('#e-free [value="'+val+'"]').attr('checked','checked');
	console.log($('#e-free').find(' [value="'+val+'"]'));

	 new PCAS("province3","city3","area3");
>>>>>>> .r509
	 $(function(){
	 	$('.removeTr').click(function(){
	 		$(this).parent().parent().remove();
 	});
	 	$('.sumb').click(function(){
	 		$('#aleatMoudle').hide();
	 	})
	 	$('#introduced_batch').click(function(){
	 		$('#aleatMoudle').show();
	 	})
	 })
	 $('#goods_delete_batch').click(function(){
	 	var id='<?php echo ($id); ?>';
	 	layer.confirm('你确定要删除模板吗？', {btn: ['确认', '取消']},
                        function (index) {
                            layer.close(index);
                            $('#del-form').submit();
                        }, function (index) {
                    layer.close(index);
                    return false;
                });
	 })
	 $('#adress-btn1').click(function(){
	 	$('#adress-group').hide();
	 	var provinceVal=$('#province2').find('option:selected').html();
	 	var cityVal=$('#city2').find('option:selected').html();
	 	var areaVal=$('#district2').find('option:selected').html();
	 	if(provinceVal == '请选择' && cityVal == '请选择' && areaVal == '请选择'){
	 		X.notice('请选择模板城市',3);
	 		return false
	 	}
	 	console.log(Oid);
	 	$('.red-table tr').eq(Oid).find('.redact').children('span').html(provinceVal+'/'+cityVal+'/'+areaVal);
	 });
	 $('#adress-btn2').click(function(){
	 	$('#adress-group').hide();
	 });
	 $('#dalogModalClose').click(function(){
	 	$('#aleatMoudle').hide();
	 });
	 var Oid;
	$('.redactA').click(function(){
		Oid=$(this).parent().parent().index();
		console.log(Oid);
		$('#adress-group').fadeIn();
		$('.special').fadeIn();
	})
	$('#Darea').click(function(){
		$('.red-table>tbody').append('<tr><td class="redact"><span>未添加地区</span><a href="javascript:;" class="redactA">编辑</a></td><td><input name="sub[sub_start_heavy][]"></td><td><input name="sub[sub_start_freight][]"></td><td><input name="sub[sub_continue_heavy][]"></td><td><input name="sub[sub_continue_freight][]"></td><td><a href="javascript:;" class="removeTr">删除</a></td></tr>')
		$('.removeTr').click(function(){
		 		$(this).parent().parent().remove();
	 	});
	 	$('.redactA').click(function(){
			Oid=$(this).parent().parent().index();
			console.log(Oid);
			$('#adress-group').fadeIn();
			$('.special').fadeIn();
		})
	})
</script>
