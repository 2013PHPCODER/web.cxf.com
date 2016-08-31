<?php
namespace System\Dal;
class UpdateSqlDal{

	public function freight($data){						//编辑运费模板
		$main=$data['main'];
		$sub=$data['sub'];	
		$id=$data['id'];
		unset($data);

		$condition=['freight_template_id'=>$id];
		$r1=M('fx_freight_template')->where($condition)->update($main);			//更新主数据

		$conn=M('fx_freight_template_special');				//特例数据更新，先删除再插入
		$r2=$conn->where($condition)->delete();			
		$r3=$conn->addAll($sub);

		return $r1 && $r2 && $r3;							//返回三次操作的并
	}

	public function editAdmin($para){					//编辑员工信息
		$data=$para['data'];
		$condition=$para['condition'];

		return M('fx_admin_user')->where($condition)->save($data);
	}

	public function editAdminSelf($para){				//员工自己编辑自己信息，只是密码
		$condition=$para['condition'];
		$data=$para['data'];
		return M('fx_admin_user')->where($condition)->save($data);
	}
}