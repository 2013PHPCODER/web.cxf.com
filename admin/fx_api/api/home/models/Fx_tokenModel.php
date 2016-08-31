<?php
namespace api\home; 
 class Fx_tokenModel extends Model{

  	 function __construct($id=null,$user_id=null,$type=null,$access_token=null,$refresh_token=null,$create_access_time=null,$create_refresh_time=null,$use_refresh_time=null) {
		 
		$this->id= $id;
		$this->user_id= $user_id;
		$this->type= $type;
		$this->access_token= $access_token;
		$this->refresh_token= $refresh_token;
		$this->create_access_time= $create_access_time;
		$this->create_refresh_time= $create_refresh_time;
		$this->use_refresh_time= $use_refresh_time;
		$this->table='Fx_token';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO',''),"user_id" => array('int', '', 'NO',''),"type" => array('tinyint', '', 'NO','1用户，2商家，3管理'),"access_token" => array('char', '32', 'NO',''),"refresh_token" => array('char', '32', 'NO',''),"create_access_time" => array('int', '', 'NO',''),"create_refresh_time" => array('int', '', 'NO',''),"use_refresh_time" => array('int', '', 'NO',''));

	 public $_cxf_num_id='id';
	 public $id;
	 public $user_id;
	 public $type;
	 public $access_token;
	 public $refresh_token;
	 public $create_access_time;
	 public $create_refresh_time;
	 public $use_refresh_time; 
}