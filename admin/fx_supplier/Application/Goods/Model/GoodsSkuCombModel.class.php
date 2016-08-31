<?php

namespace Goods\Model;

use Think\Model;

class GoodsSkuCombModel extends Model {

    /**
     * addGoodsSkuComb 添加商品sku组合
     * @param int $mGoodsId 商品id
     * @param string $skuProps 商品属性
     * @param type $cid
     * @param type $alias
     * @return boolean
     */
    public function addGoodsSkuComb($mGoodsId, $goods_no, $cid, $skuProps = '', $alias = array(), $input_custom_cpv = array()) {
        $_skuProps = $skuProps == '' ? M('goods_list_property')->where(array('goods_id' => $mGoodsId, 'goods_key' => 'skuProps'))->getField('goods_value') : $skuProps;
        $_count = preg_match_all('/[\.0-9]*:[0-9]*:[^:]*:([-0-9]+:[-0-9]+;)*/', $_skuProps, $sku_data);
        $store_num = 0;
        if (0 < $_count) {
            //导入json数据包
            $_json_file_path = ROOT_DIR . '/Public/static/sku/' . $cid . '.json';
            if (!file_exists($_json_file_path)) {
                return false;
            }
            $_json = file_get_contents($_json_file_path);
            $_json_arr = json_decode($_json, true);
            $sku_list = $sku_data[0];
            $goods_sku = array();
            $sku_name_all = '';
            $comb_data = array();
            $sku_names = array();
            foreach ($sku_list as $value) {
                $sku_str_zh = '';
                $sku_attr = '';
                //sku_data
                preg_match_all('/([-0-9]+:[-0-9]+);/', $value, $rk);
                foreach ($rk[1] as $val) {
                    $sku_attr .= $val . ';';
                    $prop = explode(':', $val);
                    //第一个sku名称
                    $sku_name = $prop[0];
                    $_sku_data = null;
                    $_sku_data['sku_name'] = $sku_name_all = $sku_name;
                    $_sku_data['goods_id'] = $mGoodsId;
                    $sku_val = array();
                    foreach ($sku_list as $sk1) {
                        preg_match_all('/([-0-9]+:[-0-9]+);/', $sk1, $rk1);
                        foreach ($rk1[1] as $sk2) {
                            $prop2 = explode(':', $sk2);
                            if ($prop2[0] == $sku_name && !in_array($prop2[1], $sku_val)) {
                                array_push($sku_val, $prop2[1]);
                            }
                        }
                    }
                    $zh = $this->get_sku_name_zh($_json_arr, $sku_name, array($prop[1]), $alias, $input_custom_cpv);
                    $sku_str_zh .= $zh['sku_name'] . ':' . $zh['sku_val'][0] . ';';
                    if (!in_array($sku_name, $sku_names)) {
                        $sku_val = array_unique($sku_val);
                        $_sku_data['sku_val'] = json_encode($sku_val);
                        if (isset($_sku_data) && !empty($_sku_data)) {
                            $sku_zh = $this->get_sku_name_zh($_json_arr, $_sku_data['sku_name'], $sku_val, $alias, $input_custom_cpv);
                            $_sku_data['sku_name_str'] = $sku_zh['sku_name'];
                            $_sku_data['sku_val_str'] = json_encode($sku_zh['sku_val']);
                            $goods_sku[] = $_sku_data;
                        }
                    }
                    array_push($sku_names, $sku_name);
                    unset($sku_val);
                    unset($_sku_data);
                }
                //sku_comb
                preg_match('/([\.0-9]+)*:([0-9]+)*/', $value, $r);
                $comb['goods_id'] = $mGoodsId;
                $comb['sku_str'] = $value;
                $comb['goods_no'] = $goods_no;
                $comb['sku_str_zh'] = $sku_str_zh;
                $comb['stock_num'] = $r[2];
                $comb['original_price'] = $r[1];
                $comb['market_price'] = 0;
                $comb['sku_attr'] = $sku_attr;
                $comb_data[] = $comb;
                $store_num += $r[2];
                unset($comb);
            }
            if (!empty($goods_sku)) {
                M('goods_list_sku')->addAll($goods_sku);
                unset($goods_sku);
            }
            if (!empty($comb_data)) {
                $this->addAll($comb_data);
                unset($comb_data);
            }
            unset($sku_list);
            unset($_json);
            unset($_json_arr);
        }
        return $store_num;
    }

    /**
     * 获取sku中文(键)
     */
    private function get_sku_name_zh($suorce, $sku_name, $sku_val, $ali_data, $input_custom_cpv) {
        $return_data = array();
        foreach ($suorce as $v) {
            foreach ($v as $vv) {
                if ($vv['pid'] == $sku_name) {
                    $return_data['sku_name'] = $vv['name'];
                    $return_data['sku_val'] = array();
                    foreach ($sku_val as $s) {
                        $name = $sku_name . ':' . $s;
                        if (!empty($ali_data) && array_key_exists($name, $ali_data)) {
                            $val = $ali_data[$name];
                        } else if (!empty($input_custom_cpv) && array_key_exists($name, $input_custom_cpv)) {
                            $val = $input_custom_cpv[$name];
                        } else {
                            $val = $this->get_sku_val_zh($vv['prop_values']['prop_value'], $s);
                        }
                        array_push($return_data['sku_val'], $val);
                    }
                }
            }
        }
        return $return_data;
    }

    /**
     * 获取sku中文(值)
     */
    private function get_sku_val_zh($suorce, $sku_val) {
        foreach ($suorce as $v) {
            if ($v['vid'] == $sku_val) {
                return $v['name'];
            }
        }
    }

}
