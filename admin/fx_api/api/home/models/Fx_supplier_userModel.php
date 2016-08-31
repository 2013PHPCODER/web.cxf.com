<?php
namespace api\home; 
 class Fx_supplier_userModel extends Model{

  	 function __construct($id=null,$user_account=null,$userpwd=null,$leavel=null,$addtime=null,$lastupdatetime=null,$usernick=null,$sex=null,$age=null,$city=null,$mobile=null,$phone=null,$province=null,$register_type=null,$address=null,$idcard=null,$account_status=null,$balance=null,$platform=null,$pay_pwd=null,$email=null,$approve_status=null,$qq=null,$wangwang=null,$approve_user=null,$approve_time=null,$approve_remark=null,$realname=null,$applicant_idcard_img=null,$legal_idcard_img=null,$business_license=null,$receiver_account_type=null,$open_bank_address=null,$receiver_account=null,$receiver_account_name=null,$company_name=null,$applicant_idcard_img_hand=null,$manager_category=null) {
		 
		$this->id= $id;
		$this->user_account= $user_account;
		$this->userpwd= $userpwd;
		$this->leavel= $leavel;
		$this->addtime= $addtime;
		$this->lastupdatetime= $lastupdatetime;
		$this->usernick= $usernick;
		$this->sex= $sex;
		$this->age= $age;
		$this->city= $city;
		$this->mobile= $mobile;
		$this->phone= $phone;
		$this->province= $province;
		$this->register_type= $register_type;
		$this->address= $address;
		$this->idcard= $idcard;
		$this->account_status= $account_status;
		$this->balance= $balance;
		$this->platform= $platform;
		$this->pay_pwd= $pay_pwd;
		$this->email= $email;
		$this->approve_status= $approve_status;
		$this->qq= $qq;
		$this->wangwang= $wangwang;
		$this->approve_user= $approve_user;
		$this->approve_time= $approve_time;
		$this->approve_remark= $approve_remark;
		$this->realname= $realname;
		$this->applicant_idcard_img= $applicant_idcard_img;
		$this->legal_idcard_img= $legal_idcard_img;
		$this->business_license= $business_license;
		$this->receiver_account_type= $receiver_account_type;
		$this->open_bank_address= $open_bank_address;
		$this->receiver_account= $receiver_account;
		$this->receiver_account_name= $receiver_account_name;
		$this->company_name= $company_name;
		$this->applicant_idcard_img_hand= $applicant_idcard_img_hand;
		$this->manager_category= $manager_category;
		$this->table='Fx_supplier_user';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','主键，自动增长列**供货商表**'),"user_account" => array('varchar', '50', 'YES','平台登录名'),"userpwd" => array('char', '60', 'YES','登录密码'),"leavel" => array('int', '', 'YES','供货商等级'),"addtime" => array('datetime', '', 'YES','添加时间'),"lastupdatetime" => array('datetime', '', 'YES','最后修改时间'),"usernick" => array('varchar', '50', 'YES','昵称'),"sex" => array('int', '', 'YES','性别'),"age" => array('int', '', 'YES','年龄'),"city" => array('varchar', '50', 'YES','城市'),"mobile" => array('varchar', '20', 'YES','联系手机'),"phone" => array('varchar', '20', 'YES','联系电话'),"province" => array('varchar', '50', 'YES','省份'),"register_type" => array('tinyint', '', 'NO','注册类型(0 个人 1 企业)'),"address" => array('varchar', '200', 'YES','地址'),"idcard" => array('varchar', '50', 'YES','身份证号或企业资质号'),"account_status" => array('int', '', 'YES','帐号状态(1，禁用 2，正常)'),"balance" => array('decimal', '', 'YES','余额'),"platform" => array('tinyint', '', 'NO','1:星密码,2:创想范'),"pay_pwd" => array('varchar', '50', 'YES','支付密码'),"email" => array('varchar', '50', 'YES','邮箱'),"approve_status" => array('int', '', 'YES','审核状态(1,待审核 2 审核拒绝 3 审核通过)'),"qq" => array('varchar', '50', 'YES','QQ号码'),"wangwang" => array('varchar', '50', 'YES','旺旺号码'),"approve_user" => array('varchar', '50', 'YES','审核人'),"approve_time" => array('datetime', '', 'YES','审核时间'),"approve_remark" => array('varchar', '200', 'YES','审核备注（拒绝原因）'),"realname" => array('varchar', '50', 'YES','真实姓名'),"applicant_idcard_img" => array('varchar', '400', 'YES','申请人身份证正反面图'),"legal_idcard_img" => array('varchar', '400', 'YES','法人身份证正反面图'),"business_license" => array('varchar', '400', 'YES','营业执照'),"receiver_account_type" => array('tinyint', '', 'YES','(收款帐号类型 1，支付宝，2 银行卡 3 微信)'),"open_bank_address" => array('varchar', '100', 'YES','开户行(例:河北大学保定支行)'),"receiver_account" => array('varchar', '255', 'YES','收款帐号'),"receiver_account_name" => array('varchar', '50', 'YES','收款账户名'),"company_name" => array('varchar', '50', 'YES','企业名称'),"applicant_idcard_img_hand" => array('varchar', '255', 'YES','手持身份证'),"manager_category" => array('mediumint', '', 'NO','经营类目'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $user_account;
	 public $userpwd;
	 public $leavel;
	 public $addtime;
	 public $lastupdatetime;
	 public $usernick;
	 public $sex;
	 public $age;
	 public $city;
	 public $mobile;
	 public $phone;
	 public $province;
	 public $register_type;
	 public $address;
	 public $idcard;
	 public $account_status;
	 public $balance;
	 public $platform;
	 public $pay_pwd;
	 public $email;
	 public $approve_status;
	 public $qq;
	 public $wangwang;
	 public $approve_user;
	 public $approve_time;
	 public $approve_remark;
	 public $realname;
	 public $applicant_idcard_img;
	 public $legal_idcard_img;
	 public $business_license;
	 public $receiver_account_type;
	 public $open_bank_address;
	 public $receiver_account;
	 public $receiver_account_name;
	 public $company_name;
	 public $applicant_idcard_img_hand;
	 public $manager_category; 
}