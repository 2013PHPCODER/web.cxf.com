<?php
namespace api\home; 
 class Hub_order_goodsModel extends Model{

  	 function __construct($id=null,$order_id=null,$goods_id=null,$hub_id=null,$goods_name=null,$category_parent=null,$goods_num=null,$sku_comb_id=null,$addtime=null) {
		 
		$this->id= $id;
		$this->order_id= $order_id;
		$this->goods_id= $goods_id;
		$this->hub_id= $hub_id;
		$this->goods_name= $goods_name;
		$this->category_parent= $category_parent;
		$this->goods_num= $goods_num;
		$this->sku_comb_id= $sku_comb_id;
		$this->addtime= $addtime;
		$this->table='Hub_order_goods';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','自增主键'),"order_id" => array('int', '', 'NO','订单ID'),"goods_id" => array('int', '', 'NO','发货订单商品表'),"hub_id" => array('int', '', 'NO','订单发货id'),"goods_name" => array('varchar', '62', 'NO','发货订单商品名'),"category_parent" => array('int', '', 'NO','父级类目'),"goods_num" => array('int', '', 'NO','订单数量'),"sku_comb_id" => array('int', '', 'NO','订单商品SKU组合ID'),"addtime" => array('int', '', 'NO','生成时间'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $order_id;
	 public $goods_id;
	 public $hub_id;
	 public $goods_name;
	 public $category_parent;
	 public $goods_num;
	 public $sku_comb_id;
	 public $addtime; 
}