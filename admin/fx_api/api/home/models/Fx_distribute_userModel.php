<?php
namespace api\home; 
 class Fx_distribute_userModel extends Model{

  	 function __construct($id=null,$user_account=null,$userpwd=null,$reg_type=null,$account_status=null,$leavel=null,$addtime=null,$lastupdatetime=null,$last_login_time=null,$usernick=null,$sex=null,$age=null,$province=null,$city=null,$area=null,$address=null,$mobile=null,$phone=null,$email=null,$qq=null,$wangwang=null,$source=null,$idcard=null,$realname=null,$receiver_account=null,$receiver_account_type=null,$open_bank_address=null,$balance=null,$parent_id=null,$acting_account=null,$receiver_account_name=null,$pay_pwd=null) {
		 
		$this->id= $id;
		$this->user_account= $user_account;
		$this->userpwd= $userpwd;
		$this->reg_type= $reg_type;
		$this->account_status= $account_status;
		$this->leavel= $leavel;
		$this->addtime= $addtime;
		$this->lastupdatetime= $lastupdatetime;
		$this->last_login_time= $last_login_time;
		$this->usernick= $usernick;
		$this->sex= $sex;
		$this->age= $age;
		$this->province= $province;
		$this->city= $city;
		$this->area= $area;
		$this->address= $address;
		$this->mobile= $mobile;
		$this->phone= $phone;
		$this->email= $email;
		$this->qq= $qq;
		$this->wangwang= $wangwang;
		$this->source= $source;
		$this->idcard= $idcard;
		$this->realname= $realname;
		$this->receiver_account= $receiver_account;
		$this->receiver_account_type= $receiver_account_type;
		$this->open_bank_address= $open_bank_address;
		$this->balance= $balance;
		$this->parent_id= $parent_id;
		$this->acting_account= $acting_account;
		$this->receiver_account_name= $receiver_account_name;
		$this->pay_pwd= $pay_pwd;
		$this->table='Fx_distribute_user';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','主键，自动增长列'),"user_account" => array('varchar', '100', 'NO','平台登录名'),"userpwd" => array('char', '60', 'NO','登录密码'),"reg_type" => array('tinyint', '', 'NO','1手机注册2邮箱注册'),"account_status" => array('tinyint', '', 'NO','帐号状态(1,禁用 ;2,正常,3:未开通-冻结)'),"leavel" => array('int', '', 'NO','分销商等级'),"addtime" => array('datetime', '', 'NO','添加注册时间'),"lastupdatetime" => array('datetime', '', 'YES','最后修改时间'),"last_login_time" => array('int', '', 'YES','最后登录时间'),"usernick" => array('varchar', '100', 'YES','昵称'),"sex" => array('int', '', 'YES','1，男 0，女'),"age" => array('int', '', 'YES','年龄'),"province" => array('varchar', '50', 'YES','省份'),"city" => array('varchar', '50', 'YES','市'),"area" => array('varchar', '100', 'YES','区'),"address" => array('varchar', '200', 'YES','地址'),"mobile" => array('varchar', '20', 'YES','联系手机'),"phone" => array('varchar', '20', 'YES','联系电话'),"email" => array('varchar', '50', 'YES','邮箱地址'),"qq" => array('varchar', '50', 'YES','qq号码'),"wangwang" => array('varchar', '50', 'YES','旺旺号码'),"source" => array('varchar', '50', 'YES','分销商来源（1，星密码 2，创想范 3，代理商）'),"idcard" => array('varchar', '50', 'YES','身份证号'),"realname" => array('varchar', '50', 'YES','真实姓名'),"receiver_account" => array('varchar', '50', 'YES','收款帐号'),"receiver_account_type" => array('int', '', 'YES','(收款帐号类型 1，支付宝，2 银行卡 3 维信)'),"open_bank_address" => array('varchar', '100', 'YES','开户行地址'),"balance" => array('decimal', '', 'YES','余额'),"parent_id" => array('int', '', 'YES','非0 父级代理商id；0自己购买'),"acting_account" => array('varchar', '50', 'YES','代理商账号'),"receiver_account_name" => array('varchar', '50', 'YES','收款账户名'),"pay_pwd" => array('char', '60', 'YES','支付密码'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $user_account;
	 public $userpwd;
	 public $reg_type;
	 public $account_status;
	 public $leavel;
	 public $addtime;
	 public $lastupdatetime;
	 public $last_login_time;
	 public $usernick;
	 public $sex;
	 public $age;
	 public $province;
	 public $city;
	 public $area;
	 public $address;
	 public $mobile;
	 public $phone;
	 public $email;
	 public $qq;
	 public $wangwang;
	 public $source;
	 public $idcard;
	 public $realname;
	 public $receiver_account;
	 public $receiver_account_type;
	 public $open_bank_address;
	 public $balance;
	 public $parent_id;
	 public $acting_account;
	 public $receiver_account_name;
	 public $pay_pwd; 
}