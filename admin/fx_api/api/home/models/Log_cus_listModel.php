<?php
namespace api\home; 
 class Log_cus_listModel extends Model{

  	 function __construct($id=null,$user_id=null,$goods_id=null,$log_info=null,$sku_comb_id=null,$ip_address=null,$start_num=null,$end_num=null,$addtime=null) {
		 
		$this->id= $id;
		$this->user_id= $user_id;
		$this->goods_id= $goods_id;
		$this->log_info= $log_info;
		$this->sku_comb_id= $sku_comb_id;
		$this->ip_address= $ip_address;
		$this->start_num= $start_num;
		$this->end_num= $end_num;
		$this->addtime= $addtime;
		$this->table='Log_cus_list';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','自增主键'),"user_id" => array('varchar', '50', 'NO','用户ID'),"goods_id" => array('int', '', 'NO','商品ID'),"log_info" => array('varchar', '255', 'NO','日志信息'),"sku_comb_id" => array('int', '', 'NO','SKU组合ID'),"ip_address" => array('varchar', '20', 'NO','IP地址'),"start_num" => array('int', '', 'NO','修改前库存'),"end_num" => array('int', '', 'NO','修改后库存'),"addtime" => array('int', '', 'NO','生成时间'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $user_id;
	 public $goods_id;
	 public $log_info;
	 public $sku_comb_id;
	 public $ip_address;
	 public $start_num;
	 public $end_num;
	 public $addtime; 
}