<?php
namespace api\home; 
 class Fx_admin_userModel extends Model{

  	 function __construct($admin_user_id=null,$account=null,$name=null,$pwd=null,$auth=null,$add_time=null,$update_time=null,$status=null) {
		 
		$this->admin_user_id= $admin_user_id;
		$this->account= $account;
		$this->name= $name;
		$this->pwd= $pwd;
		$this->auth= $auth;
		$this->add_time= $add_time;
		$this->update_time= $update_time;
		$this->status= $status;
		$this->table='Fx_admin_user';
	 }

	 static $init_valid_array = array("admin_user_id" => array('smallint', '', 'NO','unsigned smallint  自增主键[后台管理员表]	'),"account" => array('varchar', '50', 'NO',''),"name" => array('varchar', '20', 'NO',''),"pwd" => array('char', '60', 'NO',''),"auth" => array('mediumtext', '16777215', 'NO','权限内容'),"add_time" => array('int', '', 'NO',''),"update_time" => array('tinyint', '', 'NO','更新时间'),"status" => array('tinyint', '', 'NO',''));

	 public $_cxf_num_id='admin_user_id';
	 public $admin_user_id;
	 public $account;
	 public $name;
	 public $pwd;
	 public $auth;
	 public $add_time;
	 public $update_time;
	 public $status; 
}