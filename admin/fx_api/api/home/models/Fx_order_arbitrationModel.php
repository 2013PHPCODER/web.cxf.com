<?php
namespace api\home; 
 class Fx_order_arbitrationModel extends Model{

  	 function __construct($arbitration_id=null,$aftersales_id=null,$supplier_user_id=null,$supplier_result=null,$supplier_remark=null,$supplier_confirm_time=null,$supplier_file=null,$distribute_user_id=null,$distribute_result=null,$distribute_remark=null,$distribute_confirm_time=null,$distribute_file=null,$admin_user_id=null,$admin_result=null,$admin_remark=null,$admin_confirm_time=null) {
		 
		$this->arbitration_id= $arbitration_id;
		$this->aftersales_id= $aftersales_id;
		$this->supplier_user_id= $supplier_user_id;
		$this->supplier_result= $supplier_result;
		$this->supplier_remark= $supplier_remark;
		$this->supplier_confirm_time= $supplier_confirm_time;
		$this->supplier_file= $supplier_file;
		$this->distribute_user_id= $distribute_user_id;
		$this->distribute_result= $distribute_result;
		$this->distribute_remark= $distribute_remark;
		$this->distribute_confirm_time= $distribute_confirm_time;
		$this->distribute_file= $distribute_file;
		$this->admin_user_id= $admin_user_id;
		$this->admin_result= $admin_result;
		$this->admin_remark= $admin_remark;
		$this->admin_confirm_time= $admin_confirm_time;
		$this->table='Fx_order_arbitration';
	 }

	 static $init_valid_array = array("arbitration_id" => array('int', '', 'NO','主键，自动增长列**仲裁表**'),"aftersales_id" => array('int', '', 'NO','售后表id，外键'),"supplier_user_id" => array('int', '', 'NO','供货商id'),"supplier_result" => array('tinyint', '', 'NO','供货商态度(1,同意 2，拒绝)'),"supplier_remark" => array('varchar', '255', 'YES','供货商备注说明'),"supplier_confirm_time" => array('int', '', 'NO','供货商确认时间'),"supplier_file" => array('text', '65535', 'YES','供应商附件证据 json序列化索引数组，只存附件名，访问url前缀通过配置文件获取'),"distribute_user_id" => array('int', '', 'NO','分销商id'),"distribute_result" => array('tinyint', '', 'NO','分销商态度(1,同意 2，拒绝)'),"distribute_remark" => array('varchar', '255', 'YES','分销商备注说明'),"distribute_confirm_time" => array('int', '', 'NO','分销商确认时间'),"distribute_file" => array('text', '65535', 'NO','分销商附件证据 json序列化索引数组，只存附件名，访问url前缀通过配置文件获取'),"admin_user_id" => array('smallint', '', 'NO','平台审核人'),"admin_result" => array('tinyint', '', 'NO','平台判断责任(1,供货商责任，2，分销商责任)'),"admin_remark" => array('varchar', '255', 'NO','平台判断责任说明(仲裁意见)'),"admin_confirm_time" => array('int', '', 'NO','平台审核时间'));

	 public $_cxf_num_id='arbitration_id';
	 public $arbitration_id;
	 public $aftersales_id;
	 public $supplier_user_id;
	 public $supplier_result;
	 public $supplier_remark;
	 public $supplier_confirm_time;
	 public $supplier_file;
	 public $distribute_user_id;
	 public $distribute_result;
	 public $distribute_remark;
	 public $distribute_confirm_time;
	 public $distribute_file;
	 public $admin_user_id;
	 public $admin_result;
	 public $admin_remark;
	 public $admin_confirm_time; 
}