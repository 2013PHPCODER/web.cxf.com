<?php

/**
 * 订单结算
 * @author ximeng <1052214395@qq.com> <http://xinzou.cn>
 * @since 20160827
 */
require_once 'core/init.php';
$db = getDB();
$time = strtotime(date('Y-m-d')) - 60 * 60 * 24 * 7;
$param = [4, $time];
$db->executeMySQL('select * from order_list where order_state=? and close_time<=?', $param);
$order_id_arr = $db->getAll();
foreach ($order_id_arr as $key => $val) {
    $param_t_1 = [$val['order_id'], 2, 6, 2, 8];
    $db->executeMySQL('select count(id) as num from cus_order_list where order_id=? and ((refund_status=? or refund_status=?) or (refund_status=? or refund_status=?))', $param_t_1);
    $tmp_row_1 = $db->rowFetch();
    if (0 < $tmp_row_1['num']) {
        continue;
    }
    $param_t = [$val['order_id'], 2, 1, 2];
    $db->executeMySQL('select count(id) as num from fx_catch_money where source_id=? and catch_type=? and (status=? or status=?)', $param_t); //检查是否已经存在待打款记录
    $tmp_row = $db->rowFetch();
    if (0 == $tmp_row['num']) {
        try {
            add_catch_money($db, $val);
            write_log("OrderBalanceCrontab", "{$val['order_sn']}-------订单结算成功，已生成打款数据!");
        } catch (Exception $ex) {
            write_log("OrderBalanceCrontab", "{$val['order_sn']}-------{$ex->getMessage()}");
        }
    }
}

/**
 * 添加打款列表balance
 * @param type $data
 */
function add_catch_money($db, $data) {
    $sql = "INSERT INTO `fx_catch_money` "
            . "(`source_sn`, `apply_user_id`, `catch_type`, `trade_no`, `source_id`, `repay`, `status`, `receiver_account`, `receiver_account_type`, `bank_deposit`, `receiver_name`, `remark`, `addtime`,  `user_type`)"
            . " VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $supplier_info = get_supplier_info($db, $data['supplier_id']);
    $order_price = get_order_price($db, $data['order_id'], $data);
    $price = bcadd($order_price, $data['shipping_fee'], 2);
    $param = [$data['order_sn'], $data['supplier_id'], 2, $data['order_sn'], $data['order_id'], $price, 1, $supplier_info['receiver_account'], $supplier_info['receiver_account_type'], $supplier_info['open_bank_address'], $supplier_info['receiver_account_name'], "系统自动生成", time(), 1];
    $db->executeMySQL($sql, $param);
    if (!$db->isInserted()) {
        throw new Exception('添加打开数据失败');
    }
}

/**
 * 获取供货商信息
 * @param type $db
 * @param type $supplier_id
 */
function get_supplier_info($db, $supplier_id) {
    $db->executeMySQL('select * from fx_supplier_user where id=?', [$supplier_id]);
    $result = $db->rowFetch();
    if ($result) {
        return $result;
    }
    throw new Exception("获取供货商信息失败！");
}

/**
 * 获取订单结算金额
 * @param type $db
 * @param type $order_id
 * @return type float
 */
function get_order_price($db, $order_id, $order_info) {
    $db->executeMySQL('select * from order_goods where order_id=?', [$order_id]);
    $result = $db->getAll();
    if (!$result) {
        throw new Exception("获取订单结算金额失败");
        return FALSE;
    }
    $money = $order_info['shipping_fee'];
    foreach ($result as $value) {
        $money = bcadd($money, bcmul($value['price'], $value['goods_num'], 2), 2);
    }
    return $money;
}
