<?php if (!defined('THINK_PATH')) exit();?>
<form class='form-inline'>
    <div class='row'>
        <label style='width:90px'>物流公司:</label>
        <div class='form-group'>
        <select name='ship_name' class='form-control input-xs ship_name'>
            <?php if(is_array($ship_code)): $i = 0; $__LIST__ = $ship_code;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ship_code): $mod = ($i % 2 );++$i;?><option value="<?php echo ($ship_code["id"]); ?>"><?php echo ($ship_code["shipping_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
        </div>
        <div class='form-group'>
          <input type="button" id="btn_assign"  onclick="allAssign()" class="btn btn-default btn-xs" value="分配">
        </div>
    </div>
</form>
<table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
    <thead>
    <tr role="row">
        <th class="sorting_asc">订单号</th>
        <th class="sorting_asc">获取运单号</th>
        <th class="sorting_asc">消息提示</th>
    </tr>
    </thead>
    <tbody>
    <?php if(is_array($hub_order_list)): $i = 0; $__LIST__ = $hub_order_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr role="row" class="odd">
          <td class="sorting_1"><?php echo ($vo["order_sn"]); ?></td>
          <td id="shipping_code_<?php echo ($vo["order_id"]); ?>">&nbsp;</td>
          <td id="message_<?php echo ($vo["order_id"]); ?>">&nbsp;</td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    </tbody>
</table>