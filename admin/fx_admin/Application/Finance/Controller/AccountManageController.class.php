<?php

namespace Finance\Controller;

use Common\Controller\AuthController;

class AccountManageController extends AuthController {

    public function index() {
        $data = I('get.');
        $user_type = $data['user_type'] ? $data['user_type'] : 1;
        if ($data['user_account']) {
            $condition['user_account'] = array('LIKE', '%' . $data['username'] . '%');
        }
        if ($data['receiver_platform']) {
            $condition['receiver_account_type'] = $data['receiver_platform'];
        }
        if ($data['receiver_account']) {
            $condition['receiver_account'] = array('LIKE', '%' . $data['receiver_account'] . '%');
        }
        if ($user_type == 1) {
            $user_model = new \Finance\Model\FxSupplierUserModel();
            $field = 'id,user_account as username,receiver_account_type,receiver_account,open_bank_address,receiver_account_name';
        } else if ($user_type == 2) {
            $user_model = new \Finance\Model\FxDistributeUserModel();
            $field = 'id,user_account as username,balance,receiver_account_type,receiver_account,open_bank_address,receiver_account_name';
        }
        $page_count = $user_model
                ->where($condition)
                ->count();
        $_page = getpage($page_count);
        $list = $user_model->where($condition)
                ->field($field)
                ->limit($_page->firstRow . ',' . $_page->listRows)
                ->select();
        $this->ckeck_user_type = $user_type;
        $_data['list'] = $list;
        $this->user_type = C('user_type');
        $this->receiver_platform = C('receiver_platform');
        $_data['page'] = $_page->show();
        $this->list_data = $_data;
        $this->display();
    }

    /**
     * 账号详情
     */
    public function detail() {
        $user_id = I('get.user_id');
        $user_type = I('get.user_type');
        $condition['user_id'] = $user_id;
        $this->user_type = $condition['user_type'] = $user_type;
        $type = I('get.trade_type');
        if ($type) {
            $condition['trade_type'] = $type;
        }
        $search_time = I('get.search_time');
        if (!$search_time) {
            switch ($search_time) {
                case 1:
                    $start_time = strtotime(date('y-m-d', time()) . ' 00:00:00');
                    $end_time = strtotime(date('y-m-d', time()) . ' 23:59:59');
                    $condition['add_time'] = array('GT', $start_time);
                    $condition['add_time'] = array('LT', $end_time);
                    break;
                case 2:
                    $start_time = time() - 86400 * 7;
                    $end_time = strtotime(date('y-m-d', time()) . ' 23:59:59');
                    $condition['add_time'] = array('GT', $start_time);
                    $condition['add_time'] = array('LT', $end_time);
                    break;
                case 3:
                    $start_time = time() - 86400 * 30;
                    $end_time = strtotime(date('y-m-d', time()) . ' 23:59:59');
                    $condition['add_time'] = array('GT', $start_time);
                    $condition['add_time'] = array('LT', $end_time);
                    break;
                case 4:
                    $start_time = strtotime(I('get.start_time'));
                    $end_time = strtotime(I('get.end_time'));
                    $condition['add_time'] = array('GT', $start_time);
                    $condition['add_time'] = array('LT', $end_time);
                    break;
                default :break;
            }
        }
        $statement_model = new \Finance\Model\FxStatementModel();
        $user_info = M('fx_distribute_user')->field('balance,user_account as `username`')->where(array('id' => $user_id))->find();
        $page_count = $statement_model->where($condition)->count();
        $_page = getpage($page_count);
        $_data['list'] = $statement_model
                ->field('user_id,user_name,trade_type,in_money,out_money,now_balance,trade_account,trade_account_type,trade_no,add_time')
                ->where($condition)
                ->order(' add_time desc')
                ->limit($_page->firstRow . ',' . $_page->listRows)
                ->select();
        $this->in_money = $statement_model->where(array('user_id' => $user_id))->sum('in_money');
        $this->out_money = $statement_model->where(array('user_id' => $user_id))->sum('out_money');
        $this->type = C('trans_type');
        $this->user_info = $user_info;
        $_data['page'] = $_page->show();
        $this->list_data = $_data;
        $this->display();
    }

}
