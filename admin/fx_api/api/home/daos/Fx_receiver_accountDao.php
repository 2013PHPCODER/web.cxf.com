<?php

namespace api\home;

class Fx_receiver_accountDao extends Dao {

    /**
     * 获取收款账户信息
     * @param type $receiver_platform
     * @author Ximeng <ximeng@xingmima.com>
     * @since 201608112018
     */
    public function get_receiver_account() {
        $sql = 'select receiver_account,receiver_name,receiver_platform,img_path from fx_receiver_account';
        return $this->query($sql, array());
    }

}
