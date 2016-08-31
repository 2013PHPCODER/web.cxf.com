<?php

namespace api\home;

class Fx_distribute_userDao extends Dao {
    /*     * 执行自定义增删改语句 */

    public $field;
    public $table = 'fx_distribute_user';

    /**
     * 修改用户数据
     * @param int $_user_id 用户ID
     * @param string $_field 修改字段
     * @param string $_field_data 修改字段数据
     * @return boolean
     * @author San Shui <sanshui@mycxf.com>
     * @since 201608161515
     */
    public function update_user_info($_uid, $_field, $_field_data) {
        $_sql = 'UPDATE `fx_distribute_user` SET `' . $_field . '`=:field_data WHERE id=:id';
        if (!$this->excute($_sql, array('id' => $_uid, 'field_data' => $_field_data))) return false;
        return true;
    }

    public function recordLoginTime($user_id) {
        $sql = 'update fx_distribute_user set last_login_time=' . time() . ' where id=:id';
        $param = ['id' => $user_id];
        $this->excute($sql, $param);
    }

    /**
     * 
     * @param type $username
     * @param type $pwd
     * @return boolean
     */
    public function login($user_account, $pwd, $type) {
        
    //    die($user_account.'||'.$pwd."||".$type);
        $this->field = 'id as user_id, user_account, userpwd as pwd, usernick as user_nickname, email, mobile, balance as user_balance, leavel as user_level';
        $sql = 'select ' . $this->field . ' from ' . $this->table . " where $type=:user_account and account_status=".\account_status::yes;
        $param = ['user_account' => $user_account];
        $info = $this->query($sql, $param, 'fetch_row');

        if (!$info) {                                   //账号或密码错误
            return false;
        }
        return $info;
    }

    public function loginWithId($id) {              //通过id获得登录信息
        $this->field = 'id as user_id, user_account, usernick as user_nickname, email, mobile ';
        $sql = 'select ' . $this->field . 'from ' . $this->table . ' where id=:id';
        $param = ['id' => $id];
        $info = $this->query($sql, $param, 'fetch_row');
        return $info;
    }

    public function checkExist($checkField, $type = 'email') {
        $type == 'email' ? $field = 'email' : $field = 'mobile';
        $sql = 'select count(*) from ' . $this->table . ' where ' . $field . '=:field';
        $param = ['field' => $checkField];
        $r = $this->query($sql, $param, 'fetch_string');
        return $type == 'email' ? ['email' => $r, 'mobile' => null] : ['mobile' => $r, 'email' => null];
    }

    /**
     * 设置-账户设置-获取用户信息
     * @param int $_uid 用户UID
     * @return string JSON
     * @author San Shui <sanshui@mycxf.com>
     * @since 201608101311
     */
    public function get_user_info($_uid, $_user_account = '') {
        if (!empty($_user_account)) {
            $_str = ' AND user_account=:user_account';
            $_where = array('id' => $_uid, 'user_account' => $_user_account);
        } else {
            $_str = '';
            $_where = array('id' => $_uid);
        }
        $_sql = 'SELECT user_account,mobile,receiver_account,receiver_account_type,qq,leavel,email,addtime FROM ' . $this->table . ' WHERE id=:id ' . $_str;
        return $this->query($_sql, $_where, 'fetch_row');
    }

    /**
     * 查看用户是否代理
     * @param type $user_id
     */
    public function check_agent($user_id) {
        $sql = 'select id from fx_acting_user where distribute_id=:user_id limit 1';
        $info = $this->query($sql, array('user_id' => $user_id), 'fetch_row');
        if (empty($info['id'])) {
            myerror(\StatusCode::msgCheckFail, '您还没有申请代理资格！');
        }
        return true;
    }

    /**
     * 检查分销商用户名是否被占用
     * @param type $username
     */
    public function check_username_used($username) {
        $sql = 'select id from fx_distribute_user where mobile=:username limit 1';
        $info = $this->query($sql, array('username' => $username));
        if (!empty($info[0]['id'])) {
            myerror(\StatusCode::msgCheckFail, '该手机号已注册！');
        }
        return true;
    }

    private function create_guid() {
        return 'cxf_' . uniqid() . mt_rand(0, 1000);
    }

    /**
     * 添加用户
     * @param int $user_id
     * @param string $username
     * @param string $psd
     * @param int $virtual_goods_id
     * @param float $agent_price
     * @param int $level
     */
    public function add_user($order_sn, $user_id, $username, $pwd, $virtual_goods_id, $agent_info, $mark) {
        $add_user_sql = 'insert into fx_distribute_user (user_account,userpwd,account_status,leavel,addtime,mobile) value (:username,:psd,3,:level,:time,:mobile)';
        $this->beginTrans();
        try {
            $add_user_id = $this->insertOneBySql($add_user_sql, array('username' => $this->create_guid(), 'psd' => encodePwd($pwd), 'level' => $agent_info['level'], 'time' => date('Y-m-d H:i:s', time()), 'mobile' => $username));
            if (!$add_user_id) {
                throw new Exception('用户写入失败！');
            }
            $add_create_log_sql = 'insert into fx_supplier_create_log (distribute_id,new_distribute_id,new_username,`status`,level,price,agent_price,add_time,mark,virtual_goods_id,vorder_sn) value'
                    . ' (:distribute_id,:new_distribute_id,:new_username,:status,:level,:price,:agent_price,:add_time,:mark,:virtual_goods_id,:vorder_sn)';
            //添加新增记录
            $add_create_log_id = $this->insertOneBySql($add_create_log_sql, array('distribute_id' => $user_id, 'new_distribute_id' => $add_user_id, 'new_username' => $username, 'status' => 1,
                'level' => $agent_info['level'], 'price' => $agent_info['price'], 'agent_price' => $agent_info['agent_price'], 'add_time' => time(), 'mark' => $mark, 'virtual_goods_id' => $virtual_goods_id,
                'vorder_sn' => $order_sn));
            if (!$add_create_log_id) {
                throw new Exception('添加记录表失败！');
            }
            //添加虚拟订单数据
            $add_virtual_sql = 'insert into fx_virtual_order (order_sn,order_type,price,pay_money,add_time,`status`,distribute_user_id,virtual_goods_id,buyer_name,log_id,user_grade,target_grade) '
                    . 'value (:order_sn,:order_type,:price,:pay_money,:add_time,:status,:distribute_user_id,:virtual_goods_id,:buyer_name,:log_id,:user_grade,:target_grade)';
            $add_virtual_id = $this->insertOneBySql($add_virtual_sql, array('order_sn' => $order_sn, 'order_type' => 1, 'price' => $agent_info['price'], 'pay_money' => $agent_info['agent_price'],
                'add_time' => time(), 'status' => 1, 'distribute_user_id' => $add_user_id, 'virtual_goods_id' => $virtual_goods_id, 'buyer_name' => $username,
                'log_id' => $add_create_log_id, 'user_grade' => 1, 'target_grade' => $agent_info['level']));
            if (!$add_virtual_id) {
                throw new Exception('添加订单失败！');
            }
        } catch (Exception $e) {
            $this->roll_back();
            myerror(\StatusCode::msgDBFail, 'DB ERROR:' . $e->getMessage());
        }
        $this->commit();
        return $add_virtual_id;
    }

    public function test_add() {
//        echo 1;exit;
        $add_user_sql = 'insert into fx_distribute_user (user_account,userpwd,account_status,leavel,addtime) value (:username,:psd,3,:level,:time)';
        $add_user_id = $this->insertOneBySql($add_user_sql, array('username' => 'qssqqeweq', 'psd' => '123', 'level' => 3, 'time' => date('Y-m-d H:i:s', time())));
        print_r($add_user);
        exit;
    }

}
