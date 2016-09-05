<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html>
    <head>
        <title>订单详情</title>
        <link rel="stylesheet" href="/Public/css/bootstrap.min.css">
        <link rel="stylesheet" href="/Public/css/AdminLTE.css">
        <link rel="stylesheet" href="/Public/css/font-awesome.min.css">
        <link rel="stylesheet" href="/Public/css/my.css">
    </head>
    <body>
        <section class="content">
            <div class=" order_detail box">
                <div class="box-body table-responsive no-padding ">
                    <h4 class="order_type">订单状态：
                        <?php switch($datas["order_state"]): case "0": ?>待付款<?php break;?>
                        <?php case "1": ?>已付款待确认<?php break;?>
                        <?php case "2": ?>已确认待发货<?php break;?>
                        <?php case "3": ?>已确认已发货<?php break;?>
                        <?php case "4": ?>已完成<?php break;?>
                        <?php case "5": ?>已关闭<?php break;?>
                        <?php case "6": ?>异常<?php break; endswitch;?>
                    </h4>
                    <h4 class="order_type">售后状态：
                        <?php if(($datas["cus_order_num"]) == "0"): ?>无售后信息
                        <?php else: ?>
                        <?php if(($datas["refund_status"]) > "0"): ?><!--退款状态：-->
                        <?php echo f_afterStatus($datas['refund_status'],'refund'); endif; ?>
                        <?php if(($datas["return_status"]) > "0"): ?><!--退款退货状态：-->
                        <?php echo f_afterStatus($datas['return_status'],'return'); endif; endif; ?>	
                    </h4>
                </div>
            </div>
            <?php if($datas["order_state"] == 3 or $datas["order_state"] == 4 or $datas["hub_order_state"] > 1): ?><div class=" order_detail box" style="padding-bottom:20px;">
                    <div class="box-header">
                        <h4 class="order_type">发货信息</h4>
                    </div>
                    <div class="box-body table-responsive no-padding ship_border"> 
                        <div class="order_type" <?php if(count($datas['order_goods']) > 1): ?>style="border-right:1px solid #f4f4f4;"<?php endif; ?>>
                            <?php if(is_array($datas["order_goods"])): foreach($datas["order_goods"] as $k=>$order_goods): if($k > 0 ): ?><div style='height:1px; background:#f4f4f4'></div><?php endif; ?>
                                <div class="shipping_info">
                                    <table cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td rowspan="2" colspan="1" style="padding:0;"><img src="<?php echo ($order_goods["goods_img"]); ?>!upyun123/fwfh/48x48"></td>
                                            <td colspan="4" style="padding:0 10px;"><?php echo ($order_goods["goods_name"]); ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="padding:0 10px;"><?php echo ($order_goods["buyer_goods_on"]); ?></td>
                                        </tr>
                                    </table>
                                    <table cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="200" colspan="2"><?php echo ($order_goods["sku_str"]); ?></td>
                                            <td >数量<?php echo ($order_goods["goods_num"]); ?></td>
                                        </tr>
                                    </table>
                                </div><?php endforeach; endif; ?>
                        </div>
                        <div class="order_type order_type_padding">
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                <?php if(!empty($datas["send_hub_time"])): ?><td>发货时间：</td>
                                    <td><?= date("Y-m-d H:i",$datas['send_hub_time']) ?></td><?php endif; ?>
                                </tr>
                                <tr>
                                    <td>运单类型：</td>
                                    <td><?php if($datas["hub_type"] == 1): ?>传统面单<?php endif; ?>
                                <?php if($datas["hub_type"] == 2): ?>电子面单<?php endif; ?></td>
                                </tr>
                                <tr>
                                    <td>物流公司：</td>
                                    <td><?php echo ($datas["shipping_name"]); ?></td>
                                </tr>
                                <tr>
                                    <td>运&nbsp;&nbsp;单&nbsp;&nbsp;号：</td>
                                    <td><a href="https://www.baidu.com/s?wd=<?php echo ($datas["shipping_code"]); ?>" target="_blank"><?php echo ($datas["shipping_code"]); ?></a>&nbsp;&nbsp;
                                        <?php if(($datas["hub_type"]) == "1"): ?><a class="edit_shipping_code" data-toggle="modal" data-target="#edit_shipping_code">修改</a><?php endif; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div><?php endif; ?>
            <div class=" order_detail box">
                <div class="box-header">
                    <h4 class="order_type">基本信息:</h4>
                </div>
                <div class="box-body table-responsive no-padding ">
                    <div class="order_type">
                        <p>订单号：<?php echo ($datas["order_sn"]); ?></p>
                        <p>下单时间：<?php if($datas['add_time']>0) echo date('Y-m-d H:i:s',$datas['add_time']); ?></p>
                        <p>付款时间：<?php if($datas['payment_time']>0) echo date('Y-m-d H:i:s',$datas['payment_time']); ?></p>
                        <p>收货人信息</p>
                        <p>
                        <?php if(is_array($datas["concat_address"])): foreach($datas["concat_address"] as $k=>$contact): echo ($contact["contact_name"]); ?>&nbsp;&nbsp;<?php echo ($contact["tel"]); ?>&nbsp; <?php echo ($contact["province"]); ?>&nbsp;<?php echo ($contact["city"]); ?>&nbsp;<?php echo ($contact["dist"]); ?>&nbsp;<?php echo ($contact["contact_address"]); ?>
                            <?php if($k == 0 and $datas["is_edit_address"] == 1): ?>（新地址）&nbsp;&nbsp;<?php endif; ?>
                            <?php if($datas['order_state'] < 3 and $k == 0): if(($datas["is_cus"]) == "0"): ?><!--<a href="" id="edit" data-toggle="modal" data-target="#edit_address">修改</a>--><?php endif; endif; ?>
                            </br><?php endforeach; endif; ?>
                        </p>
                        <p>订单备注：</p>
                        <p>
                            <textarea disabled="disabled"><?php echo ($datas["memo"]); ?></textarea>
                        </p>
                    </div>
                    <div class="order_type ">

                    </div>
                </div>
            </div>
            <div class="box order_detail">
                <div class="box-header">
                    <h3 class="box-title">商品信息</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>主图</th>
                                <th>标题</th>
                                <th>商家编码</th>
                                <th>SKU属性</th>
                                <th>单价/元</th>
                                <th>数量</th>
                                <th>商品总价/元</th>
                            </tr>
                        <?php if(is_array($datas["order_goods"])): foreach($datas["order_goods"] as $key=>$order_goods): ?><tr>
                                <td><img class="table_img" src="<?php echo ($order_goods["goods_img"]); ?>!upyun123/fwfh/40x40"></td>
                                <td><?php echo ($order_goods["goods_name"]); ?></td>
                                <td><?php echo ($order_goods["buyer_goods_no"]); ?> </td>
                                <td><?php echo ($order_goods["sku_str"]); ?></td>
                                <td><?php echo ($order_goods["price"]); ?></td>
                                <td><?php echo ($order_goods["goods_num"]); ?></td>
                                <td><strong><?php echo ($order_goods["goods_price_total"]); ?></strong></td>
                            </tr><?php endforeach; endif; ?>
                        <tr>
                            <td colspan="9"><h4 class="order_info">商品总数：<strong>&nbsp;<?php echo ($datas["goods_num_total"]); ?>&nbsp;件</strong></h4>
                                <h4 class="order_info">实收款：<strong>&nbsp;<?php echo ($datas["order_goods_price"]); ?> + <?php echo ($datas["shipping_fee"]); ?>(运费) = <?php echo number_format($datas['pay_amount'],2);?>&nbsp;元</strong></h4></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box order_detail">
                <div class="box-header">
                    <h3 class="box-title">订单操作日志</h3>
                    <div class="box-tools">
                        <div class="input-group order"> </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>操作人</th>
                                <th>操作内容</th>
                                <th>操作时间</th>
                                <th>系统备注</th>
                            </tr>
                        <?php if(is_array($orderLog)): $i = 0; $__LIST__ = $orderLog;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$log): $mod = ($i % 2 );++$i;?><tr>
                                <td><?php echo ($log["user_name"]); ?></td>
                                <td><?php echo ($log["log_info"]); ?></td>
                                <td><?= date("Y-m-d H:i",$log['addtime'])?></td>
                                <td><?php echo ($log["handle_info"]); ?></td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <div style="display: none;" class="modal fade" id="edit_shipping_code">
            <div class="modal-dialog" style="margin:150px auto">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" style="text-align:center">修改物流信息</h4>
                    </div>
                    <div class="modal-body ">
                        <form method="post" id="edit_shipping" class="form-horizontal bv-form">
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="ship_name"> 物流公司：</label>
                                    <div class="col-sm-8">
                                        <select class="ship_name form-control" name="shipping_id" style="width:240px">
                                            <?php if(is_array($ship_info)): foreach($ship_info as $key=>$si): ?><option value="<?php echo ($si["shipping_id"]); ?>" <?php if($si['shipping_name'] == $datas['shipping_name']): ?>selected<?php endif; ?>><?php echo ($si["shipping_name"]); ?></option><?php endforeach; endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="ship_code"> 物流单号：</label>
                                    <div class="col-sm-8">
                                        <input name="ship_code" class="form-control" id="ship_code" value="<?php echo ($datas["shipping_code"]); ?>" type="text" style="width:240px">
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer text-center">
                                <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">关闭</button>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <button type="submit" class="btn btn-default">保存</button>
                            </div>
                            <!-- /.box-footer -->
                            <input class="order_id"value="<?php echo ($datas["order_id"]); ?>" type="hidden">
                        </form>
                    </div>
                </div>
                <!-- /.modal-content --> 
            </div>
            <!-- /.modal-dialog --> 
        </div>

        <div style="display: none;" class="modal fade" id="edit_address">
            <div class="modal-dialog" style="margin:150px auto">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" style="text-align:center">修改地址</h4>
                    </div>
                    <div class="modal-body ">
                        <form method="post" id="edit_address_info" class="form-horizontal bv-form">
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="user_name"> 收件人：</label>
                                    <div class="col-sm-4">
                                        <input name="user_name" class="form-control" id="user_name" value="<?php echo ($address["contact_name"]); ?>" type="text">
                                    </div>
                                    <label class="col-sm-2 control-label" for="user_phone"> 手机号：</label>
                                    <div class="col-sm-4">
                                        <input name="user_phone" class="form-control" id="user_phone" value="<?php echo ($address["tel"]); ?>" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="address"> 地址：</label>
                                    <div class="col-sm-10" id="address">
                                        <select class="prov form-control" id="prov">
                                            <?php if(is_array($province)): foreach($province as $key=>$prov): ?><option value="<?php echo ($prov["id"]); ?>" 
                                            <?php if($prov['area_name'] == $address['province']): ?>selected<?php endif; ?>><?php echo ($prov["area_name"]); ?></option><?php endforeach; endif; ?>
                                    </select>
                                    <select class="city form-control" id="city">
                                        <?php if(is_array($citys)): foreach($citys as $key=>$city): ?><option value="<?php echo ($city["id"]); ?>" 
                                        <?php if($city['area_name'] == $address['city']): ?>selected<?php endif; ?>><?php echo ($city["area_name"]); ?></option><?php endforeach; endif; ?>
                                </select>
                                <select class="dist form-control" id="dist">
                                    <?php if(empty($address['dist'])){ ?>
                                    <option value="" selected>请选择</option>
                                    <?php  }else{ ?>
                                    <?php if(is_array($dists)): foreach($dists as $key=>$dist): ?><option value="<?php echo ($dist["id"]); ?>" 
                                    <?php if($dist['area_name'] == $address['dist']): ?>selected<?php endif; ?>><?php echo ($dist["area_name"]); ?>
                                    </option><?php endforeach; endif; ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="contact_address"></label>
                        <div class="col-sm-10">
                            <textarea name="contact_address" id="contact_address" class="form-control" style="width:400px; min-height:40px; height:60px"><?php echo ($address["contact_address"]); ?> </textarea>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">关闭</button>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="submit" class="btn btn-default">保存</button>
                </div>
                <!-- /.box-footer -->
                <input id="address_id" value="<?php echo ($address["id"]); ?>" type="hidden">
                <input id="order_id" value="<?php echo ($address["order_id"]); ?>" type="hidden">
                <input id="zip_code" value="<?php echo ($address["zip_code"]); ?>" type="hidden">
            </form>
        </div>
        <div class="modal-footer"> </div>
    </div>
    <!-- /.modal-content --> 
</div>
<!-- /.modal-dialog --> 
</div>
<script src="/Public/js/plugins/jQuery-2.2.0.min.js"></script> 
<script type="text/javascript" src="/Public/static/layer/layer.js"></script> 
<script src="/Public/js/bootstrap.min.js"></script> 
<script src="/Public/js/app.min.js"></script> 
<script src="/Public/js/custom.js"></script> 
<script type="text/javascript">
    $(document).ready(function (e) {
        $(".prov").change(function (e) {
            $.ajax({
                url: "<?php echo U('Orders/Orders/area_list');?>",
                type: "GET",
                data: {'id': $(this).val()},
                dataType: "json",
                success: function (result) {
                    document.getElementById("city").options.length = 0;
                    document.getElementById("dist").options.length = 0;
                    document.getElementById("city").options.add(new Option("请选择", ''));
                    document.getElementById("dist").options.add(new Option("请选择", ''));
                    for (var i = 0; i < result.length; i++) {
                        document.getElementById("city").options.add(new Option(result[i].area_name, result[i].id));
                    }
                }, error: function () {
                }
            });
        });
        $(".city").change(function (e) {
            $.ajax({
                url: "<?php echo U('Orders/Orders/area_list');?>",
                type: "GET",
                data: {'id': $(this).val()},
                dataType: "json",
                success: function (result) {
                    document.getElementById("dist").options.length = 0;
                    document.getElementById("dist").options.add(new Option("请选择", ''));
                    for (var d = 0; d < result.length; d++) {
                        document.getElementById("dist").options.add(new Option(result[d].area_name, result[d].id));
                    }
                }, error: function () {
                }
            });
        });

        $("#edit_address_info").submit(function (e) {
            var mobile = $("#user_phone").val();
            var user_name = $("#user_name").val();
            var partten = /^1[3-8]\d{9}$/;
            var tel = /^0(([1,2]\d)|([3-9]\d{2}))\d{7,8}$/;
            if (mobile.length != 11 || (!partten.test(mobile) && !tel.test(mobile))) {
                layer.alert("请输入正确的手机号", {icon: 6});
                return false;
            }
            if (user_name.length > 10 || user_name.length < 2) {
                layer.alert("收件人姓名为2~10个字符", {icon: 6});
                return false;
            }
            if ($(".city").val() == '') {
                layer.alert("请选择城市", {icon: 6});
                return false;
            }
            if ($(".dist").find('option').length > 1 && $(".dist").val() == '') {
                layer.alert("请选择地区", {icon: 6});
                return false;
            }
//		if($(".dist").val()==''){
//			layer.alert("请选择地区",{icon:6});
//			return false;
//		}
            if ($("#contact_address").val().length < 5) {
                layer.alert("详细地址至少5个字以上", {icon: 6});
                return false;
            }
            if ($("#contact_address").val().length > 40) {
                layer.alert("详细地址最长40个字以内", {icon: 6});
                return false;
            }
            if ($(".dist").val() == '') {
                $(".dist").val('');
            }
//		alert($(".dist").val());
            var data = {
                contact_name: user_name,
                tel: mobile,
                province: $(".prov").val(),
                city: $(".city").val(),
                dist: $(".dist").val(),
                contact_address: $("#contact_address").val(),
                order_id: $("#order_id").val(),
                zip_code: $("#zip_code").val()
            };
            $.ajax({
                url: "<?php echo U('Orders/Orders/editAddress');?>",
                type: "POST",
                dataType: "json",
                data: data,
                success: function (result) {
                    if (result.status) {
                        $("#edit_address").css("display", "none");
                        layer.confirm(result.msg, {
                            btn: ['确定']
                        }, function () {
                            location.reload();
                        });
                    } else {
                        layer.confirm(result.msg);
                    }
                }, error: function () {
                    console.log('error');
                }
            });
            return false;
        });
        $("#edit_shipping").submit(function (e) {
            var code = $("#ship_code").val();
            var ship_code = /^[A-Za-z0-9]+$/;
            if (!ship_code.test(code)) {
                layer.alert("请输入正确的物流单号", {icon: 6});
                return false;
            }
            ;
            if (code.length >= 15) {
                layer.alert("物流单号不能超过14位", {icon: 6});
                return false;
            }
            var query = {
                shipping_id: $(".ship_name").val(),
                shipping_code: $("#ship_code").val(),
                order_id: $(".order_id").val()
            };
            $.ajax({
                url: "<?php echo U('Orders/Orders/edit_shipping');?>",
                type: "POST",
                dataType: "json",
                data: query,
                success: function (result) {
                    if (result.status) {
                        $("#edit_shipping_code").css("display", "none");
                        layer.confirm(result.msg, {
                            btn: ['确定']
                        }, function () {
                            location.reload();
                        });
                    } else {
                        layer.confirm(result.msg);
                    }
                }, error: function () {
                    console.log('error');
                }
            });
            return false;
        });
    });
</script>
</body>
</html>