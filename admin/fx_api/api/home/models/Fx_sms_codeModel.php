<?php
namespace api\home; 
 class Fx_sms_codeModel extends Model{

  	 function __construct($id=null,$mobile=null,$content=null,$addtime=null,$type=null,$user_id=null,$status=null) {
		 
		$this->id= $id;
		$this->mobile= $mobile;
		$this->content= $content;
		$this->addtime= $addtime;
		$this->type= $type;
		$this->user_id= $user_id;
		$this->status= $status;
		$this->table='Fx_sms_code';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','主键id'),"mobile" => array('varchar', '20', 'NO','手机号'),"content" => array('varchar', '50', 'NO','内容'),"addtime" => array('int', '', 'NO','获取时间'),"type" => array('tinyint', '', 'NO','调用角色（1.供货商；2.平台；3.分销商）'),"user_id" => array('int', '', 'NO','使用者id'),"status" => array('tinyint', '', 'NO','使用为-1未使用为1'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $mobile;
	 public $content;
	 public $addtime;
	 public $type;
	 public $user_id;
	 public $status; 
}