<?php

namespace Goods\Controller;

use Common\Controller\BasicController;

class GoodsController extends BasicController {

    protected $goods_list_model;
    protected $depot_list;
    protected $goods_category_model;

    public function __construct() {
        parent::__construct();
        $this->goods_list_model = new \Goods\Model\GoodsListModel();
        //修改原有一对一关系仓库，修改为多对多
        $this->depot_list = M('fx_storage_list')->where(array('supplier_user_id' => $this->user_info['id']))->field('id,sname')->select();
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
        $_datas = $this->goods_list_model->getGoodsList($this->goods_list_model->searchWhere($this->user_info['id']), I('get.sort') ? str_replace('~', ' ', I('get.sort')) : 'goods_id desc' );
        $goods_sku_comb_model = new \Goods\Model\GoodsSkuCombModel();
        $goods_id_list = '';
        foreach ($_datas['list'] as $value) {
            $goods_id_list .= $value['goods_id'] . ',';
            //取商品sku
//            $_datas['list'][$key]['sku_list'] = $goods_sku_comb_model->where(array('goods_id' => $value['goods_id']))->select();
        }
        $skus = $goods_sku_comb_model->where(array('goods_id' => array('in', trim($goods_id_list, ','))))->select();
        foreach ($_datas['list'] as $key => $val) {
            $sku = array();
            foreach ($skus as $v) {
                if ($val['goods_id'] == $v['goods_id']) {
                    $sku[] = $v;
                }
            }
            array_unique($sku);
            $_datas['list'][$key]['sku_list'] = $sku;
        }
        unset($skus);
        $this->datas = $_datas;
        $this->depot = $this->depot_list;
        $this->goods_category = $this->goods_category_model->get_category_list($this->user_info['id']);
        $this->show();
    }

    /**
     * importGoods 新增商品
     * @return
     */
    public function importGoods() {
        $goods_error_model = new \Goods\Model\GoodsErrorModel();
        $_where['user_name'] = $this->user_info['user_account'];
        $_count = $goods_error_model->join("__GOODS_LIST__ ON __GOODS_ERROR__.goods_id = __GOODS_LIST__.goods_id")->where($_where)->count();
        $_page = getpage($_count);
        $goods_error_list = $goods_error_model
                ->field('goods_error.addtime,goods_error.goods_lack_momo,goods_list.goods_category,goods_list.goods_name,goods_list.buyer_goods_no,goods_list.img_path')
                ->join("__GOODS_LIST__ ON __GOODS_ERROR__.goods_id = __GOODS_LIST__.goods_id")
                ->where($_where)
                ->limit($_page->firstRow . ',' . $_page->listRows)
                ->select();
        foreach ($goods_error_list as $key => $value) {
            $value['goods_lack_momo'] = unserialize($value['goods_lack_momo']);
            $value['goods_lack_momo'] = implode(',', $value['goods_lack_momo']['goods_lack_momo']);
            $_datas['list'][$key] = $value;
        }
        $_datas['page'] = $_page->show();
        $this->datas = $_datas;
        $this->depot = $this->depot_list;
        $this->show();
    }

    /**
     * addImportGoods 新增商品
     * @return 
     */
    public function addImportGoods() {
        $upload_size = get_upload_size($this->user_info['leavel']);
        $targetFolder = C('UPLOAD_URL');
        if (!is_dir(ROOT_DIR . $targetFolder)) mkdir(ROOT_DIR . $targetFolder, 0777, true);
        $upload = new \Think\Upload(); // 实例化上传类
        $upload->maxSize = 1024 * 1024 * 200; // 设置附件上传大小
        $upload->exts = array('csv'); // 设置附件上传类型
        $upload->rootPath = "." . $targetFolder; // 设置附件上传根目录
        $upload->subName = array('date', 'Ymd'); // 设置附件上传根目录
        $upload->saveName = '';
        $upload->replace = true;
        // 上传文件
        $info = $upload->upload();
        if (!$info) {
            //上传错误提示错误信
            $this->aReturn(0, $upload->getError(), array('returnData' => 0));
        } else {
            //上传成功
            if ('csv' == $info['file']['ext']) {
                $_file_path = $targetFolder . $info['file']['savepath'] . $info['file']['savename'];
                $_returnData = $this->goods_list_model->saveGoods($upload_size, $_file_path, $this->user_info, array('depot_id' => I('post.depot_id/d')));
                if ($_returnData['_total_num'] > 0) {
                    $this->log('上传' . $_returnData['_total_num'] . '件商品,成功：' . $_returnData['_total_ok'] . '件，失败：' . $_returnData['_error_num'] . '商品id为：' . json_encode($_returnData['goods_ids']));
                }
                unset($_returnData['goods_ids']);
            }
            if ($_returnData['_total_num'] == 0) {
                $this->aReturn(0, '导入成功数量为0，请检查是否超过允许上传最大数量或是重复上传！');
            }
            $this->aReturn(1, '导入成功', $_returnData);
        }
        $this->aReturn(0, '导入失败');
    }

    /**
     * updateGoodsStatus 商品状态更新
     * @return 
     */
//    public function updateGoodsStatus() {
//        $_data['goods_status'] = I('get.goods_status/d');
//        $_data['goods_id'] = I('get.goods_id/d');
//        $_goods_list_db = $this->goods_list_model;
//        $_goods_list_db->create($_data);
//        if ($_goods_list_db->where(array('supplier_id' => $this->user_info['id']))->save()) {
//            $this->success('商品状态更新成功', HTTP_REFERER);
//        } else {
//            $this->error('商品状态更新失败', HTTP_REFERER);
//        }
//    }

    /**
     * goodsSaleAjax 商品上架操作
     * @return 
     */
    public function goodsSaleAjax() {
        $_goods_id = I('post.goods_id');
        if (0 == $_goods_id) {
            $this->aReturn(0, L('_GOODS_PARAME_FAILURE_'));
        }
        $_where['goods_sale'] = 2;
        $_where['goods_id'] = $_goods_id;
        $_where['supplier_id'] = $this->user_info['id'];
        $count = $this->goods_list_model->where($_where)->count();
        if (0 == $count) {
            $this->aReturn(0, '商品错误');
        }
        $_data['goods_sale'] = 1;
        $_data['new_upload'] = 1;
        $_data['sale_time'] = time();
        if ($this->goods_list_model->where($_where)->save($_data)) {
            $this->aReturn(1, '提交成功');
        }
        $this->aReturn(0, '提交失败');
    }

    /**
     * updateGoodsSaleBatch 批量上架操作
     * @return  josn
     */
    public function updateGoodsSaleBatch() {
        if (1 == I('post.alldata')) {
            $this->pagesize = 100000;
            $this->datas = $this->getGoodsList($this->goods_list_model->searchWhere($this->user_info['id']));
            foreach ($this->datas['list'] as $value) {
                $_goods_ids[] = $value['goods_id'];
            }
        } else {
            if (!is_array(I('post.goods'))) {
                $this->aReturn(0, '商品错误');
            }
            $_goods_ids = I('post.goods');
        }
        $_where['goods_sale'] = 2;
        $_where['supplier_id'] = $this->user_info['id'];
        $_where['goods_id'] = array('IN', $_goods_ids);
        $_data['goods_sale'] = 1;
        $_data['new_upload'] = 1;
        $_data['sale_time'] = time();
        $total = count($_goods_ids);
        $finish_num = $this->goods_list_model->where($_where)->save($_data);
        $_error_num = $total - $finish_num;
        $this->aReturn(1, $_error_num ? '商品上架操作完成！其中共' . $_error_num . '个商品上架操作失败' : '商品上架操作成功');
    }

    /**
     * goodsDeleteBatch 批量删除
     * @return 
     */
    public function goodsDeleteBatch() {
        if (1 == I('post.alldata')) {
            $this->pagesize = 100000;
            $this->datas = $this->getGoodsList($this->goods_list_model->searchWhere($this->user_info['id']));
            foreach ($this->datas['list'] as $value) {
                $_goods_ids[] = $value['goods_id'];
            }
        } else {
            if (!is_array(I('post.goods'))) {
                $this->aReturn(0, '商品错误');
            }
            $_goods_ids = I('post.goods');
        }
        $_where['goods_status'] = array('IN', '1,2');
        $_where['supplier_id'] = $this->user_info['id'];
        $_where['goods_id'] = array('IN', $_goods_ids);
        $_data['is_delete'] = 1;
        $total = count($_goods_ids);
        $finish_delete = $this->goods_list_model->where($_where)->save($_data);
        $not_delete = $total - $finish_delete;
        if ($not_delete > 0) {
            if ($finish_delete > 0) {
                $this->aReturn(1, '删除成功' . $finish_delete . '个，其中有' . $not_delete . '个商品不能操作');
            } else {
                $this->aReturn(0, '没有可删除的商品，不能操作');
            }
        }
        $this->aReturn(1, '删除成功');
    }

    /**
     * goodsDelete 单个商品删除操作
     * @return [type] [description]
     */
    public function goodsDelete() {
        $_goods_id = I('post.goods_id');
        if (0 == $_goods_id) {
            $this->aReturn(0, L('_GOODS_PARAME_FAILURE_'));
        }
        $_where['goods_status'] = array('IN', '1,2');
        $_where['goods_id'] = $_goods_id;
        $_where['supplier_id'] = $this->user_info['id'];
        if (0 == $this->goods_list_model->where($_where)->count()) {
            $this->aReturn(0, '删除失败');
        }
        $_data['is_delete'] = 1;
        if ($this->goods_list_model->where($_where)->save($_data)) {
            $this->aReturn(1, '删除成功');
        }
        $this->aReturn(0, '删除失败');
    }

    /**
     * offGoodsSaleBatch 批量下架操作
     * @return [type] [description]
     */
    public function offGoodsSaleBatch() {
        if (1 == I('post.alldata')) {
            $this->pagesize = 100000;
            $this->datas = $this->getGoodsList($this->goods_list_model->searchWhere($this->user_info['id']));
            foreach ($this->datas['list'] as $key => $value) {
                $_goods_ids[] = $value['goods_id'];
            }
        } else {
            if (!is_array(I('post.goods'))) {
                $this->aReturn(0, '商品错误');
            }
            $_goods_ids = I('post.goods');
        }
        $_error['num'] = 0;
        $_where['goods_sale'] = 1;
        $_where['new_upload'] = 1;
        $_where['goods_status'] = 3;
        $_where['goods_id'] = array('IN', $_goods_ids);
        $_where['sale_time'] = array('gt', 0);
        $_where['supplier_id'] = $this->user_info['id'];
        $_data['goods_sale'] = 2;
        $_data['goods_status'] = 1;
        $_data['off_sale_time'] = time();
        $total = count($_goods_ids);
        $suc_num = $this->goods_list_model->where($_where)->save($_data);
        $error_num = $total - $suc_num;
        if (0 < $error_num) {
            $this->aReturn(1, '下架操作完成，其中' . $error_num . '个商品未下架成功');
        }
        $this->aReturn(1, '下架成功');
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
        $_where['supplier_id'] = $this->user_info['id'];
        if (0 == $this->goods_list_model->where($_where)->count()) {
            $this->aReturn(0, '商品错误');
        }
        if (0 == $this->goods_list_model->where(array('goods_id' => $_goods_id, 'supplier_id' => $this->user_info['id']))->getField('new_upload')) {
            $this->aReturn(0, '商品错误');
        }
        $_data['goods_sale'] = 2;
        $_data['goods_status'] = 1;
        $_data['off_sale_time'] = time();
        if ($this->goods_list_model->where($_where)->save($_data)) {
            $this->aReturn(1, '下架成功');
        }
        $this->aReturn(0, '下架失败');
    }

    /**
     * [cancelPassedBatch 商品批量取消操作
     * @return 
     */
    public function cancelPassedBatch() {
        if (1 == I('post.alldata')) {
            $this->pagesize = 100000;
            $this->datas = $this->getGoodsList($this->goods_list_model->searchWhere($this->user_info['id']));
            foreach ($this->datas['list'] as $key => $value) {
                $_goods_ids[] = $value['goods_id'];
            }
        } else {
            if (!is_array(I('post.goods'))) {
                $this->aReturn(0, '商品错误');
            }
            $_goods_ids = I('post.goods');
        }

        $_where['goods_status'] = 1;
        $_where['goods_sale'] = 1;
        $_where['supplier_id'] = $this->user_info['id'];
        $_data['goods_sale'] = 2;
        $_data['goods_status'] = 1;
        $_goods_total = 0;
        $_goods_update_success = 0;
        $_goods_update_failed = 0;
        foreach ($_goods_ids as $key => $value) {
            $_data['new_upload'] = 1;
            if (1 == $this->goods_list_model->where(array('goods_id' => $value, 'supplier_id' => $this->user_info['id'], 'off_sale_time' => 0))->count()) {
                $_data['new_upload'] = 0;
            }
            $_goods_total++;
            $_where['goods_id'] = $value;
            if ($this->goods_list_model->where($_where)->save($_data)) {
                $_goods_update_success ++;
            } else {
                $_goods_update_failed++;
            }
        }
        $this->aReturn(1, ($_goods_total == $_goods_update_success) ? '商品取消操作成功' : '商品取消操作完成!共' . $_goods_update_failed . '个商品未能取消成功');
    }

    /**
     * goodsCancelSale 商品取消
     * @return 
     */
    public function goodsCancelSale() {
        $_goods_id = I('post.goods_id');
        if (0 == $_goods_id) {
            $this->aReturn(0, '商品错误');
        }
        if (0 == $this->goods_list_model->where(array('goods_id' => $_goods_id, 'supplier_id' => $this->user_info['id']))->getField('off_sale_time')) {
            $_data['new_upload'] = 0;
        }
        $_data['goods_sale'] = 2;
        $_where['goods_sale'] = 1;
        $_where['goods_id'] = $_goods_id;
        $_where['supplier_id'] = $this->user_info['id'];
        $_data['goods_status'] = 1;
        if ($this->goods_list_model->where($_where)->save($_data)) {
            $this->aReturn(1, '取消成功');
        }
        $this->aReturn(0, '取消失败');
    }

    /**
     * [updateGoodsSale 商品上下架更新]
     * @return 
     */
//    public function updateGoodsSale() {
//        $_data['goods_sale'] = I('get.goods_sale/d');
//        $_data['goods_id'] = I('get.goods_id/d');
//        $_goods_list_db = $this->goods_list_model;
//        $_goods_list_db->create($_data);
//        if ($_goods_list_db->where(array('supplier_id' => $this->user_info['id']))->save()) {
//            $this->success((1 == $_goods_list_db->goods_sale ) ? L('_UPDATE_GOODS_SALE_SUCCESS_') : L('_UPDATE_GOODS_OFFSALE_FAILURE_'), HTTP_REFERER);
//        } else {
//            $this->error(L('_UPDATE_GOODS_STATUS_FAILURE_'), HTTP_REFERER);
//        }
//    }

    /**
     * 	 添加商品货号
     *  'goods_art_no.goods_id ='.$art_no['goods_id']." and
     */
//    public function addArtNo() {
//        $art_no['goods_id'] = I('post.goods_id');
//        $art_no['art_no'] = I('post.art_no');
//        $goods_info = $this->goods_list_model->field('buyer_goods_no,goods_category,supplier_id,')
//                        ->where(array('goods_id' => $art_no['goods_id'], 'supplier_id' => $this->user_info['id']))->find();
//        $_count = 0;
//        if (strtolower($goods_info['buyer_goods_no']) == strtolower($art_no['art_no'])) {
//            $_count++;
//        }
//        $_where['goods_category'] = $goods_info['goods_category'];
//        $_where['supplier_id'] = $goods_info['supplier_id'];
//        $_where['buyer_goods_no'] = $updata['buyer_goods_no'] = $art_no['art_no'];
//        $count_art_no = $this->goods_list_model->join('goods_art_no ON goods_art_no.goods_id =goods_list.goods_id ')
//                ->field('art_no')
//                ->where(array('art_no' => $art_no['art_no'], 'goods_list.goods_category' => $goods_info['goods_category']))
//                ->count('art_no');
//        if ($count_art_no > 0) {
//            $this->aReturn(0, "商家编码已存在");
//        } else {
//            $art_no['addtime'] = time();
//            $result = $this->goods_list_model->where("goods_id=" . $art_no['goods_id'])->save($updata);
//            if ($result) {
//                if (M('goods_art_no')->add($art_no)) {
//                    $this->aReturn(1, L('ADD_SUCCESS'));
//                } else {
//                    $this->aReturn(0, L('ADD_FAILURE'));
//                }
//            }
//        }
//    }

    /**
     * [getArtNoList 取商品编号]
     * @param  int $mGoodsId 商品ID
     * @param  int $mNum     商品数量
     * @return 
     */
//    public function getArtNoList($mGoodsId, $mNum = '') {
//        return M('goods_art_no')->where(array('goods_id' => $mGoodsId))->select();
//    }

    /**
     * exportPriceExecl 导出价格电子表格
     * @return [type] [description]
     */
//    public function exportPriceExecl() {
//        $xlsCell = array(
//            array('goods_no', '商品编号'),
//            array('buyer_goods_no', '商家编码'),
//            array('original_price', '成本价'),
//            array('distribution_price', '分销价'),
//            array('market_price', '市场价')
//        );
//        $this->pagesize = 100000;
//        $this->datas = $this->goods_list_model->outPutGoodsList($this->goods_list_model->searchWhere($this->user_info['id']), '', 'goods_list.goods_no,goods_list.buyer_goods_no,goods_sku_comb.original_price,goods_sku_comb.market_price,goods_sku_comb.distribution_price');
//        $_data = array();
//        foreach ($this->datas['list'] as $key => $value) {
//            $_data[$key]['goods_no'] = $value['goods_no'];
//            $_data[$key]['buyer_goods_no'] = $value['buyer_goods_no'];
//            $_data[$key]['original_price'] = $value['original_price'];
//            $_data[$key]['market_price'] = $value['market_price'];
//            $_data[$key]['distribution_price'] = $value['distribution_price'];
//        }
//        exportExcel('价格表', $xlsCell, $_data);
//        exit;
//    }

    /**
     * goodsPassed 商品确认ajax操作
     * @return json
     */
//    public function goodsPassed() {
//        $_goods_id = I('post.goods_id');
//        $_goods_status = I('post.goods_status');
//        if (0 == $_goods_id) {
//            $this->aReturn(0, L('_GOODS_PARAME_FAILURE_'));
//        }
//        if (0 == $_goods_status) {
//            $this->aReturn(0, L('_GOODS_PARAME_FAILURE_'));
//        }
//
//        $_where['goods_sale'] = 1;
//        $_where['goods_id'] = $_goods_id;
//        $_where['goods_status'] = 1;
//        $_where['supplier_id'] = $this->user_info['id'];
//        if (0 == $this->goods_list_model->where($_where)->count()) {
//            $this->aReturn(0, L('_GOODS_PARAME_FAILURE_'));
//        }
//        $_data['goods_status'] = $_goods_status;
//        $_data['conf_time'] = time();
//        if ($this->goods_list_model->where($_where)->save($_data)) {
//            $this->aReturn(1, L('_GOODS_REVIEW_SUCCESS_'));
//        }
//        $this->aReturn(0, L('_GOODS_REVIEW_FAILURE_'));
//    }

    /**
     * goodsSale 商品上架
     * @return [type] [description]
     */
//    public function goodsSale() {
//        $_goods_ids = '';
//        if (1 == I('post.alldata')) {
//            $this->pagesize = 100000;
//            $this->datas = $this->getGoodsList($this->goods_list_model->searchWhere($this->user_info['id']));
//            foreach ($this->datas['list'] as $value) {
//                $_goods_ids[] = $value['goods_id'];
//            }
//        } else {
//            if (!is_array(I('post.goods'))) {
//                $this->aReturn(0, '商品错误');
//            }
//            $_goods_ids = I('post.goods');
//        }
//        foreach ($_goods_ids as $val) {
//            $_where['goods_id'] = $val;
//            $_where['goods_sale'] = 2;
//            $_where['supplier_id'] = $this->user_info['id'];
//            $_data['goods_sale'] = 1;
//            $_data['new_upload'] = 1;
//            $this->goods_list_model->where($_where)->save($_data);
//        }
//        $this->aReturn(1, '更新成功');
//    }

    /**
     * goodsNoList 商品货号列表
     * @return
     */
//    public function goodsNoList() {
//        if (I('get.goods_search', 0)) {
//            if ('goods_no' == I('get.goods_search')) {
//                if (I('get.search_word') != '') {
//                    $_where[I('get.goods_search')] = I('get.search_word');
//                }
//            } else {
//                if (I('get.search_word') != '') {
//                    $_where[I('get.goods_search')] = array('like', "%" . I('get.search_word') . "%");
//                }
//            }
//        }
//        $_where['is_delete'] = 0;
//        $_where['goods_lack'] = 0;
//        $_where['supplier_id'] = $this->user_info['id'];
////        $_datas = $this->goods_list_model->getGoodsList($_where, '');
//        $_datas = $this->goods_list_model->getGoodsList($_where, '', 'goods_id,goods_no,buyer_goods_no as `art_no`,goods_name,addtime,goods_status,goods_sale');
////        foreach ($_datas['list'] as $key => $value) {
////            $value['goodsArtList'] = M('goods_art_no')->where("goods_id = {$value['goods_id']}")->select();
////            $_datas['list'][$key] = $value;
////        }
//        $this->datas = $_datas;
//        $this->show();
//    }

    /**
     * importPrice  导入价格
     * @return [type] [description]
     */
//    public function importPrice() {
//        layout(false);
//        $this->shop = $this->system_shop_model->select();
//        $this->show();
//    }

    /**
     * [importPriceAdd 商品价格导入
     * @return json
     */
//    public function importPriceAdd() {
//        $_price_list = $this->loadExecl();
//        $_error_num = 0;
//        $goods_sku_comb_model = new \Goods\Model\GoodsSkuCombModel();
//        foreach ($_price_list as $value) {
//            if (0 > $value['E'] || 0 > $value['C'] || 0 > $value['D']) {
//                $_error_num ++;
//                continue;
//            }
//            $_where['goods_no'] = $value['A'];
//            $_where['supplier_id'] = $this->user_info['id'];
//            $_data['original_price'] = $value['C'];
//            $_data['market_price'] = $value['E'];
//            $_data['distribution_price'] = $value['D'];
//            $goods_sku_comb_model->where(array('goods_no' => $value['A']))->save($_data);
//            $this->goods_list_model->where($_where)->save(array('price' => $value['C'],'distribution_price'=>$value['D']));
//        }
//        if (0 == $_error_num) {
//            $this->aReturn(1, '更新成功！');
//        }
//        $this->aReturn(1, '更新完成！共有' . $_error_num . '个商品价格未更新！');
//    }

    /**
     * loadExecl execl导入及解析
     * @return 
     */
//    private function loadExecl() {
//        $targetFolder = C('UPLOAD_URL');
//        if (!is_dir(ROOT_DIR . $targetFolder)) mkdir(ROOT_DIR . $targetFolder, 0777, true);
//        $upload = new \Think\Upload(); // 实例化上传类
//        $upload->maxSize = 10145728; // 设置附件上传大小
//        $upload->exts = array('xlsx', 'xls'); // 设置附件上传类型
//        $upload->rootPath = "." . $targetFolder; // 设置附件上传根目录
//        $upload->subName = array('date', 'Ymd'); // 设置附件上传根目录
//        // 上传文件
//        $info = $upload->upload();
//        if (!$info) {
//            print_r($upload->getError());
//            exit();
//        }
//        $_file_path = $targetFolder . $info['file']['savepath'] . $info['file']['savename'];
//        vendor("PhpExcel.implodeExecl", '', '.php');
//        return importExecl(ROOT_DIR . $_file_path);
//    }

    /**
     * passedBatch    批量商品审核ajax操作
     * @return json
     */
//    public function passedBatch() {
//        $_goods_status = I('post.goods_status');
//        if (0 == $_goods_status) {
//            $this->aReturn(0, L('_GOODS_PARAME_FAILURE_'));
//        }
//        if (1 == I('post.alldata')) {
//            $this->pagesize = 100000;
//            $this->datas = $this->goods_list_model->getGoodsList($this->goods_list_model->searchWhere($this->user_info['id']));
//            foreach ($this->datas['list'] as $value) {
//                $_goods_ids[] = $value['goods_id'];
//            }
//        } else {
//            if (!is_array(I('post.goods'))) {
//                $this->aReturn(0, L('_GOODS_REVIEW_FAILURE'));
//            }
//            $_goods_ids = I('post.goods');
//        }
//        $total_num = count($_goods_ids);
//        $goods_ids = trim(implode(',', $_goods_ids), ',');
//        $_data['goods_status'] = $_goods_status;
//        $_data['conf_time'] = time();
//        $success = $this->goods_list_model
//                ->where(array(
//                    'goods_id' => array('in', $goods_ids),
//                    'supplier_id' => $this->user_info['id'],
//                    'goods_sale' => 1,
//                    'goods_status' => 1))
//                ->save($_data);
//        $_error_num = $total_num - $success;
//        if (0 < $_error_num) {
//            $this->aReturn(1, '审核操作完成，其中' . $_error_num . '个商品审核失败');
//        }
//        $this->aReturn(1, L('_GOODS_REVIEW_SUCCESS_'));
//    }

    /**
     * goodsRelease 商品发布
     * @return [type] [description]
     */
//    public function goodsRelease() {
//        $_searchWhere = $this->goods_list_model->searchWhere($this->user_info['id']);
//        $_searchWhere['goods_sale'] = 1;
//        $_searchWhere['goods_status'] = 3;
//        $_searchWhere['new_upload'] = 1;
//        if (2 == I('get.shop_id', 0)) {
//            $_searchWhere['shop_id '] = 1;
//        }
//        if (3 == I('get.shop_id', 0)) {
//            $_searchWhere['shop_id '] = 2;
//        }
//        if (4 == I('get.shop_id', 0)) {
//            $_searchWhere['shop_name'] = array('exp', 'is NULL');
//        }
//        $_json = 'left join __SYSTEM_SHOP_GOODS__ ON __GOODS_LIST__.goods_id = __SYSTEM_SHOP_GOODS__.goods_id';
//        $_sort = I('get.sort') ? str_replace('~', ' ', I('get.sort')) : 'goods_id desc';
//        $_goods_list = $this->goods_list_model->field('goods_list.*')->join($_json)->where($_searchWhere)->group('system_shop_goods.goods_id')->count();
//        $_page = getpage($_goods_list);
//        $_datas['page'] = $_page->show();
//        $_datas['list'] = $this->goods_list_model
//                ->field('goods_list.*')
//                ->join($_json)
//                ->where($_searchWhere)
//                ->group('goods_id')
//                ->order($_sort)
//                ->limit($_page->firstRow . ',' . $_page->listRows)
//                ->select();
//        $this->datas = $_datas;
//        $this->depot = $this->depot_list;
//        $this->goods_category = $this->goods_category_model->get_category_list();
//        $this->show();
//    }

    /**
     * goodsIntroduced  商品发布
     * @return [type] [description]
     */
//    public function goodsIntroduced() {
//        layout(false);
////        $this->shop = $this->system_shop_model->select();
//        $this->display();
//    }

    /**
     * goodsIntroducedbatch 商品批量发布
     * @return 
     */
//    public function goodsIntroducedbatch() {
//        layout(false);
////        $this->shop = $this->system_shop_model->select();
//        $this->show();
//    }
//    public function introducedBatch() {
//        if (1 == I('post.alldata')) {
//            $this->pagesize = 100000;
//            $this->datas = $this->goods_list_model->getGoodsList($this->goods_list_model->searchWhere($this->user_info['id']), '', 'goods_id');
//            foreach ($this->datas['list'] as $key => $value) {
//                $_goods_ids[] = $value['goods_id'];
//            }
//        } else {
//            if (!is_array(I('post.goods'))) {
//                $this->aReturn(0, L('_GOODS_PARAME_FAILURE_'));
//            }
//            $_goods_ids = I('post.goods');
//        }
//        $_where['shop_id'] = array('in', $this->user_info['platform']);
//        $_where['goods_id'] = array('in', $_goods_ids);
//        $this->system_shop_goods_model->where($_where)->delete();
//        $shop_name = $this->system_shop_model->where(array('id' => $this->user_info['platform']))->getField('shop_name');
//        $_data = array();
//        foreach ($_goods_ids as $value) {
//            $_data[]['goods_id'] = $value;
//            $_data[]['shop_id'] = $this->user_info['platform'];
//            $_data[]['shop_name'] = $shop_name;
//        }
//        if (!empty($_data)) {
//            $this->system_shop_goods_model->addAll($_data);
//        }
//        $this->aReturn(1);
//    }

    /**
     * [goodsShop 单个商品添加发布平台
     * @return 
     */
//    public function goodsShop() {
//        $_goods_id = I('get.goods_id', 0);
//        if (0 == $_goods_id) {
//            $this->aReturn(0, '_PARAME_FAILURE_');
//        }
////        $_shop = I('post.shop');
////        $_where['goods_id'] = $_goods_id;
////        $_where['shop_id'] = $this->user_info['platform']; //array('in',$_shop);
////        $this->system_shop_goods_model->where($_where)->delete();
//        $this->system_shop_goods_model->where(array('goods_id' => $_goods_id, 'shop_id' => $this->user_info['platform']))->delete();
//        $_data['goods_id'] = $_goods_id;
////        foreach ($_shop as $value) {
//        $_data['shop_name'] = $this->system_shop_model->where(array('shop_id' => $this->user_info['']))->getField('shop_name');
//        $_data['shop_id'] = $this->user_info['platform'];
//        $this->system_shop_goods_model->add($_data);
////        }
//        $this->aReturn(1);
//    }
}
