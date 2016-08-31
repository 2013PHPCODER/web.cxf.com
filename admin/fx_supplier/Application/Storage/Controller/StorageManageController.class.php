<?php

namespace Storage\Controller;

use Common\Controller\BasicController;
use Think\Controller;

class StorageManageController extends BasicController {

    public function index() {
        if (1 == I('get.explode_goods/d')) {
            $this->exportStock();
            exit();
        }
        $this->depot = depotList();
        $this->goods_category = goodsCategoryList();
        $_goodsWhere = $this->goodsWhere();
        if (2 == I('get.group_id', 0)) {
            $_goodsWhere['goods_sku_comb.stock_num'] = array('exp', ' <=goods_sku_comb.stock_lock_num and goods_sku_comb.stock_lock_num >0 ');
        }
        $this->datas = $this->getStorage($_goodsWhere, I('get.sort') ? str_replace('~', ' ', I('get.sort')) : 'goods_list.goods_id asc');
        $this->show();
    }

    /**
     * [logEdit 库存日志]
     * @return [type] [description]
     */
    public function logEdit() {
        $this->depot = depotList();
        $this->shipping = system_shipping();
        $this->goods_category = goodsCategoryList();
        $this->datas = $this->getLogCusList($this->logWhere());
        $this->display();
    }

    /**
     * getStorage 获取商品库存
     * @return Array
     */
    public function getStorage($mWhere = '', $mOrder = '', $type = '') {
        $_join = 'goods_sku_comb ON goods_sku_comb.goods_id = goods_list.goods_id ';
        $goods_list = M('goods_list')->join($_join)->where($mWhere)->group('goods_list.goods_id')->select();
        $_count = count($goods_list);
        $_page = getPage($_count);
        $_data['list'] = M('goods_list')->join($_join)->field('goods_list.goods_id,goods_list.goods_sale,goods_list.goods_name,goods_list.goods_no,goods_list.buyer_goods_no,goods_list.stock_num')->where($mWhere)->group('goods_list.goods_id')->order($mOrder)->limit($_page->firstRow . ',' . $_page->listRows)->select();
        $goods_id_list = '';
        foreach ($_data['list'] as $value) {
            $goods_id_list .= $value['goods_id'] . ',';
        }
        $goods_sku_comb_model = new \Goods\Model\GoodsSkuCombModel();
        $skus = $goods_sku_comb_model->field('id,goods_id,sku_str_zh,stock_num,stock_lock_num')->where(array('goods_id' => array('in', trim($goods_id_list, ','))))->select();
        foreach ($_data['list'] as $key => $val) {
            $sku = array();
            foreach ($skus as $v) {
                if ($val['goods_id'] == $v['goods_id']) {
                    $sku[] = $v;
                }
            }
            array_unique($sku);
            $_data['list'][$key]['sku_list'] = $sku;
        }
        
//        foreach ($_data['list'] as $k => $v) {
//            $total = M('goods_sku_comb')->where('goods_id =' . $v['goods_id'])->group('goods_id')->sum('stock_num');
//            $_data['list'][$k]['sku_str_zh'] = M('goods_sku_comb')->where('goods_id =' . $v['goods_id'])->order('id asc')->getField('sku_str_zh', true);
//            $_data['list'][$k]['stock_num'] = M('goods_sku_comb')->where('goods_id =' . $v['goods_id'])->order('id asc')->Field('stock_num,id')->select();
//            $_data['list'][$k]['stock_lock_num'] = M('goods_sku_comb')->where('goods_id =' . $v['goods_id'])->order('id asc')->getField('stock_lock_num', true);
//            $_data['list'][$k]['all_stock'] = $total;
//        }
        $_data['page'] = $_page->show();
        return $_data;
    }

    /**
     * [getLogCusList 日志列表]
     * @param  string $mWhere [搜索条件]
     * @param  string $mOrder [排序方式]
     * @param  string $type   [description]
     * @return [type]         [description]
     */
    public function getLogCusList($mWhere = '', $mOrder = '') {
        $_join_goods_list = 'goods_list ON goods_list.goods_id = log_cus_list.goods_id';
        $_join_goods_sku_com = 'goods_sku_comb ON  goods_sku_comb.id = log_cus_list.sku_comb_id';
        $_field = '*,log_cus_list.id as log_id,log_cus_list.addtime as log_time';
        $_count = M('log_cus_list')->join($_join_goods_list)->join($_join_goods_sku_com)->where($mWhere)->order($mOrder)->count();
        $_page = getPage($_count);
        $_log_list = M('log_cus_list');
        $_log_list->join($_join_goods_list);
        $_log_list->join($_join_goods_sku_com);
        $_data['list'] = $_log_list->where($mWhere)->order($mOrder)->field($_field)->limit($_page->firstRow . ',' . $_page->listRows)->select();
        $_data['sql'] = $_log_list->getLastSql();
        foreach ($_data['list'] as $n => $m) {
            preg_match_all('/([0-9]+:[0-9]+);/', $m['sku_str'], $rk);
            $arr_sku = array();
            foreach ($rk[1] as $k => $v) {
                $sku_key_val = explode(':', $v);
                $sku_name = $sku_key_val[0];
                $sku_val = $sku_key_val[1];
                $_data['goods_id'] = $m['goods_id'];
                $_data['sku_val'] = $sku_val;
                //$sku_val_str = M('goods_sku_list_val')->where($_data)->getField('sku_val_str');
                array_push($arr_sku, $sku_val_str);
            }
            $_data['list'][$n]['sku'] = $arr_sku;
        }
        $_data['page'] = $_page->show();
        return $_data;
    }

    /**
     * [logWhere 日志搜索条件]
     * @return [type] [description]
     */
    public function logWhere() {
        //group_id
//        $_where['goods_list.shop_id'] = $this->user_info['platform'];
        //仓库地址
        if (I('get.depot')) {
            $_where['depot_id'] = I('get.depot');
        }
        //商品类目 
        if (I('get.goods_category')) {
            $_where['category_parent'] = I('get.goods_category');
        }
        //分销商
        if (I('get.buyer_id')) {
            $_where['buyer_id'] = I('get.buyer_id');
        }
        //操作人
        if (I('get.user_id')) {
            $_where['user_id'] = I('get.user_id');
        }
        //操作时间 日志操作时间
        if (I('get.startTime') or I('get.endTime')) {
            $_startTime = I('get.startTime', 0) ? strtotime(I('get.startTime')) : 1;
            $_endTime = I('get.endTime', 0) ? strtotime(I('get.endTime')) : time();
            $_where['log_cus_list.addtime'] = array('BETWEEN', array($_startTime, $_endTime));
        }
        //关键字
        if (I('get.order_search') and I('get.search_word')) {
            if (I('get.order_search') == 'goods_name') {
                $_where['goods_name'] = array('LIKE', '%' . I('get.search_word') . '%');
            } elseif (I('get.order_search') == 'buyer_goods_no') {
                $_where['buyer_goods_no'] = array('LIKE', '%' . I('get.search_word') . '%');
            } else {
                $_where[I('get.order_search')] = I('get.search_word');
            }
        }
        $_where['supplier_id'] = $this->user_info['id']; //查询供应商仓库库存
        return $_where;
    }

    /**
     * [exportStock 导出库存表]
     * @return [type] [description]
     */
    public function exportStock() {
        $xlsCell = array(
            array('goods_id', '商品ID'),
            array('sku_comb_id', 'SKU组合ID'),
            array('buyer_goods_no', '商家编码'),
            array('goods_name', '商品名称'),
            array('goods_color', '颜色'),
            array('goods_size', '尺寸'),
            array('stock_num', '库存')
        );
        $_list = $this->getStockTable($this->goodsWhere());
        foreach ($_list['list'] as $k => $v) {
            $_data[$k]['goods_id'] = $v['goods_id'];
            $_data[$k]['sku_comb_id'] = $v['id'];
            $_data[$k]['buyer_goods_no'] = $v['buyer_goods_no'];
            $_data[$k]['goods_name'] = $v['goods_name'];
            $_data[$k]['stock_num'] = $v['stock_num'];
            preg_match_all('/([0-9]+:[0-9]+);/', $v['sku_str'], $rk);
            $sku_arr = array();
            foreach ($rk[1] as $n => $m) {
                // var_dump($m);
                $sku_key_val = explode(':', $m);
                $sku_name = $sku_key_val[0];
                $sku_val = $sku_key_val[1];
                $_condition['goods_id'] = $v['goods_id'];
                $_condition['sku_val'] = $sku_val;
                // $sku_name_str      =  M('goods_sku_list_name')->where( $_condition )->getField('sku_name_str');
                // $_data['goods_id'] = $v['goods_id'];
                // $_data['sku_val']  = $sku_val;
                //$sku_val_str = M('goods_sku_list_val')->where($_condition)->getField('sku_val_str');
                $sku_arr[] = $sku_val_str;
            }
            $_data[$k]['goods_color'] = $sku_arr[0];
            $_data[$k]['goods_size'] = $sku_arr[1];
        }
        $result = exportExcel('库存表', $xlsCell, $_data);
        exit();
    }

    /**
     * [getStockTable 导出库存]
     * @param  string $mWhere [description]
     * @return [type]         [description]
     */
    public function getStockTable($mWhere = '') {
        $goods_list = M('goods_list');
        $goods_list->join('goods_sku_comb ON goods_sku_comb.goods_id = goods_list.goods_id');
        $_data['list'] = $goods_list->where($mWhere)->select();
        return $_data;
    }

    /**
     * [goodsWhere 库存管理 搜索条件]
     * @return [type] [description]
     */
    public function goodsWhere() {
        $_where['is_delete'] = 0;
        $_where['goods_lack'] = 0;
        //搜索条件
        //仓库地址
        if (I('get.depot')) {
            $_where['depot_id'] = I('get.depot');
        }
        //商品类目
        if (I('get.goods_category')) {
            $_where['top_category'] = I('get.goods_category');
        }

        if (1 == I('get.explode_goods/d')) {
            if (is_array(I('get.explodeGoods'))) {
                $_where['goods_list.goods_id'] = array('in', I('get.explodeGoods'));
            }
        }
        //商品状态
        if (I('get.goods_sale')) {
            $_where['goods_sale'] = I('goods_sale');
        }
        //仓储 管理 时间
        if (I('get.time_type') and ( I('get.startTime') or I('get.endTime') )) {
            $_startTime = I('get.startTime', 0) ? strtotime(I('get.startTime')) : 1;
            $_endTime = I('get.endTime', 0) ? strtotime(I('get.endTime')) : time();
            $_where[I('get.time_type')] = array('BETWEEN', array($_startTime, $_endTime));
        }

        if (I('get.goods_search', 0)) {
            if (I('get.search_word') != '') {
                if (strtolower(I('get.goods_search')) == 'goods_name') {
                    $_where['goods_list.goods_name'] = array('LIKE', '%' . I('get.search_word') . '%');
                } elseif (strtolower(I('get.goods_search')) == 'buyer_goods_no') {
                    $_where['goods_list.buyer_goods_no'] = array('LIKE', '%' . I('get.search_word') . '%');
                } else {
                    $_where['goods_list.' . I('get.goods_search')] = I('get.search_word');
                }
            }
        }
        $_where['supplier_id'] = $this->user_info['id']; //查询供应商仓库库存
        return $_where;
    }

    /**
     * [allEdit 批量库存修改]
     * @return [type] [description]
     */
    public function allEdit() {
        if (I('post.')) {
            if (I('post.type') == 'all') {
                $goods_id = M('goods_list')->getField('goods_id', true);
            }
            if (I('post.goods_id')) {
                $goods_id = I('post.goods_id');
            }
            $sku_comb = M('goods_sku_comb');
            $num = 0;
            try {
                foreach ($goods_id as $k => $v) {
                    $_goods_sku_all = $sku_comb->where('goods_id =' . $v)->Field('id,stock_num')->select();
                    $sku_comb->stock_num = I('post.val');
                    $sku_comb->where('goods_id = ' . $v)->save();
                    /* 批量修改库存 设置日志 */
                    /* 获取商品的所有sku $_goods_sku_all */
                    foreach ($_goods_sku_all as $key => $value) {
                        $_old_stock = $value['stock_num'];
                        $this->setStockLog($value['id'], I('post.val'), $_old_stock);
                        $this->updateStockTime($v);
                    }
                }
            } catch (Exception $e) {
                echo $e->getMessage();
                exit();
            }
            $_data['status'] = "ok";
            $this->ajaxReturn($_data);
        }
    }

    /**
     * [setStockLog 单个设置商品库存]
     * @param [type] $mskuId  商品sku_id
     * @param [type] $mstock  修改后的库存
     * @param [type] $moldStock  以前的库存
     */
    public function setStockLog($mskuId, $mstock, $moldStock) {
        $sku_comb = M('goods_sku_comb');
        $goods_id = $sku_comb->where('id =' . $mskuId)->getField('goods_id');
        //$goods_info  = M('goods_list')->where('goods_id ='.$sku_val['goods_id'])->find();
        $goods_info = M('goods_list')->where('goods_id = ' . $goods_id)->find();
        /* 更新到库存 */
        $log_cus_list = M('log_cus_list');
        $log_cus_list->addtime = time();
        $log_cus_list->user_id = $this->user_info['id'];
        $log_cus_list->goods_id = $goods_info['goods_id'];
        $log_cus_list->log_info = !empty($info) ? $info : "修改库存";
        $log_cus_list->sku_comb_id = $mskuId;
        $log_cus_list->ip_address = get_client_ip();
        $log_cus_list->start_num = $moldStock;
        $log_cus_list->end_num = $mstock;
        $log_cus_list->add();
    }

    /**
     * [updateStockTime 更新库存时间]
     * @param  [type] $mgoodsId [商品ID]
     * @return [type]           [description]
     */
    public function updateStockTime($mgoodsId) {
        $goods_list = M('goods_list');
        $goods_list->stock_update_time = time();
        $goods_list->where("goods_id = $mgoodsId")->save();
    }

}
