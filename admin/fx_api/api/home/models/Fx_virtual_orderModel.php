<?php
namespace api\home; 
 class Fx_virtual_orderModel extends Model{

  	 function __construct($id=null,$order_sn=null,$order_type=null,$price=null,$pay_money=null,$add_time=null,$payment_time=null,$status=null,$distribute_user_id=null,$virtual_goods_id=null,$buyer_name=null,$log_id=null,$user_grade=null,$target_grade=null) {
		 
		$this->id= $id;
		$this->order_sn= $order_sn;
		$this->order_type= $order_type;
		$this->price= $price;
		$this->pay_money= $pay_money;
		$this->add_time= $add_time;
		$this->payment_time= $payment_time;
		$this->status= $status;
		$this->distribute_user_id= $distribute_user_id;
		$this->virtual_goods_id= $virtual_goods_id;
		$this->buyer_name= $buyer_name;
		$this->log_id= $log_id;
		$this->user_grade= $user_grade;
		$this->target_grade= $target_grade;
		$this->table='Fx_virtual_order';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','主键id'),"order_sn" => array('varchar', '20', 'NO','交易号'),"order_type" => array('tinyint', '', 'NO','1:新增用户购买,2:用户升级'),"price" => array('decimal', '', 'NO','商品价格'),"pay_money" => array('decimal', '', 'NO','支付金额'),"add_time" => array('int', '', 'NO','添加时间'),"payment_time" => array('int', '', 'NO','支付时间'),"status" => array('tinyint', '', 'NO','状态（1.待付款‘2.已完成；3.已关闭）'),"distribute_user_id" => array('int', '', 'NO','分销商id'),"virtual_goods_id" => array('int', '', 'NO','虚拟商品id'),"buyer_name" => array('varchar', '200', 'NO','分销商名称'),"log_id" => array('int', '', 'YES','创建新增用户日志表id'),"user_grade" => array('smallint', '', 'NO','用户等级'),"target_grade" => array('smallint', '', 'NO','目标等级'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $order_sn;
	 public $order_type;
	 public $price;
	 public $pay_money;
	 public $add_time;
	 public $payment_time;
	 public $status;
	 public $distribute_user_id;
	 public $virtual_goods_id;
	 public $buyer_name;
	 public $log_id;
	 public $user_grade;
	 public $target_grade; 
}