<?php
namespace api\home; 
 class Goods_sku_combModel extends Model{

  	 function __construct($id=null,$goods_id=null,$goods_no=null,$sku_str=null,$sku_str_zh=null,$stock_num=null,$sale_count=null,$sku_attr=null,$stock_lock_num=null,$original_price=null) {
		 
		$this->id= $id;
		$this->goods_id= $goods_id;
		$this->goods_no= $goods_no;
		$this->sku_str= $sku_str;
		$this->sku_str_zh= $sku_str_zh;
		$this->stock_num= $stock_num;
		$this->sale_count= $sale_count;
		$this->sku_attr= $sku_attr;
		$this->stock_lock_num= $stock_lock_num;
		$this->original_price= $original_price;
		$this->table='Goods_sku_comb';
	 }

	 static $init_valid_array = array("id" => array('int', '', 'NO','自增主键'),"goods_id" => array('int', '', 'NO','商品ID'),"goods_no" => array('varchar', '255', 'NO',''),"sku_str" => array('varchar', '255', 'NO','商品SKU值'),"sku_str_zh" => array('varchar', '255', 'NO','商品SKU组合字符串（中文）'),"stock_num" => array('int', '', 'NO','库存'),"sale_count" => array('int', '', 'NO','售出数量'),"sku_attr" => array('varchar', '255', 'YES','sku属性(用于搜索)'),"stock_lock_num" => array('int', '', 'YES','预警库存'),"original_price" => array('decimal', '', 'NO','原价'));

	 public $_cxf_num_id='id';
	 public $id;
	 public $goods_id;
	 public $goods_no;
	 public $sku_str;
	 public $sku_str_zh;
	 public $stock_num;
	 public $sale_count;
	 public $sku_attr;
	 public $stock_lock_num;
	 public $original_price; 
}