<?php

namespace api\home;

//虚拟订单相关
class VirtualOrderController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 获取虚拟商品列表
     */
    public function get_virtual_goods_list() {
        $vgoods_dao = \DAO::fx_virtual_goods();
        $goods_list = $vgoods_dao->get_list();
        $this->response($goods_list);
        exit;
    }

    /**
     * 代理商开通分销账户
     */
    public function create_act() {
        $data = isset($this->request) ? $this->request : null;
        $user_id = isset($data->user_id) ? $data->user_id : null;
        $mark = isset($data->mark) ? $data->mark : null;
        \Valid::has_number($user_id)->withError('参数错误!');
        //@TODO 校验用户是否有代理资格
        $distribute_user_dao = \Dao::fx_distribute_user();
        $distribute_user_dao->check_agent($user_id);
        $virtual_goods_id = isset($data->virtual_goods_id) ? $data->virtual_goods_id : null;
        $new_account = isset($data->new_account) ? $data->new_account : null;
        $pwd = isset($data->pwd) ? $data->pwd : null;
        $re_pwd = isset($data->re_pwd) ? $data->re_pwd : null;
        \Valid::has_number($virtual_goods_id)->withError('参数错误!');
        if (is_mobile($new_account)) {
            $username = $new_account;
        } else {
            myerror(\StatusCode::msgCheckFail, '新增账号必须是手机号!');
        }
        if (strlen($pwd) < 6) {
            myerror(\StatusCode::msgCheckFail, '密码长度必须大于6位！');
        }
        if ($pwd !== $re_pwd) {
            myerror(\StatusCode::msgCheckFail, '两次输入的密码不一致！');
        }
        //校验用户名是否被占用
        $distribute_user_dao->check_username_used($username);
        //获取价格
        $vgoods_dao = \DAO::fx_virtual_goods();
        $agent_info = $vgoods_dao->get_agent_info($virtual_goods_id);
        $order_sn = '2' . date('ymdhis' . rand(100000, 999999));
        //检测订单号是否唯一
        $is_order = $vgoods_dao->check_order_unique($order_sn);
        while (!$is_order) {
            $order_sn = '2' . date('ymdhis' . rand(100000, 999999));
            $is_order = $vgoods_dao->check_order_unique($order_sn);
        }
        //写入用户表、写入新增分销商表、写入订单表
        $order_id = $distribute_user_dao->add_user($order_sn, $user_id, $username, $pwd, $virtual_goods_id, $agent_info, $mark);
        $this->response(array('order_id' => $order_id, 'order_sn' => $order_sn, 'money' => $agent_info['agent_price']));
        exit;
    }

    /**
     * 开通账户列表
     */
    public function create_list() {
        $data = $this->request;
        $user_id = isset($data->user_id) ? $data->user_id : null;
        $page = isset($data->page) ? $data->page : 1;
        $page_size = isset($data->per_page) ? $data->per_page : 20;
        \Valid::has_number($user_id)->withError('参数错误!');
        $level = isset($data->level) ? $data->level : null;
        $start_time = isset($data->start_time) ? strtotime($data->start_time) : null;
        $end_time = isset($data->end_time) ? strtotime($data->end_time) : null;
        $keyword = isset($data->keyword) ? strtotime($data->keyword) : null;
        $virtual_order_dao = \Dao::Fx_virtual_order();
        $list = $virtual_order_dao->get_order_list($user_id, $page, $page_size, $level, $start_time, $end_time, $keyword);
        $this->response($list);
        exit;
    }

    /**
     * 付款后提交表单
     */
    public function vorder_recharge() {
        $data = $this->request;
        batch_isset($data, array('user_id', 'user_name', 'order_sn', 'trade_no', 'pay_account', 'receiver_account', 'pay_type'));
        $user_id = $data->user_id;
        $user_name = $data->user_name;
        $order_sn = $data->order_sn;
//        $confirm_money = $data->confirm_money;
        $trade_no = $data->trade_no;
        $pay_account = $data->pay_account;
        $receiver_account = $data->receiver_account;
        $pay_type = $data->pay_type;
        \Valid::has_number($user_id)->withError('user_id参数错误!');
        if (empty($user_name)) myerror(\StatusCode::msgCheckFail, '参数错误！');
        if (empty($order_sn)) myerror(\StatusCode::msgCheckFail, '参数错误！');
        if (empty($trade_no)) myerror(\StatusCode::msgCheckFail, '参数错误！');
        if (empty($pay_account)) myerror(\StatusCode::msgCheckFail, '参数错误！');
        if (empty($receiver_account)) myerror(\StatusCode::msgCheckFail, '参数错误！');
        \Valid::has_number($pay_type)->withError('参数错误!');
        //查询订单
        $vorder_dao = \Dao::Fx_virtual_order();
        $vorder_info = $vorder_dao->get_vorder_info($order_sn, 'id,order_sn,order_type,pay_money,`status`,log_id');
        if ($vorder_info['status'] != 1) {
            myerror(\StatusCode::msgCheckFail, '订单状态错误！');
        }
//        if ($vorder_info['pay_money'] != $confirm_money) {
//            myerror(\StatusCode::msgCheckFail, '支付金额不正确！');
//        }
        switch ($vorder_info['order_type']) {
            case 1:
                $pay_user_id = $vorder_dao->get_create_id($vorder_info['log_id']);
                break;
            case 2:
                $pay_user_id = $user_id;
                break;
            default :
                myerror(\StatusCode::msgCheckFail, '订单状态错误！');
                break;
        }
        $confirm_dao = \Dao::confirm_success_trade();
        //校验正确，写入confirm表
        if (!$confirm_dao->add_confirm($pay_user_id, $data, $vorder_info)) myerror(\StatusCode::msgCheckFail, '订单更新失败！');
        $this->response(array('sucess' => true, 'msg' => '提交成功!等待后台审核'));
    }

    public function cancel_vorder() {
        $data = $this->request;
        batch_isset($data, array('order_sn'));
        $order_sn = $data->order_sn;
        if (empty($order_sn)) {
            myerror(\StatusCode::msgCheckFail, '错误的订单号！');
        }
        $vorder_dao = \Dao::Fx_virtual_order();
        $vorder_dao->cacel_order($order_sn);
        $this->response(array('msg' => '取消成功！'));
    }

}
