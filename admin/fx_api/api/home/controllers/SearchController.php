<?php
namespace api\home;
class SearchController extends Controller{

	public function index(){

		$q=$this->request;	

		// $q=new \stdclass();
		// $q->keyword='2016秋季新款系带中长款风衣';		//默认上架时间倒序
		// // $q->sort_key=2;			//排序条件，1上架时间（默认）, 2销量，3价格
		// // $q->sort_type=1;		//排序方式，0降序(默认)， 1升序
		// $q->min_price=(float) 12.5;
		// // $q->max_price=(float) 123.5;
		// $q->category_id=10685;
		// $q->page=1;


		$sort_key=isset($q->sort_key)? ($q->sort_key==2? 'sale_count': ($q->sort_key==3? 'price': 'sale_time' )): 'sale_time';			//生成搜索参数
		$sort_type=isset($q->sort_type)? ($q->sort_type==1? 'asc': 'desc'): 'desc';
		$sort=$sort_key.' '.$sort_type;
		$keyword=isset($q->keyword)? $q->keyword: '';

		$page=isset($q->page) && $q->page ? intval($q->page): 1;


		/*开始搜索*/

		$sphinx=new \Sphinx($keyword, $sort, $page);			

		$bool=isset($q->min_price) or isset($q->max_price); 		//如果有价格范围
		if ($bool) {
			$min_price=isset($q->min_price)? floatval($q->min_price): floatval(0);
			$max_price=isset($q->max_price)? floatval($q->max_price): floatval(0);

			if ($min_price>$max_price) {			//交换价格
				$tmp=0.0;
				$min_price=$tmp;
				$min_price=$max_price;
				$max_price=$tmp;
			}

			$sphinx->filterPrice($min_price, $max_price);					
		}
		if (isset($q->category_id) && $q->category_id) {							//如果有类目
			$cid=\Dao::Goods_category()->getGoodsCategory($q->category_id);
			if ($cid) {																//类目存在进行过滤
				$sphinx->filterCategory($cid);
			}
		}



		$result=$sphinx->search();
		$this->response=['per_page'=>\Config('page_num'), 'page'=>$page];

		if ($result['total']==0 || !$result['ids']) {				//没有找到结果
			$this->response['total']=0;
			$this->response['item']=[];
			$this->response();
			return;
		}

		$this->response['total']=$result['total'];
		$dao=\Dao::Goods_list();									//进入mysql查询
		$r=$dao->searchGoods($result['ids']);

		foreach ($r as $k => $v) {
			$test[]=$v['goods_name'];
		}

		if (is_array($r) && !empty($r)) {
			foreach ($r as &$v) {
				$v['img_path']=imgUrl($v['img_path'], 'goods', 300);
				$tmp=change_price($v['price']);
				$v['basic_price']=$tmp['basic_price'];
				$v['middle_price']=$tmp['middle_price'];
				$v['senior_price']=$tmp['senior_price'];
				$v['distribution_price']=$tmp['distribution_price'];
				
			}
		}

		// $sphinx->instance->buildExcerpts($goods_name, 'goods_main, goods_sub', )

		// $sphinx->build($r,'goods_name');
		// dump($r);die;

		$this->response['item']=$r;
		$this->response();


	}



	// public function s_build($str, $blade, $i){			//str目标字符，blade用于切割的字符， i存储的偏移量
	// 	// $len=strlen($blade);
	// 	$keyword=['2016', '韩版', '春衫']
	// 	$str='2016韩版春衫夏季爆款哈哈2016春衫';

	// 	foreach ($keyword as $key => $value) {
	// 		$tmp=explode($value, $str);
	// 	}

	// 	// $start=stripos($str, $blade);
	// 	// if ($start === false ) {
	// 	// 	return $str;
	// 	// }
	// 	// return   
	// 	// $arr['have'][$start]=substr($str, $start, $len);

	// }
}