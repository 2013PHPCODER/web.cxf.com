<?php
namespace api\home; 
 class Hub_orderModel extends Model{

  	 function __construct($id=null,$order_id=null,$order_sn=null,$buyer_id=null,$buyer_name=null,$ship_stats=null,$hub_type=null,$shipping_code=null,$shipping_name=null,$shipping_no=null,$memo=null,$order_time=null,$con_time=null,$receiver_name=null,$receiver_tel=null,$buyer_goods_no=null,$shop_id=null,$depot_id=null,$addtime=null,$shipping_fee=null,$is_print=null,$print_no=null,$shipping_is_print=null,$shipping_info=null) {
		 
		$this->id= $id;
		$this->order_id= $order_id;
		$this->order_sn= $order_sn;
		$this->buyer_id= $buyer_id;
		$this->buyer_name= $buyer_name;
		$this->ship_stats= $ship_stats;
		$this->hub_type= $hub_type;
		$this->shipping_code= $shipping_code;
		$this->shipping_name= $shipping_name;
		$this->shipping_no= $shipping_no;
		$this->memo= $memo;
		$this->order_time= $order_time;
		$this->con_time= $con_time;
		$this->receiver_name= $receiver_name;
		$this->receiver_tel= $receiver_tel;
		$this->buyer_goods_no= $buyer_goods_no;
		$this->shop_id= $shop_id;
		$this->depot_id= $depot_id;
		$this->addtime= $addtime;
		$this->shipping_fee= $shipping_fee;
		$this->is_print= $is_print;
		$this->print_no= $print_no;
		$this->shipping_is_print= $shipping_is_print;
		$this->shipping_info= $shipping_info;
		$this->table='Hub_order';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','自主增键'),"order_id" => array('int', '', 'NO','订单ID'),"order_sn" => array('bigint', '', 'NO','订单编号'),"buyer_id" => array('varchar', '50', 'NO','分销商ID'),"buyer_name" => array('varchar', '50', 'NO','分销商用户名'),"ship_stats" => array('tinyint', '', 'NO','发货状态：0＝待配货，1：待分配，2=待发货，3=已发货'),"hub_type" => array('tinyint', '', 'NO','面单分类：1=普通面单，2=电子面单'),"shipping_code" => array('varchar', '50', 'NO','运单号'),"shipping_name" => array('varchar', '50', 'NO','物流公司'),"shipping_no" => array('varchar', '50', 'NO','物流公司编号'),"memo" => array('text', '65535', 'YES','订单备注'),"order_time" => array('int', '', 'NO','订单生成时间'),"con_time" => array('int', '', 'NO','订单确认时间'),"receiver_name" => array('varchar', '20', 'NO','收件人姓名'),"receiver_tel" => array('varchar', '20', 'NO','收件人电话'),"buyer_goods_no" => array('varchar', '50', 'NO','商家编的码'),"shop_id" => array('int', '', 'NO','平台ID'),"depot_id" => array('int', '', 'NO','仓库地址'),"addtime" => array('int', '', 'NO','生成时间'),"shipping_fee" => array('decimal', '', 'YES','运费'),"is_print" => array('tinyint', '', 'NO','配合单是否打印：1=打印,2=未打印'),"print_no" => array('varchar', '50', 'NO','打印编号'),"shipping_is_print" => array('tinyint', '', 'NO','面单是否打印：1=打印,0=未打印'),"shipping_info" => array('text', '65535', 'NO','面单接口返回数据'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $order_id;
	 public $order_sn;
	 public $buyer_id;
	 public $buyer_name;
	 public $ship_stats;
	 public $hub_type;
	 public $shipping_code;
	 public $shipping_name;
	 public $shipping_no;
	 public $memo;
	 public $order_time;
	 public $con_time;
	 public $receiver_name;
	 public $receiver_tel;
	 public $buyer_goods_no;
	 public $shop_id;
	 public $depot_id;
	 public $addtime;
	 public $shipping_fee;
	 public $is_print;
	 public $print_no;
	 public $shipping_is_print;
	 public $shipping_info; 
}