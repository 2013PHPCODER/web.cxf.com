<?php
namespace api\home; 
 class Cus_order_goods_imgModel extends Model{

  	 function __construct($id=null,$cus_id=null,$img_path=null) {
		 
		$this->id= $id;
		$this->cus_id= $cus_id;
		$this->img_path= $img_path;
		$this->table='Cus_order_goods_img';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO',''),"cus_id" => array('int', '', 'NO','退货单ID'),"img_path" => array('varchar', '150', 'NO','凭证地址'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $cus_id;
	 public $img_path; 
}