<?php
namespace api\home; 
 class Fx_supplier_create_logModel extends Model{

  	 function __construct($id=null,$distribute_id=null,$new_distribute_id=null,$new_username=null,$status=null,$level=null,$price=null,$agent_price=null,$add_time=null,$finish_time=null,$mark=null,$virtual_goods_id=null,$vorder_sn=null) {
		 
		$this->id= $id;
		$this->distribute_id= $distribute_id;
		$this->new_distribute_id= $new_distribute_id;
		$this->new_username= $new_username;
		$this->status= $status;
		$this->level= $level;
		$this->price= $price;
		$this->agent_price= $agent_price;
		$this->add_time= $add_time;
		$this->finish_time= $finish_time;
		$this->mark= $mark;
		$this->virtual_goods_id= $virtual_goods_id;
		$this->vorder_sn= $vorder_sn;
		$this->table='Fx_supplier_create_log';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO',''),"distribute_id" => array('int', '', 'NO','申请代理商id'),"new_distribute_id" => array('int', '', 'NO','新代理商id'),"new_username" => array('varchar', '50', 'YES','新代理商用户名'),"status" => array('tinyint', '', 'NO','1:未付款2:已付款'),"level" => array('smallint', '', 'YES','套餐级别'),"price" => array('decimal', '', 'NO','套餐价格'),"agent_price" => array('decimal', '', 'NO','代理价格'),"add_time" => array('bigint', '', 'NO','添加时间'),"finish_time" => array('bigint', '', 'YES','完成时间'),"mark" => array('varchar', '255', 'YES','备注'),"virtual_goods_id" => array('int', '', 'YES','虚拟商品id'),"vorder_sn" => array('varchar', '50', 'NO','虚拟订单号'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $distribute_id;
	 public $new_distribute_id;
	 public $new_username;
	 public $status;
	 public $level;
	 public $price;
	 public $agent_price;
	 public $add_time;
	 public $finish_time;
	 public $mark;
	 public $virtual_goods_id;
	 public $vorder_sn; 
}