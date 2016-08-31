<?php

namespace api\home;

class Goods_sku_combDao extends Dao {

    /**
     * 获取sku中文字符串
     * @param type $goods_sku_comb_id
     * @return string
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    public function get_sku_str($goods_sku_comb_id) {
        $sql = "select sku_str_zh from goods_sku_comb "
                . "where id=:id";
        $param = array(
            'id' => $goods_sku_comb_id
        );
        $result = $this->query($sql, $param);
        if ($result) {
            return $result[0]['sku_str_zh'];
        }
        return '';
    }

    /**
     * 获取商品sku信息
     * @param type $goods_sku_comb_id
     * @param type $fields
     * @return boolean
     * @author Ximeng <ximeng@xingmima.com>
     * @since 2016091301
     */
    public function get_goods_sku_info($goods_sku_comb_id, $fields) {
        $sql = "select {$fields} from goods_sku_comb "
                . "where id=:id";
        $param = array(
            'id' => $goods_sku_comb_id
        );
        $result = $this->query($sql, $param);
        if ($result) {
            return $result[0];
        }
        return false;
    }

}
