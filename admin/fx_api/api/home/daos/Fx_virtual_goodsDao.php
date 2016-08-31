<?php

namespace api\home;

class Fx_virtual_goodsDao extends Dao {
    /*     * 执行自定义增删改语句 */

    /**
     * 获取虚拟商品列表
     */
    public function get_list() {
        $sql = 'select id,name,price,agent_price from fx_virtual_goods';
        return $this->query($sql, array());
    }

    /**
     * 根据id获取代理价格
     * @param type $id
     */
    public function get_agent_info($id) {
        $sql = 'select price,agent_price,level from fx_virtual_goods where id=:id';
        $info = $this->query($sql, array('id' => $id));
        if (empty($info[0])) {
            myerror(\StatusCode::msgCheckFail, '错误的订单！!');
        }
        return $info[0];
    }

    /**
     * 检查数据库有没有相同的订单号
     * @param type $order_sn
     * @return type
     */
    public function check_order_unique($order_sn) {
        $sql = 'select id from fx_virtual_order where order_sn=:order_sn';
        $info = $this->query($sql, array('order_sn' => $order_sn));
        if (empty($info[0])) {
            return 1;
        }
        return 0;
    }

}
