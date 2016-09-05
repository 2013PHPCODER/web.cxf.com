<?php if (!defined('THINK_PATH')) exit();?><table class="table table-hover print_table" id="print_table">
    <tbody>
      <tr >
        <th>订单号/商品ID</th>
        <th>最新商家编码</th>
        <th>颜色&nbsp;尺码</th>
        <th>成本价/元</th>
        <th>数量</th>
        <th>发货状态</th>
        <th>售后状态</th>
      </tr>
      <?php if(is_array($datas)): $i = 0; $__LIST__ = $datas;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr class="first">
        <td ><?php echo ($list["order_sn"]); ?></td>
        <td><?=date("Y-m-d H:m:s",time())?></td>
        <td colspan="3" style="width: 150px;">
              <?php echo ($list["concat_address"]["contact_name"]); ?>,<?php echo ($list["concat_address"]["tel"]); ?>,&nbsp;<?php echo ($list["concat_address"]["province"]); ?>&nbsp;<?php echo ($list["concat_address"]["city"]); ?>&nbsp;<?php echo ($list["concat_address"]["dist"]); ?>&nbsp;<?php echo ($list["concat_address"]["contact_address"]); ?> 
        </td>
        <td colspan="3" style="text-align:center;">
            <?php echo ($list["memo"]); ?>
        </td>
      </tr>
      <tr class="first">
          <td><?php echo ($list["goods_no"]); ?></td>
          <td><?php echo ($list["buyer_goods_no"]); ?></td>
          <td><?php echo ($list["sku"]); ?></td>
          <td><?php echo ($list["original_price"]); ?></td>
          <td><?php echo ($list["goods_num"]); ?></td>
          <td><?php switch($list["ship_stats"]): case "0": ?>待配货<?php break;?>
                <?php case "1": ?>待分配<?php break;?>
                <?php case "2": ?>待发货<?php break;?>
                <?php case "3": ?>已完成<?php break; endswitch;?></td>
          <td style="color: red"> <?php echo xeq($list['is_cus'],1,'售后中');?></td>
      </tr>
      <tr>
        <td colspan="4"></td>
        <td>商品总数:</td>
        <td><?php echo ($list["goods_num"]); ?>件</td>
        <td colspan="2"></td>
      </tr>
      <input type="hidden" class="print_table" name="order_id[]" value="<?php echo ($list["order_id"]); ?>"><?php endforeach; endif; else: echo "" ;endif; ?>
    </tbody>
</table>