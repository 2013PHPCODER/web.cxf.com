<?php
namespace api\home; 
 class Fx_verifyModel extends Model{

  	 function __construct($id=null,$code=null,$target=null,$mobile=null,$email=null,$wrong_times=null,$add_time=null,$update_time=null,$status=null) {
		 
		$this->id= $id;
		$this->code= $code;
		$this->target= $target;
		$this->mobile= $mobile;
		$this->email= $email;
		$this->wrong_times= $wrong_times;
		$this->add_time= $add_time;
		$this->update_time= $update_time;
		$this->status= $status;
		$this->table='Fx_verify';
	 }

	 static $init_valid_array = array("id" => array('mediumint', '', 'NO',''),"code" => array('varchar', '20', 'NO','验证码'),"target" => array('varchar', '100', 'NO','发送验证码的目标位置，用来约束验证码有效范围，默认为注册'),"mobile" => array('bigint', '', 'NO','手机号码'),"email" => array('varchar', '100', 'NO','邮箱'),"wrong_times" => array('tinyint', '', 'NO','验证码错误次数，用于失效验证码'),"add_time" => array('int', '', 'NO','验证码生成时间'),"update_time" => array('int', '', 'NO','更新时间，用于判断验证码上一次输错时间，或下一次可调用时间'),"status" => array('tinyint', '', 'NO','验证码是否可用，1可用，0不可用'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $code;
	 public $target;
	 public $mobile;
	 public $email;
	 public $wrong_times;
	 public $add_time;
	 public $update_time;
	 public $status; 
}