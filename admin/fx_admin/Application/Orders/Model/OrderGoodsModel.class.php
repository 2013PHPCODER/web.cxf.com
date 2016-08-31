<?php

/**
 * 订单商品model
 * @author Simon 
 */

namespace Orders\Model;

use Think\Model;

class OrderGoodsModel extends Model {

    /**
     * [getOrderImg 获取订单商品图片]
     * @return [type] [description]
     */
    public function getOrderGoods($mOrderId) {
        $this->field("img_path,goods_id,goods_name,distribution_price,buyer_goods_no,goods_num");
        return $this->where("order_goods.order_id ={$mOrderId}")->find();
    }

}
