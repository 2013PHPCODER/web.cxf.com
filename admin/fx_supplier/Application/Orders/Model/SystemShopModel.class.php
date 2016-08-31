<?php

/**
 * 平台model
 * @author Simon 
 */

namespace Orders\Model;

use Think\Model;

class SystemShopModel extends Model {

    /**
     * [system_shop 取平台列表]
     * @return Array [description]
     */
    public function system_shop() {
        return $this->select();
    }

}
