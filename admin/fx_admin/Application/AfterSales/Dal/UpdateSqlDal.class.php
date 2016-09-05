<?php
namespace AfterSales\Dal;
class UpdateSqlDal{


	public function changeStatus($para){				//改变售后状态，仅针对待确认状态下
		$conn=M('cus_order_list');
		$is_refuse=$para['is_refuse'];
		$cus_id=$para['return']['condition']['id'];
		// if ($para['refund']) {
		// 	$condition=$para['refund']['condition'];
		// 	$data=$para['refund']['data'];
		// }else{
			$condition=$para['return']['condition'];
			$data=$para['return']['data'];
		// }

		$conn->startTrans();			//开始事务	
		if ($is_refuse) {		//拒绝下维护订单表
			$order_id=$conn->join('order_list as b on cus_order_list.order_id=b.order_id')->where($condition)->getField('b.order_id');
			$r1=M('order_list')->where(['order_id'=>$order_id])->save(['is_cus'=>2]);
		}else{
			$r1=1;
		}
		$r2=$conn->where($condition)->save($data);

		if ($r1 && $r2) {
			$conn->commit();
			return $r2;
		}else{
			$conn->rollback();
			return false;
		}

	}

	public function changeStatusArbitration($para){				//改变售后状态，可能会写财务表
		$conn=M('cus_order_list');
		$condition=$para['return']['condition'];
		$data=$para['return']['data'];
		$is_refuse=$para['is_refuse'];

		$conn->startTrans();			//开始事务
		if ($para['is_finance']) {			//是否需要打财务表
			$a=$conn->join('order_list as b on cus_order_list.order_id=b.order_id')->where($condition)->field('goods_amount as amount, b.buyer_id as user_id, b.order_id, b.order_sn')->find();
			$user_id=$a['user_id'];
			$order_id=$a['order_id'];
			$amount=$a['amount'];
			$user_info=M('fx_distribute_user')->where(['id'=>$user_id])->field('receiver_account_type, open_bank_address, receiver_account')->find();

			$finance_data=[
				'source_sn'=>$a['order_sn'], 'catch_type'=>3, 'source_id'=>$condition['id'],
				'repay'=>$amount, 'status'=>1, 'addtime'=>time(), 'user_type'=>2, 
				'receiver_account_type'=>$user_info['receiver_account_type'], 'bank_deposit'=>$user_info['open_bank_address'],
				'receiver_name'=>$user_info['receiver_account']
			];
			$r1=M('fx_catch_money')->add($finance_data);
			$r2=$conn->where($condition)->save($data);

		}else{					
			$r1=1;
			$r2=$conn->where($condition)->save($data);
			$order_id=$conn->join('order_list as b on cus_order_list.order_id=b.order_id')->where($condition)->getField('b.order_id');
		}

		if ($is_refuse) {			//拒绝下维护订单表
			$r3=M('order_list')->where(['order_id'=>$order_id])->save(['is_cus'=>2]);
		}else{
			$r3=1;
		}

		if ($r1 && $r2 && $r3) {
			$conn->commit();
			return $r2;
		}else{
			$conn->rollback();
			return false;
		}




	}


}