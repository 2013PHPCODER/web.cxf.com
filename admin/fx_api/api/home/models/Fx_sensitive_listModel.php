<?php
namespace api\home; 
 class Fx_sensitive_listModel extends Model{

  	 function __construct($id=null,$sensitive=null,$admin=null,$type=null,$datetime=null,$status=null) {
		 
		$this->id= $id;
		$this->sensitive= $sensitive;
		$this->admin= $admin;
		$this->type= $type;
		$this->datetime= $datetime;
		$this->status= $status;
		$this->table='Fx_sensitive_list';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','敏感词ID--**敏感词表**'),"sensitive" => array('varchar', '20', 'NO','敏感词(20个字符限制)'),"admin" => array('int', '', 'NO','后台操作人'),"type" => array('varchar', '20', 'NO','敏感词类型'),"datetime" => array('int', '', 'NO','添加时间'),"status" => array('tinyint', '', 'NO','默认开始'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $sensitive;
	 public $admin;
	 public $type;
	 public $datetime;
	 public $status; 
}