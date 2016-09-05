<?php
namespace AfterSales\Controller;
use Common\Controller\BasicController as Auth;
class ChangeStatusController extends Auth{



	public function refundLine(){						//退款流程
		$post=I('post.');
		$id=(int) $post['id'];
		$status=(int) $post['status'];
		$reason=(int) $post['reason'];
		$this->verifyData($id, $reason, $status, 'wait_supplier_confirm', 'refund');			//校验数据



		if ($post['is_send']) {			//确认发货,需要转退货流程
			empty($post['shipping_id']) || empty($post['shipping_code']) || empty($post['shipping_name']) and $this->error('请填写物流信息');
			$data['cus']=[
				'return_status'=>\aftersale_back_good_status::wait_buyer_sendgoods,
				'refund_status'=>0,
				'cus_type'=>1,
				'refund_reason'=>\aftersale_remark::seven_day_no_reason,
			];
			$data['order']=[
				'order_state'=>\order_status::wait_receive_goods,
				'shipping_code'=>$post['shipping_code'],
				'shipping_id'=>$post['shipping_id'],
				'shipping_name'=>$post['shipping_name']
			];
			$log='供货商已发货';
			$_log='售后操作，已发货，售后编号：'.$id;


		}else{					//未发货，要写打款表
			$data['cus']=[
				'refund_status'=>\aftersale_back_money_status::wait_admin_pay,
			];
			$data['order']='';
			$log='未发货，进入退款中，待平台支付';
			$_log='售后操作，进入退款中，售后编号：'.$id;

		}
		$condition=['id'=>$id, 'supplier_id'=>$this->user_info['id']];
		$para=['data'=>$data, 'condition'=>$condition];

		$r=R('updateSql/changeStatusWithOrder', [$para, $this->user_info['id']], 'Dal');
		if ($r) {
			$this->logs($id, $log);
			$this->log($_log);
			$this->success("操作成功");
		}else{
			$this->error('操作失败');
		}	

	}


	public function comfirmReceiptGoods(){						//确认收货 退货情况下
		$post=I('post.', '', 'intval');
		$id=$post['id'];
		$status=$post['status'];
		$reason=$post['reason'];
		$type=$post['type'];

		$this->verifyData($id, $reason, $status, 'wait_supplier_receivegoods', 'return');			//校验数据

		$para=[
			'condition'=>['id'=>$id],
			'data'=>['return_status'=>\aftersale_back_good_status::wait_supplier_approve, 'receipt_time'=>time()],
		];
		$r=R('updateSql/changeStatus', [$para], 'Dal');
		$para=[									//更新商品表
			'condition'=>['cus_id'=>$id], 
			'data'=>[
				'cus_goods_status'=>$post['goods_status'],
				'responsible'=>$post['duty'],
				'damaged'=>$post['damaged'],
			]	
		];
		R('updateSql/saveGoodsInfo', [$para], 'Dal');  
		if ($r) {
			$this->logs($id, '确认收货');
			$goods_info=$post['goods_status']==1? '商品完整': '商品异常';
			$this->log("售后操作，已确认收货，$goods_info 。售后编号：.$id");
			$this->success("操作成功");
		}else{
			$this->error('操作失败');
		}		

	}

	public function waitMyCheck(){									//等待我审核，退货.....
		$post=I('post.');
		$id=(int) $post['id'];
		$status=(int) $post['status'];
		$reason=(int) $post['reason'];
		$type=$post['type'];
		$action=(int) $post['action'];

		$this->verifyData($id, $reason, $status, 'wait_supplier_approve', 'return');
		$para=['condition'=>['id'=>$id, 'supplier_id'=>$this->user_info['id']] ];		
		if ($action!=1) {									//不同意，进入仲裁		
			!isset($post['reason_refuse']) || empty($post['reason_refuse'])  and $this->error('请填写拒绝售后的理由');
			$reason_refuse=trim($post['reason_refuse']);
			$reason_refuse_img=isset($post['reason_refuse_img'])? rtrim($post['reason_refuse_img'], '|'): null;
			$post['type']=='return' && $para['data']=['return_status'=> \aftersale_back_good_status::wait_admin_kill, 'supplier_refuse_reason'=>$reason_refuse, 'supplier_refuse_img'=>$reason_refuse_img];
			$log='供应商拒绝，等待平台仲裁';
			$_log='拒绝售后申请。售后编号：'.$id;
		}else{																				//同意						
			$a=$this->isReplenishment($reason);						//根据退货理由返回相应状态码和是否写财务表
			$para['data']['return_status']=$a['status'];
			$para['is_finance']=$a['is_finance'];
			$log='供应商已同意，等待补款或平台退款';
			$_log='同意售后申请，进入退货流程。售后编号：'.$id;
														
		}

		$r=R('updateSql/changeStatusWithFinance', [$para, $this->user_info['id']], 'Dal');
		if ($r) {
			$this->logs($id, $log);
			$this->log($_log);
			$this->success("操作成功");
		}else{
			$this->error('操作失败');
		}	

	}

	public function waitReplishment(){					//等待我补款， 退货情况下
		$post=I('post.');
		$id=(int) $post['id'];
		$status=(int) $post['status'];
		$reason=(int) $post['reason'];
		$type=$post['type'];


		$pay=$post['pay'];							//财务数据		

		$bool=empty($pay['type']) || empty($pay['account']) || empty($pay['sn']) || empty($pay['target_account']) and $this->error('信息填写不完整');										

		$this->verifyData($id, $reason, $status, 'wait_supplier_repaypostfee', 'return');			//校验数据

		$condition=['id'=>$id];
		$data=['have_replenished'=>1];

		//计算数据
		$order=M('cus_order_list')->where(['id'=>$id])->field('order_sn, order_id')->find();

		$finance_data=[
			'user_id'=>$this->user_info['id'],
			'user_name'=>$this->user_info['user_account'],
			'source_id'=>$id,
			'source_sn'=>$order['order_sn'],
			'type'=>3,
			'confirm_money'=>getRefundFreight($order['order_id']),
			'trade_no'=>$pay['sn'],
			'receiver_account'=>$pay['target_account'],
			'pay_type'=>(int) $pay['type'],
			'pay_account'=>$pay['account'],
			'pay_time'=>time(),
			'add_time'=>time(),
		];

		$para=[
			'condition'=>$condition,
			'data'=>$data,
			'finance_data'=>$finance_data,
		];

		$r=R('addSql/recordFinance', [$para], 'Dal');
		if ($r) {
			$this->logs($id, '供应商已补款，等待平台确认');
			$this->log('售后补款成功，等待平台确认。售后编号：'.$id);
			$this->success("操作成功");
		}else{
			$this->error('操作失败');
		}	

	}


	public function getReplishmentInfo(){					//获得补款信息
		if (IS_AJAX && IS_POST) {
			$order_id=$_POST['id'];
			//先检查是否可以查询信息
			$check=M('cus_order_list')->where(['order_id'=>$order_id, 'supplier_id'=>$this->user_info['id']])->count();
			if ($check) {
				$this->ajaxReturn(getRefundFreight($order_id));
			}

			
		}
	}

	public function getImgToken(){
		$file_type=$$_POST['file_type'];
		$file_name=$_POST['file_name'];
		$data=uploadKey($file_name, $file_type);
		$this->ajaxReturn($data);		
	}


	/*
		id 售后订单id
		reason 售后理由验证码
		status 售后状态码
		$verifyStatus 只能接受的状态码,将用于和status比对
	*/

	private function verifyData($id='', $reason='', $status='', $verifyStatus='', $type='refund'){						//校验状态，用于改变状态时候先校验
		
		$id || $reason || $status || $verifyStatus ||  $this->error('缺少售后操作所需的信息');			//验证原始状态是否提交		

		if ($type=='refund') {
			$status_arr=$this->reflect('aftersale_back_money_status');
			$valid_condition['refund_status']=$status;
		}else{
			$status_arr=$this->reflect('aftersale_back_good_status');
			$valid_condition['return_status']=$status;
		}
		$status_arr[$status] !== $verifyStatus && $this->error('当前售后状态不属于此类操作'); 		//验证需要操作的状态和枚可接受的状态是否一致	


		$valid_condition['id']=$id;
		$valid_condition['refund_reason']=$reason;		
		$valid_condition['supplier_id']=$this->user_info['id'];		
		$r=R('querySql/validStatus', [$valid_condition], 'Dal')? true: false;						//校验该订单是否和数据库数据一致

		!$r && $this->error('存在不可操作的订单状态');				

	}

	private function reflect($class){						//反射枚举状态
		$ref=new \ReflectionClass($class);
		$arr=$ref->getConstants();                                           
		return array_flip($arr);   
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

	private function logs($id, $info){				//记录日志
		$data=['cus_id'=>$id, 'user_name'=>$this->user_info['user_account'], 'action'=>$info, 'add_time'=>time(), 'remark'=>$info];
		$data=[$data];
		R('addSql/afterLog', [$data], 'Dal');					//写入操作日志
	}


}