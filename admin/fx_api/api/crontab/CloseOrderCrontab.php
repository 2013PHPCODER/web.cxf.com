<?php

/**
 * 自动取消订单
 * @author ximeng <1052214395@qq.com> <http://xinzou.cn>
 * @since 20160827
 */
require_once 'core/init.php';
$db = getDB();
$time = strtotime(date('Y-m-d')) - 60 * 60 * 24 * 3;
$param = [0, $time];
$sql = "SELECT o_l.order_id,o_l.order_sn,o_g.goods_id,o_g_s.sku_comb_id FROM order_list AS o_l INNER JOIN order_goods AS o_g ON o_l.order_id=o_g.order_id
LEFT JOIN order_goods_sku o_g_s ON o_l.order_id=o_g_s.order_id and o_g.goods_id=o_g_s.goods_id WHERE o_l.order_state = ? AND o_l.add_time<=?";
$db->executeMySQL($sql, $param);
$order_id_arr = $db->getAll();
foreach ($order_id_arr as $key => $val) {
    try {
        $db->executeMySQL("SELECT count(id) num FROM confirm_success_trade WHERE source_id = ? AND type = ?", [$val['order_id'], 1]);
        $trade_count = $db->rowFetch();
        if (0 < $trade_count['num']) continue; //排除已存在收款记录的订单
        $param_t_1 = [5, $val['order_id']];
        $db->beginTransaction();
        $db->executeMySQL('update order_list set order_state=? where order_id=?', $param_t_1);
        if (!$db->rowCount()) {
            throw new Exception("订单状态修改失败");
        }
        $db->executeMySQL('update goods_list set stock_num=stock_num+1 where goods_id=?', [$val['goods_id']]);
        if (!$db->rowCount()) {
            throw new Exception("商品库存修改失败");
        }
        $db->executeMySQL('update goods_sku_comb set stock_num=stock_num+1 where id=?', [$val['sku_comb_id']]);
        if (!$db->rowCount()) {
            throw new Exception("商品属性库存修改失败");
        }
        add_order_log($db, $val['order_id'], '系统自动取消订单'); //添加订单操作日志
        $db->commit();
        write_log("CloseOrderCrontab", "{$val['order_sn']}-------订单取消成功");
    } catch (Exception $ex) {
        $db->rollBack();
        write_log("CloseOrderCrontab", "{$val['order_sn']}-------{$ex->getMessage()}", "error");
    }
}
