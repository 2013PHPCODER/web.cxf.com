<?php

namespace Home\Model;

use Think\Model;

class HubOrderModel extends Model{

    /**
     * [getHubList description]
     * @param  string $mWhere [组合搜索条件查询]
     * @param  string $mOrder [排序]
     * @param  string $type    非空的就查询所有
     * @return Array         [description]
     */
    public function getHubList($mWhere = '',$mOrder = '',$type = ''){
        $order_list = M('hub_order');
        if(!empty($type)){
            $_join = 'hub_order_goods ON hub_order_goods.order_id = hub_order.order_id';
            $_join_tow = "goods_list ON goods_list.goods_id = hub_order_goods.goods_id";
            $_list = $order_list->join($_join)->join($_join_tow)->Field('hub_order.order_id')->where($mWhere)->select();
            foreach($_list as $value){
                $_data[] = $value['order_id'];
            }
        }else{
            $_join = 'hub_order_goods ON hub_order_goods.order_id = hub_order.order_id';
            $_join_tow = "goods_list ON goods_list.goods_id = hub_order_goods.goods_id";
            $_field = '*,hub_order.id as hub_id';
            $_count = M('hub_order')->join($_join)->join($_join_tow)->where($mWhere)->count();
            $_page = getPage($_count);
            $order_list->join($_join);
            $order_list->join($_join_tow);
            $_data['list'] = $order_list->where($mWhere)->order($mOrder)->limit($_page->firstRow . ',' . $_page->listRows)->field($_field)->select();
            $_data['sql'] = M('hub_order')->getLastSql();
            foreach($_data['list'] as $k=> $v){
                $_data['list'][$k]['order_memo'] = M('order_list')->where('order_id =' . $v['order_id'])->getField('memo');
                $_data['list'][$k]['goods_price'] = getDistributionPrice($v['goods_id'],$v['shop_id']);
                $_data['list'][$k]['concat_address'] = getOrderConcatAll($v['order_id']);
                $_data['list'][$k]['sku'] = getOrderGoodsSK($v['order_id']);
                $_data['list'][$k]['order_amount'] = M('order_list')->where('order_id =' . $v['order_id'])->getField('order_amount');
                $_data['list'][$k]['img_path'] = M('goods_list')->where('goods_id =' . $v['goods_id'])->getField('img_path');
                $_data['list'][$k]['is_cus'] = M('order_list')->where("order_id=" . $v['order_id'])->getField('is_cus');
            }
            $_data['page'] = $_page->show();
        }
        return $_data;
    }

}
