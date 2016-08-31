<?php

namespace Goods\Controller;

use Common\Controller\AuthController;

class GoodsController extends AuthController {

    protected $goods_list_model;
    protected $depot_list;
    protected $goods_category_model;

    public function __construct() {
        parent::__construct();
        $this->goods_list_model = new \Goods\Model\GoodsListModel();
        //修改原有一对一关系仓库，修改为多对多
        //$this->depot_list = M('fx_storage_list')->where(array('supplier_user_id' => session('user.id')))->field('id,sname')->select();
//        print_r($this->depot_list);exit;
        $this->depot_list = M('fx_storage_list')->field('id,sname')->select();
        $this->goods_category_model = new \Goods\Model\GoodsCategoryModel();
    }

    /**
     * index 商品列表 默认进入
     * @return 
     */
    public function index() {
        if (1 == I('get.explode_goods/d')) {
            //导出
            $this->exportPriceExecl();
        }
        $_GET['explodeGoods'] = 0;
        $fields = 'gl.goods_id,gl.goods_id,gl.goods_no,gl.buyer_goods_no,su.user_account,gl.goods_name,gp.upyun_path,'
                . 'gl.addtime,.gl.conf_time,gl.goods_category,gl.price,gl.goods_status,gl.goods_sale,gl.new_upload';
        $_datas = $this->goods_list_model->getGoodsList($this->goods_list_model->searchWhere(), I('get.sort') ? str_replace('~', ' ', I('get.sort')) : 'goods_id desc', $fields);
        $goods_sku_comb_model = new \Goods\Model\GoodsSkuCombModel();
        foreach ($_datas['list'] as $key => $value) {
            //取商品sku
            $_datas['list'][$key]['sku_list'] = $goods_sku_comb_model->where(array('goods_id' => $value['goods_id']))->select();
        }
        $this->datas = $_datas;
        $this->depot = $this->depot_list;
        $this->goods_category = $this->goods_category_model->get_category_list();
        $this->show();
    }

    /**
     * passedBatch    批量商品审核ajax操作
     * @return json
     */
    public function passedBatch() {
        $_goods_status = I('post.goods_status');
        if (0 == $_goods_status) {
            $this->aReturn(0, '审核状态错误');
        }
        if (1 == I('post.alldata')) {
            $this->pagesize = 100000;
            $this->datas = $this->goods_list_model->getGoodsList($this->goods_list_model->searchWhere());
            foreach ($this->datas['list'] as $key => $value) {
                $_goods_ids[] = $value['goods_id'];
            }
        } else {
            if (!is_array(I('post.goods'))) {
                $this->aReturn(0, '审核失败');
            }
            $_goods_ids = I('post.goods');
        }
        $total_num = count($_goods_ids);
        $goods_ids = trim(implode(',', $_goods_ids), ',');
        $_error['num'] = 0;
        $_data['goods_status'] = $_goods_status;
        $_data['conf_time'] = time();
        $success = $this->goods_list_model->where(array('goods_id' => array('in', $goods_ids), 'goods_sale' => 1, 'goods_status' => 1))->save($_data);
        $_error['num'] = $total_num - $success;
        $this->log('商品审核' . $total_num . '件，成功:' . $success . '件，失败：' . $_error['num'] . '件,商品id：' . $goods_ids);
        if (0 < $_error['num']) {
            $this->aReturn(1, "审核操作完成，其中{$_error['num']}个商品审核失败");
        }
        $this->aReturn(1, '审核成功');
    }

    /**
     * [updateGoodsSale 商品上下架更新]
     * @return 
     */
    public function updateGoodsSale() {
        $_data['goods_sale'] = I('get.goods_sale/d');
        $_data['goods_id'] = I('get.goods_id/d');
        $_goods_list_db = $this->goods_list_model;
        $_goods_list_db->create($_data);
        if ($_goods_list_db->save()) {
            $this->success((1 == $_goods_list_db->goods_sale ) ? '商品状态更新成功' : '商品状态更新势必', HTTP_REFERER);
        } else {
            $this->error('商品状态更新失败', HTTP_REFERER);
        }
    }

    /**
     * goodsPassed 商品确认ajax操作
     * @return json
     */
    public function goodsPassed() {
        $_goods_id = I('post.goods_id');
        $_goods_status = I('post.goods_status');
        if (0 == $_goods_id) {
            $this->aReturn(0, '商品错误');
        }
        if (0 == $_goods_status) {
            $this->aReturn(0, '商品状态错误');
        }
        $_where['goods_sale'] = 1;
        $_where['goods_id'] = $_goods_id;
        $_where['goods_status'] = 1;
        if (0 == $this->goods_list_model->where($_where)->count()) {
            $this->aReturn(0, '商品错误');
        }
        $_data['goods_status'] = $_goods_status;
        $_data['conf_time'] = time();
        if ($this->goods_list_model->where($_where)->save($_data)) {
            $this->aReturn(1, '商品更新成功');
        }
        $this->aReturn(0, '商品更新失败');
    }

    /**
     * offGoodsSaleBatch 批量下架操作
     * @return [type] [description]
     */
    public function offGoodsSaleBatch() {
        if (1 == I('post.alldata')) {
            $this->pagesize = 100000;
            $this->datas = $this->getGoodsList($this->goods_list_model->searchWhere());
            foreach ($this->datas['list'] as $key => $value) {
                $_goods_ids[] = $value['goods_id'];
            }
        } else {
            if (!is_array(I('post.goods'))) {
                $this->aReturn(0, '商品信息错误');
            }
            $_goods_ids = I('post.goods');
        }
        $_error['num'] = 0;
        $_where['goods_sale'] = 1;
        $_where['new_upload'] = 1;
        $_where['goods_status'] = 3;
        $_where['sale_time'] = array('gt', 0);
        $_data['goods_sale'] = 2;
        $_data['goods_status'] = 1;
        $_data['off_sale_time'] = time();
        foreach ($_goods_ids as $key => $value) {
            $_where['goods_id'] = $value;
            if (!$this->goods_list_model->where($_where)->save($_data)) {
                $_error['num'] ++;
            }
        }
        if (0 < $_error['num']) {
            $this->aReturn(1, "下架操作完成，其中{$_error['num']}个商品未下架成功");
        }
        $this->aReturn(1, '商品下架成功');
    }

    /**
     * goodsOffSaleAjax 单个商品下架操作
     * @return 
     */
    public function goodsOffSaleAjax() {
        $_goods_id = I('post.goods_id');
        if (0 == $_goods_id) {
            $this->aReturn(0, '商品错误');
        }
        $_where['goods_sale'] = 1;
        $_where['goods_id'] = $_goods_id;
        // $_where['new_upload'] 	= 1;
        if (0 == $this->goods_list_model->where($_where)->count()) {
            $this->aReturn(0, '商品错误');
        }
        if (0 == $this->goods_list_model->where("goods_id =" . $_goods_id)->getField('new_upload')) {
            $this->aReturn(0, '商品信息错误');
        }
        $_data['goods_sale'] = 2;
        $_data['goods_status'] = 1;
        $_data['off_sale_time'] = time();
        if ($this->goods_list_model->where($_where)->save($_data)) {
            $this->aReturn(1, '商品下架成功');
        }
        $this->aReturn(0, '商品下架失败');
    }

}
