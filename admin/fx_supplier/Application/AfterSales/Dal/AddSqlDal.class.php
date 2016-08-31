<?php
namespace AfterSales\Dal;
/*
*数据操作层，新增
**by 林澜叶
*/
class AddSqlDal{

	public function afterLog($data){					//写入售后操作日志
		return M('fx_aftersales_log')->addAll($data);
	}
	public function recordFinance($para){					//写入财务流水,会先改变状态
		$conn=M('cus_order_list');
		$condition=$para['condition'];
		$data=$para['data'];
		$finance_data=$para['finance_data'];

		$conn->startTrans();

		$r1=$conn->where($condition)->save($data);
		$r2=M('confirm_success_trade')->add($finance_data);
		$r=$r1 && $r2;
		$r? $conn->commit(): $conn->rollback();

		return $r;
	}

}