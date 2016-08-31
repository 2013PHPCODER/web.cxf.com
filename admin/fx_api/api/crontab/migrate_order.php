<?php

/**
 * 订单数据迁移脚本
 * @author ximeng <1052214395@qq.com> <http://xinzou.cn>
 * @since 20160829
 */
require_once 'core/init.php';
$fx_db = get_fxDB();
$wb_db = get_wbDB();
echo "migrate begin\n";
while (true) {
    $param = [];
    $wb_db->executeMySQL('select * from order_list where is_migrate=0 limit 1', $param);
    $order_info = $wb_db->rowFetch();
    if (!$order_info) break;
    $wb_db->executeMySQL('select * from order_contact where order_id=?', [$order_info['order_id']]);
    $order_contact = $wb_db->rowFetch();
    $wb_db->executeMySQL('select * from order_goods where order_id=?', [$order_info['order_id']]);
    $order_goods = $wb_db->rowFetch();
    $wb_db->executeMySQL('select * from order_goods_sku where order_id=?', [$order_info['order_id']]);
    $order_goods_sku = $wb_db->rowFetch();
    $wb_db->executeMySQL('select * from order_message where order_id=?', [$order_info['order_id']]);
    $order_message = $wb_db->rowFetch();
    $order_info['supplier_id'] = 1;
    $order_info['cost_price'] = $order_info['order_amount'];
    $order_info['is_supplier_close'] = 0;
    $order_info['is_pay'] = 1;
    $sku_comb_id = get_sku_comb_id($order_goods_sku['goods_id'], $order_goods_sku['sku_comb_id'], $wb_db, $fx_db);
    $order_goods_sku['sku_comb_id'] = $sku_comb_id ? $sku_comb_id : 1;
    $order_goods['price'] = $order_goods['distribution_price'];
    $order_goods['top_category'] = 0;
    $order_goods['add_time'] = $order_goods['addtime'];
    if (!$order_message) {
        $order_message['to_user_type'] = 2 == $order_message['user_type'] ? 3 : 2; //留言（对谁留言）
    }
    unset($order_info['parent_id'], $order_info['pay_time'], $order_info['is_migrate'], $order_goods['addtime']); //去除不需要字段
    try {
        $fx_db->beginTransaction();
        $order_id = $fx_db->insert($order_info, 'order_list');
        $order_contact_id = $fx_db->insert($order_contact, 'order_contact');
        $order_goods_id = $fx_db->insert($order_goods, 'order_goods');
        $order_goods_sku_id = $fx_db->insert($order_goods_sku, 'order_goods_sku');
        if (!$order_message) {
            $order_message_id = $fx_db->insert($order_message, 'order_message');
        }
        $wb_db->executeMySQL("update order_list set is_migrate=1 where order_id=?", [$order_info['order_id']]);
        $fx_db->commit();
        echo "\n{$order_info['order_sn']}--------->migrate success!----------time=" . time();
    } catch (Exception $ex) {
        $fx_db->rollBack();
    }
}
echo "\nok!migrate finish----------time=" . time();

/**
 * 获取sku_comb_id
 * @param type $sku_comb_id
 * @param type $wb_db
 */
function get_sku_comb_id($goods_id, $sku_comb_id, $wb_db, $fx_db) {
    $wb_db->executeMySQL('select sku_str from goods_sku_comb where id=?', [$sku_comb_id]);
    $goods_sku_comb = $wb_db->rowFetch();
    $fx_db->executeMySQL('select id from goods_sku_comb where goods_id=? and sku_str=?', [$goods_id, $goods_sku_comb['sku_str']]);
    $goods_sku_comb_new = $fx_db->rowFetch();
    return $goods_sku_comb_new['id'];
}
