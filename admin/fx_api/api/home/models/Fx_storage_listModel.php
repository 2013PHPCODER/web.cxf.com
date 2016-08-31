<?php
namespace api\home; 
 class Fx_storage_listModel extends Model{

  	 function __construct($id=null,$supplier_user_id=null,$sname=null,$province=null,$city=null,$area=null,$address=null,$mobile=null,$functionary=null,$freight=null) {
		 
		$this->id= $id;
		$this->supplier_user_id= $supplier_user_id;
		$this->sname= $sname;
		$this->province= $province;
		$this->city= $city;
		$this->area= $area;
		$this->address= $address;
		$this->mobile= $mobile;
		$this->functionary= $functionary;
		$this->freight= $freight;
		$this->table='Fx_storage_list';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','仓库ID,主键，自动增长列**仓库表**'),"supplier_user_id" => array('int', '', 'NO','用户的UID'),"sname" => array('varchar', '30', 'NO','仓库名称'),"province" => array('varchar', '8', 'NO','省'),"city" => array('varchar', '20', 'NO','市'),"area" => array('varchar', '20', 'NO','区/县'),"address" => array('varchar', '100', 'NO','地址(可以不填省市区）'),"mobile" => array('char', '11', 'NO','用户手机'),"functionary" => array('varchar', '30', 'NO','负责人'),"freight" => array('int', '', 'NO','运费模板'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $supplier_user_id;
	 public $sname;
	 public $province;
	 public $city;
	 public $area;
	 public $address;
	 public $mobile;
	 public $functionary;
	 public $freight; 
}