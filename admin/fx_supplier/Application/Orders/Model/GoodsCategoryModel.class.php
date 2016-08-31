<?php

/**
 * 商品类目model
 * @author Simon 
 */

namespace Orders\Model;

use Think\Model;

class GoodsCategoryModel extends Model {

    /**
     * goodsCategoryList 商品类目列表
     * @return [type] [description]
     */
    public function goodsCategoryList($mParentId = 0) {
        return $this->field('cid,name')->where("parent_cid = {$mParentId}")->order('cid asc')->select();
    }

}
