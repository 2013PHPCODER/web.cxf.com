<?php
namespace api\home; 
 class Order_goods_skuModel extends Model{

  	 function __construct($id=null,$order_id=null,$goods_id=null,$sku_comb_id=null) {
		 
		$this->id= $id;
		$this->order_id= $order_id;
		$this->goods_id= $goods_id;
		$this->sku_comb_id= $sku_comb_id;
		$this->table='Order_goods_sku';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','自增主键'),"order_id" => array('int', '', 'NO','主订单ID'),"goods_id" => array('int', '', 'NO','订单商品ID'),"sku_comb_id" => array('int', '', 'NO','订单商品SKU组合ID'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $order_id;
	 public $goods_id;
	 public $sku_comb_id; 
}