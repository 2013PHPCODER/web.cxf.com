<?php

namespace api\home;

class Order_listDao extends Dao {

    /**
     * 获取订单列表
     * @param type $fields
     * @param type $condition
     * @param type $param
     * @param type $sort
     * @param type $page
     * @param type $per_page
     * @return type array
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    public function getOrderList($fields, $condition, $param, $sort, $page, $per_page) {
        $sql_count = "select count(o_l.order_id) as total from order_list as o_l "
                . "left join order_goods as o_g on o_l.order_id=o_g.order_id "
                . "where {$condition}";
        $count = $this->query($sql_count, $param);
        $result['total'] = $count[0]['total'];
        $sql = "select {$fields} from order_list as o_l "
                . "left join order_goods as o_g on o_l.order_id=o_g.order_id "
                . "left join order_goods_sku ON order_goods_sku.order_id = o_l.order_id and o_g.goods_id=order_goods_sku.goods_id "
                . "left join goods_sku_comb ON goods_sku_comb.id = order_goods_sku.sku_comb_id "
                . "where {$condition} order by {$sort} limit {$page},{$per_page}";
        $result['item'] = $this->query($sql, $param);
        return $result;
    }

    /**
     * 查询订单详情
     * @param int $_order_id 订单ID
     * @return array 返回查询结果
     * @author San Shui <sanshui@mycxf.com>
     * @since 201608101741
     */
    public function order_details($_order_id, $_order_sn) {
        //查询订单信息--多个条件查询，防止用户拿到授权信息获取其他信息
        $_order_list_sql = 'SELECT send_hub_time,order_state,is_cus,goods_amount,pay_amount,shipping_fee,payment_time,con_time,other_order_sn,add_time,shipping_name,is_pay,'
                . 'shipping_code,hub_type FROM '
                . 'order_list WHERE order_id=:order_id AND order_sn=:order_sn';
        $_order_list_datas = $this->query($_order_list_sql, array('order_id' => $_order_id, 'order_sn' => $_order_sn), 'fetch_row');
        if (empty($_order_list_datas)) myerror(\StatusCode::msgCheckFail, \Order::order_detail_error);
        $_order_list_datas['num_total'] = 0;
        if (0 == $_order_list_datas['order_state'] && 1 == $_order_list_datas['is_pay']) {
            $_order_list_datas['order_state'] = '1';
        }
        //发货信息
        $_order_contact_sql = 'SELECT contact_name,tel,province,city,dist,'
                . 'contact_address FROM order_contact WHERE order_id=:order_id';
        $_order_contact_datas = $this->query($_order_contact_sql, array('order_id' => $_order_id), 'fetch_row');

        //包裹
        $_order_goods_sql = 'SELECT distribution_price,goods_num,goods_name,buyer_goods_no,img_path,goods_id FROM order_goods WHERE order_id=:order_id';
        $_order_goods_datas = $this->query($_order_goods_sql, array('order_id' => $_order_id));
        if (empty($_order_goods_datas)) myerror(\StatusCode::msgCheckFail, \Order::order_detail_error);

        //order_goods_sku 订单商品SKU
        $_order_goods_sku_sql = 'SELECT sku_comb_id FROM order_goods_sku WHERE order_id=:order_id AND goods_id=:goods_id';
        $_goods_sku_comb_sql = 'SELECT sku_str_zh FROM goods_sku_comb WHERE id=:id';
        foreach ($_order_goods_datas as $_key => $_value) {
            $_sku_comb_id_arr = $this->query($_order_goods_sku_sql, array('order_id' => $_order_id, 'goods_id' => $_value['goods_id']), 'fetch_row');
            $_sku_str_zh_arr = $this->query($_goods_sku_comb_sql, array('id' => $_sku_comb_id_arr['sku_comb_id']), 'fetch_row');
            $_order_goods_datas[$_key]['sku_str_zh'] = $_sku_str_zh_arr['sku_str_zh'];
            $_order_goods_datas[$_key]['subtotal'] = $_value['goods_num'] * $_value['distribution_price'];
            $_order_list_datas['num_total'] += $_value['goods_num'];
        }

        //留言
        $_order_message_sql = 'SELECT message FROM order_message WHERE order_id=:order_id AND to_user_type=:to_user_type';
        $_order_message_datas = $this->query($_order_message_sql, array('order_id' => $_order_id, 'to_user_type' => \Order::order_detail_orderto_user_type), 'fetch_row');

        //售后单号
        if (0 < $_order_list_datas['is_cus']) {
            $_cus_order_list_sql = 'SELECT id FROM cus_order_list WHERE order_id=:order_id';
            $_cus_order_list_arr = $this->query($_cus_order_list_sql, array('order_id' => $_order_id), 'fetch_row');
            $_order_list_datas['cus_id'] = $_cus_order_list_arr['id'];
        }
        $_order_list_datas['add_time'] = 100 < $_order_list_datas['add_time'] ? date('Y-m-d H:i:s', $_order_list_datas['add_time']) : '';
        $_order_list_datas['payment_time'] = 100 < $_order_list_datas['payment_time'] ? date('Y-m-d H:i:s', $_order_list_datas['payment_time']) : '';
        $_order_list_datas['con_time'] = 100 < $_order_list_datas['con_time'] ? date('Y-m-d H:i:s', $_order_list_datas['con_time']) : '';
        return array('order' => $_order_list_datas, 'contact' => $_order_contact_datas, 'goods' => $_order_goods_datas, 'message' => $_order_message_datas['message']);
    }

    /**
     * 获取订单数量
     * @param type $condition
     * @return type
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    public function getOrderCount($condition, $param) {
        $sql_count = "select count(o_l.order_id) as total from order_list as o_l "
                . "where {$condition}";
        $count = $this->query($sql_count, $param);
        return $count[0]['total'];
    }

    /**
     * 检查订单号是否重复
     * @param type $order_sn
     * @return type int
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    public function checkOrderSn($order_sn) {
        $sql = "select count(o_l.order_id) as total from order_list as o_l "
                . "where order_sn=:order_sn";
        $result = $this->query($sql, array("order_sn" => $order_sn));
        return $result[0]['total'];
    }

    /**
     * 添加完整订单数据
     * @param type $data
     * @return type int 订单id
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    public function add_order($q, $order_data, $order_contact_data, $order_goods_data, $_order_goods_sku_data, $order_message_data) {
        $_goods_list_obj = \Dao::Goods_list();

        try {
            $this->begin_trans();
            $_goods_list_obj->change_goods_stock($q->goods_id, $q->goods_sku_id, $q->goods_count);
            $order_id = $this->insert_order($order_data, 'order_list');
            $this->insert_order_goods($order_id, $order_goods_data, 'order_goods');
            $this->insert_order_contact($order_id, $order_contact_data, 'order_contact');
            $this->insert_order_goods_sku($order_id, $_order_goods_sku_data, 'order_goods_sku');
            if (count($order_message_data) > 0) {
                $this->insert_order_message($order_id, $order_message_data, 'order_message');
            }
            $this->insert_log_list('订单生成', '订单生成，状态待付款', $q->user_id, $q->user_name, 1, $order_id);
            $this->commit();
            return $order_id;
        } catch (\Exception $ex) {
            $this->roll_back();
            myerror(\StatusCode::msgDBUpdateFail, $ex->getMessage());
        }
    }

    /**
     * 插入订单日志记录
     * @param type $log_info    系统备注
     * @param type $handle_info     操作说明
     * @param type $user_id 用户ID
     * @param type $user_name   操作人用户名
     * @param type $cid 分类ID：
     * @param type $pid 被记录对像的ＩＤ
     * @return type
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    public function insert_log_list($log_info, $handle_info, $user_id, $user_name, $cid, $pid) {
        $data['log_info'] = $log_info;
        $data['handle_info'] = $handle_info;
        $data['user_id'] = $user_id;
        $data['user_name'] = $user_name;
        $data['cid'] = $cid;
        $data['pid'] = $pid;
        $data['addtime'] = time();
        $data['ip_address'] = get_client_ip();
        return $this->insert_data($data, 'log_list');
    }

    /**
     * 插入订单留言数据返回id
     * @param type $data
     * @return type int 订单id
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    public function insert_order_message($order_id, $data, $table) {
        $data['order_id'] = $order_id;
        return $this->insert_data($data, $table);
    }

    /**
     * 插入订单商品sku数据返回id
     * @param type $data
     * @return type int 订单id
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    public function insert_order_goods_sku($order_id, $data, $table) {
        $data['order_id'] = $order_id;
        return $this->insert_data($data, $table);
    }

    /**
     * 插入订单商品数据返回id
     * @param type $data
     * @return type int 订单id
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    public function insert_order_goods($order_id, $data, $table) {
        $data['order_id'] = $order_id;
        return $this->insert_data($data, $table);
    }

    /**
     * 插入订单数据返回id
     * @param type $data
     * @return type int 订单id
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    public function insert_order($data, $table) {
        return $this->insert_data($data, $table);
    }

    /**
     * @return type插入订单联系人返回id
     * @param type $order_id
     * @param array $data
     * @param type $table
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    public function insert_order_contact($order_id, $data, $table) {
        $data['order_id'] = $order_id;
        return $this->insert_data($data, $table);
    }

    /**
     * 插入数据返回id
     * @param type $data
     * @return type int 订单id
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    public function insert_data($data, $table) {
        $_fields = '';
        $parmeters = '';
        foreach ($data as $key => $val) {
            $_fields .= $key . ',';
            $parmeters .= ':' . $key . ',';
        }
        $_fields = substr($_fields, 0, strlen($_fields) - 1);
        $parmeters = substr($parmeters, 0, strlen($parmeters) - 1);
        $sql = "insert into {$table} ({$_fields}) values({$parmeters})";
        $_id = $this->insertOneBySql($sql, $data);
        if ($_id) {
            return $_id;
        }
        throw new Exception('写入信息异常！');
    }

    /**
     * 获取订单信息
     * @param type $order_id
     * @return type
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    public function get_order_info($order_id, $fields = '*') {
        $sql = 'select ' . $fields . ' from order_list where order_id=:order_id';
        $result = $this->query($sql, array('order_id' => $order_id));
        return $result[0];
    }

    /**
     * 确认收货---order_state订单状态：0＝待付款，1=已付款待确认，2=已确认待发货，
     * 3＝已确认已发货，4＝已完成，5=已关闭，6=异订单状态：0＝待付款，1=已付款待确认，
     * 2=已确认待发货，3＝已确认已发货，4＝已完成，5=已关闭，6=异常
     * @param int $_order_id 订单ID
     * @param bigint $_order_sn 订单编号
     * @author San Shui <sanshui@mycxf.com>
     * @since 201608121504
     */
    public function confirm_good($_user_id,$_user_name,$_order_id, $_order_sn) {
        $_order_state = \Order::order_confirm_state;
        $_state_sql = 'SELECT COUNT(*) AS count FROM order_list WHERE (`order_id`=:order_id) AND (order_sn=:order_sn) AND (order_state=:order_state)';
        $_count_arr = $this->query($_state_sql, array('order_id' => $_order_id, 'order_sn' => $_order_sn, 'order_state' => $_order_state), 'fetch_row');
        if (0 < $_count_arr['count']) myerror(\StatusCode::msgCheckFail, \Order::order_confirmed_success);

        $_sql = 'UPDATE `order_list` SET `order_state`=:order_state,`close_time`=:close_time'
                . ' WHERE (`order_id`=:order_id) AND (order_sn=:order_sn)';
        $_row = $this->excute($_sql, array('order_id' => $_order_id, 'order_sn' => $_order_sn,
            'order_state' => $_order_state, 'close_time' => time()));
        if (0 >= $_row) {
            return false;
        }
        //确认收货日志
        $this->insert_log_list('订单收货', '订单已收货，订单状态“已完成”', $_user_id, $_user_name, 1, $_order_id);
        return true;
    }

    /**
     * 订单付款
     * @param type $q
     * @param type $_data
     * @return boolean
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    public function order_pay($q, $_data, $fx_statement_data) {
        $_sql = 'UPDATE `order_list` SET `is_pay`=1 WHERE (`order_id`=:order_id)';
        try {
            $this->begin_trans();
//            $this->insert_data($fx_statement_data, 'fx_statement');
            $this->insert_data($_data, 'confirm_success_trade');
            $this->excute($_sql, array('order_id' => $_data['source_id']));
            $this->insert_log_list('客户付款', '客户已付款，等待到账确认', $q->user_id, $q->user_name, 1, $_data['source_id']);
            $this->commit();
            return true;
        } catch (\Exception $ex) {
            $this->roll_back();
            myerror(\StatusCode::msgDBUpdateFail, $ex->getMessage());
            return false;
        }
    }

}
