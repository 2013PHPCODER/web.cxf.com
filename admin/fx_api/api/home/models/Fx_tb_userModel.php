<?php
namespace api\home; 
 class Fx_tb_userModel extends Model{

  	 function __construct($tb_user_id=null,$userid=null,$nick=null,$avatar=null,$status=null,$type=null,$promoted=null,$has_shop=null,$shop_id=null,$has_more_pic=null,$item_img_num=null,$item_img_size=null,$level=null,$score=null,$is_golden_seller=null,$part_send=null,$auto_rate=null,$auto_rate_content=null,$cookie=null,$cookie_expire_time=null,$access_token=null,$refresh_token=null,$expire_time=null,$w2_valid=null,$r2_valid=null,$refresh_token_valid_time=null,$addtime=null,$updatetime=null,$is_agent=null,$site_category=null,$site_instance_id=null,$page_id=null,$prototype_id=null,$widget_id_hd=null,$widget_id_bd=null,$widget_id_ft=null,$default=null) {
		 
		$this->tb_user_id= $tb_user_id;
		$this->userid= $userid;
		$this->nick= $nick;
		$this->avatar= $avatar;
		$this->status= $status;
		$this->type= $type;
		$this->promoted= $promoted;
		$this->has_shop= $has_shop;
		$this->shop_id= $shop_id;
		$this->has_more_pic= $has_more_pic;
		$this->item_img_num= $item_img_num;
		$this->item_img_size= $item_img_size;
		$this->level= $level;
		$this->score= $score;
		$this->is_golden_seller= $is_golden_seller;
		$this->part_send= $part_send;
		$this->auto_rate= $auto_rate;
		$this->auto_rate_content= $auto_rate_content;
		$this->cookie= $cookie;
		$this->cookie_expire_time= $cookie_expire_time;
		$this->access_token= $access_token;
		$this->refresh_token= $refresh_token;
		$this->expire_time= $expire_time;
		$this->w2_valid= $w2_valid;
		$this->r2_valid= $r2_valid;
		$this->refresh_token_valid_time= $refresh_token_valid_time;
		$this->addtime= $addtime;
		$this->updatetime= $updatetime;
		$this->is_agent= $is_agent;
		$this->site_category= $site_category;
		$this->site_instance_id= $site_instance_id;
		$this->page_id= $page_id;
		$this->prototype_id= $prototype_id;
		$this->widget_id_hd= $widget_id_hd;
		$this->widget_id_bd= $widget_id_bd;
		$this->widget_id_ft= $widget_id_ft;
		$this->default= $default;
		$this->table='Fx_tb_user';
	 }

	 static $init_valid_array = array("tb_user_id" => array('bigint', '', 'NO','淘宝用户ID'),"userid" => array('int', '', 'NO','对应平台用户ID'),"nick" => array('varchar', '60', 'NO','淘宝账号昵称'),"avatar" => array('varchar', '255', 'YES','淘宝用户头像地址'),"status" => array('tinyint', '', 'YES','账号状态 0:正常 1:禁用 3:已删除'),"type" => array('varchar', '2', 'YES','用户类型。可选值:B(B商家),C(C商家)'),"promoted" => array('tinyint', '', 'YES','是否实名 0:否 1:是'),"has_shop" => array('tinyint', '', 'YES','是否开店 0:否 1:是'),"shop_id" => array('bigint', '', 'YES','店铺ID'),"has_more_pic" => array('tinyint', '', 'YES','是否购买多图服务 0:否 1:是'),"item_img_num" => array('int', '', 'YES','可上传商品图片数量'),"item_img_size" => array('int', '', 'YES','单张商品图片最大容量(商品主图大小)。单位:k'),"level" => array('int', '', 'YES',''),"score" => array('int', '', 'YES',''),"is_golden_seller" => array('tinyint', '', 'YES','是否是金牌卖家 0:否 1:是'),"part_send" => array('tinyint', '', 'YES','是否部分发货 0:否 1:是'),"auto_rate" => array('tinyint', '', 'YES','是自动评价 0:否 1:是'),"auto_rate_content" => array('varchar', '100', 'YES','自动评价内容'),"cookie" => array('text', '65535', 'YES','淘宝账号cookie'),"cookie_expire_time" => array('bigint', '', 'YES','cookie 过期时间'),"access_token" => array('varchar', '255', 'YES',''),"refresh_token" => array('varchar', '255', 'YES',''),"expire_time" => array('bigint', '', 'YES','Access token 过期时间'),"w2_valid" => array('bigint', '', 'YES','w2级别API访问过期时间'),"r2_valid" => array('bigint', '', 'YES','r2级别API访问过期时间'),"refresh_token_valid_time" => array('bigint', '', 'YES','Refresh token 过期时间'),"addtime" => array('datetime', '', 'YES','添加时间'),"updatetime" => array('datetime', '', 'YES','最后更新时间'),"is_agent" => array('tinyint', '', 'YES','是否托管 0:否 1:是'),"site_category" => array('tinyint', '', 'YES','店铺版本(1:基础版,2:专业版)'),"site_instance_id" => array('bigint', '', 'YES',''),"page_id" => array('bigint', '', 'YES',''),"prototype_id" => array('int', '', 'YES',''),"widget_id_hd" => array('bigint', '', 'YES',''),"widget_id_bd" => array('bigint', '', 'YES',''),"widget_id_ft" => array('bigint', '', 'YES',''),"default" => array('tinyint', '', 'YES','是否默认店铺 0:否 1:是'));

	 public $_cxf_num_id='tb_user_id';
	 public $tb_user_id;
	 public $userid;
	 public $nick;
	 public $avatar;
	 public $status;
	 public $type;
	 public $promoted;
	 public $has_shop;
	 public $shop_id;
	 public $has_more_pic;
	 public $item_img_num;
	 public $item_img_size;
	 public $level;
	 public $score;
	 public $is_golden_seller;
	 public $part_send;
	 public $auto_rate;
	 public $auto_rate_content;
	 public $cookie;
	 public $cookie_expire_time;
	 public $access_token;
	 public $refresh_token;
	 public $expire_time;
	 public $w2_valid;
	 public $r2_valid;
	 public $refresh_token_valid_time;
	 public $addtime;
	 public $updatetime;
	 public $is_agent;
	 public $site_category;
	 public $site_instance_id;
	 public $page_id;
	 public $prototype_id;
	 public $widget_id_hd;
	 public $widget_id_bd;
	 public $widget_id_ft;
	 public $default; 
}