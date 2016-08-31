<?php

/**
 * 订单商品SKUmodel
 * @author Simon 
 */

namespace Orders\Model;

use Think\Model;

class OrderGoodsSkuModel extends Model {

    /**
     * 获取商品sku中文
     * @param type $good_id
     * @param type $order_id
     * @return type
     */
    public function getOrderGoodsSku($good_id, $order_id) {
        $_sku_comb_id = M('OrderGoodsSku')->where("goods_id={$good_id} and order_id ={$order_id}")->getField('sku_comb_id');
        $sku_str_zh = M('GoodsSkuComb')->where("id={$_sku_comb_id}")->getField('sku_str_zh');
        return $sku_str_zh;
    }

}
