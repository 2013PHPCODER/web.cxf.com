<?php
namespace api\home; 
 class Fx_supplier_levelModel extends Model{

  	 function __construct($id=null,$level=null,$num=null,$update_user=null,$update_time=null) {
		 
		$this->id= $id;
		$this->level= $level;
		$this->num= $num;
		$this->update_user= $update_user;
		$this->update_time= $update_time;
		$this->table='Fx_supplier_level';
	 }

	 static $init_valid_array = array("id" => array('tinyint', '', 'NO','主键，自动增长列**供货商等级表**'),"level" => array('tinyint', '', 'NO','等级'),"num" => array('smallint', '', 'NO','对应上传商品数量'),"update_user" => array('varchar', '20', 'NO','更新人'),"update_time" => array('int', '', 'NO','更新时间'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $level;
	 public $num;
	 public $update_user;
	 public $update_time; 
}