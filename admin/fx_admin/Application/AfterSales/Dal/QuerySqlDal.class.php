<?php
namespace AfterSales\Dal;
class QuerySqlDal{



	public function lists($para){					//售后列表
		$condition=$para['condition'];
		$tables=$para['tables'];
		$p=$para['p'];

		$conn=M('cus_order_list as a');
		$field='a.id, a.addtime, a.buyer_name, a.distributors_qq, a.receiver_name, a.receiver_mobile, a.refund_reason, a.order_sn, a.cus_type, '; 
		$field.='a.remark, a.shipping_code, a.refund_status, a.return_status, a.order_id, ';
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
		$condition=['cus_id'=>$para['id']];
		$id=$para['id'];
		$order_id=$para['order_id'];		

		$field='id, order_sn, addtime, cus_type, refund_amount, refund_reason, shipping_code, company_name, remark, refund_status, return_status, supplier_refuse_reason, ';
		$field.='conf_time, receipt_time, verify_time, close_time, return_time, refund_money_time, arbitration_time, supplier_refuse_img';
		$info=M('cus_order_list')->where(['id'=>$id])->field($field)->find();							//售后主信息
		$order=M('order_list')->where(['order_id'=>$order_id])->getField('order_state');

		$condition=['cus_id'=>$para['id']];
		$field='goods_name,img_path,goods_num,shop_price, buyer_goods_no, cus_goods_status as goods_status, responsible, damaged, b.sku_str_zh as sku';	
		$goods=M('cus_order_goods_list')->join('goods_sku_comb as b on cus_order_goods_list.sku_comb_id=b.id')->where($condition)->field($field)->find();			//商品信息
		$imgs=M('cus_order_goods_img')->field('img_path')->where($condition)->select();		//凭证图片					
		$logs=M('fx_aftersales_log')->where($condition)->field('id',true)->order('id desc')->select();			// 日志信息
		

		return ['info'=>$info, 'logs'=>$logs,'imgs'=>$imgs, 'goods'=>$goods, 'order'=>$order];
	}

	public function validStatus($condition){				//验证状态是否正确
		return M('cus_order_list')->where($condition)->count();

	}

	public function freight($condition){				//查退运费
		return M('fx_refund_template')->where($condition)->field('from, to, fee as freight')->select();
	}
}