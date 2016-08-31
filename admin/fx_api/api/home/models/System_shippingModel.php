<?php
namespace api\home; 
 class System_shippingModel extends Model{

  	 function __construct($id=null,$shipping_id=null,$shipping_name=null,$shipping_code=null,$reg_mail_no=null,$sort=null) {
		 
		$this->id= $id;
		$this->shipping_id= $shipping_id;
		$this->shipping_name= $shipping_name;
		$this->shipping_code= $shipping_code;
		$this->reg_mail_no= $reg_mail_no;
		$this->sort= $sort;
		$this->table='System_shipping';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','自增主键'),"shipping_id" => array('varchar', '50', 'YES','物流公司ID'),"shipping_name" => array('varchar', '50', 'YES','物流公司名称'),"shipping_code" => array('varchar', '50', 'NO','物流公司编号'),"reg_mail_no" => array('varchar', '200', 'NO','物流公司正测验证'),"sort" => array('int', '', 'NO','排序'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $shipping_id;
	 public $shipping_name;
	 public $shipping_code;
	 public $reg_mail_no;
	 public $sort; 
}