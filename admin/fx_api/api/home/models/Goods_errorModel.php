<?php
namespace api\home; 
 class Goods_errorModel extends Model{

  	 function __construct($id=null,$goods_id=null,$user_name=null,$goods_lack_momo=null,$addtime=null) {
		 
		$this->id= $id;
		$this->goods_id= $goods_id;
		$this->user_name= $user_name;
		$this->goods_lack_momo= $goods_lack_momo;
		$this->addtime= $addtime;
		$this->table='Goods_error';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO',''),"goods_id" => array('int', '', 'NO','商器ＩＤ'),"user_name" => array('varchar', '50', 'NO','姓名'),"goods_lack_momo" => array('text', '65535', 'NO','商品信息缺失内容'),"addtime" => array('int', '', 'NO','添加时间'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $goods_id;
	 public $user_name;
	 public $goods_lack_momo;
	 public $addtime; 
}