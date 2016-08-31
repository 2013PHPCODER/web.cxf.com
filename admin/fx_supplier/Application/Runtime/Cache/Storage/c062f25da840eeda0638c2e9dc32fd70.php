<?php if (!defined('THINK_PATH')) exit();?>
<form class='form-inline'>
    <div class='row'>
        <label style='width:90px'>物流公司:</label>
        <div class='form-group'>
        <select name='ship_name' class='form-control input-xs ship_name' id="ship_name">
            <?php if(is_array($ship_code)): $i = 0; $__LIST__ = $ship_code;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ship_code): $mod = ($i % 2 );++$i;?><option value="<?php echo ($ship_code["id"]); ?>"><?php echo ($ship_code["shipping_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
        </div>
    </div>
    <div class='row'>
        <div class='form-group'> <input  onchange='radiochange(this)' value='1' type='radio' name='hub_type'>获取电子面单号
        </div>
    </div>
    <div class='row'>
        <div class='form-group'>
            <input type='text' disabled='disabled' id='hub_one' readonly="readonly" class='form-control input-xs' value=''><input class='btn btn-default btn-xs getconcatBnt' type='button' value='获取' onclick='getconcat()'>
            <span id="tip_one" style="color: red; display: none;">获取失败</span>
        </div>
    </div>
    <div class='row'>
        <div class='form-group'>
        <input  onchange="radiochange(this)" value='2' type='radio' name='hub_type'>录入物流单号
        </div>
    </div>
    <div class='row'>
        <div class='form-group'>
        <input type='text' disabled='disabled' id='hub_two' class='form-control input-xs'  value=''>
        <span id="tip" style="color: red; display: none;">输入格式错误,请重新输入</span>
        <input type="hidden" name="" id="hub_id" value="<?php echo ($hub_id); ?>">
        <input type="hidden" name="" id="order_id" value="<?php echo ($order_id); ?>">
        </div>
    </div>
</form>