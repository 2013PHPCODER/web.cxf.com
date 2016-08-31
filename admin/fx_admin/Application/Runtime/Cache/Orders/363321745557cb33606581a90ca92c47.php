<?php if (!defined('THINK_PATH')) exit();?><div class="content_message" style="padding-left:15px;padding-right:5px;height: 242px;overflow-y: scroll;">
    <div class="row" id="message_content">
        <?php if(is_array($result)): $i = 0; $__LIST__ = $result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$message): $mod = ($i % 2 );++$i;?><p><?=date("Y-m-d H:m:s",$message['addtime']) ?>&nbsp;
                <?php switch($message["user_type"]): case "1": ?>供应商<?php break;?>	
            <?php case "2": ?>管理员<?php break;?>
            <?php case "3": ?>分销商<?php break; endswitch;?>
            &nbsp;对&nbsp;
            <?php switch($message["to_user_type"]): case "1": ?>供应商<?php break;?>	
            <?php case "2": ?>管理员<?php break;?>
            <?php case "3": ?>分销商<?php break; endswitch;?>
            &nbsp;<?php echo ($message["message"]); ?>;
            </p><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>	
</div>
<form class="row" style="position: fixed;bottom: 0;width: 100%;">
    <div class="form-group">
        <input type="text" name=""  placeholder="请输入留言"  class="form-control input-xs" style="display: block;float: left;width:250px;margin-left:10px" id="input_message">
        <input type="button" class="btn btn-default btn-xs "  style="display: block;float: left;margin-left:10px;" value="分销商" id="setMessage" onclick="addMessage(this, 3)">
        <input type="button" class="btn btn-default btn-xs "  style="display: block;float: left;margin-left:10px;" value="供应商" id="setMessage" onclick="addMessage(this, 1)">
        <input type="hidden" id="message_id" value=<?php echo ($order_id); ?>>
    </div>
</form>