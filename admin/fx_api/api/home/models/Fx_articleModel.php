<?php
namespace api\home; 
 class Fx_articleModel extends Model{

  	 function __construct($id=null,$title=null,$content=null,$addtime=null,$adduser=null,$click_num=null,$show_platform=null,$show_order=null,$show_status=null) {
		 
		$this->id= $id;
		$this->title= $title;
		$this->content= $content;
		$this->addtime= $addtime;
		$this->adduser= $adduser;
		$this->click_num= $click_num;
		$this->show_platform= $show_platform;
		$this->show_order= $show_order;
		$this->show_status= $show_status;
		$this->table='Fx_article';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','主键，自动增长列[文章表]'),"title" => array('varchar', '200', 'YES','文章标题'),"content" => array('text', '65535', 'YES','文章内容'),"addtime" => array('datetime', '', 'YES','添加时间'),"adduser" => array('varchar', '200', 'YES','添加人'),"click_num" => array('int', '', 'YES','点击量'),"show_platform" => array('tinyint', '', 'YES','发布平台 1web端，2客户端'),"show_order" => array('int', '', 'YES','排序'),"show_status" => array('int', '', 'YES','在线状态 ,1是 ,2否'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $title;
	 public $content;
	 public $addtime;
	 public $adduser;
	 public $click_num;
	 public $show_platform;
	 public $show_order;
	 public $show_status; 
}