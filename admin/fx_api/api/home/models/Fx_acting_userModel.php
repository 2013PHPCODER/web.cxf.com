<?php
namespace api\home; 
 class Fx_acting_userModel extends Model{

  	 function __construct($id=null,$addtime=null,$distribute_id=null,$buy_account_num=null,$receiver_money=null) {
		 
		$this->id= $id;
		$this->addtime= $addtime;
		$this->distribute_id= $distribute_id;
		$this->buy_account_num= $buy_account_num;
		$this->receiver_money= $receiver_money;
		$this->table='Fx_acting_user';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','id 主键，自动增长列'),"addtime" => array('datetime', '', 'YES','添加时间'),"distribute_id" => array('int', '', 'YES','外键，分销商id'),"buy_account_num" => array('int', '', 'YES','购买帐号总数'),"receiver_money" => array('decimal', '', 'YES','收款金额'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $addtime;
	 public $distribute_id;
	 public $buy_account_num;
	 public $receiver_money; 
}