<?php
namespace api\home; 
 class Fx_search_counterModel extends Model{

  	 function __construct($max_id=null,$search_type=null) {
		 
		$this->max_id= $max_id;
		$this->search_type= $search_type;
		$this->table='Fx_search_counter';
	 }

	 static $init_valid_array = array("max_id" => array('int', '', 'NO','最大id值，'),"search_type" => array('tinyint', '', 'NO','搜索类型，1商品'));

	 public $max_id;
	 public $search_type; 
}