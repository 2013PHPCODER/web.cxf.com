<?php

/**
 * 物流公司model
 * @author Simon 
 */

namespace Orders\Model;

use Think\Model;

class SystemShippingModel extends Model {

    /**
     * [system_shipping 取物流公司名称]
     * @return Array [description]
     */
    public function system_shipping() {
        return $this->order("sort asc")->select();
    }

    /**
     * getShipInf 取物流公司信息
     * @param  Int     $mShipId 物流公司ＩＤ
     * @return Array          
     */
    public function getShipInf($mShipId) {
        return $this->where("id={$mShipId}")->find();
    }

}
