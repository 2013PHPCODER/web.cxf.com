<?php

namespace api\home;

class Confirm_success_tradeDao extends Dao {

    /**
     * 
     * @param type $data
     * @param type $source_id
     */
    public function add_confirm($distribute_id, $data, $source_info) {
        //检查是否已经有数据
        $check_sql = 'select id from confirm_success_trade where type=4 and user_id=:user_id and source_id=:source_id limit 1';
        $record = $this->query($check_sql, array('user_id' => $data->user_id, 'source_id' => $source_info['id']), 'fetch_row');
        if (!empty($record)) {
            myerror(\StatusCode::msgCheckFail, '该订单已经提交！');
        }
        $sql = 'insert into confirm_success_trade (user_type,user_id,user_name,source_id,source_sn,type,`status`,confirm_money,trade_no,pay_account,receiver_account,pay_type,add_time,pay_time)'
                . ' value (:user_type,:user_id,:user_name,:source_id,:source_sn,:type,:status,:confirm_money,:trade_no,:pay_account,:receiver_account,:pay_type,:add_time,:pay_time)';
        $parmeters = array('user_type' => 2, 'user_id' => $distribute_id, 'user_name' => $data->user_name, 'source_id' => $source_info['id'], 'source_sn' => $data->order_sn, 'type' => 4, 'status' => 0,
            'confirm_money' => $source_info['pay_money'], 'trade_no' => $data->trade_no, 'pay_account' => $data->pay_account, 'receiver_account' => $data->receiver_account,
            'pay_type' => $data->pay_type, 'add_time' => time(), 'pay_time' => time());
        return $this->excute($sql, $parmeters);
    }

}
