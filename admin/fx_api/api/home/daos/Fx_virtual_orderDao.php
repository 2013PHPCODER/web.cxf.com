<?php

namespace api\home;

class Fx_virtual_orderDao extends Dao {
    /*     * 执行自定义增删改语句 */

    /**
     * 查询用户新增用户记录
     * @param type $user_id
     */
    public function get_order_list($user_id, $page, $page_size, $level, $stime, $etime, $keyword) {
        $sql = 'select `log`.id,`log`.new_username,`log`.vorder_sn,`vg`.`name`,`log`.price,`log`.agent_price,`log`.mark,`log`.status,(`log`.price -`log`.agent_price) as `ratio`,FROM_UNIXTIME(`log`.add_time) as `add_time` '
                . ' from fx_supplier_create_log as `log` INNER JOIN fx_virtual_goods as `vg` on log.virtual_goods_id=vg.id  where `status`=2 and distribute_id=:user_id ';
        $count_sql = 'select count(*) as `num`  from fx_supplier_create_log as `log` INNER JOIN fx_virtual_goods as `vg` on log.virtual_goods_id=vg.id  where `status`=2 and distribute_id=:distribute_id ';
        if ($level) {
            $sql .= ' and vg.level= ' . $level;
            $count_sql .=' and vg.level= ' . $level;
        }
        if ($stime) {
            $sql .= ' and log.finish_time>' . $stime;
            $count_sql .= ' and log.finish_time>' . $stime;
        }
        if ($etime) {
            $sql .= ' and log.finish_time< ' . $etime;
            $count_sql .=' and log.finish_time< ' . $etime;
        }
        if ($keyword) {
            $sql .= ' and log.new_username like %' . $keyword . '%';
            $count_sql .=' and log.new_username like % ' . $keyword . '%';
        }
        $sql .= ' ORDER BY log.finish_time desc limit ' . ($page - 1) * $page_size . ',' . $page_size;
        $list = $this->query($sql, array('user_id' => $user_id));
        $count = $this->query($count_sql, array('distribute_id' => '"' . $user_id . '"'));
        $num = $count[0]['num'];
        return array('page' => $page, 'total' => $num, 'list' => $list, 'total_page' => ceil($num / $page_size));
    }

    /**
     * 根据order_sn查询订单信息
     * @param type $order_sn
     * @param type $fields
     */
    public function get_vorder_info($order_sn, $fields = '*') {
        $sql = 'select ' . $fields . ' from fx_virtual_order where order_sn=:orderno'; // . $order_sn . '"';
        $parmeter = array('orderno' => $order_sn);
        $order = $this->query($sql, $parmeter, 'fetch_row');
        if (empty($order)) {
            myerror(\StatusCode::msgCheckFail, '错误的订单号！');
        }
        return $order;
    }

    /**
     * 获取开通账户开通着id
     * @param type $log_id
     */
    public function get_create_id($log_id) {
        $sql = 'select distribute_id from fx_supplier_create_log where id=:id';
        $parmeter = array('id' => $log_id);
        $log = $this->query($sql, $parmeter, 'fetch_row');
        if (empty($log)) {
            myerror(\StatusCode::msgCheckFail, '错误的订单号！');
        }
        return $log['distribute_id'];
    }

//    public function excute_sql() {
//        $sql = 'insert into fx_virtual_order(order_sn,order_type) values(:a,:b)';
//        $parmeter = array("a" => 'aaa', 'b' => "bbb");
//        $order = $this->excute($sql, $parmeter);
//    }

    /**
     * 取消订单
     * @param type $order_sn
     */
    public function cacel_order($order_sn) {
        $order_sql = 'select id,order_type from fx_virtual_order  where order_sn=:orderno and `status`=1';
        $order_info = $this->query($order_sql, array('orderno' => $order_sn), 'fetch_row');
        if (empty($order_info)) {
            myerror(\StatusCode::msgCheckFail, '错误的订单号！');
        }
        switch ($order_info['order_type']) {
            case 1:
                $sql = 'select vo.id,scl.new_distribute_id from fx_virtual_order as `vo` INNER JOIN fx_supplier_create_log as `scl` on vo.log_id=scl.id where vo.order_type=1 and order_sn=:orderno and `status`=1'; // . $order_sn . '"';
                $parmeter = array("orderno" => $order_sn);
                $order = $this->query($sql, $parmeter, 'fetch_row');
                if (empty($order)) {
                    myerror(\StatusCode::msgCheckFail, '错误的订单号！');
                }
                $update_sql = 'update fx_virtual_order set `status`=3 where order_sn=:order_sn and order_type=1';
                $delete_user_account_sql = 'delete from fx_distribute_user where id =:distribute_id and account_status=3';
                $this->beginTrans();
                try {
                    $update = $this->excute($update_sql, array('order_sn' => $order_sn));
                    $del = $this->excute($delete_user_account_sql, array('distribute_id' => $order['new_distribute_id']));
                    if (!$update || !$del) {
                        throw new Exception('取消订单失败！');
                    }
                } catch (Exception $e) {
                    $this->roll_back();
                    myerror(\StatusCode::msgDBFail, 'DB ERROR:' . $e->getMessage());
                }
                $this->commit();
                break;
            case 2:
                $update_sql = 'update fx_virtual_order set `status`=3 where order_sn=:order_sn and order_type=2 and `status`=1';
                $update = $this->excute($update_sql, array('order_sn' => $order_sn));
                if (!$update) {
                    myerror(\StatusCode::msgCheckFail, '取消订单失败！');
                }
                break;
            default :
                myerror(\StatusCode::msgCheckFail, '错误的订单号！');
                break;
        }
        return true;
    }

}
