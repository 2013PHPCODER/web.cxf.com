<?php
namespace api\home; 
 class Fx_virtual_goodsModel extends Model{

  	 function __construct($id=null,$name=null,$level=null,$price=null,$agent_price=null,$img_url=null,$updatetime=null) {
		 
		$this->id= $id;
		$this->name= $name;
		$this->level= $level;
		$this->price= $price;
		$this->agent_price= $agent_price;
		$this->img_url= $img_url;
		$this->updatetime= $updatetime;
		$this->table='Fx_virtual_goods';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','主键id'),"name" => array('varchar', '200', 'NO','商品名'),"level" => array('int', '', 'NO','等级'),"price" => array('decimal', '', 'NO','价格'),"agent_price" => array('decimal', '', 'NO','代理价格'),"img_url" => array('varchar', '255', 'NO','图片地址'),"updatetime" => array('timestamp', '', 'NO','更新时间'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $name;
	 public $level;
	 public $price;
	 public $agent_price;
	 public $img_url;
	 public $updatetime; 
}