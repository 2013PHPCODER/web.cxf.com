<?php

/**
 * 售后单数据迁移脚本
 * @author ximeng <1052214395@qq.com> <http://xinzou.cn>
 * @since 20160829
 */
require_once 'core/init.php';
$fx_db = get_fxDB();
$wb_db = get_wbDB();
echo "migrate begin\n";
while (true) {
    $param = [];
    $wb_db->executeMySQL('select * from cus_order_list where (status=2 or status=4) and is_migrate=0 limit 1', $param);
    $cus_order_info = $wb_db->rowFetch();
    if (!$cus_order_info) break;
    $wb_db->executeMySQL('select * from cus_order_goods_list where cus_id=?', [$cus_order_info['id']]);
    $cus_order_goods_list = $wb_db->getAll();
    foreach ($cus_order_goods_list as &$value) {
        $value['sku_comb_id'] = get_sku_comb_id($value['goods_id'], $value['sku_comb_id'], $wb_db, $fx_db);
        $value['cus_goods_status'] = $value['cus_goods_statu'];
        unset($value['cus_goods_statu']);
    }
    $cus_order_info['supplier_id'] = 1;
//    $cus_order_info['refund_status'] = $cus_order_info['status'];
    if (2 == $cus_order_info['cus_type']) {
        $cus_order_info['refund_status'] = 6;
    } else {
        $cus_order_info['return_status'] = 8;
    }
    $cus_order_info['refund_money_time'] = $cus_order_info['close_time'];
    $cus_order_info['supplier_show_refund'] = $cus_order_info['refund_amount'];
    unset($cus_order_info['status'], $cus_order_info['is_migrate']);
    $fx_db->executeMySQL("select * from cus_order_list where order_id=?", [$cus_order_info['order_id']]);
    $new_cus_record = $fx_db->rowFetch();

    try {
        $fx_db->beginTransaction();
        if ($new_cus_record) {//排除多条售后记录（保留最新记录）
            $fx_db->executeMySQL("delete from cus_order_list where order_id=?", [$cus_order_info['order_id']]);
        }
        $fx_db->insertAll($cus_order_goods_list, 'cus_order_goods_list');
        $fx_db->insert($cus_order_info, 'cus_order_list');
        $wb_db->executeMySQL("update cus_order_list set is_migrate=1 where id=?", [$cus_order_info['id']]);
        $fx_db->commit();
        echo "\n{$cus_order_info['id']}--------->migrate success!----------time=" . time();
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
