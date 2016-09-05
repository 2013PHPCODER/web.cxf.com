<?php

namespace api\home;

class Log_listDao extends Dao {
    
     /**
     * 添加订单日志
     * @author shenlang
     * @param type $user_id 用户id
     * @param type $order_id 订单id
     * @param type $distribute_name 用户名
     */
    public function addLog($user_id, $order_id, $distribute_name) {
        $ip = $_SERVER["REMOTE_ADDR"];
        $addtime = time();
        $sql = "insert log_list(log_info,handle_info,user_id,user_name,cid,pid,ip_address,addtime) VALUES(:log,:handle,:user_id,:user_name,:cid,:pid,:ip_address,:addtime)";
        $arr=array('log'=>'生成虚拟订单','handle'=>'用户升级生成订单','user_id'=>$user_id,'user_name'=>$distribute_name,'cid'=>'5','pid'=>$order_id,'ip_address'=>$ip,'addtime'=>$addtime);
        return $this->excute($sql, $arr);
    }
}
