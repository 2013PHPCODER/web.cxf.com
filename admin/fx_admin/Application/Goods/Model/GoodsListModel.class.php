<?php

namespace Goods\Model;

use Think\Model;

class GoodsListModel extends Model {

    /**
     * getGoodsList 商品列表
     * @param  Array  $mWhere 查询条件
     * @param  String $mOrder 排序
     * @return Array         
     */
    public function getGoodsList($mWhere = '', $mOrder = '', $fields = '') {
        $_count = $this->where($mWhere)->count();
        $_page = getpage($_count);
        $_goods_list = $this->table('goods_list as `gl`')
                ->join('inner join fx_supplier_user as `su` on su.id=gl.supplier_id')
                ->join('left join goods_img_path as `gp` on gp.md5_path=gl.img_path')
                ->field($fields)
                ->where($mWhere)->order($mOrder);
        if (0 == I('get.explode_goods/d')) {
            $_goods_list = $_goods_list->limit($_page->firstRow . ',' . $_page->listRows);
        }
        $_data['list'] = $_goods_list->select();
        $_data['sql'] = $this->getlastsql();
        $_data['page'] = $_page->show();
        return $_data;
    }

    /**
     * searchWhere 搜索条件组合
     * @return Array 
     */
    public function searchWhere() {
        //商品状态
        $_where['is_delete'] = 0;
        $_where['goods_lack'] = 0;
        if (2 == I('get.group_id')) {
            $_where['new_upload'] = 0;
        }
        if (3 == I('get.group_id')) {
            $_where['goods_sale'] = 2;
            $_where['off_sale_time'] = array('gt', 0);
            $_where['new_upload'] = 1;
        }
        if (4 == I('get.group_id')) {
            $_where['goods_sale'] = 1;
            $_where['sale_time'] = array('gt', 0);
            $_where['goods_status'] = 3;
        }
        if (5 == I('get.group_id')) {
            $_where['goods_status'] = 1;
            $_where['goods_sale'] = 1;
            $_where['new_upload'] = 1;
        }
        if (6 == I('get.group_id')) {
            $_where['goods_status'] = 2;
        }
        //商品状态
        if (2 == I('get.goods_status')) {
            $_where['new_upload'] = 0;
        }
        if (3 == I('get.goods_status')) {
            $_where['goods_sale'] = 2;
            $_where['off_sale_time'] = array('gt', 0);
            $_where['new_upload'] = 1;
        }
        if (4 == I('get.goods_status')) {
            $_where['goods_sale'] = 1;
            $_where['sale_time'] = array('gt', 0);
            $_where['goods_status'] = 3;
        }
        if (5 == I('get.goods_status')) {
            $_where['goods_status'] = 1;
            $_where['goods_sale'] = 1;
            $_where['new_upload'] = 1;
        }
        if (6 == I('get.goods_status')) {
            $_where['goods_status'] = 2;
        }
        //商品id
        if (1 == I('get.explode_goods/d')) {
            if (is_array(I('get.explodeGoods'))) {
                $_where['goods_list.goods_id'] = array('in', I('get.explodeGoods'));
            }
        }
        //商品类目
        if (I('get.goods_category')) {
            $_where['top_category'] = I('get.goods_category', 0);
        }
        //仓库名称
        if (I('get.depot')) {
            $_where['depot_id'] = I('get.depot', 0);
        }
        //上架时间 
        if ('sale_time' == I('get.time_type') and ( I('get.startTime') or I('get.endTime') )) {
            $_startTime = I('get.startTime', 0) ? strtotime(I('get.startTime', 0)) : 1;
            $_endTime = I('get.endTime') ? strtotime(I('get.endTime')) : time();
            $_where['conf_time'] = array('BETWEEN', array($_startTime, $_endTime));
        }
        //下架时间
        if ('off_sale_time' == I('get.time_type') and ( I('get.startTime') or I('get.endTime') )) {
            $_startTime = I('get.startTime', 0) ? strtotime(I('get.startTime', 0)) : 1;
            $_endTime = I('get.endTime') ? strtotime(I('get.endTime')) : time();
            $_where['off_sale_time'] = array('BETWEEN', array($_startTime, $_endTime));
        }
        //上传时间
        if ('addtime' == I('get.time_type') and ( I('get.startTime') or I('get.endTime') )) {
            $_startTime = I('get.startTime', 0) ? strtotime(I('get.startTime', 0)) : 1;
            $_endTime = I('get.endTime') ? strtotime(I('get.endTime')) : time();
            $_where['addtime'] = array('BETWEEN', array($_startTime, $_endTime));
        }
        //商品名称或者货号
        if (0 !== I('get.goods_search', 0)) {
            if ('goods_name' != I('get.goods_search') and 'buyer_goods_no' != I('get.goods_search')) {
                if (I('get.search_word') != '') {
                    $_where[I('get.goods_search')] = I('get.search_word');
                }
            } else {
                if (I('get.search_word') != '') {
                    $_where[I('get.goods_search')] = array('like', "%" . I('get.search_word') . "%");
                }
            }
        }
        return $_where;
    }

  
}
