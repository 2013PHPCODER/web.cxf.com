<?php
namespace api\home; 
 class Order_contactModel extends Model{

  	 function __construct($id=null,$order_id=null,$tel=null,$contact_name=null,$contact_address=null,$zip_code=null,$addtime=null,$province=null,$city=null,$dist=null) {
		 
		$this->id= $id;
		$this->order_id= $order_id;
		$this->tel= $tel;
		$this->contact_name= $contact_name;
		$this->contact_address= $contact_address;
		$this->zip_code= $zip_code;
		$this->addtime= $addtime;
		$this->province= $province;
		$this->city= $city;
		$this->dist= $dist;
		$this->table='Order_contact';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','自增主键'),"order_id" => array('int', '', 'NO','订单id'),"tel" => array('varchar', '30', 'NO','电话:座机,手机号'),"contact_name" => array('varchar', '30', 'NO','联系人姓名'),"contact_address" => array('varchar', '255', 'NO','联系人地址'),"zip_code" => array('int', '', 'NO','邮编'),"addtime" => array('int', '', 'NO','生成时间'),"province" => array('varchar', '100', 'NO','省/直辖市名称'),"city" => array('varchar', '100', 'NO','地级市名称'),"dist" => array('varchar', '100', 'NO','县、县级市、区名称'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $order_id;
	 public $tel;
	 public $contact_name;
	 public $contact_address;
	 public $zip_code;
	 public $addtime;
	 public $province;
	 public $city;
	 public $dist; 
}