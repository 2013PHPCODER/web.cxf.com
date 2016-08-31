<?php
namespace api\home; 
 class Fx_track_logModel extends Model{

  	 function __construct($id=null,$module=null,$content=null,$log_user=null,$log_time=null) {
		 
		$this->id= $id;
		$this->module= $module;
		$this->content= $content;
		$this->log_user= $log_user;
		$this->log_time= $log_time;
		$this->table='Fx_track_log';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','主键，自动增长列(**系统使用日志表**)'),"module" => array('int', '', 'YES','操作模块(1，商品，2，订单，3，仓储，4，系统，5，售后，6，用户)'),"content" => array('varchar', '500', 'YES','操作日志内容'),"log_user" => array('varchar', '50', 'YES','操作人'),"log_time" => array('datetime', '', 'YES','操作时间'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $module;
	 public $content;
	 public $log_user;
	 public $log_time; 
}