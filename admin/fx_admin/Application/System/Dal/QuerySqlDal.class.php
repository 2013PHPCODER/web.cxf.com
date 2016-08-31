<?php
namespace System\Dal;
class QuerySqlDal{



	public function adminList($condition=null){			//管理员列表
		$conn=M('fx_admin_user');
		if ($condition) {
			$list=$conn->where($condition)->field('pwd', true)->select();
		}else{
			$list=$conn->field('pwd, auth', true)->select();
		}
		return $list;
	}
	public function adminNameList(){				//获取所有管理员的姓名和id列表
		return M('fx_admin_user')->field('admin_user_id as id, name')->select();
	}


	public function adminDetail($condition){			//员工详细资料
		return M('fx_admin_user')->where($condition)->field('pwd, add_time, update_time', true)->find();
	}

	public function logs($para){			//操作记录
		$condition=$para['condition'];
		$p=$para['p'];
		$conn=M('fx_admin_logs as a');
		$field='a.admin_user_id as id, a.detail, a.module, a.add_time, b.name';

		if ($condition) {
			$list=$conn->where($condition)->field($field)->join('fx_admin_user as b on a.admin_user_id=b.admin_user_id')->limit(($p-1)*20, 20)->order('add_time desc')->select();
			$total=$conn->where($condition)->count();
		}else{
			$list=$conn->field($field)->join('fx_admin_user as b on a.admin_user_id=b.admin_user_id')->limit(($p-1)*20, 20)->order('add_time desc')->select();
			$total=$conn->count();
		}
		return ['list'=>$list, 'total'=>$total];
	}
	public function supplierLogs($para){			//供应商日志
		$condition=$para['condition'];
		$p=$para['p'];
		$conn=M('fx_operate_logs as a');
		$field='a.user_id as id, a.detail, a.module, a.add_time, a.user_name as name';

		if ($condition) {
			$list=$conn->where($condition)->field($field)->limit(($p-1)*20, 20)->order('add_time desc')->select();
			$total=$conn->where($condition)->count();
		}else{
			$list=$conn->field($field)->limit(($p-1)*20, 20)->order('add_time desc')->select();
			$total=$conn->count();
		}
		return ['list'=>$list, 'total'=>$total];
	}
	public function messageList($para){
		$condition=$para['condition'];
		$p=$para['p'];
		$sort=$para['sort'];
		$list=M('fx_notice')->where($condition)->limit(($p-1)*20, 20)->order('id '.$sort)->select();
		$total==M('fx_notice')->where($condition)->count();
		return ['list'=>$list, 'total'=>$total];
	}

}