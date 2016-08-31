<?php
namespace System\Dal;
class QuerySqlDal{



	public function logs($para){			//操作记录
		$condition=$para['condition'];
		$p=$para['p'];
		$conn=M('fx_operate_logs as a');
		$field='a.user_id as id, a.detail, a.module, a.add_time';

		if ($condition) {
			$list=$conn->where($condition)->field($field)->limit(($p-1)*20, 20)->order('add_time desc')->select();
			$total=$conn->where($condition)->count();
		}else{
			$list=$conn->field($field)->limit(($p-1)*20, 20)->order('add_time desc')->select();
			$total=$conn->count();
		}


		return ['list'=>$list, 'total'=>$total];
	}


}