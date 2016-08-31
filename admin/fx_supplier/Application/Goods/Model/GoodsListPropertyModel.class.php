<?php

namespace Goods\Model;

use Think\Model;

class GoodsListPropertyModel extends Model {

    /**
     * [mosaicGoods 添加商品属性]
     * @param  [Int] $mGoodsId    [goods_list表的ID]
     * @param  [Array] $mGoodsKey   [商品的属性名]
     * @param  [Array] $mGoodsKeyZh [商品的属性名中文]
     * @param  [Array] $mGoodsVal   [商品的属性值]
     * @return 
     */
    public function mosaicGoods($mGoodsId, $mGoodsKey, $mGoodsKeyZh, $mGoodsVal) {
        $_data = array();
        $_data['goods_id'] = $mGoodsId;
        $this->where(array('goods_id' => $mGoodsId))->delete();
        foreach ($mGoodsVal as $key => $value) {
            $_data['goods_title'] = $mGoodsKeyZh[$key];
            $_data['goods_key'] = $mGoodsKey[$key];
            $_data['goods_value'] = (String) $mGoodsVal[$key];
            $_datas[] = $_data;
        }
        $this->addAll($_datas);
        unset($_data);
        unset($_datas);
    }

}
