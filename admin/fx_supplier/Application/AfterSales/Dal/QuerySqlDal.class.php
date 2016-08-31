<?php
namespace AfterSales\Dal;
class QuerySqlDal{



	public function lists($para){					//售后列表
		$condition=$para['condition'];
		$tables=$para['tables'];
		$p=$para['p'];

		$conn=M('cus_order_list as a');
		$field='a.id, a.addtime, a.buyer_name, a.distributors_qq, a.receiver_name, a.receiver_mobile, a.refund_reason, a.order_sn, '; 
		$field.='a.remark, a.shipping_code, a.refund_status, a.return_status, a.order_id, a.cus_type, a.have_replenished, a.been_arbitrated, ';
		$field.='b.buyer_goods_no, b.goods_id';
		if ($table=$tables['table']) {							//目前写死, 只关联一个表
			$condition2=$tables['condition'];
			$list=$conn->join('left join cus_order_goods_list as b on a.id=b.cus_id')->field($field)->where($condition)->where($condition2)->limit(($p-1)*20, 20)->order('a.addtime desc')->select();
			$total=$conn->join('left join cus_order_goods_list as b on a.id=b.cus_id')->where($condition)->where($condition2)->count();
		}else{
			$list=$conn->join('left join cus_order_goods_list as b on a.id=b.cus_id')->field($field)->where($condition)->limit(($p-1)*20, 20)->order('a.addtime desc')->select();
			$total==$conn->where($condition)->count();
		}
		
		return ['total'=>$total, 'list'=>$list];
	}


	public function detail($para){					// 获得售后详情		
		$supplier_id=$para['supplier_id'];
		$id=$para['id'];
		$order_id=$para['order_id'];		

		$field='id, order_sn, addtime, cus_type, refund_amount, refund_reason, shipping_code, company_name, remark, refund_status, return_status, supplier_refuse_reason, ';
		$field.='conf_time, receipt_time, verify_time, close_time, return_time, refund_money_time, arbitration_time, admin_arbitration_reason, supplier_refuse_img, supplier_show_refund as show_refund';
		$info=M('cus_order_list')->where(['id'=>$id, 'supplier_id'=>$supplier_id])->field($field)->find();							//售后主信息
		if (!$info) {
			return false;
		}

		$order=M('order_list')->where(['order_id'=>$order_id, 'supplier_id'=>$supplier_id])->getField('order_state');

		$field='goods_name, img_path, goods_num, shop_price, buyer_goods_no, cus_goods_status as goods_status, responsible, damaged, b.sku_str_zh as sku';	
		$condition=['cus_id'=>$para['id']];
		$goods=M('cus_order_goods_list')->where($condition)->join('goods_sku_comb as b on cus_order_goods_list.sku_comb_id=b.id')->field($field)->find();			//商品信息
		

		$imgs=M('cus_order_goods_img')->field('img_path')->where($condition)->select();		//凭证图片					
		$logs=M('fx_aftersales_log')->where($condition)->field('id',true)->order('id desc')->select();			// 日志信息
		

		return ['info'=>$info, 'logs'=>$logs,'imgs'=>$imgs, 'goods'=>$goods, 'order'=>$order];
	}

	public function validStatus($condition){				//验证状态是否正确
		return M('cus_order_list')->where($condition)->count();

	}

	public function refundFreight($condition){				//退运费计算

		$to=M('order_contact as a')->where($condition)->getField('province');
		$from=M('order_goods as a')->join('goods_list as b on a.goods_id=b.goods_id')->join('fx_storage_list as c on b.depot_id=c.id')->where($condition)->getField('province');	
		
		return ['to'=>$to, 'from'=>$from];
	}
}