<?php
namespace api\home; 
 class Fx_noticeModel extends Model{

  	 function __construct($id=null,$title=null,$content=null,$adduser=null,$addtime=null,$to_client=null) {
		 
		$this->id= $id;
		$this->title= $title;
		$this->content= $content;
		$this->adduser= $adduser;
		$this->addtime= $addtime;
		$this->to_client= $to_client;
		$this->table='Fx_notice';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','主键，自动增长列**站内信**'),"title" => array('varchar', '255', 'NO','标题'),"content" => array('varchar', '255', 'NO','公告内容'),"adduser" => array('varchar', '20', 'NO','添加人'),"addtime" => array('int', '', 'NO','添加时间'),"to_client" => array('tinyint', '', 'NO','发布对象(1,web站点 2，开店助理客户端)'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $title;
	 public $content;
	 public $adduser;
	 public $addtime;
	 public $to_client; 
}