<?php
namespace api\home; 
 class Cus_order_goods_listModel extends Model{

  	 function __construct($id=null,$cus_id=null,$goods_id=null,$goods_name=null,$img_path=null,$goods_num=null,$shop_price=null,$price=null,$buyer_goods_no=null,$sku_comb_id=null,$depot_id=null,$cus_goods_status=null,$responsible=null,$damaged=null) {
		 
		$this->id= $id;
		$this->cus_id= $cus_id;
		$this->goods_id= $goods_id;
		$this->goods_name= $goods_name;
		$this->img_path= $img_path;
		$this->goods_num= $goods_num;
		$this->shop_price= $shop_price;
		$this->price= $price;
		$this->buyer_goods_no= $buyer_goods_no;
		$this->sku_comb_id= $sku_comb_id;
		$this->depot_id= $depot_id;
		$this->cus_goods_status= $cus_goods_status;
		$this->responsible= $responsible;
		$this->damaged= $damaged;
		$this->table='Cus_order_goods_list';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','自主增键'),"cus_id" => array('int', '', 'NO','退货单ID'),"goods_id" => array('int', '', 'NO','商品ID'),"goods_name" => array('varchar', '255', 'NO','商品名称'),"img_path" => array('varchar', '255', 'NO','商品图片'),"goods_num" => array('int', '', 'NO','商品数量'),"shop_price" => array('decimal', '', 'NO','平台的分销价'),"price" => array('decimal', '', 'NO','申请的价格'),"buyer_goods_no" => array('varchar', '100', 'NO','商家编的码'),"sku_comb_id" => array('int', '', 'NO','商品SKU组合ＩＤ'),"depot_id" => array('int', '', 'YES','仓库地址ID'),"cus_goods_status" => array('tinyint', '', 'YES','1=商品完整,2=商品异常'),"responsible" => array('tinyint', '', 'YES','责任方 1=仓库 2=物流 3=消费者'),"damaged" => array('text', '65535', 'YES','商品损坏原因'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $cus_id;
	 public $goods_id;
	 public $goods_name;
	 public $img_path;
	 public $goods_num;
	 public $shop_price;
	 public $price;
	 public $buyer_goods_no;
	 public $sku_comb_id;
	 public $depot_id;
	 public $cus_goods_status;
	 public $responsible;
	 public $damaged; 
}