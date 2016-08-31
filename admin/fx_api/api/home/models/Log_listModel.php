<?php
namespace api\home; 
 class Log_listModel extends Model{

  	 function __construct($id=null,$log_info=null,$handle_info=null,$user_id=null,$cid=null,$pid=null,$ip_address=null,$addtime=null) {
		 
		$this->id= $id;
		$this->log_info= $log_info;
		$this->handle_info= $handle_info;
		$this->user_id= $user_id;
		$this->cid= $cid;
		$this->pid= $pid;
		$this->ip_address= $ip_address;
		$this->addtime= $addtime;
		$this->table='Log_list';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','自增主键'),"log_info" => array('varchar', '255', 'NO','系统备注'),"handle_info" => array('varchar', '50', 'NO','操作说明'),"user_id" => array('varchar', '50', 'NO','用户ID'),"cid" => array('tinyint', '', 'NO','分类ID：1=订单,2=售后,3=库存,4=操作,5=虚拟订单'),"pid" => array('int', '', 'NO','被记录对像的ＩＤ'),"ip_address" => array('varchar', '20', 'NO','IP地址'),"addtime" => array('int', '', 'NO','生成时间'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $log_info;
	 public $handle_info;
	 public $user_id;
	 public $cid;
	 public $pid;
	 public $ip_address;
	 public $addtime; 
}