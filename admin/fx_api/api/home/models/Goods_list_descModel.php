<?php
namespace api\home; 
 class Goods_list_descModel extends Model{

  	 function __construct($id=null,$goods_id=null,$desc=null,$wireless_desc=null) {
		 
		$this->id= $id;
		$this->goods_id= $goods_id;
		$this->desc= $desc;
		$this->wireless_desc= $wireless_desc;
		$this->table='Goods_list_desc';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','自主增键'),"goods_id" => array('int', '', 'NO','商品表id'),"desc" => array('text', '65535', 'NO','商品描述'),"wireless_desc" => array('text', '65535', 'YES','商品手机描述'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $goods_id;
	 public $desc;
	 public $wireless_desc; 
}