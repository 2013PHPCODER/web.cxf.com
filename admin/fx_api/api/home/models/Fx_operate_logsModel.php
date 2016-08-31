<?php
namespace api\home; 
 class Fx_operate_logsModel extends Model{

  	 function __construct($id=null,$user_id=null,$user_name=null,$user_type=null,$detail=null,$module=null,$ip=null,$request=null,$add_time=null,$url=null) {
		 
		$this->id= $id;
		$this->user_id= $user_id;
		$this->user_name= $user_name;
		$this->user_type= $user_type;
		$this->detail= $detail;
		$this->module= $module;
		$this->ip= $ip;
		$this->request= $request;
		$this->add_time= $add_time;
		$this->url= $url;
		$this->table='Fx_operate_logs';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','虚主键(主键，自动增长列)[系统操作日志表]'),"user_id" => array('int', '', 'NO','操作者id'),"user_name" => array('varchar', '50', 'NO','用户账号或昵称'),"user_type" => array('tinyint', '', 'NO','用户类型，1供货商，2后台管理员'),"detail" => array('varchar', '2000', 'NO','操作记录	记录具体操作内容'),"module" => array('varchar', '20', 'NO','操作的模块'),"ip" => array('varchar', '15', 'YES','操作者ip'),"request" => array('varchar', '1000', 'YES','请求数据'),"add_time" => array('int', '', 'NO','操作时间'),"url" => array('varchar', '100', 'YES',''));

	 public $_cxf_num_id='id';
	 public $id;
	 public $user_id;
	 public $user_name;
	 public $user_type;
	 public $detail;
	 public $module;
	 public $ip;
	 public $request;
	 public $add_time;
	 public $url; 
}