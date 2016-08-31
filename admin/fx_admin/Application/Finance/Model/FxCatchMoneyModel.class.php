<?php

namespace Finance\Model;

use Think\Model;

class FxCatchMoneyModel extends Model {

    protected $_validate = array(
        array('remark', 'require', '备注不能为空！'), //非空严验证 
        array('failcause', 'require', '失败原因不能为空！'), //非空严验证 
        array('pay_account_type', 'require', '付款账户类型不能为空！'), //非空严验证 
        array('pay_account', 'require', '付款账户不能为空！'), //非空严验证 
        array('trade_no', 'require', '交易号不能为空！'), //非空严验证 
    );

}
