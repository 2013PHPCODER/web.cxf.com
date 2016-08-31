<?php
namespace api\home; 
 class Fx_distribute_levelModel extends Model{

  	 function __construct($id=null,$level=null,$price=null,$update_user=null,$update_time=null) {
		 
		$this->id= $id;
		$this->level= $level;
		$this->price= $price;
		$this->update_user= $update_user;
		$this->update_time= $update_time;
		$this->table='Fx_distribute_level';
	 }

	 static $init_valid_array = array("id" => array('tinyint', '', 'NO','主键，自动增长列**分销商等级表**'),"level" => array('tinyint', '', 'NO','分销等级'),"price" => array('decimal', '', 'NO','对应价格'),"update_user" => array('varchar', '20', 'NO','更新人'),"update_time" => array('int', '', 'NO','更新时间'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $level;
	 public $price;
	 public $update_user;
	 public $update_time; 
}