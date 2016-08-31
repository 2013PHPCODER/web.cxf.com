<?php
namespace api\home; 
 class System_menuModel extends Model{

  	 function __construct($id=null,$menu_name=null,$meun_key=null,$group_id=null,$parent_id=null,$power_key=null,$url=null,$sort=null,$is_delete=null) {
		 
		$this->id= $id;
		$this->menu_name= $menu_name;
		$this->meun_key= $meun_key;
		$this->group_id= $group_id;
		$this->parent_id= $parent_id;
		$this->power_key= $power_key;
		$this->url= $url;
		$this->sort= $sort;
		$this->is_delete= $is_delete;
		$this->table='System_menu';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','自增主键'),"menu_name" => array('varchar', '50', 'NO','菜单名'),"meun_key" => array('varchar', '30', 'NO','菜单名（英文）'),"group_id" => array('tinyint', '', 'NO','页面分组'),"parent_id" => array('int', '', 'NO','父级ID'),"power_key" => array('varchar', '100', 'NO','权限KEY（唯一）'),"url" => array('varchar', '100', 'NO','菜单url'),"sort" => array('int', '', 'NO','菜单排序'),"is_delete" => array('tinyint', '', 'NO','是否删除：0＝否：1＝是'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $menu_name;
	 public $meun_key;
	 public $group_id;
	 public $parent_id;
	 public $power_key;
	 public $url;
	 public $sort;
	 public $is_delete; 
}