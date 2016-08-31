<?php
namespace api\home; 
 class Confirm_success_tradeModel extends Model{

  	 function __construct($id=null,$user_type=null,$user_id=null,$user_name=null,$source_id=null,$source_sn=null,$type=null,$status=null,$confirm_money=null,$trade_no=null,$pay_account=null,$receiver_account=null,$pay_type=null,$add_time=null,$pay_time=null,$confirm_time=null,$confirm_user_id=null) {
		 
		$this->id= $id;
		$this->user_type= $user_type;
		$this->user_id= $user_id;
		$this->user_name= $user_name;
		$this->source_id= $source_id;
		$this->source_sn= $source_sn;
		$this->type= $type;
		$this->status= $status;
		$this->confirm_money= $confirm_money;
		$this->trade_no= $trade_no;
		$this->pay_account= $pay_account;
		$this->receiver_account= $receiver_account;
		$this->pay_type= $pay_type;
		$this->add_time= $add_time;
		$this->pay_time= $pay_time;
		$this->confirm_time= $confirm_time;
		$this->confirm_user_id= $confirm_user_id;
		$this->table='Confirm_success_trade';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','主键，自动增长列(订单完结表，**收款表**)'),"user_type" => array('tinyint', '', 'NO','用户类型:1:供货商,2:分销商'),"user_id" => array('int', '', 'NO','用户id'),"user_name" => array('varchar', '50', 'YES','付款账号'),"source_id" => array('int', '', 'YES','订单表id或售后表id'),"source_sn" => array('varchar', '100', 'YES','来源单号(order_sn,售后单号等)'),"type" => array('tinyint', '', 'NO','1:订单收款,2:充值,3:补款,4:虚拟订单收款'),"status" => array('int', '', 'NO','状态(0,未收款,1已收款)'),"confirm_money" => array('decimal', '', 'NO','收款金额'),"trade_no" => array('varchar', '40', 'YES','第三方流水号'),"pay_account" => array('varchar', '50', 'YES','付款账户'),"receiver_account" => array('varchar', '100', 'YES','收款账户'),"pay_type" => array('tinyint', '', 'YES','支付方式:1:支付宝,2:银行卡,3:微信'),"add_time" => array('int', '', 'NO','添加时间'),"pay_time" => array('int', '', 'YES','打款时间'),"confirm_time" => array('int', '', 'YES','完成时间'),"confirm_user_id" => array('int', '', 'YES','操作完成人id'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $user_type;
	 public $user_id;
	 public $user_name;
	 public $source_id;
	 public $source_sn;
	 public $type;
	 public $status;
	 public $confirm_money;
	 public $trade_no;
	 public $pay_account;
	 public $receiver_account;
	 public $pay_type;
	 public $add_time;
	 public $pay_time;
	 public $confirm_time;
	 public $confirm_user_id; 
}