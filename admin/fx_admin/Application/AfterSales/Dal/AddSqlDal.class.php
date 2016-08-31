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

}