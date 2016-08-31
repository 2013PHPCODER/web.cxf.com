<?php
namespace AfterSales\Controller;
use Common\Controller\AuthController as Auth;

class IndexController extends auth{

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
		

// dump($r);return;
		$this->assign('list', $r['list']);
		$this->assign('total', $r['total']);
		$this->display();

	}

	
	public function detail(){				// 售后详情
		$get=I('get.', '', 'intval');
		$para=['id'=>$get['id'], 'order_id'=>$get['order_id']];
		$r=R('QuerySql/detail', [$para], 'Dal');		


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


	public function changeStatus(){				//改变售后状态,待确认状态下可用, 支持批量操作
		$post=I('post.');
		//验证状态是否准确	
		$valid_condition['refund_status|return_status']=[\aftersale_back_money_status::wait_admin_confirm,\aftersale_back_good_status::wait_admin_confirm, '_multi'=>true];
		$valid_condition['id']=['in',$post['id']];
		$valid=R('querySql/validStatus', [$valid_condition], 'Dal')==count($post['id'])? true: false;					//判断实际查出来的条数和提交过来的是否一致	
		
		if ($valid) {
			foreach ($post['type'] as $k => &$v) {
				if ($v==='refund') {										//退款操作
					$condition['refund']['id']=['in', $post['id'][$k]];								
					$data['refund_status']=$post['action']==1? \aftersale_back_money_status::wait_supplier_confirm: \aftersale_back_money_status::refuse;//拒绝还是同意
				}else{															//退货操作
					$condition['return']['id']=['in', $post['id'][$k]];					
					$data['return_status']=$post['action']==1? \aftersale_back_good_status::wait_buyer_sendgoods: \aftersale_back_good_status::refuse;
				}
			}

			//生成数据库操作数据
			// if (isset($condition['refund'])) {
			// 	$para['refund']=['condition'=>$condition['refund'], 'data'=>['refund_status'=>$data['refund_status']] ];
			// 	$para['refund']['data']['verify_time']=time();
			// 	$post['action']==1?  : $para['refund']['data']['close_time']=time();
			// }
			// if (isset($condition['return'])) {
				$para['return']=['condition'=>$condition['return'], 'data'=>['return_status'=>$data['return_status']] ];
				$para['return']['data']['verify_time']=time();
				if ($post['action']==1) {
					$para['is_refuse']=0;
				}else{
					$para['return']['data']['close_time']=time();
					$para['is_refuse']=1;
				}
			// }

			$r=R('updateSql/changeStatus', [$para], 'Dal');								//传入数据	
			if ($r) {
				$data=[];								//记录日志
				$logs_content=$post['action']==1? \after_sale_line_content::platform_confirm: \after_sale_line_content::platform_kill;
				foreach ($post['id'] as $k => $v) {
					$data[]=['cus_id'=>$v, 'user_name'=>'admin', 'action'=>$logs_content, 'remark'=>$logs_content, 'add_time'=>time()];
				}
				$this->logs($data);
				$_log=$post['action']==1? '同意售后申请，售后编号：'.$post['id']: '拒绝售后申请，售后编号：'.$post['id'];
				$this->success('操作成功', U('afterSales/index/index'));
			}else{
				$this->error("操作失败", U('afterSales/index/index'));
			}
		}else{
			$this->error("存在不可更改状态的售后订单", U('afterSales/index/index'));							//不符合状态改变
		}
	}




	public function detailArbitration(){						// 仲裁详情
		$get=I('get.', '', 'intval');
		$para=['id'=>$get['id'], 'order_id'=>$get['order_id']];
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

		$r['supplier_imgs']=!empty($r['info']['supplier_refuse_img'])? explode('|', $r['info']['supplier_refuse_img']): [];
		foreach ($r['supplier_imgs'] as $key=>&$v) {						//图片信息
			$r['supplier_imgs'][$key]=['img_thumb'=>f_img($v, '', 200), 'img_path'=>f_img($v, '')];
		}

		$this->assign('info', $r['info']);
		$this->assign('imgs', $r['imgs']);
		$this->assign('supplier_imgs', $r['supplier_imgs']);
		$this->assign('goods', $r['goods']);
		$this->assign('logs', $r['logs']);
		$this->assign('order_status', $r['order']);

		$this->display();
	}


	public function arbitration(){						//仲裁操作
		$post=I('post.');

		//验证状态是否准确	
		$valid_condition['refund_status|return_status']=[\aftersale_back_money_status::wait_admin_kill,\aftersale_back_good_status::wait_admin_kill, '_multi'=>true];
		$valid_condition['id']=$post['id'];
		$valid=R('querySql/validStatus', [$valid_condition], 'Dal')? true: false;					//判断实际查出来的条数和提交过来的是否一致	


		if ($valid) {

			// 原始信息
			$id=(int) $post['id'];						//售后表主键
			$type=$post['type'];						//退款或退货，
			$refund_reason=(int) $post['refund_reason'];		//售后理由

			//表单信息
			$action=$post['action'];								//拒绝或同意1
			$submit_reason=$post['submit_reason'];					//管理员输入的理由

			// if ($type==='refund') {										//退款操作,已被干掉
			// 	$condition['refund']=['id'=> $post['id']];								
			// 	$data['refund_status']=$action==1? \aftersale_back_money_status::wait_admin_pay: \aftersale_back_money_status::refuse;	//拒绝还是同意
			// }else{															//退货操作
				$condition['return']=['id'=> $post['id']];	
				if ($action==1) {
					$a=$this->isReplenishment($refund_reason);
					$data['return_status']=$a['status'];
					$para['is_finance']=$a['is_finance'];
					$para['is_refuse']=0;
				}else{
					$data['return_status']=\aftersale_back_good_status::refuse;
					$para['is_refuse']=1;
				}
			// }

			
			//生成数据库操作数据
			// if (isset($condition['refund'])) {
			// 	$para['refund']=['condition'=>$condition['refund'], 'data'=>['refund_status'=>$data['refund_status'], 'been_arbitrated'=>1, 'admin_arbitration_reason'=>$submit_reason] ];
			// 	$para['refund']['data']['arbitration_time']=time();
			// 	$action==1? : $para['refund']['data']['close_time']=time();
			// }
			if (isset($condition['return'])) {
				$para['return']=['condition'=>$condition['return'], 'data'=>['return_status'=>$data['return_status'], 'been_arbitrated'=>1, 'admin_arbitration_reason'=>$submit_reason] ];
				$para['return']['data']['arbitration_time']=time();
				$action==1? : $para['return']['data']['close_time']=time();
			}

			$r=R('updateSql/changeStatusArbitration', [$para], 'Dal');								//传入数据	

			if ($r) {
				//记录日志
				$logs_content=$action==1? \after_sale_line_content::platform_zhongcai_confirm: \after_sale_line_content::platform_zhongcai_kill;
				$data=['cus_id'=>$id, 'user_name'=>'admin', 'action'=>$logs_content, 'remark'=>$logs_content, 'add_time'=>time()];
				$this->logs([$data]);
				$_log=$action==1? '仲裁后同意，售后编号：'.$post['id']: '仲裁后拒绝，售后编号：'.$post['id'];
				$this->log($_log);
				$this->success('操作成功', U('afterSales/index/index'));
			}else{
				$this->error("操作失败", U('afterSales/index/index'));
			}

		}else{
			$this->error("存在不可更改状态的售后订单", U('afterSales/index/index'));							//不符合状态改变
		}		
	}



	private function isReplenishment($refund_reason){					//根据退款原因判断是否补款 返回对应状态码
		$ref=new \ReflectionClass('\aftersale_remark');
	    $arr=$ref->getConstants();                                           // 获得常量
	    $arr=array_flip($arr);                                  //反转数值
	    $refund_reason=$arr[$refund_reason];                                 //获得枚举数组
	    switch ($refund_reason) {
	    	// case 'buy_error':
	    	// case 'do_not_want':
	    	case 'seven_day_no_reason':
	    		$status=\aftersale_back_good_status::wait_admin_repay;
	    		$is_finance=1;				//是否需要往财务表写数据
	    		break;
	    	case 'mass_question':	    		
	    	case 'was_inconsistent':
	    	case 'less_missed':
	    	case 'send_error':
	    		$status=\aftersale_back_good_status::wait_supplier_repaypostfee;
	    		$is_finance=0;
	    		break;	    			    			    			    			    	
	    }
	    return ['status'=>$status, 'is_finance'=>$is_finance];
	}

	private function logs($data){				//记录日志
		return R('addSql/afterLog', [$data], 'Dal');					//写入操作日志
	}
}