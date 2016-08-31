<?php
namespace api\home; 
 class Goods_list_propertyModel extends Model{

  	 function __construct($id=null,$goods_id=null,$goods_title=null,$goods_key=null,$goods_value=null) {
		 
		$this->id= $id;
		$this->goods_id= $goods_id;
		$this->goods_title= $goods_title;
		$this->goods_key= $goods_key;
		$this->goods_value= $goods_value;
		$this->table='Goods_list_property';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','自增主键'),"goods_id" => array('int', '', 'NO','商品ID'),"goods_title" => array('varchar', '50', 'NO','商品属性名(汉字)'),"goods_key" => array('varchar', '50', 'NO','商品属性名'),"goods_value" => array('text', '65535', 'NO','商品'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $goods_id;
	 public $goods_title;
	 public $goods_key;
	 public $goods_value; 
}