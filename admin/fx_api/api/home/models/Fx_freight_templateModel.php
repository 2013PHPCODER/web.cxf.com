<?php
namespace api\home; 
 class Fx_freight_templateModel extends Model{

  	 function __construct($freight_template_id=null,$supplier_user_id=null,$freight_no=null,$name=null,$is_free=null,$start_heavy=null,$continue_heavy=null,$start_freight=null,$continue_freight=null,$description=null,$add_time=null,$update_time=null,$status=null) {
		 
		$this->freight_template_id= $freight_template_id;
		$this->supplier_user_id= $supplier_user_id;
		$this->freight_no= $freight_no;
		$this->name= $name;
		$this->is_free= $is_free;
		$this->start_heavy= $start_heavy;
		$this->continue_heavy= $continue_heavy;
		$this->start_freight= $start_freight;
		$this->continue_freight= $continue_freight;
		$this->description= $description;
		$this->add_time= $add_time;
		$this->update_time= $update_time;
		$this->status= $status;
		$this->table='Fx_freight_template';
	 }

	 static $init_valid_array = array("freight_template_id" => array('int', '', 'NO','主键，自动增长列**运费模板表**'),"supplier_user_id" => array('int', '', 'NO','隶属于的供应商id'),"freight_no" => array('tinyint', '', 'NO','运费模板编号，可用于排序'),"name" => array('varchar', '20', 'NO','仓库名'),"is_free" => array('tinyint', '', 'NO','是否包邮，0否1是'),"start_heavy" => array('smallint', '', 'YES','每单位首重'),"continue_heavy" => array('smallint', '', 'YES','每单位续重'),"start_freight" => array('decimal', '', 'YES','单位首重费用'),"continue_freight" => array('decimal', '', 'YES','每单位续重的费用'),"description" => array('varchar', '255', 'YES','模板描述'),"add_time" => array('int', '', 'NO','添加时间'),"update_time" => array('int', '', 'NO','更新时间'),"status" => array('tinyint', '', 'NO','模板状态，0不可用，1可用'));

	 public $_cxf_num_id='freight_template_id';
	 public $freight_template_id;
	 public $supplier_user_id;
	 public $freight_no;
	 public $name;
	 public $is_free;
	 public $start_heavy;
	 public $continue_heavy;
	 public $start_freight;
	 public $continue_freight;
	 public $description;
	 public $add_time;
	 public $update_time;
	 public $status; 
}