<?php
namespace api\home; 
 class Fx_catch_moneyModel extends Model{

  	 function __construct($id=null,$apply_user_id=null,$catch_type=null,$trade_no=null,$source_sn=null,$source_id=null,$repay=null,$status=null,$receiver_account=null,$receiver_account_type=null,$bank_deposit=null,$receiver_name=null,$remark=null,$pay_account_type=null,$pay_account=null,$deal_user=null,$addtime=null,$deal_time=null,$failcause=null,$user_type=null) {
		 
		$this->id= $id;
		$this->apply_user_id= $apply_user_id;
		$this->catch_type= $catch_type;
		$this->trade_no= $trade_no;
		$this->source_sn= $source_sn;
		$this->source_id= $source_id;
		$this->repay= $repay;
		$this->status= $status;
		$this->receiver_account= $receiver_account;
		$this->receiver_account_type= $receiver_account_type;
		$this->bank_deposit= $bank_deposit;
		$this->receiver_name= $receiver_name;
		$this->remark= $remark;
		$this->pay_account_type= $pay_account_type;
		$this->pay_account= $pay_account;
		$this->deal_user= $deal_user;
		$this->addtime= $addtime;
		$this->deal_time= $deal_time;
		$this->failcause= $failcause;
		$this->user_type= $user_type;
		$this->table='Fx_catch_money';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','主键，自动增长列[提现表]'),"apply_user_id" => array('int', '', 'NO','收款人id'),"catch_type" => array('tinyint', '', 'NO','1:提现,2:打款(订单完结),3:售后打款'),"trade_no" => array('varchar', '20', 'YES','第三方流水号'),"source_sn" => array('varchar', '50', 'YES','订单编号'),"source_id" => array('int', '', 'YES','订单表id或售后表id'),"repay" => array('decimal', '', 'NO','申请提现金额'),"status" => array('int', '', 'NO','状态 [1,待打款 2，已打款,3,打款失败]'),"receiver_account" => array('varchar', '100', 'NO','打款账户'),"receiver_account_type" => array('tinyint', '', 'NO','收款方式1:支付宝,2:银行卡,3:微信'),"bank_deposit" => array('varchar', '100', 'YES','开户行'),"receiver_name" => array('varchar', '50', 'NO','收款人'),"remark" => array('varchar', '200', 'NO','备注'),"pay_account_type" => array('tinyint', '', 'NO','付款账号类型：1:支付宝,2:银行卡,3:微信'),"pay_account" => array('varchar', '50', 'NO','付款账户'),"deal_user" => array('int', '', 'NO','处理人'),"addtime" => array('int', '', 'NO','申请时间'),"deal_time" => array('int', '', 'NO','处理时间'),"failcause" => array('varchar', '255', 'NO','失败原因'),"user_type" => array('tinyint', '', 'NO','1:供货商,2:经销商'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $apply_user_id;
	 public $catch_type;
	 public $trade_no;
	 public $source_sn;
	 public $source_id;
	 public $repay;
	 public $status;
	 public $receiver_account;
	 public $receiver_account_type;
	 public $bank_deposit;
	 public $receiver_name;
	 public $remark;
	 public $pay_account_type;
	 public $pay_account;
	 public $deal_user;
	 public $addtime;
	 public $deal_time;
	 public $failcause;
	 public $user_type; 
}