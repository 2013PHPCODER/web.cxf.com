<?php
namespace api\home; 
 class Fx_customer_serviceModel extends Model{

  	 function __construct($id=null,$type=null,$admin=null,$datetime=null,$status=null,$qq=null) {
		 
		$this->id= $id;
		$this->type= $type;
		$this->admin= $admin;
		$this->datetime= $datetime;
		$this->status= $status;
		$this->qq= $qq;
		$this->table='Fx_customer_service';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','主键，自动增长列**客服管理**'),"type" => array('char', '2', 'NO','售前;售后'),"admin" => array('int', '', 'NO','添加人'),"datetime" => array('int', '', 'NO','添加时间'),"status" => array('tinyint', '', 'NO','是否开启，-1否，1是'),"qq" => array('bigint', '', 'NO','最大QQ号15位'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $type;
	 public $admin;
	 public $datetime;
	 public $status;
	 public $qq; 
}