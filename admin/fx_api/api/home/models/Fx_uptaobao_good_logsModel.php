<?php
namespace api\home; 
 class Fx_uptaobao_good_logsModel extends Model{

  	 function __construct($id=null,$user_id=null,$goods_id=null,$user_account=null,$goods_name=null,$price=null,$is_success=null,$tb_nick=null,$addtime=null,$fail_msg=null) {
		 
		$this->id= $id;
		$this->user_id= $user_id;
		$this->goods_id= $goods_id;
		$this->user_account= $user_account;
		$this->goods_name= $goods_name;
		$this->price= $price;
		$this->is_success= $is_success;
		$this->tb_nick= $tb_nick;
		$this->addtime= $addtime;
		$this->fail_msg= $fail_msg;
		$this->table='Fx_uptaobao_good_logs';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO',' --主键，自动增长列 **铺货日志记录表**'),"user_id" => array('int', '', 'NO','用户id'),"goods_id" => array('int', '', 'NO','[铺货商品id]'),"user_account" => array('varchar', '50', 'YES','[可加字段，方便读取]'),"goods_name" => array('varchar', '100', 'YES','商品标题[可加字段，方便读取]'),"price" => array('decimal', '', 'YES','商品价格（可加字段）'),"is_success" => array('int', '', 'YES','是否成功(0,成功 1 ，失败)'),"tb_nick" => array('varchar', '50', 'YES','店铺昵称'),"addtime" => array('bigint', '', 'YES','添加时间'),"fail_msg" => array('varchar', '255', 'YES','铺货失败原因'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $user_id;
	 public $goods_id;
	 public $user_account;
	 public $goods_name;
	 public $price;
	 public $is_success;
	 public $tb_nick;
	 public $addtime;
	 public $fail_msg; 
}