<?php
namespace api\home; 
 class Goods_img_pathModel extends Model{

  	 function __construct($md5_path=null,$upyun_path=null,$tb_path=null) {
		 
		$this->md5_path= $md5_path;
		$this->upyun_path= $upyun_path;
		$this->tb_path= $tb_path;
		$this->table='Goods_img_path';
	 }

	 static $init_valid_array = array("md5_path" => array('varchar', '100', 'NO','淘宝数据md5值'),"upyun_path" => array('varchar', '255', 'YES','upyun上面图片地址'),"tb_path" => array('varchar', '255', 'YES','淘宝空间图片地址'));

	 public $_cxf_num_id='md5_path';
	 public $md5_path;
	 public $upyun_path;
	 public $tb_path; 
}