<?php

namespace Home\Controller;

use Think\Controller;

/**
 * 
 */
class SkuController extends Controller{

    public function getSkuAll(){
        $_goods_list = M('goods_list')->field('goods_id')->select();
        foreach($_goods_list as $k=> $v){
            $this->addGoodsSkuComb($v['goods_id']);
        }
    }

    public function addGoodsKeyVal($mGoodsId,$mSkuStr){
        preg_match_all('/([0-9]+:[0-9]+);/',$mSkuStr,$rk);
        foreach($rk[1] as $kk=> $vv){
            $sku_key_val = explode(':',$vv);
            $_where = NULL;
            $_data = NULL;
            $_where['goods_id'] = $mGoodsId;
            $_where['sku_name'] = $sku_key_val[0];

            if(0 == M('goods_sku_list_name')->where($_where)->count()){
                $_data['goods_id'] = $mGoodsId;
                $_data['sku_name'] = $sku_key_val[0];
                $sku_key_id = M('goods_sku_list_name')->add($_data);
            }else{
                $sku_key_id = M('goods_sku_list_name')->where($_where)->getField('id');
            }
            $_data = NULL;
            $_where = NULL;
            $_where['goods_id'] = $mGoodsId;
            $_where['sku_id'] = $sku_key_id;
            $_where['sku_val'] = $sku_key_val[1];

            if(0 == M('goods_sku_list_val')->where($_where)->count()){
                $_data['goods_id'] = $mGoodsId;
                $_data['sku_id'] = $sku_key_id;
                $_data['sku_val'] = $sku_key_val[1];
                M('goods_sku_list_val')->add($_data);
            }
        }
    }

    public function addGoodsSkuComb($mGoodsId){
        $_where['goods_id'] = $mGoodsId;
        $_where['goods_key'] = 'skuProps';
        $_skuProps = M('goods_list_property')->where($_where)->getField('goods_value');
        $_count = preg_match_all('/[0-9]*:[0-9]*:[^:]*:([0-9]+:[0-9]+;)*/',$_skuProps,$return_array);
        if(0 < $_count){
            foreach($return_array[0] as $key=> $value){
                $this->addGoodsKeyVal($mGoodsId,$value);
                $_data = NULL;
                preg_match('/([0-9]+)*:([0-9]+)*/',$value,$r);
                $_data['goods_id'] = $mGoodsId;
                $_data['sku_str'] = $value;
                $_data['stock_num'] = $r[2];
                $_comb_id = M('goods_sku_comb')->add($_data);
                $_data = NULL;
                $_system_shop_list = M('system_shop')->select();
                foreach($_system_shop_list as $k=> $v){
                    $_data['goods_id'] = $mGoodsId;
                    $_data['shop_id'] = $v['id'];
                    $_data['comb_id'] = $_comb_id;
                    $_data['original_price'] = $r[1];
                    $_data['market_price'] = $r[1];
                    $_data['distribution_price'] = $r[1];
                    M('goods_price')->add($_data);
                }
            }
        }
    }

}
