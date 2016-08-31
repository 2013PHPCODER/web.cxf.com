<?php

namespace api\home;

class Fx_distribute_levelDao extends Dao {
    /*     * 执行自定义增删改语句 */

    public function get_price_level() {
        $sql = 'select level,price from fx_distribute_level';
        return $this->query($sql, array());
    }

}
