<?php
namespace api\home; 
 class Taobao_authorizeModel extends Model{

  	 function __construct($id=null,$user_id=null,$taobao_user_nick=null,$access_token=null,$expires_in=null,$return_data=null,$re_expires_in=null,$expire_time=null,$r1_expires_in=null,$w2_valid=null,$w2_expires_in=null,$taobao_user_id=null,$w1_expires_in=null,$r1_valid=null,$r2_valid=null,$w1_valid=null,$r2_expires_in=null,$token_type=null,$refresh_token=null,$refresh_token_valid_time=null,$raw=null) {
		 
		$this->id= $id;
		$this->user_id= $user_id;
		$this->taobao_user_nick= $taobao_user_nick;
		$this->access_token= $access_token;
		$this->expires_in= $expires_in;
		$this->return_data= $return_data;
		$this->re_expires_in= $re_expires_in;
		$this->expire_time= $expire_time;
		$this->r1_expires_in= $r1_expires_in;
		$this->w2_valid= $w2_valid;
		$this->w2_expires_in= $w2_expires_in;
		$this->taobao_user_id= $taobao_user_id;
		$this->w1_expires_in= $w1_expires_in;
		$this->r1_valid= $r1_valid;
		$this->r2_valid= $r2_valid;
		$this->w1_valid= $w1_valid;
		$this->r2_expires_in= $r2_expires_in;
		$this->token_type= $token_type;
		$this->refresh_token= $refresh_token;
		$this->refresh_token_valid_time= $refresh_token_valid_time;
		$this->raw= $raw;
		$this->table='Taobao_authorize';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO',''),"user_id" => array('varchar', '50', 'NO','系统登录用户'),"taobao_user_nick" => array('varchar', '50', 'NO','淘宝帐户'),"access_token" => array('varchar', '255', 'NO','Access token'),"expires_in" => array('int', '', 'NO','Access token过期时间'),"return_data" => array('text', '65535', 'NO','序列化返回所有数据'),"re_expires_in" => array('int', '', 'NO','Refresh token过期时间'),"expire_time" => array('bigint', '', 'NO','Access token过期时间'),"r1_expires_in" => array('bigint', '', 'NO','r1级别API或字段的访问过期时间；'),"w2_valid" => array('varchar', '13', 'NO','w2级别API或字段的访问过期时间；'),"w2_expires_in" => array('bigint', '', 'NO','淘宝帐号对应id'),"taobao_user_id" => array('bigint', '', 'NO','淘宝帐号对应id'),"w1_expires_in" => array('int', '', 'NO',''),"r1_valid" => array('bigint', '', 'NO',''),"r2_valid" => array('bigint', '', 'NO',''),"w1_valid" => array('bigint', '', 'NO',''),"r2_expires_in" => array('bigint', '', 'NO',''),"token_type" => array('varchar', '20', 'NO',''),"refresh_token" => array('varchar', '100', 'NO',''),"refresh_token_valid_time" => array('bigint', '', 'NO',''),"raw" => array('varchar', '100', 'NO',''));

	 public $_cxf_num_id='id';
	 public $id;
	 public $user_id;
	 public $taobao_user_nick;
	 public $access_token;
	 public $expires_in;
	 public $return_data;
	 public $re_expires_in;
	 public $expire_time;
	 public $r1_expires_in;
	 public $w2_valid;
	 public $w2_expires_in;
	 public $taobao_user_id;
	 public $w1_expires_in;
	 public $r1_valid;
	 public $r2_valid;
	 public $w1_valid;
	 public $r2_expires_in;
	 public $token_type;
	 public $refresh_token;
	 public $refresh_token_valid_time;
	 public $raw; 
}