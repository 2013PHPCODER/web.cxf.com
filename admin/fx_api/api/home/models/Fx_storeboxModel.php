<?php
namespace api\home; 
 class Fx_storeboxModel extends Model{

  	 function __construct($id=null,$name=null,$address=null,$mobile=null,$leader=null,$addtime=null,$adduser=null,$freight_template_id=null) {
		 
		$this->id= $id;
		$this->name= $name;
		$this->address= $address;
		$this->mobile= $mobile;
		$this->leader= $leader;
		$this->addtime= $addtime;
		$this->adduser= $adduser;
		$this->freight_template_id= $freight_template_id;
		$this->table='Fx_storebox';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','主键，自动增长列**仓库表**'),"name" => array('varchar', '100', 'YES','仓库名称'),"address" => array('varchar', '200', 'YES','仓库地址'),"mobile" => array('varchar', '20', 'YES','联系电话'),"leader" => array('varchar', '20', 'YES','负责人'),"addtime" => array('datetime', '', 'YES','创建时间'),"adduser" => array('varchar', '50', 'YES','创建人'),"freight_template_id" => array('int', '', 'YES','运费模版id'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $name;
	 public $address;
	 public $mobile;
	 public $leader;
	 public $addtime;
	 public $adduser;
	 public $freight_template_id; 
}