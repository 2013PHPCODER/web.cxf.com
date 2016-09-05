<?php

/**
 * 自动确认收货
 * @author ximeng <1052214395@qq.com> <http://xinzou.cn>
 * @since 20160827
 */
require_once 'core/init.php';
$db = getDB();
$time = strtotime(date('Y-m-d')) - 60 * 60 * 24 * 7;
$param = [3, 3, $time];
$sql = "SELECT o_l.order_id,o_l.order_sn FROM order_list AS o_l INNER JOIN hub_order AS h_o ON o_l.order_id = h_o.order_id WHERE o_l.order_state = ? AND h_o.ship_stats = ? AND o_l.send_hub_time<=?";
$db->executeMySQL($sql, $param);
$order_id_arr = $db->getAll();
foreach ($order_id_arr as $key => $val) {
    $param_t_1 = [4, $val['order_id']];
    try {
        $db->executeMySQL('update order_list set order_state=? where order_id=?', $param_t_1);
        add_order_log($db, $val['order_id'], '系统自动确认收货'); //添加订单操作日志
        if (!$db->rowCount()) {
            throw new Exception("订单自动确认收货失败！");
        }
        write_log("FinishOrderCrontab", "{$val['order_sn']}--------订单自动确认收货成功");
    } catch (Exception $ex) {
        write_log("FinishOrderCrontab", $val['order_sn'] . '--------' . $ex->getMessage(), "error");
    }
}
