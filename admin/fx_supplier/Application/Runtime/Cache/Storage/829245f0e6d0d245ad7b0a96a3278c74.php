<?php if (!defined('THINK_PATH')) exit();?>
<table class="table table-hover print_table" id="print_table">
    <tbody>
      <tr >
        <th>商品ID</th>
        <th>skuID</th>
        <th>SKU</th>
        <th>预警库存</th>
      </tr>
      <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr class="first">
        <td ><?php echo ($list["goods_id"]); ?></td>
        <td>
          <?php echo ($list["id"]); ?>
        </td>
        <td >
            <?php echo ($list["sku_str_zh"]); ?>
        </td>
        <td>
        	<input type="text" class="form-control input-xs stock_lock"  id="stock_lock_val" data-stock="<?php echo ($list["stock_lock_num"]); ?>" value="<?php echo ($list["stock_lock_num"]); ?>">
        	<input type="hidden" id="sku_id" value="<?php echo ($list["id"]); ?>">
        </td>
      </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    </tbody>
</table>