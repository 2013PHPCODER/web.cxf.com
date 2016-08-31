<?php

/**
 * 订单联系信息表model
 * @author Simon 
 */

namespace Orders\Model;

use Think\Model;

class OrderContactModel extends Model {

    /**
     * [getOrderConcatAll 获取订单收件人所有地址信息]
     * @param  int  $mOrderID [订单ID]
     * @return Array           [数组]
     */
    public function getOrderConcatAll($mOrderID, $mLimit = 1) {
        $fields = "tel,contact_name,contact_address,zip_code,province,city,dist";
        $this->field($fields);
        $_concat = $this->where(array('order_id' => $mOrderID))->order('id desc');
        if (1 == $mLimit) {
            return $_concat->find();
        } else {
            return $_concat->select();
        }
    }

}
