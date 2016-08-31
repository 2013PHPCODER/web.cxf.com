<?php

namespace api\home;

class CatchMoneyController extends Controller {

    /**
     * 申请提现
     * @return string JSON
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    public function apply_withdraw() {
        $q = $this->request;
        if (empty($q->user_id)) myerror(\StatusCode::msgCheckFail, '用户id不能为空！');
        if (empty($q->apply_money)) myerror(\StatusCode::msgCheckFail, '提现金额不能为空！');
        if (empty($q->user_account)) myerror(\StatusCode::msgCheckFail, '收款账户不能为空！');
        if (empty($q->user_name)) myerror(\StatusCode::msgCheckFail, '收款人不能为空！');

        $data = new \stdClass();
        $data->apply_user_id = $q->user_id;
        $data->receiver_name = $q->user_name;
        $data->repay = $q->apply_money;
        $data->receiver_account = $q->user_account;
        $data->remark = isset($q->remark) ? $q->remark : '';

        $dao = \Dao::Fx_catch_money();
        $result = $dao->apply_withdraw($data);
        if (!$result) {
            $this->response['sucess'] = 0;
            $this->response['msg'] = "申请失败！";
        }
        $this->response['sucess'] = 1;
        $this->response['msg'] = "申请成功！";
        $this->response();
    }

    /**
     * 资金明细列表
     * @return string JSON
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    public function statement_list() {
        
    }

}