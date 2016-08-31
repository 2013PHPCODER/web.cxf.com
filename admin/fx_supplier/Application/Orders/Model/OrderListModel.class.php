<?php

/**
 * 订单列表model
 * @author Simon 
 */

namespace Orders\Model;

use Think\Model;

class OrderListModel extends Model {

    /**
     * [getOrderList 订单列表]
     * @param  string $mWhere [查询条件]
     * @param  string $mOrder [订单排序]
     * @return [Array]         [订单列表数组]
     */
    public function getOrderList($mWhere = '', $mOrder = '', $type = '') {
        $this->join('order_goods ON order_goods.order_id = order_list.order_id');
        $_count = $this->where($mWhere)->count('order_list.order_id');
        $_page = getPage($_count);
        $fields = "order_list.order_id,order_list.order_sn,order_list.add_time,order_list.shop_id,order_list.buyer_name,order_list.qq,order_list.is_cus,"
                . "order_list.memo,order_list.order_state,order_list.cost_price order_amount,order_list.shipping_fee,order_list.shipping_code,order_list.shipping_name,"
                . "order_goods.img_path,order_goods.goods_id,order_goods.goods_name,order_goods.price goods_price,order_goods.buyer_goods_no,order_goods.goods_num,"
                . "order_message.message,order_contact.tel,order_contact.contact_name,order_contact.contact_address,order_contact.zip_code,order_contact.province,order_contact.city,"
                . "order_contact.dist,goods_sku_comb.sku_str_zh as sku";
        $this->field($fields);
        $this->join('left join order_message ON order_message.order_id = order_list.order_id');
        $this->join('left join order_contact ON order_contact.order_id = order_list.order_id');
        $this->join('left join order_goods ON order_goods.order_id = order_list.order_id');
        $this->join('left join order_goods_sku ON order_goods_sku.order_id = order_list.order_id and order_goods.goods_id=order_goods_sku.goods_id');
        $this->join('left join goods_sku_comb ON goods_sku_comb.id = order_goods_sku.sku_comb_id');
        $_data['list'] = $this->where($mWhere)->group('order_list.order_id')->order($mOrder)->limit($_page->firstRow . ',' . $_page->listRows)->select();
        if (0 < count($_data['list'])) {
            $order_id_arr = array_column($_data['list'], 'order_id');
            $order_ids = implode(',', $order_id_arr);
            $cus_where = "order_id in ({$order_ids}) and (refund_status<>2 and refund_status<>6 or return_status<>2 and return_status<>8)";
            $cus_order_list = M('cus_order_list force index (order_id)')->field('order_id')->where($cus_where)->select();
            $order_id_cus = array_combine(array_column($cus_order_list, 'order_id'), array_column($cus_order_list, 'order_id'));
        }
        foreach ($_data['list'] as &$v) {
            $v['is_cus'] = isset($order_id_cus[$v['order_id']]) ? 1 : 0;
            $v['message'] = empty($v['message']) ? 0 : 1;
        }
        $_data['page'] = $_page->show();
        return $_data;
    }

}
