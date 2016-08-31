<?php

return array(
    'user_type' => array(
        1 => '供货商',
        2 => '经销商'
    ),
    'receiver_platform' => array(
        1 => '支付宝',
        2 => '银行卡',
        3 => '微信'
    ),
    'trans_type' => array(
        0 => '打款', 1 => '提现', 2 => '结算',
    ),
    'confirm_success_money_status' => array(
        '0' => '未打款',
        '1' => '已打款',
    ),
    'confirm_success_money_type' => array(
        1 => '订单收款',
        2 => '充值',
        3 => '补款',
        4 => '虚拟订单'
    ),
    'catch_money_status' => array(
        1 => '未打款',
        2 => '已打款',
        3 => '打款失败',
    ),
    'catch_money_type' => array(
        1 => '提现',
        2 => '订单打款',
        3 => '售后打款',
    ),
    'pay_account_type' => array(
        1 => '支付宝',
        2 => '银行卡',
        3 => '微信'
    ),
);
