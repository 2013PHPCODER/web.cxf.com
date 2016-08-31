<?php
namespace Finance\Controller;
use Common\Controller\BasicController;
class FinanceController extends BasicController {
    /**
     * 收款账户
     */
    public function index() {
        //输出数据
        $this->supplier_info = M('fx_supplier_user')
                        ->where("id={$this->user_info['id']}")
                        ->field('receiver_account,pay_pwd,mobile,balance,open_bank_address,'
                                . 'receiver_account_name,receiver_account,receiver_account_type')->find();
        $_where['supplier_id'] = $this->user_info['id'];
        $_where['order_state'] = array('IN','1,2,3');
        $_balance = M('order_list')->where($_where)->sum('cost_price');
        $this->balance = empty($_balance) ?0: $_balance;
        $this->show();
    }

    /**
     *  
     * 验证码生成 
     */
    public function verify_c() {
        $Verify = new \Think\Verify();
        $Verify->fontSize = 18;
        $Verify->length = 4;
        $Verify->useNoise = false;
        $Verify->codeSet = '0123456789';
        $Verify->imageW = 130;
        $Verify->imageH = 50;
        //$Verify->expire = 600;  
        $Verify->entry();
    }

    /**
     * 获取手机验证码
     */
    public function getAccPayPass() {
        $_where['user_id'] = $this->user_info['id'];
        $_where['type'] = 1;
        $_now_time = time();
        $_where['addtime'] = array('GT', $_now_time - 60);
        $_where['status'] = array('GT', 0);
        $_fx_sms_code_model = M('fx_sms_code');
        if ($_fx_sms_code_model->where($_where)->count() > 0) $this->aReturn(0, '获取验证码过于频繁，请稍后再试！');
        $_data = [];
        $_data['mobile'] = I('post.phone');
        $_data['user_id'] = $this->user_info['id'];
        $_data['type'] = 1;
        $_random_number = getRandomNum(6, 'NUMBER');
        $_data['content'] = $_random_number;
        $_data['addtime'] = $_now_time;
        $_data['status'] = 1;
        $result = sendSms($_data['mobile'], $_data['content']);
        //测试时赋值$result为true
        $result = true;
        //测试时赋值$result为true
        if (!$result) $this->aReturn(0, '发送失败！');
        $_add_resutl = $_fx_sms_code_model->add($_data);
        if ($_add_resutl) $this->aReturn(1, '发送成功！');
    }

    /**
     * 修改收款账户
     * @author san shui <2881501985@qq.com>
     * @return string JSON
     * @since 201608051718
     */
    public function editPayPwd() {
        if (IS_POST) {
            //验证码
            $_check_code = trim(I('post.checkCode'));
            $Verify = new \Think\Verify();
            if (!$Verify->check($_check_code)) $this->error("验证码错误！");

            //验证支付密码
            $_payPass = trim(I('post.payPass'));
            $_againPayPass = trim(I('post.againPayPass'));
            if ($_payPass !== $_againPayPass) {
                $this->error(L('FINANCE_PAY_FAILURE'));
            }
            //验证用户密码(登录现为明文验证)
            $_loginPass = trim(I('post.loginPass'));
            //if ($this->user_info['userpwd'] !== $_loginPass) $this->error(L('FINANCE_LOGIN_FAILURE'));
            if (!password_verify($_loginPass, $this->user_info['userpwd'])) $this->error(L('FINANCE_LOGIN_FAILURE'));

            //短信验证
            $_mobile = trim(I('post.mobile'));
            $_phone_code = trim(I('post.phoneCode'));
            if ($this->smsCheckCode($_mobile, $_phone_code) == FALSE) $this->error(L('FINANCE_MOBILE_VERIFY'));

            $_tmp_pwd = md5(C('FINANCE_PWD_STR') . $_againPayPass);
            if (FALSE === M('fx_supplier_user')->where(array('id' => $this->user_info['id']))->save(array('pay_pwd' => $_tmp_pwd))) {
                $this->error(L('UPDATE_FAILURE'));
            } else {
                $this->success(L('UPDATE_SUCCESS'));
            }
        } else {
            $this->error(L('_PARAM_FAILURE_'));
        }
    }

    /**
     * 修改收款账户
     * @author san shui <2881501985@qq.com>
     * @return string JSON
     * @since 201608051718
     */
    public function editAccount() {
        if (IS_POST) {
            $_receiver_account_type = I('post.receiver_account_type/d');
            if ($_receiver_account_type <= 0) $this->error();
            switch ($_receiver_account_type) {
                case 1:
                    $_receiver_account = I('post.receiver_account');
                    if (empty($_receiver_account)) $this->error(L('FINANCE_ACCOUNT_NOT_NULL'));
                    break;
                case 2:
                    //开户行
                    $_open_bank_address = I('post.open_bank_address');
                    if (empty($_open_bank_address)) $this->error(L('FINANCE_OPEN_BANK_NOT_NULL'));
                    //银行卡
                    $_receiver_account = I('post.receiver_account');
                    if (empty($_receiver_account) || strlen($_receiver_account) < 16 || is_numeric($_receiver_account) == false) $this->error(L('FINANCE_OPEN_BANK'));
                    break;
                default:
                    break;
            }
            //账户归属人姓名
            $_receiver_account_name = I('post.receiver_account_name');
            if (empty($_receiver_account_name)) $this->error(L('FINANCE_ACCOUNT_NAME'));

            //验证码
            $_check_code = trim(I('post.checkCode'));
            $Verify = new \Think\Verify();
            if (!$Verify->check($_check_code)) $this->error(L('_VERIFY_FAILURE_'));

            //验证用户支付密码(登录现为明文验证)
            $_fx_supplier_user_model = M('fx_supplier_user');
            $_accPayPass = md5(C('FINANCE_PWD_STR') . trim(I('post.accPayPass')));
            if ($_fx_supplier_user_model->where(array('pay_pwd' => $_accPayPass))->count() <= 0) $this->error(L('FINANCE_ACCOUNT_PAY_FAILURE'));

            //短信验证
            $_mobile = trim(I('post.mobile'));
            $_phone_code = trim(I('post.accPhoneCode'));
            if ($this->smsCheckCode($_mobile, $_phone_code) == FALSE) $this->error(L('FINANCE_MOBILE_VERIFY'));

            $_save['receiver_account_type'] = $_receiver_account_type;
            $_save['receiver_account'] = $_receiver_account;
            $_save['open_bank_address'] = $_open_bank_address;
            $_save['receiver_account_name'] = $_receiver_account_name;

            if (FALSE === $_fx_supplier_user_model->where(array('id' => $this->user_info['id']))->save($_save)) {
                $this->error(L('UPDATE_FAILURE'));
            } else {
                $this->success(L('UPDATE_SUCCESS'));
            }
        } else {
            $this->error(L('_PARAM_FAILURE_'));
        }
    }

    public function smsCheckCode($_mobile, $_code) {
        $_tmp_time = time() - 60;
        $_m_where['user_id'] = $this->user_info['id'];
        $_m_where['content'] = $_code;
        $_m_where['mobile'] = $_mobile;
        $_m_where['status'] = array('GT', 0);
        $_m_where['addtime'] = array('EGT', $_tmp_time);
        $_fx_sms_code_model = M('fx_sms_code');
        if ($_fx_sms_code_model->where($_m_where)->count() <= 0) {
            return false;
        }
        //更新短信日志表
        $_fx_sms_code_model->where($_m_where)->setField(array('status' => -1));
        return true;
    }

    /**
     * 完结订单
     */
    public function endOrder() {
        $this->datas = $this->getEndOrderList();
        $this->show();
    }

    /**
     * 设置where条件
     * @return array
     */
    public function setWhere() {
        $_where = array();
        //时间范围
        $_get_start_time = strtotime(I('get.startTime'));
        $_get_end_time = strtotime(I('get.endTime'));
        if (!empty($_get_start_time) && !empty($_get_end_time)) {
            $_where['confirm_time'] = array('between', array($_get_start_time, $_get_end_time));
        } else if (!empty($_get_start_time) && empty($_get_end_time)) {
            $_where['confirm_time'] = array('GT', $_get_start_time);
        } else if (empty($_get_start_time) && !empty($_get_end_time)) {
            $_where['confirm_time'] = array('LT', $_get_end_time);
        }
        //状态
        $_get_status = I('get.c_status/d');
        switch ($_get_status) {
            case 1:
                $_where['status'] = 0;
                break;
            case 2:
                $_where['status'] = 1;
                break;
            default:
                break;
        }
        $_get_order_sn = I('get.order_sn');
        if (0 < $_get_order_sn) {
            $_where['order_sn'] = array('LIKE', '%' . $_get_order_sn . '%');
        }
        return $_where;
    }

    /**
     * 获取完结订单列表
     * @param array $_mWhere
     * @return type
     */
    public function getEndOrderList() {
        $_where = array();
        //时间范围
        $_get_start_time = strtotime(I('get.startTime'));
        $_get_end_time = strtotime(I('get.endTime'));
        if (!empty($_get_start_time) && !empty($_get_end_time)) {
            $_where['cm.deal_time'] = array('between', array($_get_start_time, $_get_end_time));
        } else if (!empty($_get_start_time) && empty($_get_end_time)) {
            $_where['cm.deal_time'] = array('GT', $_get_start_time);
        } else if (empty($_get_start_time) && !empty($_get_end_time)) {
            $_where['cm.deal_time'] = array('LT', $_get_end_time);
        }
        //状态
        $_get_status = I('get.c_status/d');
        if ($_get_status > 0) {
            $_where['status'] = $_get_status;
        }
        $_get_order_sn = I('get.order_sn');
        if (0 < $_get_order_sn) {
            $_where['source_sn'] = array('LIKE', '%' . $_get_order_sn . '%');
        }
        $_where['apply_user_id'] = $this->user_info['id'];
        $_where['catch_type'] = 2;
        $_where['user_type'] = 1;
        $catch_money_model = M('fx_catch_money');
        $_count = $catch_money_model
                ->table('fx_catch_money as `cm`')
                ->join('inner join order_list as `ol` on cm.source_id=ol.order_id')->where($_where)->count();
        $_page = getPage($_count);
        $_data['list'] = $catch_money_model
                ->table('fx_catch_money as `cm`')
                ->join('inner join order_list as `ol` on cm.source_id=ol.order_id')
                ->field('cm.source_sn,cm.source_id,cm.repay,cm.`status`,cm.deal_time,ol.finnshed_time,ol.add_time')
                ->where($_where)
                ->limit($_page->firstRow . ',' . $_page->listRows)
                ->select();
        $_data['page'] = $_page->show();
        return $_data;
    }

    /**
     * 获取订单信息
     */
    public function getOrderInfo() {
        $_datas = array();
        $_where = array();
        $_where['order_list.order_sn'] = I('get.order_sn');
        $_datas['order'] = M('confirm_success_trade')->join('order_list ON order_list.order_id = confirm_success_trade.source_id')
                        ->where($_where)->field('confirm_success_trade.id,order_list.order_sn,'
                        . 'confirm_success_trade.confirm_money,confirm_success_trade.pay_time,'
                        . 'confirm_success_trade.add_time,order_list.pay_amount,.order_list.shipping_fee,order_list.order_amount')->find();
        $_order_id = M('order_list')->where($_where)->getField('order_id');
        if (!$_order_id) $this->aReturn(0, '获取订单信息失败！');
        $_datas['goods'] = M('order_goods')->field("goods_id,goods_name,goods_num,distribution_price")->where("order_id={$_order_id}")->select();
        $this->aReturn(1, '获取订单信息成功！', $_datas);
    }

    public function paymentDetails() {
        $_trade_type = I('trade_type/d');
        if (0 < $_trade_type) {
            $_where['trade_type'] = $_trade_type;
        }
        //时间范围
        $_get_start_time = strtotime(I('get.startTime'));
        $_get_end_time = strtotime(I('get.endTime'));
        if (!empty($_get_start_time) && !empty($_get_end_time)) {
            $_where['add_time'] = array('between', array($_get_start_time, $_get_end_time));
        } else if (!empty($_get_start_time) && empty($_get_end_time)) {
            $_where['add_time'] = array('GT', $_get_start_time);
        } else if (empty($_get_start_time) && !empty($_get_end_time)) {
            $_where['add_time'] = array('LT', $_get_end_time);
        }
        $_fx_statement_model = M('fx_statement');
        $this->balance = M('fx_supplier_user')->where(array('id' => $this->user_info['id']))->getField('balance');
        $this->in_money = $_fx_statement_model->where(array('user_id' => $this->user_info['id']))->sum('in_money');
        $this->out_money = $_fx_statement_model->where(array('user_id' => $this->user_info['id']))->sum('out_money');
        $_count = $_fx_statement_model->where($_where)->count();
        $_page = getPage($_count);
        $this->pager = $_page->show();
        $this->datas = $_fx_statement_model->where($_where)->field('id,trade_no,add_time,trade_type,in_money,out_money,now_balance')
                        ->limit($_page->firstRow . ',' . $_page->listRows)->select();
        $this->show();
    }

}
