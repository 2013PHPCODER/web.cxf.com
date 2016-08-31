<?php
namespace api\home; 
 class Fx_aftersales_logModel extends Model{

  	 function __construct($id=null,$cus_id=null,$user_name=null,$action=null,$add_time=null,$remark=null) {
		 
		$this->id= $id;
		$this->cus_id= $cus_id;
		$this->user_name= $user_name;
		$this->action= $action;
		$this->add_time= $add_time;
		$this->remark= $remark;
		$this->table='Fx_aftersales_log';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','无意义主键'),"cus_id" => array('int', '', 'NO','售后id'),"user_name" => array('varchar', '50', 'NO','操作员'),"action" => array('varchar', '255', 'NO','操作内容'),"add_time" => array('int', '', 'NO','操作时间'),"remark" => array('varchar', '255', 'YES','备注'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $cus_id;
	 public $user_name;
	 public $action;
	 public $add_time;
	 public $remark; 
}