<?php
namespace api\home; 
 class Fx_statementModel extends Model{

  	 function __construct($id=null,$user_type=null,$user_id=null,$user_name=null,$trade_type=null,$in_money=null,$out_money=null,$now_balance=null,$trade_account=null,$trade_account_type=null,$trade_no=null,$add_time=null,$remark=null) {
		 
		$this->id= $id;
		$this->user_type= $user_type;
		$this->user_id= $user_id;
		$this->user_name= $user_name;
		$this->trade_type= $trade_type;
		$this->in_money= $in_money;
		$this->out_money= $out_money;
		$this->now_balance= $now_balance;
		$this->trade_account= $trade_account;
		$this->trade_account_type= $trade_account_type;
		$this->trade_no= $trade_no;
		$this->add_time= $add_time;
		$this->remark= $remark;
		$this->table='Fx_statement';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','主键，自动增长列**资金流水表**'),"user_type" => array('tinyint', '', 'NO','1:供货商,2:分销商'),"user_id" => array('int', '', 'YES','用户id'),"user_name" => array('varchar', '50', 'YES','用户名称'),"trade_type" => array('tinyint', '', 'NO','1，分销商提现（供货商没有提现的说法）[打款]，2，分销商售后补款[打款] 3，分销商售后退款[打款] 4，供货商完结订单[打款] 5，分销商下单[收款] 6，分销商充值[收款] 7，供货商补款[收款]'),"in_money" => array('decimal', '', 'NO','入账金额'),"out_money" => array('decimal', '', 'NO','出账金额'),"now_balance" => array('decimal', '', 'NO','实时余额'),"trade_account" => array('varchar', '100', 'YES','收付款账号'),"trade_account_type" => array('tinyint', '', 'YES','收付款账户类型'),"trade_no" => array('bigint', '', 'YES','第三方流水号或订单号'),"add_time" => array('bigint', '', 'NO','交易时间'),"remark" => array('varchar', '255', 'YES','备注'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $user_type;
	 public $user_id;
	 public $user_name;
	 public $trade_type;
	 public $in_money;
	 public $out_money;
	 public $now_balance;
	 public $trade_account;
	 public $trade_account_type;
	 public $trade_no;
	 public $add_time;
	 public $remark; 
}