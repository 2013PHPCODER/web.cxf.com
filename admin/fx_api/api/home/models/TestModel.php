<?php
namespace api\home; 
 class TestModel extends Model{

  	 function __construct($test_id=null,$text=null,$content=null,$sex=null) {
		 
		$this->test_id= $test_id;
		$this->text= $text;
		$this->content= $content;
		$this->sex= $sex;
		$this->table='Test';
	 }

	 static $init_valid_array = array("test_id" => array('int', '', 'NO',''),"text" => array('text', '65535', 'NO',''),"content" => array('varchar', '50', 'YES',''),"sex" => array('int', '', 'YES',''));

	 public $_cxf_num_id='test_id';
	 public $test_id;
	 public $text;
	 public $content;
	 public $sex; 
}