<?php
namespace api\home; 
 class Fx_goods_collectModel extends Model{

  	 function __construct($id=null,$user_id=null,$goods_id=null,$addtime=null,$is_up_taobao=null) {
		 
		$this->id= $id;
		$this->user_id= $user_id;
		$this->goods_id= $goods_id;
		$this->addtime= $addtime;
		$this->is_up_taobao= $is_up_taobao;
		$this->table='Fx_goods_collect';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','自增主键[分销中心，收藏表]'),"user_id" => array('int', '', 'NO','用户id'),"goods_id" => array('int', '', 'NO','商品id'),"addtime" => array('datetime', '', 'NO','添加时间'),"is_up_taobao" => array('tinyint', '', 'YES','1已上传到淘宝，2未上传'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $user_id;
	 public $goods_id;
	 public $addtime;
	 public $is_up_taobao; 
}