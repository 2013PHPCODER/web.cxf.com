<?php
namespace api\home; 
 class System_depotModel extends Model{

  	 function __construct($id=null,$depot_name=null,$receiver_name=null,$area=null,$province=null,$city=null,$receiver_address=null,$receiver_tel=null,$supplier_user_id=null) {
		 
		$this->id= $id;
		$this->depot_name= $depot_name;
		$this->receiver_name= $receiver_name;
		$this->area= $area;
		$this->province= $province;
		$this->city= $city;
		$this->receiver_address= $receiver_address;
		$this->receiver_tel= $receiver_tel;
		$this->supplier_user_id= $supplier_user_id;
		$this->table='System_depot';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','自主增键'),"depot_name" => array('varchar', '100', 'YES','仓库名称'),"receiver_name" => array('varchar', '100', 'NO','姓名'),"area" => array('varchar', '100', 'NO','区域'),"province" => array('varchar', '100', 'NO','省份'),"city" => array('varchar', '100', 'NO','城市'),"receiver_address" => array('varchar', '100', 'NO','地址'),"receiver_tel" => array('varchar', '20', 'NO','电话'),"supplier_user_id" => array('int', '', 'YES','供货商ID'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $depot_name;
	 public $receiver_name;
	 public $area;
	 public $province;
	 public $city;
	 public $receiver_address;
	 public $receiver_tel;
	 public $supplier_user_id; 
}