<?php
namespace Storage\Dal;
class UpdateSqlDal{

	function freight($para){
		$condition=$para['condition'];
		$data=$para['data'];
		$main=$data['main'];
		$sub=$data['sub'];	
		$id=$data['id'];
		unset($data);

		$r1=M('fx_freight_template')->where($condition)->save($main);			//更新主数据

		$conn=M('fx_freight_template_special');				//特例数据更新，先删除再插入
		$r2=$conn->where($condition)->delete();			
		$r3=$conn->addAll($sub);

		return true;
	}

}