<?php
namespace api\home; 
 class Fx_freight_template_specialModel extends Model{

  	 function __construct($id=null,$freight_template_id=null,$area=null,$name=null,$start_heavy=null,$continue_heavy=null,$start_freight=null,$continue_freight=null) {
		 
		$this->id= $id;
		$this->freight_template_id= $freight_template_id;
		$this->area= $area;
		$this->name= $name;
		$this->start_heavy= $start_heavy;
		$this->continue_heavy= $continue_heavy;
		$this->start_freight= $start_freight;
		$this->continue_freight= $continue_freight;
		$this->table='Fx_freight_template_special';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','主键，自动增长列**运费模板特例表**'),"freight_template_id" => array('int', '', 'NO','freight_template的外键'),"area" => array('mediumint', '', 'NO','行政区域编码，采用国家标准'),"name" => array('varchar', '20', 'NO','行政区域名称 默认北京'),"start_heavy" => array('smallint', '', 'NO','每单位首重'),"continue_heavy" => array('smallint', '', 'NO','每单位续重'),"start_freight" => array('decimal', '', 'NO','单位首重费用'),"continue_freight" => array('decimal', '', 'NO','每单位续重的费用'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $freight_template_id;
	 public $area;
	 public $name;
	 public $start_heavy;
	 public $continue_heavy;
	 public $start_freight;
	 public $continue_freight; 
}