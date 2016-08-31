<?php

namespace api\home;

class Order_goods_skuDao extends Dao {

    /**
     * 获取sku_comb_id
     * @param type $order_id
     * @param type $goods_id
     * @return boolean
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    public function get_sku_comb_id($order_id, $goods_id) {
        $sql = "select sku_comb_id from order_goods_sku "
                . "where order_id=:order_id and goods_id=:goods_id";
        $param = array(
            'order_id' => $order_id,
            'goods_id' => $goods_id
        );
        $result = $this->query($sql, $param);
        if ($result) {
            return $result[0]['sku_comb_id'];
        }
        return FALSE;
    }

}
