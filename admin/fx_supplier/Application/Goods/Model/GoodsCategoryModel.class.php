<?php

namespace Goods\Model;

use Think\Model;

class GoodsCategoryModel extends Model {

    public function get_category_list($user_id) {
        $sql = 'SELECT DISTINCT(gc.cid),gc.`name` FROM `goods_list` as gl INNER JOIN goods_category as gc on gl.top_category=gc.cid where
 gl.supplier_id=' . $user_id;
        return D()->query($sql);
//        return $this->field('cid,name')->where(array('parent_cid' => $mParentId))->order('cid asc')->select();
    }

}
