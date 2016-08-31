<?php
namespace api\home; 
 class Order_messageModel extends Model{

  	 function __construct($id=null,$order_id=null,$user_type=null,$user_id=null,$message=null,$addtime=null,$to_user_type=null) {
		 
		$this->id= $id;
		$this->order_id= $order_id;
		$this->user_type= $user_type;
		$this->user_id= $user_id;
		$this->message= $message;
		$this->addtime= $addtime;
		$this->to_user_type= $to_user_type;
		$this->table='Order_message';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','自增主键'),"order_id" => array('int', '', 'NO','主订单ID'),"user_type" => array('int', '', 'NO','角色类型：1=贷应商，2=管理员，3=分销商'),"user_id" => array('varchar', '100', 'NO','用户ID'),"message" => array('varchar', '255', 'NO','消息：限制120个汉字'),"addtime" => array('int', '', 'NO','生成时间'),"to_user_type" => array('int', '', 'NO','发向角色类型：1=贷应商，2=管理员，3=分销商'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $order_id;
	 public $user_type;
	 public $user_id;
	 public $message;
	 public $addtime;
	 public $to_user_type; 
}