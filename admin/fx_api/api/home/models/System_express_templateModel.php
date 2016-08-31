<?php
namespace api\home; 
 class System_express_templateModel extends Model{

  	 function __construct($id=null,$express_code=null,$template=null) {
		 
		$this->id= $id;
		$this->express_code= $express_code;
		$this->template= $template;
		$this->table='System_express_template';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO',''),"express_code" => array('varchar', '50', 'NO','物流公司code'),"template" => array('text', '65535', 'NO',''));

	 public $_cxf_num_id='id';
	 public $id;
	 public $express_code;
	 public $template; 
}