<?php
namespace api\home; 
 class Goods_art_noModel extends Model{

  	 function __construct($id=null,$goods_id=null,$art_no=null,$addtime=null) {
		 
		$this->id= $id;
		$this->goods_id= $goods_id;
		$this->art_no= $art_no;
		$this->addtime= $addtime;
		$this->table='Goods_art_no';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','自增主键'),"goods_id" => array('int', '', 'NO','商品ID'),"art_no" => array('varchar', '100', 'NO','货号'),"addtime" => array('int', '', 'NO','添加时间'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $goods_id;
	 public $art_no;
	 public $addtime; 
}