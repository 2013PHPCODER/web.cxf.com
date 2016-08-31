<?php
namespace api\home; 
 class Order_listModel extends Model{

  	 function __construct($order_id=null,$order_sn=null,$other_order_sn=null,$other_shop=null,$buyer_id=null,$buyer_name=null,$shop_id=null,$add_time=null,$payment_time=null,$finnshed_time=null,$goods_amount=null,$order_amount=null,$cost_price=null,$pay_amount=null,$order_state=null,$con_time=null,$send_hub_time=null,$close_time=null,$order_marked=null,$shipping_code=null,$shipping_id=null,$shipping_name=null,$shipping_fee=null,$qq=null,$message_starts=null,$memo=null,$is_send_hub=null,$is_cus=null,$hub_type=null,$receiver_name=null,$receiver_tel=null,$is_edit_address=null,$shipping_info=null,$supplier_id=null,$is_supplier_close=null,$is_pay=null) {
		 
		$this->order_id= $order_id;
		$this->order_sn= $order_sn;
		$this->other_order_sn= $other_order_sn;
		$this->other_shop= $other_shop;
		$this->buyer_id= $buyer_id;
		$this->buyer_name= $buyer_name;
		$this->shop_id= $shop_id;
		$this->add_time= $add_time;
		$this->payment_time= $payment_time;
		$this->finnshed_time= $finnshed_time;
		$this->goods_amount= $goods_amount;
		$this->order_amount= $order_amount;
		$this->cost_price= $cost_price;
		$this->pay_amount= $pay_amount;
		$this->order_state= $order_state;
		$this->con_time= $con_time;
		$this->send_hub_time= $send_hub_time;
		$this->close_time= $close_time;
		$this->order_marked= $order_marked;
		$this->shipping_code= $shipping_code;
		$this->shipping_id= $shipping_id;
		$this->shipping_name= $shipping_name;
		$this->shipping_fee= $shipping_fee;
		$this->qq= $qq;
		$this->message_starts= $message_starts;
		$this->memo= $memo;
		$this->is_send_hub= $is_send_hub;
		$this->is_cus= $is_cus;
		$this->hub_type= $hub_type;
		$this->receiver_name= $receiver_name;
		$this->receiver_tel= $receiver_tel;
		$this->is_edit_address= $is_edit_address;
		$this->shipping_info= $shipping_info;
		$this->supplier_id= $supplier_id;
		$this->is_supplier_close= $is_supplier_close;
		$this->is_pay= $is_pay;
		$this->table='Order_list';
	 }

	 static $init_valid_array = array("order_id" => array('int', '', 'NO','订单索引自增主键'),"order_sn" => array('bigint', '', 'NO','订单编号'),"other_order_sn" => array('varchar', '100', 'NO','第三方订单编号'),"other_shop" => array('varchar', '100', 'NO','第三方平台名称'),"buyer_id" => array('int', '', 'NO','分销商ID'),"buyer_name" => array('varchar', '100', 'NO','分销商名称'),"shop_id" => array('int', '', 'NO','平台ID'),"add_time" => array('int', '', 'NO','订单生成时间'),"payment_time" => array('int', '', 'NO','支付(付款)时间'),"finnshed_time" => array('int', '', 'NO','订单完成时间'),"goods_amount" => array('decimal', '', 'NO','商品总价格'),"order_amount" => array('decimal', '', 'NO','订单总价格'),"cost_price" => array('decimal', '', 'NO','成本价（成交总价，供货商）'),"pay_amount" => array('decimal', '', 'NO','支付金额'),"order_state" => array('tinyint', '', 'NO','订单状态：0＝待付款，1=已付款待确认，2=已确认待发货，3＝已确认已发货，4＝已完成，5=已关闭，6=异常'),"con_time" => array('int', '', 'NO','确认时间'),"send_hub_time" => array('int', '', 'NO','发货时间'),"close_time" => array('int', '', 'NO','关闭或完成时间'),"order_marked" => array('tinyint', '', 'NO','订单标记:0=未打印，1=已打印，2=分配失败'),"shipping_code" => array('varchar', '50', 'NO','物流单号'),"shipping_id" => array('int', '', 'NO','物流公司ID'),"shipping_name" => array('varchar', '50', 'NO','物流公司名称'),"shipping_fee" => array('decimal', '', 'NO','运费'),"qq" => array('varchar', '16', 'NO','分销商QQ'),"message_starts" => array('tinyint', '', 'NO','留言状态：0＝没有留言，1=有留言'),"memo" => array('text', '65535', 'NO','备注'),"is_send_hub" => array('tinyint', '', 'NO','是否发货'),"is_cus" => array('tinyint', '', 'NO','是否有售后：0=没有售后，1=有售后'),"hub_type" => array('tinyint', '', 'NO','面单分类：1=普通面单，2=电子面单'),"receiver_name" => array('varchar', '20', 'NO','最新联系人姓名'),"receiver_tel" => array('varchar', '20', 'NO','最新联系人电话'),"is_edit_address" => array('tinyint', '', 'NO','是否修改过收货地址：0=未编辑，1=有编辑'),"shipping_info" => array('text', '65535', 'NO','面单接口返回数据'),"supplier_id" => array('int', '', 'NO','供应商id（商品的供应商）'),"is_supplier_close" => array('tinyint', '', 'NO','是否是总台关闭订单（0.否；1.是）'),"is_pay" => array('tinyint', '', 'YES','是否付款（0：未付款，1：已付款）'));

	 public $_cxf_num_id='order_id';
	 public $order_id;
	 public $order_sn;
	 public $other_order_sn;
	 public $other_shop;
	 public $buyer_id;
	 public $buyer_name;
	 public $shop_id;
	 public $add_time;
	 public $payment_time;
	 public $finnshed_time;
	 public $goods_amount;
	 public $order_amount;
	 public $cost_price;
	 public $pay_amount;
	 public $order_state;
	 public $con_time;
	 public $send_hub_time;
	 public $close_time;
	 public $order_marked;
	 public $shipping_code;
	 public $shipping_id;
	 public $shipping_name;
	 public $shipping_fee;
	 public $qq;
	 public $message_starts;
	 public $memo;
	 public $is_send_hub;
	 public $is_cus;
	 public $hub_type;
	 public $receiver_name;
	 public $receiver_tel;
	 public $is_edit_address;
	 public $shipping_info;
	 public $supplier_id;
	 public $is_supplier_close;
	 public $is_pay; 
}