<?php
namespace Storage\Dal;
class QuerySqlDal{


	public function freightList($para){
		$p=$para['p'];
		$key=$para['key'];
		if ($key) {
			$condition=['status'=>1, 'a.name'=>['like', "%$key%"]];
		}else{
			$condition=['status'=>1, 'supplier_user_id'=>session('user_info.id')];
		}

		$field='a.freight_template_id as id, a.name, a.start_heavy, a.continue_heavy, a.start_freight, a.continue_freight, a.is_free, count(b.freight_template_id) as special';
		
		$conn=M('fx_freight_template as a');
		$list=$conn->join('left join fx_freight_template_special as b on a.freight_template_id=b.freight_template_id')->where($condition)->field($field)->group('a.freight_template_id')->limit(($p-1)*20, 20)->select();
		$total=$conn->where($condition)->count();
		return ['list'=>$list, 'total'=>$total];

	}

	public function freightDetail($para){
		$id=$para['id'];

		$condition=['a.freight_template_id'=>$id];
		$field='a.freight_template_id as id, a.name, a.start_heavy, a.continue_heavy, a.start_freight, a.continue_freight, a.is_free';
		$main=M('fx_freight_template as a')->where($condition)->field($field)->find();

		$field='a.name, a.start_heavy, a.continue_heavy, a.start_freight, a.continue_freight, a.area as code';
		$sub=M('fx_freight_template_special as a')->where($condition)->field($field)->select();

		return ['main'=>$main, 'sub'=>$sub];
	}
	public function checkFreight($condition){				//检查运费模板
		return M('fx_storage_list')->where($condition)->count();
	}
}