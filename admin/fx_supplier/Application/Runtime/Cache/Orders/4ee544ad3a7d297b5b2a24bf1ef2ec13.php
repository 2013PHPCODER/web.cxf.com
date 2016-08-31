<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
    <div class="box-header with-border">
        <div class="box-title">
            <ul class="choose_ul">
                <li><a class="<?php echo xeq(I('get.group_id',1),1,'btn btn-warning btn-xs');?>" href="<?php echo U('orders/index',array('group_id' => 1 ));?>" >所有订单</a></li>
                <li><a  class="<?php echo xeq(I('get.group_id'),3,'btn btn-warning btn-xs');?>" href="<?php echo U('orders/index',array('group_id' => 3 ));?>">待发货</a></li>
                <li><a class="<?php echo xeq(I('get.group_id'),4,'btn btn-warning btn-xs');?>" href="<?php echo U('orders/index',array('group_id' => 4 ));?>">已发货</a></li>
                <li><a class="<?php echo xeq(I('get.group_id'),5,'btn btn-warning btn-xs');?>" href="<?php echo U('orders/index',array('group_id' => 5 ));?>">已完成</a></li>
                <li><a class="<?php echo xeq(I('get.group_id'),7,'btn btn-warning btn-xs');?>" href="<?php echo U('orders/index',array('group_id' => 7 ));?>">异常订单</a></li>
                <li><a class="<?php echo xeq(I('get.group_id'),8,'btn btn-warning btn-xs');?>" href="<?php echo U('orders/index',array('group_id' => 8 ));?>">已关闭</a></li>
            </ul>
        </div>
        <div class="box-tools pull-left"> </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row" >
            <form class="form-inline" method="get" action="<?php echo U('orders/index',$mp);?>" id="form_search">
                <div class="row" >
                    <div class="form-group">
                        <label for="exampleInputName2">时间:&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <select class="form-control input-xs" name="time_type">
                            <option <?php echo xeq(I('get.time_type'),'addtime','selected');?> value="add_time">下单时间</option>
                            <option <?php echo xeq(I('get.time_type'),'payment_time','selected');?> value="payment_time">支付时间</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>开始时间:</label>
                        <!--<input type="text" class="form-control input-xs" id="startTime" value="<?php echo I('get.startTime');?>" name="startTime">-->
                        <input type="text" class="form-control input-xs" onClick="WdatePicker()"  value="<?php echo I('get.startTime');?>" name="startTime"/>
                    </div>
                    <div class="form-group">
                        <label>结束时间:</label>
                        <!--<input type="text" class="form-control input-xs" id="endTime" value="<?php echo I('get.endTime');?>" name="endTime">-->
                        <input type="text" class="form-control input-xs" onClick="WdatePicker()"  value="<?php echo I('get.endTime');?>" name="endTime"/>
                    </div>
                    <div class="form-group">
                        <select class="form-control input-xs" name="order_search" >
                            <option value="">选择关键字</option>
                            <option <?php echo xeq(I('get.order_search'),'order_sn','selected');?> value="order_sn">订单号</option>
                            <option <?php echo xeq(I('get.order_search'),'goods_name','selected');?> value="goods_name">商品名称</option>
                            <option <?php echo xeq(I('get.order_search'),'goods_no','selected');?>  value="goods_no">商品ID</option>
                            <option <?php echo xeq(I('get.order_search'),'buyer_goods_no','selected');?> value="buyer_goods_no">商家编码</option>
                            <option <?php echo xeq(I('get.order_search'),'receiver_name','selected');?> value="receiver_name">收件人姓名</option>
                            <option <?php echo xeq(I('get.order_search'),'receiver_tel','selected');?> value="receiver_tel">收件人手机号</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" <?php echo xeq(I('get.order_search'),'','disabled');?> name="search_word" class="form-control input-xs" value="<?php echo I('get.search_word');?>"  placeholder="商品名称、货号、收件人姓名、电话">
                    </div>
                    <div class="form-group">
                        <input type="submit"  class="btn btn-block btn-warning btn-xs" value="搜索">
                        <input type="hidden" name="is_close" value="1" id="is_close" >
                        <input type="hidden" name="is_cus" value="1" id="is_cus">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-header">
        <form id="exportOrderExeclForm" action="<?php echo U(ACTION_NAME,I('get.'));?>" method="post">
            <input id="export_order_id" name="export_order_id" type="hidden">
            <input id="explode_orders" name="explode_orders" type="hidden">
        </form>
        <!--        <?php $_group = $_GET['group_id'] ? $_GET['group_id'] : 1 ; ?>
                <?php if( $_group == 1 ){ ?>
                <input type="checkbox" name="is_close" <?php echo xeq(I('get.is_close'),'2','checked');?>  class="check_close">
                <label for="">排除已关闭订单</label>
                <?php } else{ ?>
                &nbsp;
                <?php } ?>-->
        &nbsp;
        <div class="box-tools">
            <form id="sortForm" action="<?php echo U(ACTION_NAME,I('get.'));?>" method="get">
                <div class="input-group order" >
                    <ul>
                        <li><a href="#" class="btn btn-default btn-xs" id="exportOrderExecl">导出</a></li>
                        <?php switch($_GET['group_id']): case "1": ?><li><i class="btn btn-default btn-xs all_confirm" >确认</i></li>
                            <li><i  class="btn btn-default btn-xs all_deal" >处理</i></li><?php break;?>
                        <?php case "2": ?><li><a href="#" class="btn btn-default btn-xs all_confirm">确认</a></li><?php break;?>
                        <?php case "3": ?><li><a href="#" class="btn btn-default btn-xs excep">异常</a></li><?php break;?>
                        <?php case "4": break;?>
                        <?php case "5": break;?>
                        <?php case "6": break;?>
                        <?php case "7": ?><li><a href="#" class="btn btn-default btn-xs all_deal">处理</a></li><?php break;?>
                        <?php case "8": break;?>
                        <?php default: ?>
                        <li><i class="btn btn-default btn-xs all_confirm">确认</i></li>
                        <li><i  class="btn btn-default btn-xs all_deal">处理</i></li><?php endswitch;?>
                    </ul>
                </div>
                <?php if(in_array(I('get.group_id')?I('get.group_id'):1,array('1','2','3','7'))){?>
                <div class="fomr-group order">
                    <select class="form-control input-xs sort" name="sort">
                        <option value="">订单排序</option>
                        <option <?php if($_GET['sort']=="add_time~asc") echo "selected"; ?> value="add_time~asc">下单时间升序</option>
                        <option <?php if($_GET['sort']=="add_time~desc") echo "selected"; ?> value="add_time~desc">下单时间降序</option>
                        <option <?php if($_GET['sort']=="payment_time~asc") echo "selected"; ?> value="payment_time~asc">付款时间升序</option>
                        <option <?php if($_GET['sort']=="payment_time~desc") echo "selected"; ?> value="payment_time~desc">付款时间降序</option>
                    </select>
                </div>
                <?php }?>
            </form>
        </div>
    </div>

    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover" id="dataTable">
            <tbody>
                <tr>
                    <th align="middle"><input type="checkbox" id="checkAll"></th>
                    <th>商品</th>
                    <th class="price">单价/元</th>
                    <th class="num">数&nbsp;&nbsp;&nbsp;量</th>
                    <th class="total_money">总金额/元</th>
                    <th> </th>
                    <th>订单状态</th>
                    <th>操作</th>
                </tr>
            <?php if(is_array($datas["list"])): $i = 0; $__LIST__ = $datas["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr style="background-color: #fbfbfb;">

                    <td colspan="6"><ul class="table_li">
                            <li style="width: 2%">
                                <?php if(($list["is_cus"]) == "0"): ?><input type="checkbox" name="order_id[]" class="choose"  value="<?php echo ($list["order_id"]); ?>">
                            <?php else: ?>
                            &nbsp;<?php endif; ?>
                            </li>
                            <li><?php echo ($list["order_sn"]); ?></li>
                            <li>下单时间：
                                <?= date('Y-m-d H:i',$list['add_time']) ?>
                            </li>
                        </ul></td>
                    <td style="color: red;"><?php if(($list["is_cus"]) == "1"): ?><strong>售后中</strong><?php endif; ?></td>
                    <td>
                        <input type="hidden" id="order_id" value="<?php echo ($list["order_id"]); ?>">
                        <?php if($list['message'] == 1){ ?>
                        <a href="#" class="message"><i class="glyphicon glyphicon-comment"></i></a>
                        <?php }?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center" ><img class="table_img" src="<?php echo ($list["img_path"]); ?>_60x60.jpg"></td>
                    <td ><p> <?php echo ($list["goods_name"]); ?> </p>
                        <p>	<?php echo ($list["buyer_goods_no"]); ?>&nbsp;&nbsp;&nbsp;<?php echo ($list["sku"]); ?>&nbsp;&nbsp;</p>
                    </td>
                    <td><p><?php echo ($list["goods_price"]); ?></p></td>
                    <td align="center"> <?php echo ($list["goods_num"]); ?> </td>
                    <td><p><?php echo ($list["order_amount"]); ?></p>
                        <p>含运费:<?php echo ($list["shipping_fee"]); ?></p></td>
                    <td><p>收件人:
                            <?php echo ($list["contact_name"]); ?>,<?php echo ($list["tel"]); ?>&nbsp;,<?php echo ($list["province"]); echo ($list["city"]); echo ($list["dist"]); echo ($list["contact_address"]); ?>

                        </p></td>
                    <td><p>
                            <?php switch($list["order_state"]): case "0": ?>待付款<?php break;?>
                <?php case "1": ?>待确认<?php break;?>
                <?php case "2": ?>待发货<?php break;?>
                <?php case "3": ?>已发货<?php break;?>
                <?php case "4": ?>已完成<?php break;?>
                <?php case "5": ?>已关闭<?php break;?>
                <?php case "6": ?>异常订单<?php break; endswitch;?>
                </p>
                <?php if(I('get.group_id') == 4){ ?>
                <p> <a href="https://www.baidu.com/s?wd=<?php echo ($list["shipping_code"]); echo ($list["shipping_name"]); ?>" target="_blank">查看物流</a> </p>
                <?php }?></td>
                <td>
                    <p> <a href="<?php echo U('orders/orderDetail',array('order_id'=>$list['order_id']));?>" target="_blank">详情</a></p>
                    <?php if(($list["is_cus"]) == "0"): switch($list["order_state"]): case "0": ?><a  class='one_cancel' data-id=<?php echo ($list["order_id"]); ?>>取消</a><?php break;?>
                <?php case "2": ?><a href="#" data-id=<?php echo ($list["order_id"]); ?>  class ='one_excep'>异常</a><?php break;?>
                <?php case "5": break;?>
                <?php case "6": ?><a  href="#" data-id=<?php echo ($list["order_id"]); ?> class='one_deal'>处理</a><?php break; endswitch; endif; ?>
                </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>

            </tbody>
        </table>
    </div>
    <div class="box-footer">
        <div class="left" >
            <form class="form-inline" id="pagesizeForm" action="<?php echo U(ACTION_NAME, I('get.'));?>" method="get">
                <div class="form-group">
                    <label for="exampleInputName2">全选结果页: </label>
                    <input type="checkbox" id="selectall"  value="">
                </div>
                <div class="form-group">
                    <select name="pagesize" class="form-control input-xs pagesize">
                        <option <?php echo xeq(I('get.pagesize'), 20, 'selected');?> value="20">20条</option>
                        <option <?php echo xeq(I('get.pagesize'), 50, 'selected');?> value="50">50条</option>
                        <option <?php echo xeq(I('get.pagesize'), 100, 'selected');?> value="100">100条</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="right">
            <div class="pagination"> <?php echo ($datas["page"]); ?> </div>
        </div>
    </div>
</div>
</section>
<!-- /.box -->
</div>
 
    <script type="text/javascript" src="/Public/js/moment.js"></script> 
    <script src="/Public/js/bootstrap-datetimepicker.min.js"></script> 
    <script src="/Public/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script> 
    <script type="text/javascript" src="/Public/static/layer/layer.js"></script> 
    <script type="text/javascript" src="/Public/js/custom.js"></script> 
    <script>
                            $('select[name="order_search"]').change(function (event) {
                                /* Act on the event */
                                if ('' == $(this).val()) {
                                    $('input[name="search_word"]').attr('disabled', true);
                                    $('input[name="search_word"]').val('');
                                } else {
                                    $('input[name="search_word"]').removeAttr('disabled');
                                }
                            });
                            /**
                             * 留言
                             *
                             */
// 留言提交
                            var postMessage = function (to_user_type) {
                                if ($('#input_message').val()) {
                                    var val = $('#input_message').val();
                                    var order_id = $('#message_id').val();
                                    $.post("<?php echo U('Orders/Orders/saveMessage');?>", {order_id: order_id, val: val, to_user_type: to_user_type}, function (data) {
                                        if (data.status == 'success') {
                                            var str = "<p>";
                                            str += data.time + "&nbsp;分销商&nbsp;对&nbsp;管理员&nbsp;" + val;
                                            str += "</p>";
                                            $("#message_content").append(str);
                                            $('#input_message').val('');
                                        }
                                    });
                                }
                            }

                            var addMessage = function (obj, to_user_type) {
                                postMessage(to_user_type);
                            }
                            $(document).ready(function () {
                                //排序

                                $('.sort').change(function () {
                                    $('#sortForm').submit();
                                });
                                //排除已关闭订单
                                $('.check_close').change(function () {
                                    if ($(this).prop('checked')) {
                                        $('#is_close').val('2');
                                    }
                                    $('#form_search').submit();
                                });
                                //排除已售后订单
                                $('.check_cus').change(function () {
                                    if ($(this).prop('checked')) {
                                        $('#is_cus').val('2');
                                    }
                                    $('#form_search').submit();
                                });
                                //单个页面取消
                                $('.one_cancel').click(function () {
                                    var order_id = new Array();
                                    order_id.push($(this).data('id'));
                                    layer.confirm('订单取消后,将进入关闭状态,请确认', {title: '订单取消', btn: ['确认', '取消']}, function (index) {
                                        $.post("<?php echo U('Orders/Orders/cancelOrder');?>", {order_id: order_id}, function (result) {
                                            console.log(result);
                                            if (result.status == 'ok') {
                                                //layer.msg('操作成功,未成功确认'+result.total+"条",{time:1000});
                                                layer.alert(result.content, {btn: ['确定']}, function () {
                                                    layer.close();
                                                    window.location.reload();
                                                })
                                            } else {
                                                layer.alert('操作失败', {btn: ['确定']}, function () {
                                                    layer.close();
                                                    window.location.reload();
                                                });
                                            }
                                        })
                                    })
                                })
                                //所有订单页面 取消
                                $('.all_cancel').click(function () {
                                    if ($('.choose:checked').serialize() || $("#selectall").is(':checked')) {
                                        layer.confirm('你确定要取消订单吗?取消订单后,客户不能再进行付款,请确认',
                                                {title: '取消订单确认', btn: ['确认', '取消']},
                                                function (index) {
                                                    var data;
                                                    data = $('.choose:checked').serialize();
                                                    var urlPost = "<?php echo U('Orders/Orders/cancelOrder',I('get.'));?>";
                                                    $.post(urlPost, data, function (result) {
                                                        if (result.status == 'ok') {
                                                            // layer.msg('操作成功',{time:1000}); 
                                                            layer.alert('操作成功', {btn: ['确定']}, function () {
                                                                layer.close();
                                                                window.location.reload();
                                                            });
                                                        } else {
                                                            //layer.msg('有不能取消的订单'+result.status+'条',{time:1000});
                                                            layer.alert('有不能取消的订单' + result.status + '条', {btn: ['确定']}, function () {
                                                                layer.close();
                                                                window.location.reload();
                                                            });
                                                        }


                                                    });
                                                },
                                                function () {

                                                }

                                        );
                                    } else {
                                        layer.alert('请选择要操作的订单');
                                    }
                                    return false;
                                });
                                //所有订单页面 确认
                                $('.all_confirm').click(function () {
                                    if ($('.choose:checked').serialize() || $("#selectall").is(':checked')) {
                                        layer.confirm('订单确认后,将进入发货状态,请确认', {title: '订单确认', btn: ['确认', '取消']}, function (index) {
                                            var data;
                                            data = $('.choose:checked').serialize();
                                            var urlPost = "<?php echo U('Orders/Orders/confirmOrder',I('get.'));?>";
                                            $.post(urlPost, data, function (result) {
                                                console.log(result);
                                                if (result.status == 'ok') {
                                                    //layer.msg('操作成功,未成功确认'+result.total+"条",{time:1000});
                                                    layer.alert('操作成功,未成功确认' + result.total + "条", {btn: ['确定']}, function () {
                                                        layer.close();
                                                        window.location.reload();
                                                    });
                                                } else {
                                                    //layer.msg('操作失败',{time:1000})
                                                    layer.alert(result.content, {btn: ['确定']}, function () {
                                                        layer.close();
                                                        window.location.reload();
                                                    })
                                                }
                                            });
                                        },
                                                function () {

                                                }
                                        )
                                    } else {
                                        layer.alert('请选择要操作的订单');
                                    }
                                })

                                //单个订单确认
                                $('.one_confirm').click(function () {
                                    var order_id = new Array();
                                    order_id.push($(this).data('id'));
                                    layer.confirm('订单确认后,将进入发货状态,请确认', {title: '订单确认', btn: ['确认', '取消']}, function (index) {
                                        $.post("<?php echo U('Orders/Orders/confirmOrder');?>", {order_id: order_id}, function (result) {
                                            console.log(result);
                                            if (result.status == 'ok') {
                                                //layer.msg('操作成功,未成功确认'+result.total+"条",{time:1000});  
                                                layer.alert(result.content, {btn: ['确定']}, function () {
                                                    layer.close();
                                                    window.location.reload();
                                                })
                                            } else {
                                                layer.alert('操作失败', {btn: ['确定']}, function () {
                                                    layer.close();
                                                    window.location.reload();
                                                });
                                            }
                                        })
                                    })
                                    return false;
                                });
                                //单个订单异常
                                $('.one_excep').click(function () {
                                    var order_id = new Array();
                                    order_id.push($(this).data('id'));
                                    layer.confirm('订单确认后,将进入异常状态,请确认', {title: '订单异常', btn: ['确认', '取消']}, function (index) {
                                        $.post("<?php echo U('Orders/Orders/excepOrder');?>", {order_id: order_id}, function (result) {
                                            if (result.status == 'ok') {
                                                // layer.msg('操作成功',{time:1000});
                                                layer.alert(result.message, {btn: ['确定']}, function () {
                                                    layer.close();
                                                    window.location.reload();
                                                })
                                            } else {
                                                // layer.msg('有不能操作的订单'+result.status+'条',{time:1000})
                                                layer.alert(result.message, {btn: ['确定']}, function () {
                                                    layer.close();
                                                    window.location.reload();
                                                })
                                            }
                                        });
                                    });
                                    return false;
                                });
                                //批量订单异常
                                $('.excep').click(function () {
                                    if ($('.choose:checked').serialize() || $("#selectall").is(':checked')) {
                                        layer.confirm('订单确认后,将进入异常状态,请确认', {title: '订单异常', btn: ['确认', '取消']}, function (index) {
                                            var data
                                            data = $('.choose:checked').serialize();
                                            var urlPost = "<?php echo U('Orders/Orders/excepOrder',I('get.'));?>";
                                            $.post(urlPost, data, function (result) {
                                                if (result.status == 'ok') {
                                                    // layer.msg('操作成功',{time:1000});  
                                                    layer.alert(result.message, {btn: ['确定']}, function () {
                                                        layer.close();
                                                        window.location.reload();
                                                    });
                                                } else {
                                                    //layer.msg('有不能操作的订单'+result.status+'条',{time:1000})
                                                    layer.alert(result.message, {btn: ['确定']}, function () {
                                                        layer.close();
                                                        window.location.reload();
                                                    });
                                                }
                                            });
                                        },
                                                function () {

                                                }
                                        )
                                    } else {
                                        layer.alert('请选择要操作的订单');
                                    }
                                    return false;
                                })

                                //单个异常订单处理
                                $('.one_deal').click(function () {
                                    var order_id = new Array();
                                    order_id.push($(this).data('id'));
                                    layer.confirm('订单处理后,将进入待确认状态,请确认', {title: '异常处理', btn: ['确认', '取消']}, function (index) {
                                        $.post("<?php echo U('Orders/Orders/dealOrder');?>", {order_id: order_id}, function (result) {
                                            if (result.status == 'ok') {
                                                // layer.msg('操作成功',{time:1000});
                                                layer.alert(result.message, {btn: ['确定']}, function () {
                                                    layer.close();
                                                    window.location.reload();
                                                });
                                            } else {
                                                //layer.msg('有不能操作的订单'+result.status+'条',{time:1000})
                                                layer.alert(result.message, {btn: ['确定']}, function () {
                                                    layer.close();
                                                    window.location.reload();
                                                });
                                            }
                                        });
                                    });
                                });
                                //批量异常订单处理 
                                $('.all_deal').click(function () {
                                    if ($('.choose:checked').serialize() || $("#selectall").is(':checked')) {
                                        layer.confirm('订单处理后,将进入待确认状态,请确认', {title: '异常处理', btn: ['确认', '取消']}, function (index) {
                                            var data;
                                            data = $('.choose:checked').serialize();
                                            var urlPost = "<?php echo U('dealOrder',I('get.'));?>";
                                            $.post(urlPost, data, function (result) {
                                                //console.log(result);
                                                if (result.status == 'ok') {
                                                    layer.alert('操作成功');
                                                } else {
                                                    layer.alert('有不能操作的订单' + result.status + '条');
                                                }
                                                layer.close(index);
                                                window.location.reload();
                                            });
                                        },
                                                function () {

                                                }
                                        )
                                    } else {
                                        layer.alert('请选择要操作的订单');
                                    }
                                })
                                //备注
                                $('.assign').click(function () {
                                    var order_id = $(this).next().val();
                                    $.post("<?php echo U('Orders/Orders/addRemark');?>", {order_id: order_id}, function (result) {
                                        layer.confirm(result, {title: "备注", btn: ['确定', '取消'], area: ['400px', '300px']}, function (index) {
                                            var memo = $('#memo').val();
                                            $.post("<?php echo U('Orders/Orders/updateRemark');?>", {memo: memo, order_id: order_id}, function (data) {
                                                if (data.message == 'ok') {
                                                    layer.msg('操作成功');
                                                } else {
                                                    layer.msg('操作失败');
                                                }
                                                window.location.reload();
                                            });
                                        });
                                    });
                                });
                                //获取消息页面
                                var message = function (order_id) {
                                    $.post("<?php echo U('Orders/Orders/Message');?>", {order_id: order_id}, function (result) {
                                        layer.open({
                                            type: 1,
                                            title: "留言板",
                                            closeBtn: 1,
                                            shadeClose: true,
                                            area: ['400px', '300px'],
                                            content: result
                                        });
                                        $('#layui-layer1').unbind('keydown');
                                        $("#input_message").keydown(function (event) {
                                            var e = event || window.event;
                                            if (e.keyCode == 13) {
                                                postMessage();
                                            }
                                        });
                                    });
                                }

                                $('.message').click(function () {
                                    var order_id = $(this).prev().val();
                                    message(order_id);
                                    return false;
                                });
                            });
//导出商品订单
                            $("#exportOrderExecl").click(function (event) {
                                var data = new Array();
                                $('.choose:checked').each(function (index, el) {
                                    data[index] = $(this).val();
                                });
                                if (data.length <= 0) {
                                    layer.alert('请选择商品', {icon: 6});
                                    return false;
                                }
                                $("#exportOrderExeclForm input[name='explode_orders']").val(1);
//            $('input[name="explode_orders"]').val(1);
                                $("#exportOrderExeclForm input[name='export_order_id']").val(data);
                                $("#exportOrderExeclForm").submit();
                                return false;
                            });
    </script> 

