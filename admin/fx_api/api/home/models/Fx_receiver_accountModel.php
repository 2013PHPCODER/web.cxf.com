<?php
namespace api\home; 
 class Fx_receiver_accountModel extends Model{

  	 function __construct($id=null,$user_id=null,$user_type=null,$user_account=null,$receiver_account=null,$receiver_name=null,$receiver_platform=null,$open_bank_address=null,$update_user=null,$update_time=null) {
		 
		$this->id= $id;
		$this->user_id= $user_id;
		$this->user_type= $user_type;
		$this->user_account= $user_account;
		$this->receiver_account= $receiver_account;
		$this->receiver_name= $receiver_name;
		$this->receiver_platform= $receiver_platform;
		$this->open_bank_address= $open_bank_address;
		$this->update_user= $update_user;
		$this->update_time= $update_time;
		$this->table='Fx_receiver_account';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','主键，自动增长列**页面收款帐号表**'),"user_id" => array('int', '', 'NO','用户id'),"user_type" => array('tinyint', '', 'NO',' 1平台'),"user_account" => array('varchar', '50', 'NO','用户账户(平台账户)'),"receiver_account" => array('varchar', '100', 'NO','收款账号'),"receiver_name" => array('varchar', '20', 'NO','收款人姓名'),"receiver_platform" => array('tinyint', '', 'NO','收款平台:1:支付宝,2:银行卡,3:微信','),"open_bank_address" => array('varchar', '255', 'NO','开户行地址'),"update_user" => array('varchar', '20', 'NO','修改人姓名'),"update_time" => array('int', '', 'NO','修改时间'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $user_id;
	 public $user_type;
	 public $user_account;
	 public $receiver_account;
	 public $receiver_name;
	 public $receiver_platform;
	 public $open_bank_address;
	 public $update_user;
	 public $update_time; 
}