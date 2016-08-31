<?php
namespace api\home; 
 class System_shop_bModel extends Model{

  	 function __construct($id=null,$shop_id=null,$shop_name=null) {
		 
		$this->id= $id;
		$this->shop_id= $shop_id;
		$this->shop_name= $shop_name;
		$this->table='System_shop_b';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','自增主键'),"shop_id" => array('int', '', 'NO','平台ID'),"shop_name" => array('varchar', '50', 'NO','平台名称'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $shop_id;
	 public $shop_name; 
}