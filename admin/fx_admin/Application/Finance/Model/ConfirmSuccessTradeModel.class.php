<?php

namespace Finance\Model;

use Think\Model;

class ConfirmSuccessTradeModel extends Model {

    /**
     * 确定单条记录收款
     * @param type $id
     */
    public function confirm($id) {
        $return['status'] = 0;
        $record = $this->field('id,user_type,source_id,source_sn,pay_account,receiver_account,user_id,user_name,pay_type,confirm_money,type,status,trade_no')
                        ->where(array('id' => $id))->find();
        if (empty($record)) {
            return $return['message'] = '没有记录';
        }
        if (empty($record['pay_account']) || empty($record['user_id']) || empty($record['receiver_account']) || empty($record['pay_type']) || empty($record['user_name']) || empty($record['pay_type']) || empty($record['confirm_money']) || !$record['type'] || $record['status'] == 1) {
            $return['message'] = '数据错误';
        }
        if ($record['status'] == 1) {
            return $return['message'] = '该笔款项已确认过！';
        }
        $statement_model = new FxStatementModel();
        $statement_data = array();
        $statement_data['user_type'] = $record['user_type'];
        $statement_data['user_id'] = $record['user_id'];
        $statement_data['user_name'] = $record['user_name'];
        $statement_data['in_money'] = 0;
        $statement_data['out_money'] = -$record['confirm_money'];
        $statement_data['now_balance'] = 0;
        $statement_data['trade_account'] = $record['pay_account'];
        $statement_data['trade_account_type'] = $record['pay_type'];
        $statement_data['trade_no'] = $record['trade_no'];
        $statement_data['add_time'] = time();
        $statement_data['remark'] = '收款已成功';
        //订单收款
        switch ($record['type']) {
            case 1:
                $order_model = new OrderListModel();
                $this->startTrans();
                $suc = $this->where(array('id' => $id, 'status' => 0))
                        ->save(array('status' => 1, 'confirm_user_id' => session('user.id'), 'confirm_time' => time()));
                //增加流水表数据
                $statement_data['trade_type'] = 4;
                $state_add = $statement_model->add($statement_data);
                //修改订单表状态
                $order_change = $order_model->where(array('order_id' => $record['source_id'], 'order_state' => 0))->save(array('order_state' => 1, 'payment_time' => time()));
                if (!$suc || !$state_add || !$order_change) {
                    $this->rollback();
                    $return['message'] = '记录修改失败！';
                } else {
                    $this->commit();
                    $return['status'] = 1;
                    write_log('收款成功，操作前收款表数据：' . json_encode($record));
                    $return['message'] = 'ok!';
                }
                break;
            //充值
            case 2:
                if ($record['user_type'] == 1) {
                    $return['message'] = '用户错误！';
                    break;
                }
                $distribubte_model = new FxDistributeUserModel();
                $this->startTrans();
                $suc = $this->where(array('id' => $id, 'status' => 0))
                        ->save(array('status' => 1, 'confirm_user_id' => session('user.id'), 'confirm_time' => time()));
                //增加流水表数据
                $statement_data['trade_type'] = 6;
                $state_add = $statement_model->add($statement_data);
                //修改用户金额
                $rechange = $distribubte_model->where(array('id' => $record['user_id']))->setInc('balance', $record['confirm_money']);
                if (!$suc || !$state_add || !$rechange) {
                    $this->rollback();
                    $return['message'] = '记录修改失败！';
                } else {
                    $this->commit();
                    write_log('收款成功，操作前收款表数据：' . json_encode($record));
                    $return['status'] = 1;
                    $return['message'] = 'ok!';
                }
                break;
            //补款
            case 3:
                $cus_model = new CusOrderListModel();
                $distribubte_model = new FxDistributeUserModel();
                $catch_money_model = new FxCatchMoneyModel();
                $cus_info = $cus_model->table('cus_order_list as c')->field('c.cus_type,c.have_replenished,c.refund_status,c.return_status,o.pay_amount')
                                ->join('inner join order_list as o  on c.order_id=o.order_id')
                                ->where(array('id' => $record['source_id']))->find();
                if (empty($cus_info) || $cus_info['have_replenished'] != 1 || ($cus_info['return_status'] != 6)) {
                    $return['message'] = '售后订单状态错误！';
                    break;
                }
                $user_info = $distribubte_model->field('user_account,receiver_account,receiver_account_type,open_bank_address,receiver_account_name')->where(array('id' => $record['user_id']))->find();
                $this->startTrans();
                $suc = $this->where(array('id' => $id, 'status' => 0))
                        ->save(array('status' => 1, 'confirm_user_id' => session('user.id'), 'confirm_time' => time()));
                //增加流水表数据
                $statement_data['trade_type'] = 2;
                $state_add = $statement_model->add($statement_data);
                //修改状态
                $rechange = $cus_model->where(array('id' => $record['source_id'], 'supplier_id' => $record['user_id']))->save(array('return_status' => 5));
                //写入记录到带打款表
                $add_catch = $catch_money_model->add(array(
                    'apply_user_id' => $record['user_id'],
                    'catch_type' => 3,
                    'source_id' => $record['source_id'],
                    'source_sn' => $record['source_sn'],
                    'repay' => bcadd($record['confirm_money'], $cus_info['pay_amount'], 2),
                    'status' => 1,
                    'receiver_name' => $user_info['receiver_account_name'] ? $user_info['receiver_account_name'] : $user_info['user_account'],
                    'remark' => '补款',
                    'receiver_account_type' => $record['pay_type'],
                    'receiver_account' => $record['pay_account'],
                    'user_type' => $record['user_type'],
                ));
                if (!$suc || !$state_add || !$rechange || !$add_catch) {
                    $this->rollback();
                    $return['message'] = '记录修改失败！';
                } else {
                    $this->commit();
                    write_log('收款成功，操作前收款表数据：' . json_encode($record));
                    $return['status'] = 1;
                    $return['message'] = 'ok!';
                }
                break;
            //虚拟订单
            case 4:
                $virtual_order_model = new FxVirtualOrderModel();
                $distribubte_model = new FxDistributeUserModel();
                $sql = 'SELECT id,`status`,distribute_user_id,target_grade,order_type,log_id from fx_virtual_order  WHERE id=' . $record['source_id'];
                $info = D()->query($sql);
                if (empty($info[0])) {
                    $return['message'] = '订单错误!';
                    break;
                }
                $virtual_order_info = $info[0];
                if ($virtual_order_info['status'] != 1) {
                    $return['message'] = '订单状态错误!';
                    break;
                }
                if ($virtual_order_info['order_type'] == 1) {
                    $update_sql = 'UPDATE fx_virtual_order as `fvo` ,fx_distribute_user as `fdu` ,fx_supplier_create_log as `fcl` '
                            . 'SET fvo.`status`=2,fvo.payment_time=' . time() . ',fcl.`status`=2,fcl.finish_time=' . time() . ',fdu.leavel=' . $virtual_order_info['target_grade']
                            . ', fdu.account_status=2 WHERE fvo.`status`=1 and fcl.`status`=1 and fvo.id=' . $virtual_order_info['id'] . ' AND fdu.id=' . $virtual_order_info['distribute_user_id'] . ' and fcl.id=' . $virtual_order_info['log_id'];
                } else {
                    $update_sql = 'UPDATE fx_virtual_order as `fvo` ,fx_distribute_user as `fdu` '
                            . 'SET fvo.`status`=2,fvo.payment_time=' . time() . ',fdu.leavel=' . $virtual_order_info['target_grade']
                            . ', fdu.account_status=2 WHERE fvo.`status`=1  and fvo.id=' . $virtual_order_info['id'] . ' AND fdu.id=' . $virtual_order_info['distribute_user_id'];
                }
                $this->startTrans();
                $suc = $this->where(array('id' => $id, 'status' => 0))
                        ->save(array('status' => 1, 'confirm_user_id' => session('user.id'), 'confirm_time' => time()));
                //增加流水表数据
                $statement_data['trade_type'] = 8;
                $state_add = $statement_model->add($statement_data);
                //修改订单表状态
                $order_change = $virtual_order_model->where(array('id' => $record['source_id']))->save(array('status' => 1, 'payment_time' => time()));
                //修改用户等级
                $user_change = $this->execute($update_sql);
                if (!$suc || !$state_add || !$order_change || !$user_change) {
                    $this->rollback();
                    $return['message'] = '记录修改失败！';
                    write_log('收款成功，操作前收款失败，数据：' . json_encode($record));
                } else {
                    $this->commit();
                    write_log('收款成功，操作前收款表数据：' . json_encode($record));
                    $return['status'] = 1;
                    $return['message'] = 'ok!';
                }
                break;
            default :
                break;
        }
        return $return;
    }

}
