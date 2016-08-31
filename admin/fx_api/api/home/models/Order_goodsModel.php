<?php
namespace api\home; 
 class Order_goodsModel extends Model{

  	 function __construct($id=null,$order_id=null,$goods_id=null,$goods_no=null,$depot_id=null,$goods_name=null,$price=null,$distribution_price=null,$goods_num=null,$goods_cus_num=null,$buyer_goods_no=null,$category_id=null,$top_category=null,$img_path=null,$add_time=null) {
		 
		$this->id= $id;
		$this->order_id= $order_id;
		$this->goods_id= $goods_id;
		$this->goods_no= $goods_no;
		$this->depot_id= $depot_id;
		$this->goods_name= $goods_name;
		$this->price= $price;
		$this->distribution_price= $distribution_price;
		$this->goods_num= $goods_num;
		$this->goods_cus_num= $goods_cus_num;
		$this->buyer_goods_no= $buyer_goods_no;
		$this->category_id= $category_id;
		$this->top_category= $top_category;
		$this->img_path= $img_path;
		$this->add_time= $add_time;
		$this->table='Order_goods';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','自增主键'),"order_id" => array('int', '', 'NO','订单商品表'),"goods_id" => array('int', '', 'NO','商品ＩＤ'),"goods_no" => array('varchar', '50', 'NO','商品编号'),"depot_id" => array('int', '', 'NO','仓库ID'),"goods_name" => array('varchar', '62', 'NO','商品名称'),"price" => array('decimal', '', 'NO','商品成本价'),"distribution_price" => array('decimal', '', 'NO','成交价'),"goods_num" => array('int', '', 'NO','商品数量'),"goods_cus_num" => array('int', '', 'NO','售后商品数量'),"buyer_goods_no" => array('varchar', '200', 'NO','商家编的码'),"category_id" => array('int', '', 'NO','类目分类ＩＤ'),"top_category" => array('int', '', 'NO','商品一级类目（筛选数据）'),"img_path" => array('varchar', '255', 'NO','图片路径'),"add_time" => array('int', '', 'NO','生成时间'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $order_id;
	 public $goods_id;
	 public $goods_no;
	 public $depot_id;
	 public $goods_name;
	 public $price;
	 public $distribution_price;
	 public $goods_num;
	 public $goods_cus_num;
	 public $buyer_goods_no;
	 public $category_id;
	 public $top_category;
	 public $img_path;
	 public $add_time; 
}