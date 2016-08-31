<?php

namespace api\home;

class Fx_catch_moneyDao extends Dao {

    /**
     * 申请提现
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     * @param type $data
     * @return type boolean
     */
    public function apply_withdraw($data) {
        $data->receiver_account_type = 1;
        $data->addtime = time();
        $data->user_type = 2;
        $data->catch_type = 1;
        $data->status = 1;
        $_fields = 'apply_user_id,remark,repay,receiver_account,receiver_name,receiver_account_type,addtime,user_type,catch_type,status';
        $parmeters = ":apply_user_id,:remark,:repay,:receiver_account,:receiver_name,:receiver_account_type,:addtime,:user_type,:catch_type,:status";
        $sql = "insert into fx_catch_money ({$_fields}) values({$parmeters})";
        return $this->excute($sql, (array) $data);
    }

}
