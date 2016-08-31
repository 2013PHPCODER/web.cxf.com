<?php
namespace Storage\Dal;
/*
*数据操作层，新增
**by 林澜叶
*/
class AddSqlDal{

	public function freight($data){			//增加运费模板
		$main=$data['main'];
		$sub=$data['sub'];	
		$id=M('fx_freight_template')->add($main);		

		if (!$id) {							
			return false;
		}
		if ($sub) {							//如果有特例模板
			foreach ($sub as &$v) {							//生成特例区域的数据
				$v['freight_template_id']=$id;
			}
			M('fx_freight_template_special')->addAll($sub);			//特例区域的增加不做判断，
		}

		return true;

	}


}