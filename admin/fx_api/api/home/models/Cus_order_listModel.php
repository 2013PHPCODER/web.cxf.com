<?php
namespace api\home; 
 class Cus_order_listModel extends Model{

  	 function __construct($id=null,$order_id=null,$order_sn=null,$other_order_sn=null,$other_shop=null,$buyer_id=null,$supplier_id=null,$shop_id=null,$cus_type=null,$receiver_name=null,$receiver_mobile=null,$receiver_address=null,$distributors_qq=null,$refund_amount=null,$refund_status=null,$return_status=null,$addtime=null,$conf_time=null,$receipt_time=null,$verify_time=null,$close_time=null,$return_time=null,$arbitration_time=null,$refund_money_time=null,$shipping_no=null,$shipping_fee=null,$shipping_code=null,$company_name=null,$refund_reason=null,$remark=null,$buyer_name=null,$been_arbitrated=null,$have_replenished=null,$supplier_refuse_reason=null,$admin_arbitration_reason=null,$supplier_refuse_img=null,$supplier_show_refund=null) {
		 
		$this->id= $id;
		$this->order_id= $order_id;
		$this->order_sn= $order_sn;
		$this->other_order_sn= $other_order_sn;
		$this->other_shop= $other_shop;
		$this->buyer_id= $buyer_id;
		$this->supplier_id= $supplier_id;
		$this->shop_id= $shop_id;
		$this->cus_type= $cus_type;
		$this->receiver_name= $receiver_name;
		$this->receiver_mobile= $receiver_mobile;
		$this->receiver_address= $receiver_address;
		$this->distributors_qq= $distributors_qq;
		$this->refund_amount= $refund_amount;
		$this->refund_status= $refund_status;
		$this->return_status= $return_status;
		$this->addtime= $addtime;
		$this->conf_time= $conf_time;
		$this->receipt_time= $receipt_time;
		$this->verify_time= $verify_time;
		$this->close_time= $close_time;
		$this->return_time= $return_time;
		$this->arbitration_time= $arbitration_time;
		$this->refund_money_time= $refund_money_time;
		$this->shipping_no= $shipping_no;
		$this->shipping_fee= $shipping_fee;
		$this->shipping_code= $shipping_code;
		$this->company_name= $company_name;
		$this->refund_reason= $refund_reason;
		$this->remark= $remark;
		$this->buyer_name= $buyer_name;
		$this->been_arbitrated= $been_arbitrated;
		$this->have_replenished= $have_replenished;
		$this->supplier_refuse_reason= $supplier_refuse_reason;
		$this->admin_arbitration_reason= $admin_arbitration_reason;
		$this->supplier_refuse_img= $supplier_refuse_img;
		$this->supplier_show_refund= $supplier_show_refund;
		$this->table='Cus_order_list';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','自增主键'),"order_id" => array('int', '', 'NO','订单ID'),"order_sn" => array('bigint', '', 'NO','订单编号'),"other_order_sn" => array('int', '', 'YES','其他平台单号id'),"other_shop" => array('varchar', '50', 'YES','订单第三方平台名称，如支付宝，微信'),"buyer_id" => array('int', '', 'NO','分销商ID'),"supplier_id" => array('int', '', 'NO','供应商id'),"shop_id" => array('int', '', 'NO','商家id'),"cus_type" => array('tinyint', '', 'NO','退货分类：1＝退款退货，2=退款'),"receiver_name" => array('varchar', '255', 'NO','收货姓名'),"receiver_mobile" => array('varchar', '50', 'NO','收货人手机，座机等'),"receiver_address" => array('varchar', '255', 'NO','收货人详细地址'),"distributors_qq" => array('bigint', '', 'NO','分销商ＱＱ'),"refund_amount" => array('decimal', '', 'NO','退款金额'),"refund_status" => array('tinyint', '', 'NO','退款状态:1=平台待确认，2平台拒绝，3待供应商确认，4待仲裁（平台接入审核），5待平台支付，6 已完成'),"return_status" => array('tinyint', '', 'NO','退款状态:1=平台待确认，2平台拒绝，3等待买家发货，4等待供货商收货，5待平台打款，6 等待供货商补款，7待仲裁（平台接入），8已完成'),"addtime" => array('int', '', 'NO','生成时间'),"conf_time" => array('int', '', 'YES','供应商确认时间'),"receipt_time" => array('int', '', 'YES','收货时间'),"verify_time" => array('int', '', 'YES','平台审核时间'),"close_time" => array('int', '', 'YES','完成或拒绝时间'),"return_time" => array('int', '', 'YES','买家退货时间'),"arbitration_time" => array('int', '', 'YES','平台仲裁时间'),"refund_money_time" => array('int', '', 'YES','平台打款时间'),"shipping_no" => array('varchar', '20', 'YES','物流公司编号 目前无用'),"shipping_fee" => array('decimal', '', 'YES',''),"shipping_code" => array('varchar', '50', 'YES','运单号'),"company_name" => array('varchar', '50', 'NO','物流公司名称'),"refund_reason" => array('tinyint', '', 'NO','售后理由：1=7天无理由，分销商承担运费；2=质量问题，供应商承担运费；3＝其他原因;'),"remark" => array('varchar', '255', 'NO','备注'),"buyer_name" => array('varchar', '50', 'YES','分销商名字'),"been_arbitrated" => array('tinyint', '', 'NO','是否被仲裁过'),"have_replenished" => array('tinyint', '', 'NO','是否打款，只针对供应商需要打款时候，填写了打款信息后更新。0未打款，1已打款'),"supplier_refuse_reason" => array('mediumtext', '16777215', 'YES','供应商售后拒绝的原因'),"admin_arbitration_reason" => array('varchar', '255', 'YES','管理员仲裁的理由'),"supplier_refuse_img" => array('mediumtext', '16777215', 'YES','供应商拒绝图片，用 | 分割'),"supplier_show_refund" => array('decimal', '', 'NO','用于供应商的显示退款金额，'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $order_id;
	 public $order_sn;
	 public $other_order_sn;
	 public $other_shop;
	 public $buyer_id;
	 public $supplier_id;
	 public $shop_id;
	 public $cus_type;
	 public $receiver_name;
	 public $receiver_mobile;
	 public $receiver_address;
	 public $distributors_qq;
	 public $refund_amount;
	 public $refund_status;
	 public $return_status;
	 public $addtime;
	 public $conf_time;
	 public $receipt_time;
	 public $verify_time;
	 public $close_time;
	 public $return_time;
	 public $arbitration_time;
	 public $refund_money_time;
	 public $shipping_no;
	 public $shipping_fee;
	 public $shipping_code;
	 public $company_name;
	 public $refund_reason;
	 public $remark;
	 public $buyer_name;
	 public $been_arbitrated;
	 public $have_replenished;
	 public $supplier_refuse_reason;
	 public $admin_arbitration_reason;
	 public $supplier_refuse_img;
	 public $supplier_show_refund; 
}