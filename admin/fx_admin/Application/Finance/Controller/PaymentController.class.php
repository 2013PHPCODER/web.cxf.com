<?php

namespace Finance\Controller;

use Common\Controller\AuthController;

class PaymentController extends AuthController {

    private $catch_money_model;
    private $fx_catch_money;

    public function __construct() {
        parent::__construct();
        $this->catch_money_model = new \Finance\Model\FxCatchMoneyModel();
    }

    public function index() {
        $condition = $this->searchCondition();
        $page_count = $this->catch_money_model->where($condition)->count();
        $_page = getpage($page_count);
        $list = $this->catch_money_model->where($condition)
                ->order('addtime asc')
                ->limit($_page->firstRow . ',' . $_page->listRows)
                ->order('id desc')
                ->select();
        $this->catch_money_type = C('catch_money_type');
        $this->receiver_platform = C('receiver_platform');
        $this->catch_money_status = C('catch_money_status');
        $this->pay_account_type = C('pay_account_type');
        foreach ($list as &$value) {
            $value['addtime'] = $value['addtime']?date("Y-m-d h:i:s", $value['addtime']):'';
            $value['deal_time'] = 0 < $value['deal_time'] ? date("Y-m-d h:i:s", $value['deal_time']) : '';
            $value['catch_type'] = 0 < $value['catch_type'] ? $this->catch_money_type[$value['catch_type']] : '';
            $value['receiver_account_type'] = 0 < $value['receiver_account_type'] ? $this->receiver_platform[$value['receiver_account_type']] : '';
            $value['pay_account_type'] = 0 < $value['pay_account_type'] ? $this->receiver_platform[$value['pay_account_type']] : '';
        }
        $_data['list'] = $list;
        $_data['page'] = $_page->show();
        $this->list_data = $_data;
        $this->display();
    }

    /**
     * 创建搜索条件
     */
    private function searchCondition() {
        $condition = array();
        $group_id = I('get.group_id');
        switch ($group_id) {
            case 1:
                $condition['catch_type'] = 1;
                break;
            case 2:
                $condition['catch_type'] = 2;
                break;
            case 3:
                $condition['catch_type'] = 3;
                break;
        }
        $pay_account_type = I('get.pay_account_type');
        if (!empty($pay_account_type)) {
            $condition['pay_account_type'] = $pay_account_type;
        }
        $receiver_account_type = I('get.receiver_account_type');
        if (!empty($receiver_account_type)) {
            $condition['receiver_account_type'] = $receiver_account_type;
        }
        $catch_type = I('get.catch_type');
        if (!empty($catch_type)) {
            $condition['catch_type'] = $catch_type;
        }

        if (I('get.start_time') || I('get.end_time')) {
            $_start_time = I('get.start_time') ? strtotime(I('get.start_time')) : 1;
            $_end_time = I('get.end_time') ? strtotime(I('get.end_time')) : time();
            $condition['addtime'] = array(array('EGT', $_start_time), array('ELT', $_end_time), 'and');
        }
        $status = I('get.status');
        if ($status !== false && !empty($status)) {
            $condition['status'] = $status;
        }
        $search_key = I('get.search_key');
        $search_words = I('get.search_words');
        if ($search_key && $search_words) {
            $condition[$search_key] = array('LIKE', '%' . $search_words . '%');
        }
        return $condition;
    }

    /**
     * 保存打款信息
     */
    public function saveCatchMoney() {
        C('TOKEN_ON', false);
        $_obj = I('post.obj');
        $_sing = I('post.sing');
        $_success_count = 0;
        $_fail_count = 0;
        $_id_arr = array_column($_obj, 'id');
        if (0 === count($_id_arr)) {
            $this->aReturn('0', '必须选择一个打款单据！');
        }
        $_data = $this->beforeCreateData($_sing);
        $_create_data = $this->catch_money_model->create($_data);
        if (FALSE === $_create_data) {
            $this->aReturn('0', $this->catch_money_model->getError());
        }
        foreach ($_id_arr as $id) {
            $_result = $this->updateCatchMoney($id, $_data, $_sing);
            if ($_result) {
                $_success_count++;
            } else {
                $_fail_count++;
            }
        }
        $this->aReturn('0', "打款完成，{$_fail_count}个失败，{$_success_count}个成功！");
    }

    /**
     * 业务之前创建data数据
     * @return type
     */
    public function beforeCreateData($_sing) {
        $_data['deal_time'] = time();
        $_data['deal_user'] = $_SESSION['user']['id'];
        switch ($_sing) {
            case 1:
                $_data['pay_account_type'] = I('post.pay_account_type');
                $_data['trade_no'] = I('post.tradeNumber');
                $_data['pay_account'] = I('post.playNumber');
                $_data['status'] = 2;
                break;
            case 2:
                $_data['failcause'] = I('post.failCause');
                $_data['status'] = 3;
                break;
            default :
                unset($_data['deal_time'], $_data['deal_user']); //操作为备注，去除处理时间和处理人
                $_data['remark'] = I('post.remark');
                break;
        }
        return $_data;
    }

    /**
     * 更新业务
     * @param type $id
     * @param type $_data
     * @return type
     */
    public function updateCatchMoney($id, $_data, $_sing) {
        $_where['id'] = $id;
        if (!$_sing) {
            $this->catch_money_model->where($_where)->save($_data);
            return true;
        }
        $_catch_money = $this->catch_money_model->where($_where)->field("status,catch_type,trade_no,source_id,user_type,apply_user_id,repay")->find();
        if (1 != $_catch_money['status']) {
            return false;
        }
        $_fx_st_data = [];
        $_fx_st_data['user_type'] = $_catch_money['catch_type'];
        $_fx_st_data['user_id'] = $_catch_money['apply_user_id'];
        $_fx_st_data['receiver_name'] = $_catch_money['catch_type'];
        $_fx_st_data['in_money'] = $_catch_money['repay'];

        $_user_table = 1 == $_catch_money['user_type'] ? 'fx_supplier_user' : 'fx_distribute_user';
        $_user_info = M($_user_table)->field('balance,user_account as username')->where("id={$_catch_money['apply_user_id']}")->find();
        $_now_balance = $_user_info['balance'] - $_catch_money['repay'];
        $_fx_st_data['now_balance'] = 1 == $_catch_money['catch_type'] ? $_now_balance : 0; //排除余额数据（只有申请提现才会有余额概念）
        if (1 == $_catch_money['user_type'] && $_now_balance < 0) {
            return false; //余额小于0，扣款失败
        }
        $_fx_st_data['user_name'] = $_user_info['username'];
        $_fx_st_data['trade_account'] = $_data['pay_account'];
        $_fx_st_data['trade_account_type'] = $_data['pay_account_type'];
        $_fx_st_data['trade_no'] = $_data['trade_no'];
        $_fx_st_data['add_time'] = time();
        //事务执行前组织数据(售后)
        if (3 == $_catch_money['catch_type']) {
            $_cus_order = M('cus_order_list')->where("id = {$_catch_money['source_id']}")->field("order_id,cus_type")->find();
            $_order_id = $_cus_order['order_id']; //订单id
            if (1 == $_cus_order['cus_type']) {//退款退货
                $_cus_field = "return_status";
                $_cus_value = \aftersale_back_good_status::success;
                $_fx_st_data['trade_type'] = \StatementType::distribute_after_sale_bumoney;
            } else if (2 == $_cus_order['cus_type']) {//退款
                $_cus_field = "refund_status";
                $_cus_value = \aftersale_back_money_status::success;
                $_fx_st_data['trade_type'] = \StatementType::distribute_after_sale_backmoney;
            } else {
                return false;
            }
        }
        //事务开始
        $model = new \Think\Model();
        $model->startTrans();
        try {
            if (1 == $_catch_money['catch_type']) {
                if (1 == $_catch_money['user_type']) {
                    $result1 = M("fx_supplier_user")->where("id={$_catch_money['apply_user_id']}")->save(array('balance' => $_now_balance));
                } else if (2 == $_catch_money['user_type']) {
                    $_fx_st_data['trade_type'] = \StatementType::distribute_cash_money;
                    $result1 = M("fx_distribute_user")->where("id={$_catch_money['apply_user_id']}")->save(array('balance' => $_now_balance));
                }
                if (false === $result1) throw new \Exception("余额扣除失败！");
            }
            if (2 == $_catch_money['catch_type']) {
                $_fx_st_data['trade_type'] = \StatementType::supplier_sucess_order;
            }
            if (3 == $_catch_money['catch_type']) {
                $result2 = M('cus_order_list')->where("id = {$_catch_money['source_id']}")->save(array("{$_cus_field}" => $_cus_value));
                if (false === $result2) throw new \Exception("单据状态修改失败！");
                $result3 = M('order_list')->where("order_id = {$_order_id}")->save(array('order_state' => 5));
                if (false === $result3) throw new \Exception("单据状态修改失败！");
            }
            $result4 = M("fx_statement")->add($_fx_st_data);
            if (false === $result4) throw new \Exception("单据信息修改失败！");
            $result5 = $this->catch_money_model->where($_where)->save($_data);
            if (false === $result5) throw new \Exception("单据信息修改失败！");
            $model->commit();
        } catch (\Exception $ex) {
            $model->rollback();
            return false;
        }
        return true;
    }

}
