<?php

/**
 * 仓库model
 * @author Simon 
 */

namespace Orders\Model;

use Think\Model;

class SystemDepotModel extends Model {

    /**
     * depotList 取仓库列表
     * @return Array 
     */
    public function depotList() {
        return $this->field('id,depot_name')->select();
    }

}
