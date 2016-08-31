<?php
namespace api\home;
class AftersaleController extends Controller{

	public function index(){			//售后列表
		$q=$this->request;
		// $q=new \stdclass();
		// $q->user_id=1;
		// $q->page=1;
		// $q->return_status=1;				//售后状态
		// $q->refund_status=1;					//售后类型

		$must=['user_id', 'page'];
		batch_isset($q, $must);

		!isset($q->return_status) && !isset($q->refund_status) && myerror(\StatusCode::msgCheckFail, '缺少参数');

		$q->return_status=(isset($q->return_status) && $q->return_status>0 )? intval($q->return_status): -1;
		$q->refund_status=(isset($q->refund_status) && $q->refund_status>0 )? intval($q->refund_status): -1;



		$dao=\Dao::Cus_order_list();
		$list=$dao->lists($q->user_id, $q->page, $q->return_status, $q->refund_status);


		if ($list && is_array($list)) {
			foreach ($list as &$v) {
				$v['add_time']=f_int2date($v['add_time']);
				$v['close_time']=f_int2date($v['close_time']);
				$v['refund_money_time']=f_int2date($v['refund_money_time']);
				$v['return_time']=f_int2date($v['return_time']);

				$v['cus_type_code']=$v['cus_type'];
				f_refundType($v['cus_type']);
				f_refundReason($v['refund_reason']);
				$v['status_code']=$v['cus_type_code']==1? $v['return_status']: $v['refund_status'];				// 存储状态码
				$v['refund_amount']=$v['refund_amount']. ' (含运费'. $v['shipping_fee']. ')' ; 
				unset($v['shipping_fee']);
				if ($v['cus_type_code']==2) {										//格式化状态码
					$v['status']=f_afterStatus($v['refund_status']);			//售后状态格式化	
				}else{			
					$v['status']=f_afterStatus($v['return_status'], 'return');
				}
			}

		}

		$this->response=['page'=>$q->page, 'per_page'=>\Config('page_num'), 'item'=>$list];
		$this->response();

	}

	public function detail(){			//售后详情
		$q=$this->request;
		// $q=new \stdclass();
		// $q->user_id=1;
		// $q->cus_id=1;
		!isset($q->user_id) || !isset($q->cus_id) and myerror(\StatusCode::msgCheckFail, '缺少参数');	

		\Valid::not_empty($q->user_id)->withError('用户id为空');
		\Valid::not_empty($q->cus_id)->withError('售后订单id为空');		

		$dao=\Dao::Cus_order_list();
		$data=$dao->getDetail($q->user_id, $q->cus_id);

		$v=$data['main'];							//数据格式化
		$v['add_time']=f_int2date($v['add_time']);
		$v['close_time']=f_int2date($v['close_time']);
		$v['refund_money_time']=f_int2date($v['refund_money_time']);
		$v['return_time']=f_int2date($v['return_time']);


		$v['cus_type_code']=$v['cus_type'];
		f_refundType($v['cus_type']);
		f_refundReason($v['refund_reason']);
		$v['status_code']=$v['cus_type_code']==1? $v['return_status']: $v['refund_status'];				// 存储状态码
		$v['refund_amount']=$v['refund_amount']. ' (含运费'. $v['shipping_fee']. ')' ; 
		unset($v['shipping_fee']);
		if ($v['cus_type_code']==2) {										//格式化状态码
			$v['status']=f_afterStatus($v['refund_status']);			//售后状态格式化	
		}else{			
			$v['status']=f_afterStatus($v['return_status'], 'return');
		}			
		$data['main']=$v;

        foreach ($data['imgs'] as &$v) {
            $v=imgUrl($v['img_path']);
        }

        $data['main']['goods']=$data['goods'];
        $data['main']['imgs']=$data['imgs'];	
        $data=$data['main'];
		$this->response($data);		
	}

	public function add(){				//新增售后
		$q=$this->request;
		// $q=new \stdclass();
		// $q->user_id=3;
		// $q->order_id=367;
		// $q->after_sale_reason=4;

		!isset($q->user_id) || !isset($q->order_id) || !isset($q->after_sale_reason) and myerror(\StatusCode::msgCheckFail, '缺少参数');	



		// $q->after_sale_remark='我就是不想买了';			//可选
		// $q->img='asdhi.jpg|asd.jpg';				//可选， 上传的图片


		\Valid::not_empty($q->user_id)->withError('用户id为空');
		\Valid::not_empty($q->order_id)->withError('订单id为空');
		\Valid::not_empty($q->after_sale_reason)->withError('售后理由为空');
		!isset($q->after_sale_remark) && empty($q->after_sale_remark) && $q->after_sale_remark='';



		$dao=\Dao::Cus_order_list();


		/*开始事务*/
		$dao->beginTrans();

		$data=$dao->getRelationInfo($q->order_id, $q->user_id, $q->after_sale_reason);				//获取关联数据以便写入,顺带验证是否可以申请售后

		!$data and myerror(\StatusCode::msgExistAftersale, '该订单不可申请售后');

		$main=(object) $data['main'];
		$goodsModel=\Model::Cus_order_goods_list();			//写入售后订单列表
		foreach ($data['goods'] as &$v) {
			$v=(object) $v;
			$tmp=clone ($goodsModel);							//生成多个模型 但是缺少关联的主键
			$tmp->goods_id=$v->goods_id;
			$tmp->goods_name=$v->goods_name;
			$tmp->img_path=$v->img_path;
			$tmp->goods_num=$v->goods_num;
			$tmp->buyer_goods_no=$v->buyer_goods_no;
			$tmp->price=$v->price;
			$tmp->shop_price=$v->price;
			$tmp->depot_id=$v->depot_id;
			$tmp->sku_comb_id=$v->sku_comb_id;
			$goods[]=$tmp;
		}




		$model=\Model::Cus_order_list();			
		$model->order_id=$q->order_id;
		$model->order_sn=$main->order_sn;
		$model->buyer_id=$main->buyer_id;
		$model->other_shop=$main->other_shop;
		$model->other_order_sn=$main->other_order_sn;

		$model->supplier_id=$main->supplier_id;
		$model->shop_id=$main->shop_id;
		$model->cus_type=$main->cus_type;
		$model->receiver_name=$main->receiver_name;


		$model->return_status=$main->return_status;
		$model->refund_status=$main->refund_status;

		$model->receiver_mobile=$main->receiver_mobile;
		$model->receiver_address=$main->receiver_address;
		$model->distributors_qq=$main->distributors_qq;
		$model->refund_amount=$main->refund_amount;
		$model->addtime=time();
		$model->shipping_no=$main->shipping_no;
		$model->buyer_name=$main->buyer_name;
		$model->supplier_show_refund=$main->show_refund;

		$model->refund_reason=$q->after_sale_reason;
		$model->remark=$q->after_sale_remark;

		


		$id=$dao->insert($model);						//插入主售后订单,返回售后订单id
		$goodsDao=\Dao::Cus_order_goods_list();

		foreach ($goods as &$v) {
			$v->cus_id=$id;
		}
		$goodsDao->insertMany($goods);					//插入商品

		$bool=isset($q->img) && !empty($q->img);			//插入凭证图片
		if ($bool) {		
			if (is_string($q->img)) {
				$imgs=explode("|", $q->img);
			}else{
				$imgs=$q->img;
			}
			
			$imgModel=\Model::Cus_order_goods_img('', $id);
			foreach ($imgs as $k => $v) {
				$tmp=clone ($imgModel);
				$tmp->img_path=$v;
				$img[]=$tmp;	
			}
			$imgDao=\Dao::Cus_order_goods_img();
			$imgDao->insertMany($img);
		}
		//改订单状态
		$orderModel=\Model::Order_list();
		$orderModel->order_id=$q->order_id;
		$orderModel->is_cus=1;
		$orderDao=\Dao::Order_list();			
		$orderDao->update($orderModel);

		$dao->endTrans();	
		/*事务结束*/

		$this->response(['success'=>'申请售后成功']);
	}


	public function changeStatus(){					//改变售后状态
		$q=$this->request;
		// $q=new \stdclass();
		// $q->user_id=1;
		// $q->cus_id=256;
		// $q->type='deliver1';
		// $q->freight_company='中通';
		// $q->freight_no='dgoagho123';
		// batch_isset($q, ['user_id', 'cus_id', 'type']);

		$dao=\Dao::cus_order_list();
		if ($q->type === 'deliver') {							
			batch_isset($q, ['freight_company', 'freight_no']);
			$status=$dao->getStatus($q->cus_id, $q->user_id, 'return_status');			// 判断订单是否可操作
			// !$status || $status!=\aftersale_back_good_status::wait_buyer_sendgoods and  myerror(\StatusCode::msgAftersaleFail, '售后订单不可操作');

			//生成更新数据
			$data=['shipping_code'=>$q->freight_no, 'company_name'=>$q->freight_company, 'return_status'=>\aftersale_back_good_status::wait_supplier_receivegoods, 'return_time'=>time()];
			$is_cancel=0;
		}else{				//取消订单
			//退货类型
			$data['close_time']=time();
			$status_return=$dao->getStatus($q->cus_id, $q->user_id,  'return_status');			// 判断订单是否可操作

			// if (!$status_return) {				//不是退货
			// 	$status_refund=$dao->getStatus($q->cus_id, $q->user_id, 'refund_status');
			// 	!$status_refund || $status_refund!=\aftersale_back_money_status::wait_admin_confirm  and  myerror(\StatusCode::msgAftersaleFail, '售后订单不可操作');			//退款也没有记录，不可操作
			// }else{			

				$status_return!=\aftersale_back_good_status::wait_admin_confirm  and  myerror(\StatusCode::msgAftersaleFail, '售后订单不可操作');			
			// }
			//生成更新数据
			// if ($status_return) {
				$data['return_status']=\aftersale_back_good_status::buyer_cancel;
			// }else{
			// 	$data['refund_status']=\aftersale_back_money_status::buyer_cancel;
			// }					//默认是取消售后操作
			$is_cancel=1;	
		}
		$r=$dao->changeStatus($q->cus_id, $q->user_id, $data, $is_cancel);
		!$r && myerror(\StatusCode::msgDBUpdateFail, '数据操作失败');
		$this->response('操作成功');
	}




}