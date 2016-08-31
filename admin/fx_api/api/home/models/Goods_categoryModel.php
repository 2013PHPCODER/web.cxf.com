<?php
namespace api\home; 
 class Goods_categoryModel extends Model{

  	 function __construct($category_id=null,$status=null,$has_goods=null,$name=null,$name_alias=null,$html_style=null,$cid=null,$parent_cid=null,$parent_id=null,$level=null,$order=null,$ico=null,$title=null,$is_show=null,$big_ico=null) {
		 
		$this->category_id= $category_id;
		$this->status= $status;
		$this->has_goods= $has_goods;
		$this->name= $name;
		$this->name_alias= $name_alias;
		$this->html_style= $html_style;
		$this->cid= $cid;
		$this->parent_cid= $parent_cid;
		$this->parent_id= $parent_id;
		$this->level= $level;
		$this->order= $order;
		$this->ico= $ico;
		$this->title= $title;
		$this->is_show= $is_show;
		$this->big_ico= $big_ico;
		$this->table='Goods_category';
	 }

	 static $init_valid_array = array("category_id" => array('int', '', 'NO','平台类目ID'),"status" => array('int', '', 'YES','是否禁用 0:新建 1:正常 2:禁用'),"has_goods" => array('tinyint', '', 'NO','0:没有商品,1:有商品'),"name" => array('varchar', '255', 'NO','类目名称'),"name_alias" => array('varchar', '255', 'YES',''),"html_style" => array('varchar', '255', 'YES','页面显示样式'),"cid" => array('int', '', 'YES','对应淘宝类目ID'),"parent_cid" => array('int', '', 'YES','父级淘宝类目ID'),"parent_id" => array('int', '', 'YES','父级ID'),"level" => array('tinyint', '', 'YES','类目等级'),"order" => array('int', '', 'YES','顺序'),"ico" => array('varchar', '255', 'YES','一级分类小图标'),"title" => array('varchar', '100', 'YES','大类显示title（首页）'),"is_show" => array('int', '', 'YES','大类控制是否显示(0,不显示，1，显示)'),"big_ico" => array('varchar', '200', 'YES','一级类目大图标'));

	 public $_cxf_num_id='category_id';
	 public $category_id;
	 public $status;
	 public $has_goods;
	 public $name;
	 public $name_alias;
	 public $html_style;
	 public $cid;
	 public $parent_cid;
	 public $parent_id;
	 public $level;
	 public $order;
	 public $ico;
	 public $title;
	 public $is_show;
	 public $big_ico; 
}