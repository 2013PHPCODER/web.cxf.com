<?php
namespace api\home; 
 class Goods_listModel extends Model{

  	 function __construct($goods_id=null,$goods_no=null,$goods_category=null,$goods_name=null,$goods_sale=null,$sale_time=null,$off_sale_time=null,$goods_status=null,$conf_time=null,$buyer_goods_no=null,$supplier_id=null,$depot_id=null,$new_upload=null,$is_missing=null,$img_path=null,$stock_update_time=null,$is_delete=null,$addtime=null,$goods_lack=null,$goods_lack_momo=null,$stock_num=null,$price=null,$top_category=null,$platform=null,$item_weight=null,$sale_count=null,$fx_count=null,$collect_count=null,$picture_path=null,$img_paths=null) {
		 
		$this->goods_id= $goods_id;
		$this->goods_no= $goods_no;
		$this->goods_category= $goods_category;
		$this->goods_name= $goods_name;
		$this->goods_sale= $goods_sale;
		$this->sale_time= $sale_time;
		$this->off_sale_time= $off_sale_time;
		$this->goods_status= $goods_status;
		$this->conf_time= $conf_time;
		$this->buyer_goods_no= $buyer_goods_no;
		$this->supplier_id= $supplier_id;
		$this->depot_id= $depot_id;
		$this->new_upload= $new_upload;
		$this->is_missing= $is_missing;
		$this->img_path= $img_path;
		$this->stock_update_time= $stock_update_time;
		$this->is_delete= $is_delete;
		$this->addtime= $addtime;
		$this->goods_lack= $goods_lack;
		$this->goods_lack_momo= $goods_lack_momo;
		$this->stock_num= $stock_num;
		$this->price= $price;
		$this->top_category= $top_category;
		$this->platform= $platform;
		$this->item_weight= $item_weight;
		$this->sale_count= $sale_count;
		$this->fx_count= $fx_count;
		$this->collect_count= $collect_count;
		$this->picture_path= $picture_path;
		$this->img_paths= $img_paths;
		$this->table='Goods_list';
	 }

	 static $init_valid_array = array("goods_id" => array('int', '', 'NO','商品ID'),"goods_no" => array('varchar', '50', 'NO','商品货号'),"goods_category" => array('int', '', 'NO','商品类目'),"goods_name" => array('varchar', '62', 'NO','商品名称'),"goods_sale" => array('tinyint', '', 'NO','商品上下架:1=上架，2=下架，(默认2)'),"sale_time" => array('int', '', 'NO','上架时间'),"off_sale_time" => array('int', '', 'NO','下架时间'),"goods_status" => array('tinyint', '', 'NO','商品状态:1=待审核,2=未通过,3=已通过'),"conf_time" => array('int', '', 'NO','审核时间'),"buyer_goods_no" => array('varchar', '100', 'NO','商家的编码'),"supplier_id" => array('int', '', 'NO','供应商ＩＤ'),"depot_id" => array('int', '', 'NO','仓库ID'),"new_upload" => array('tinyint', '', 'NO','新上传:0是：1否'),"is_missing" => array('tinyint', '', 'NO','商品是否残缺：0=否，1=是'),"img_path" => array('varchar', '100', 'NO','图片地址'),"stock_update_time" => array('int', '', 'NO','库存修改时间'),"is_delete" => array('tinyint', '', 'NO','是否删除：0＝否：1＝是'),"addtime" => array('int', '', 'NO','添加时间'),"goods_lack" => array('tinyint', '', 'NO','商品是否缺失：0=否，1=是'),"goods_lack_momo" => array('varchar', '255', 'NO','商品信息缺失内容'),"stock_num" => array('int', '', 'NO','总库存'),"price" => array('decimal', '', 'NO','原价'),"top_category" => array('int', '', 'NO','顶级父目录'),"platform" => array('tinyint', '', 'NO','平台:1:星密码,2:创想范'),"item_weight" => array('float', '', 'NO','物流重量'),"sale_count" => array('int', '', 'NO','售出数量'),"fx_count" => array('int', '', 'NO','分销总数'),"collect_count" => array('int', '', 'NO','收藏数量'),"picture_path" => array('varchar', '100', 'YES','商品主图2'),"img_paths" => array('varchar', '1000', 'YES','轮播图片地址'));

	 public $_cxf_num_id='goods_id';
	 public $goods_id;
	 public $goods_no;
	 public $goods_category;
	 public $goods_name;
	 public $goods_sale;
	 public $sale_time;
	 public $off_sale_time;
	 public $goods_status;
	 public $conf_time;
	 public $buyer_goods_no;
	 public $supplier_id;
	 public $depot_id;
	 public $new_upload;
	 public $is_missing;
	 public $img_path;
	 public $stock_update_time;
	 public $is_delete;
	 public $addtime;
	 public $goods_lack;
	 public $goods_lack_momo;
	 public $stock_num;
	 public $price;
	 public $top_category;
	 public $platform;
	 public $item_weight;
	 public $sale_count;
	 public $fx_count;
	 public $collect_count;
	 public $picture_path;
	 public $img_paths; 
}