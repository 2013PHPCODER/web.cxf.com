<?php
namespace api\home; 
 class Fx_admin_logsModel extends Model{

  	 function __construct($id=null,$admin_user_id=null,$detail=null,$module=null,$add_time=null) {
		 
		$this->id= $id;
		$this->admin_user_id= $admin_user_id;
		$this->detail= $detail;
		$this->module= $module;
		$this->add_time= $add_time;
		$this->table='Fx_admin_logs';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','虚主键(主键，自动增长列)[系统操作日志表]'),"admin_user_id" => array('tinyint', '', 'NO','操作者id'),"detail" => array('mediumtext', '16777215', 'NO','操作记录	记录具体操作url'),"module" => array('varchar', '20', 'NO','操作的模块'),"add_time" => array('int', '', 'NO','操作时间'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $admin_user_id;
	 public $detail;
	 public $module;
	 public $add_time; 
}