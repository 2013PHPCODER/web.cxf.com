<?php
namespace Storage\Dal;
class DeleteSqlDal{

	function freight($condition){
		$r1=M('fx_freight_template')->where($condition)->delete();			//更新主数据			
		M('fx_freight_template_special')->where($condition)->delete();		//特例数据更新，先删除再插入		

		return $r1;							
	}

}