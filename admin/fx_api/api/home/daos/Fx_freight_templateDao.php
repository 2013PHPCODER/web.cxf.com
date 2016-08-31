<?php
namespace api\home;

class Fx_freight_templateDao extends Dao {
    /*     * 执行自定义增删改语句 */


    public function getInfo($goods_id){
    	$fields='c.*, a.item_weight as heavy';
    	$sql='select '.$fields.' from goods_list as a join fx_storage_list as b on a.supplier_id=b.supplier_user_id ';
    	$sql.='join fx_freight_template as c on b.freight=c.freight_template_id where a.goods_id=:goods_id and c.status=1  limit 1';		//确保运费模板可用
    	$param=['goods_id'=>$goods_id];
    	$main=$this->query($sql, $param, 'fetch_row');

    	if (!$main) {						//没有找到邮费模板,包邮
    		return false;
    	}
    	$id=$main['freight_template_id'];
    	$fields='*';
    	$sql='select '.$fields. ' from fx_freight_template_special where freight_template_id=:id';
    	$param=['id'=>$id];
    	$sub=$this->query($sql, $param);

    	return ['main'=>$main, 'sub'=>$sub];

    }

}
