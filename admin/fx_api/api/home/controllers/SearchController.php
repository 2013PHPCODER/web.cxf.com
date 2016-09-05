<?php
namespace api\home;
class SearchController extends Controller{

	public function index(){

		$q=$this->request;	

		// $q=new \stdclass();
		// // $q->keyword='bthnz-35-a-1#128-c88';		//默认上架时间倒序
		// $q->sort_key=1;			//排序条件，1上架时间（默认）, 2销量，3价格
		// $q->sort_type=1;		//排序方式，0降序(默认)， 1升序
		// $q->min_price=(float)300;
		// $q->max_price=(float) 123.5;
		// $q->category_id=50025838;
		// $q->page=2;
		// $q->level=2;		//类目等级


		$sort_key=isset($q->sort_key)? ($q->sort_key==2? 'sale_count': ($q->sort_key==3? 'price': 'sale_time' )): 'sale_time';			//生成搜索参数
		$sort_type=isset($q->sort_type)? ($q->sort_type==1? 'asc': 'desc'): 'desc';
		$sort=$sort_key.' '.$sort_type;
		$keyword=isset($q->keyword)? $q->keyword: '';

		$page=isset($q->page) && $q->page ? intval($q->page): 1;



		$dao=\Dao::Goods_list();									
		if ($this->isGoodsNo($keyword)) {			//判断是否为货号,是进入货号搜索
			$r=$dao->searchGoodsWithNo($keyword, $page);
			$this->response=['per_page'=>\Config('page_num'), 'page'=>$page, 'total'=>(int) $r['total']];
			$search_words='';
			$r=$r['list'];
		}else{
			/*开始搜索*/

			$sphinx=new \Sphinx($keyword, $sort, $page);			
			$bool=isset($q->min_price) || isset($q->max_price); 		//如果有价格范围

			if ($bool) {
				$min_price=isset($q->min_price)? floatval($q->min_price): floatval(0);
				$max_price=isset($q->max_price)? floatval($q->max_price): floatval(0);

				if ($min_price > $max_price ) {			//交换价格
					if ($max_price > 0) {
						$tmp=$min_price;
						$min_price=$max_price;
						$max_price=$tmp;
					}else{
						$max_price=100000000.00;			//手动赋予上限值，作为无上限
					}

				}
				$sphinx->filterPrice($min_price, $max_price);					
			}
			if (isset($q->category_id) && $q->category_id && isset($q->level) && $q->level) {							//如果有类目															
				$cids=\Dao::Goods_category()->getGoodsCategory($q->category_id, $q->level);													//类目存在进行过滤
				if ($cids) {
					$sphinx->filterCategory($cids);
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
			$r=$dao->searchGoods($result['ids']);			//进入mysql查询
			$search_words=$result['words'];
		}

		//处理结果
		if (is_array($r) && !empty($r)) {

			$high=new \LinMatch($search_words);			//高亮关键字

			foreach ($r as &$v) {
				$v['img_path']=imgUrl($v['img_path'], 'goods', 300);
				$tmp=change_price($v['price']);
				$v['basic_price']=$tmp['basic_price'];
				$v['middle_price']=$tmp['middle_price'];
				$v['senior_price']=$tmp['senior_price'];
				$v['distribution_price']=$tmp['distribution_price'];
				$v['goods_name']=$high->highlight($v['goods_name'], '<font style="color:red">', '</font>');			
			}
		}

		$this->response['item']=$r;
		$this->response();


	}



	private function isGoodsNo($key){
		$a=preg_match('/^[A-Za-z0-9\.#\-\$]{5,}$/', $key);
		$b=substr_count($key, '-');
		return $a && $b > 1;
	}
}

