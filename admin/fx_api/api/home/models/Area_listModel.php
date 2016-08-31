<?php
namespace api\home; 
 class Area_listModel extends Model{

  	 function __construct($id=null,$area_name=null,$parent_id=null,$type=null,$zip=null) {
		 
		$this->id= $id;
		$this->area_name= $area_name;
		$this->parent_id= $parent_id;
		$this->type= $type;
		$this->zip= $zip;
		$this->table='Area_list';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','自增主键'),"area_name" => array('varchar', '100', 'NO','地区名称'),"parent_id" => array('int', '', 'NO','父级ID'),"type" => array('int', '', 'NO',''),"zip" => array('int', '', 'NO',''));

	 public $_cxf_num_id='id';
	 public $id;
	 public $area_name;
	 public $parent_id;
	 public $type;
	 public $zip; 
}