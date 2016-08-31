<?php
namespace api\home; 
 class Goods_list_skuModel extends Model{

  	 function __construct($id=null,$goods_id=null,$sku_name=null,$sku_name_str=null,$sku_val=null,$sku_val_str=null) {
		 
		$this->id= $id;
		$this->goods_id= $goods_id;
		$this->sku_name= $sku_name;
		$this->sku_name_str= $sku_name_str;
		$this->sku_val= $sku_val;
		$this->sku_val_str= $sku_val_str;
		$this->table='Goods_list_sku';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','自增主键'),"goods_id" => array('int', '', 'NO','商品ID'),"sku_name" => array('varchar', '100', 'NO','商品属性名'),"sku_name_str" => array('varchar', '50', 'YES','商品属性名字符串'),"sku_val" => array('varchar', '1000', 'NO','sku值,数组json后序列化'),"sku_val_str" => array('varchar', '1000', 'YES','商品属性值字符串(数组json后序列化，且顺序必须和sku_val一致)'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $goods_id;
	 public $sku_name;
	 public $sku_name_str;
	 public $sku_val;
	 public $sku_val_str; 
}