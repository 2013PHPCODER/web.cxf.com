<?php
namespace AfterSales\Controller;
use Common\Controller\BasicController as Auth;

class IndexController extends Auth{

	public function index(){				// 售后列表
		C("TOKEN_ON", FALSE);
		$get=I('get.');
		$c=$get['condition'];
		$p=(int) $get['p']? : 1;

		/*状态条件*/
		strlen($get['refund'])>0 and ($refund=(int) $get['refund']);
		strlen($get['return'])>0 and ($return=(int) $get['return']);
		isset($refund) and isset($return) and $main_c['refund_status|return_status']=[$refund, $return, '_multi'=>true];
		isset($refund) and !isset($return) and $main_c['refund_status']=$refund;
		!isset($refund) and isset($return) and $main_c['return_status']=$return;

		if ($c) {							//存在主赛选条件时候
			strlen($c['buyer_name'])>0  and  $main_c['a.buyer_name']=htmlspecialchars( $c['buyer_name'] );				
			strlen($c['refund_reason'])>0  and  $main_c['a.refund_reason']=(int) $c['refund_reason'];
			strlen($c['cus_type'])>0  and  $main_c['a.cus_type']=(int) $c['cus_type'];
			strlen($c['shop_id'])>0  and  $main_c['a.shop_id']=(int) $c['shop_id'];
			
			$time1=strtotime($c['addtime'][0]);				//时间范围条件
			$time2=strtotime($c['addtime'][1]);
			if ($time2<$time1 && $time2>0) {			//保证time2大于time1, time2可能为0
				$tmp=$time2;
				$time2=$time1;
				$time1=$tmp;
			}			
			$time1=$time1>=0 ?$time1 :0;					//确保时间非负数
			$time2=$time2>=0 ?$time2 :0;				
			$time1 && $time2 && ($main_c['a.addtime']=['between', [$time1, $time2]] );
			$time1 && !$time2 && ($main_c['a.addtime']=['egt', $time1] );
			!$time1 && $time2 && ($main_c['a.addtime']=['elt', $time2] );
		}
		if ($c['key_type'] && $c['key']) {					//存在分类搜索
			$c['key']=htmlspecialchars($c['key']);
			switch ($c['key_type']) {
				case 'id':
					$main_c['a.id']=$c['key'];
					break;				
				case 'receiver_name':
					$main_c['receiver_name']=$c['key'];
					break;
				case 'receiver_mobile':
					$main_c['receiver_mobile']=$c['key'];
					break;
				case 'shipping_code':
					$main_c['shipping_code']=$c['key'];
					break;
				case 'order_id':
					$main_c['order_sn']=$c['key'];
					break;										
				case 'goods_id':
					$join_table['table']='cus_order_goods_list';
					$join_table['condition']['goods_id']=$c['key'];
					break;
				case 'buyer_goods_no':
					$join_table['table']='cus_order_goods_list';
					$join_table['condition']['buyer_goods_no']=$c['key'];				
					break;
			}
		}

		$main_c['supplier_id']=$this->user_info['id'];
		$para=['condition'=>$main_c, 'tables'=>$join_table];				//生成条件数组
		$para['p']=$p;
		$r=R('QuerySql/lists', [$para], 'Dal');								//获得数据

		foreach ($r['list'] as $k=>&$v) {										//格式化处理数据
			if ($v['cus_type'] == 1 && $v['return_status'] == \aftersale_back_good_status::wait_admin_confirm) {				//过滤掉平台待确认状态
				unset($r['list'][$k]);
				continue;
			}elseif($v['cus_type'] == 2 && $v['refund_status'] == \aftersale_back_money_status::wait_admin_confirm  ){
				unset($r['list'][$k]);
				continue;
			}


			$v['addtime']=f_int2date($v['addtime']);
			$v['reason']=$v['refund_reason'];							//存储退款状态码
			$v['cus_type_code']=$v['cus_type'];
			f_refundType($v['cus_type']);

			f_refundReason($v['refund_reason']);
			if ($v['refund_status']) {
				$v['status_code']=$v['refund_status'];							// 存储状态码
				$v['type']='refund';
				$v['is_arbitration']=is_arbitration($v['refund_status']);			//是否为仲裁,位置不可和下边状态码格式化兑换
				$v['status']=f_afterStatus($v['refund_status']);			//售后状态格式化	
				$v['operator']=f_afterOperator($v['status_code']);						//根据售后状态是否具有操作功能

			}else{
				$v['status_code']=$v['return_status'];
				$v['type']='return';			
				$v['is_arbitration']=is_arbitration($v['return_status'], 'return');
				$v['status']=f_afterStatus($v['return_status'], 'return');			
				$v['operator']=f_afterOperator($v['status_code'], 'return');		
			}
												
		}
		//查询额外的平台补款账户信息，用于补款显示
		if (!isset($refund) && !isset($return) or isset($return) && $return == \aftersale_back_good_status::wait_supplier_repaypostfee) {
			$field='receiver_account as account, receiver_name as name, receiver_platform as platform, open_bank_address as bank';
			$bukuan=M('fx_receiver_account')->field($field)->select();
			foreach ($bukuan as &$v) {
				$v['platform_code']=$v['platform'];
				switch ($v['platform']) {
					case '1':
						$v['platform']='支付宝';
						break;
					case '2':
						$v['platform']='银行卡';
						break;
					case '3':
						$v['platform']='微信';
						break;												
				}
			}
		}
		//查询额外的物流公司信息，用于退款发货操作
		if (!isset($refund) && !isset($return) or isset($refund) && $refund == \aftersale_back_money_status::wait_supplier_confirm) {
			$field='shipping_id, shipping_name';
			$shipping=M('system_shipping')->field($field)->select();
		}



		// dump($r);return;
		$this->assign('list', $r['list']);
		$this->assign('total', $r['total']);
		$this->assign('bukuan', $bukuan);
		$this->assign('shipping', $shipping);
		$this->display();

	}

	
	public function detail(){				// 售后详情
		$get=I('get.', '', 'intval');
		$para=['id'=>$get['id'], 'order_id'=>$get['order_id'], 'supplier_id'=>$this->user_info['id']];
		$r=R('QuerySql/detail', [$para], 'Dal');		

		!$r && $this->error('售后详情不可访问');

		f_int2date($r['info']['addtime']);						//数据处理
		f_int2date($r['info']['conf_time']);
		f_int2date($r['info']['receipt_time']);
		f_int2date($r['info']['verify_time']);
		f_int2date($r['info']['close_time']);
		f_int2date($r['info']['return_time']);
		f_int2date($r['info']['refund_money_time']);
		f_int2date($r['info']['arbitration_time']);


		f_refundReason($r['info']['refund_reason']);

		if ($r['info']['refund_status']) {
			$r['info']['status']=f_afterStatus($r['info']['refund_status'], 'refund');
		}else{
			$r['info']['status']=f_afterStatus($r['info']['return_status'], 'return');
		}
		f_refundType($r['info']['cus_type']);

		f_orderStatus($r['order']);


		f_obligation($r['goods']['responsible']);			//商品信息
		f_img($r['goods']['img_path']);
		$r['goods']['goods_status']=$r['goods']['goods_status'] == 1 ? '商品完整': '商品有问题';

		foreach ($r['logs'] as &$v) {						//日志信息
			f_int2date($v['add_time']);
		}
		if (is_array($r['imgs']) && $r['imgs']) {
			foreach ($r['imgs'] as &$v) {						//图片信息
				$v['img_thumb']=f_img($v['img_path'], '', 200);
				$v['img_path']=f_img($v['img_path'], '');
			}
		}



		$this->assign('info', $r['info']);
		$this->assign('imgs', $r['imgs']);
		$this->assign('goods', $r['goods']);
		$this->assign('logs', $r['logs']);
		$this->assign('order_status', $r['order']);

		$this->display();
	}






	public function detailArbitration(){						// 仲裁详情
		$get=I('get.', '', 'intval');
		$para=['id'=>$get['id'], 'order_id'=>$get['order_id'], 'supplier_id'=>$this->user_info['id']];
		$r=R('QuerySql/detail', [$para], 'Dal');		


		f_int2date($r['info']['addtime']);						//数据处理
		f_int2date($r['info']['conf_time']);
		f_int2date($r['info']['receipt_time']);
		f_int2date($r['info']['verify_time']);
		f_int2date($r['info']['close_time']);
		f_int2date($r['info']['return_time']);
		f_int2date($r['info']['refund_money_time']);
		f_int2date($r['info']['arbitration_time']);
		
		$r['info']['refund_reason_status']=$r['info']['refund_reason'];			//保留退款原因状态码
		f_refundReason($r['info']['refund_reason']);

		if ($r['info']['refund_status']) {
			$r['info']['status']=f_afterStatus($r['info']['refund_status'], 'refund');
			$r['info']['after_type']='refund';
		}else{
			$r['info']['status']=f_afterStatus($r['info']['return_status'], 'return');
			$r['info']['after_type']='return';
		}
		f_refundType($r['info']['cus_type']);

		f_orderStatus($r['order']);


		f_obligation($r['goods']['responsible']);			//商品信息
		f_img($r['goods']['img_path']);


		foreach ($r['logs'] as &$v) {						//日志信息
			f_int2date($v['add_time']);
		}
		foreach ($r['imgs'] as &$v) {						//图片信息
			$v['img_thumb']=f_img($v['img_path'], '', 200);
			$v['img_path']=f_img($v['img_path'], '');
		}
		$r['supplier_imgs']=!empty($r['info']['supplier_refuse_img'])? explode('|', $r['info']['supplier_refuse_img']): [];


		foreach ($r['supplier_imgs'] as $key=>&$v) {						//图片信息
			$r['supplier_imgs'][$key]=['img_thumb'=>f_img($v, '', 200), 'img_path'=>f_img($v, '')];
		}

		$r['goods']['goods_status']=$r['goods']['goods_status'] == 1 ? '商品完整': '商品有问题';
		$this->assign('info', $r['info']);
		$this->assign('imgs', $r['imgs']);
		$this->assign('supplier_imgs', $r['supplier_imgs']);
		$this->assign('goods', $r['goods']);
		$this->assign('logs', $r['logs']);
		$this->assign('order_status', $r['order']);

		$this->display();
	}



	public function arbitrationList(){
		C("TOKEN_ON", FALSE);
		$get=I('get.');
		$c=$get['condition'];
		$p=(int) $get['p']? :1;
		/*状态条件*/
		strlen($get['refund'])>0 and ($refund=(int) $get['refund']);
		strlen($get['return'])>0 and ($return=(int) $get['return']);
		isset($refund) and isset($return) and $main_c['refund_status|return_status']=[$refund, $return, '_multi'=>true];
		isset($refund) and !isset($return) and $main_c['refund_status']=$refund;
		!isset($refund) and isset($return) and $main_c['return_status']=$return;

		
		if ($c) {							//存在主赛选条件时候
			strlen($c['buyer_name'])>0  and  $main_c['a.buyer_name']=htmlspecialchars( $c['buyer_name'] );				
			strlen($c['refund_reason'])>0  and  $main_c['a.refund_reason']=(int) $c['refund_reason'];
			strlen($c['cus_type'])>0  and  $main_c['a.cus_type']=(int) $c['cus_type'];
			strlen($c['shop_id'])>0  and  $main_c['a.shop_id']=(int) $c['shop_id'];
			
			$time1=strtotime($c['addtime'][0]);				//时间范围条件
			$time2=strtotime($c['addtime'][1]);
			if ($time2<$time1 && $time2>0) {			//保证time2大于time1, time2可能为0
				$tmp=$time2;
				$time2=$time1;
				$time1=$tmp;
			}			
			$time1=$time1>=0 ?$time1 :0;					//确保时间非负数
			$time2=$time2>=0 ?$time2 :0;				
			$time1 && $time2 && ($main_c['a.addtime']=['between', [$time1, $time2]] );
			$time1 && !$time2 && ($main_c['a.addtime']=['egt', $time1] );
			!$time1 && $time2 && ($main_c['a.addtime']=['elt', $time2] );
		}
		if ($c['key_type'] && $c['key']) {					//存在分类搜索
			$c['key']=htmlspecialchars($c['key']);
			switch ($c['key_type']) {
				case 'id':
					$main_c['a.id']=$c['key'];
					break;				
				case 'receiver_name':
					$main_c['receiver_name']=$c['key'];
					break;
				case 'receiver_mobile':
					$main_c['receiver_mobile']=$c['key'];
					break;
				case 'shipping_code':
					$main_c['shipping_code']=$c['key'];
					break;
				case 'order_id':
					$main_c['order_id']=$c['key'];
					break;										
				case 'goods_id':
					$join_table['table']='cus_order_goods_list';
					$join_table['condition']['goods_id']=$c['key'];
					break;
				case 'buyer_goods_no':
					$join_table['table']='cus_order_goods_list';
					$join_table['condition']['buyer_goods_no']=$c['key'];				
					break;
			}
		}

		$main_c['supplier_id']=$this->user_info['id'];
		$main_c['been_arbitrated']=1;

		$para=['condition'=>$main_c, 'tables'=>$join_table];				//生成条件数组
		$para['p']=$p;
		$r=R('QuerySql/lists', [$para], 'Dal');								//获得数据

		foreach ($r['list'] as &$v) {
			$v['addtime']=f_int2date($v['addtime']);
			f_refundType($v['cus_type']);
			f_refundReason($v['refund_reason']);
			$status=$v['refund_status']? :$v['return_status'];				// 存储状态码
			$v['type']=$v['refund_status']? 'refund': 'return';				//售后类型，退款或退货
			if ($v['refund_status']) {										//格式化状态码
				$v['is_arbitration']=is_arbitration($v['refund_status']);			//是否为仲裁,位置不可和下边状态码格式化兑换
				$v['status']=f_afterStatus($v['refund_status']);			//售后状态格式化					
			}else{			
				$v['is_arbitration']=is_arbitration($v['return_status'], 'return');
				$v['status']=f_afterStatus($v['return_status'], 'return');
			}
			$v['operator']=f_afterOperator($status);									//根据售后状态是否具有操作功能
		}

		$this->assign('list', $r['list']);
		$this->assign('total', $r['total']);
		$this->display();		
	} 




}