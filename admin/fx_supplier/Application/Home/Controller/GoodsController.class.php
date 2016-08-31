<?php

namespace Home\Controller;

use Common\Controller\BasicController;

class GoodsController extends BasicController {

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
        $_datas = $this->getGoodsList($this->searchWhere(), I('get.sort') ? str_replace('~', ' ', I('get.sort')) : 'goods_id desc' );
        foreach ($_datas['list'] as $key => $value) {
            //取商品价格
            $_datas['list'][$key]['price'] = M('goods_price')->where("goods_no={$value['goods_no']}")->order('shop_id asc ')->find();
            //取商品ＳＫＵ
            $_datas['list'][$key]['sku_list'] = M('goods_sku_comb')->where("goods_id ={$value['goods_id']}")->select();
            //取商品总库存
            $_datas['list'][$key]['stock_num'] = M('goods_sku_comb')->where("goods_id ={$value['goods_id']}")->sum('stock_num');
        }
        $this->datas = $_datas;
        $this->depot = $this->depotList();
        $this->goods_category = $this->goodsCategoryList();
        $this->show();
    }

    /**
     * goodsRelease 商品发布
     * @return [type] [description]
     */
    public function goodsRelease() {
        $_searchWhere = $this->searchWhere();
        $_searchWhere['goods_sale'] = 1;
        $_searchWhere['goods_status'] = 3;
        $_searchWhere['new_upload'] = 1;

        if (2 == I('get.shop_id', 0)) {
            $_searchWhere['shop_id '] = 1;
        }
        if (3 == I('get.shop_id', 0)) {
            $_searchWhere['shop_id '] = 2;
        }
        if (4 == I('get.shop_id', 0)) {
            $_searchWhere['shop_name'] = array('exp', 'is NULL');
        }
        $_json = 'left join __SYSTEM_SHOP_GOODS__ ON __GOODS_LIST__.goods_id = __SYSTEM_SHOP_GOODS__.goods_id';
        $_sort = I('get.sort') ? str_replace('~', ' ', I('get.sort')) : 'goods_id desc';
        $_goods_list = M('goods_list')->field('goods_list.*')->join($_json)->where($_searchWhere)->group('goods_id')->select();
        //echo M('goods_list')->getlastsql();
        $_page = $this->getpage(count($_goods_list));
        $_datas['page'] = $_page->show();
        $_datas['list'] = M('goods_list')->field('goods_list.*')->join($_json)->where($_searchWhere)->group('goods_id')->order($_sort)
                        ->limit($_page->firstRow . ',' . $_page->listRows)->select();
        $this->datas = $_datas;
        $this->depot = M('system_depot')->field('id,depot_name')->select();
        $this->goods_category = $this->goodsCategoryList();
        $this->show();
    }

    /**
     * goodsIntroduced  商品发布
     * @return [type] [description]
     */
    public function goodsIntroduced() {
        $this->shop = M('system_shop')->select();
        $this->show();
    }

    /**
     * goodsIntroducedbatch 商品批量发布
     * @return 
     */
    public function goodsIntroducedbatch() {
        $this->shop = M('system_shop')->select();
        $this->show();
    }

    public function introducedBatch() {
        if (1 == I('post.alldata')) {
            $this->pagesize = 100000;
            $this->datas = $this->getGoodsList($this->searchWhere());
            foreach ($this->datas['list'] as $key => $value) {
                $_goods_ids[] = $value['goods_id'];
            }
        } else {
            if (!is_array(I('post.goods'))) {
                $this->aReturn(0, L('_GOODS_PARAME_FAILURE_'));
            }
            $_goods_ids = I('post.goods');
        }

        $_shop = I('post.shop');
        $_where['goods_id'] = array('in', $_goods_ids);

        M('system_shop_goods')->where($_where)->delete();
        if (!is_array($_shop)) {
            $this->aReturn(1);
        }
        foreach ($_goods_ids as $key => $value) {
            $_data['goods_id'] = $value;
            foreach ($_shop as $k => $v) {
                $_data['shop_id'] = $v;
                $_data['shop_name'] = M('system_shop')->where("id={$v}")->getField('shop_name');
                M('system_shop_goods')->add($_data);
            }
        }
        $this->aReturn(1);
    }

    /**
     * [goodsShop 单个商品添加发布平台
     * @return 
     */
    public function goodsShop() {
        $_goods_id = I('get.goods_id', 0);
        if (0 == $_goods_id) {
            $this->aReturn(0, '_PARAME_FAILURE_');
        }
        $_shop = I('post.shop');
        $_where['goods_id'] = $_goods_id;
        M('system_shop_goods')->where($_where)->delete();
        M('system_shop_goods')->where("goods_id={$_goods_id}")->delete();
        $_data['goods_id'] = $_goods_id;
        foreach ($_shop as $key => $value) {
            $_data['shop_name'] = M('system_shop')->where("id={$value}")->getField('shop_name');
            $_data['shop_id'] = $value;
            M('system_shop_goods')->add($_data);
        }
        $this->aReturn(1);
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

        //商品ＩＤ
        if (1 == I('get.explode_goods/d')) {
            if (is_array(I('get.explodeGoods'))) {
                $_where['goods_id'] = array('in', I('get.explodeGoods'));
            }
        }
        //商品类目
        if (I('get.goods_category')) {
            $_where['category_parent'] = I('get.goods_category', 0);
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

    /**
     * goodsSale 商品上架
     * @return [type] [description]
     */
    public function goodsSale() {
        $_goods_ids = '';
        if (1 == I('post.alldata')) {
            $this->pagesize = 100000;
            $this->datas = $this->getGoodsList($this->searchWhere());
            foreach ($this->datas['list'] as $key => $value) {
                $_goods_ids[] = $value['goods_id'];
            }
        } else {
            if (!is_array(I('post.goods'))) {
                $this->aReturn(0, L('_GOODS_PARAME_FAILURE_'));
            }
            $_goods_ids = I('post.goods');
        }

        foreach ($_goods_ids as $key => $value) {
            $_where['goods_id'] = $value;
            $_where['goods_sale'] = 2;
            $_data['goods_sale'] = 1;
            $_data['new_upload'] = 1;
            M('goods_list')->where($_where)->save($_data);
        }
        $this->aReturn(1, L('UPDATE_SUCCESS'));
    }

    /**
     * importGoods 新增商品
     * @return
     */
    public function importGoods() {
        $_phpCAS = session('phpCAS');
        $_where['user_name'] = $_phpCAS['user'];
        $_count = M('goods_error')->join("__GOODS_LIST__ ON __GOODS_ERROR__.goods_id = __GOODS_LIST__.goods_id")->where($_where)->count();
        $_page = $this->getpage($_count);
        $goods_error_list = M('goods_error')->field('goods_error.addtime,goods_error.goods_lack_momo,goods_list.goods_category,goods_list.goods_name,goods_list.buyer_goods_no,goods_list.img_path')->join("__GOODS_LIST__ ON __GOODS_ERROR__.goods_id = __GOODS_LIST__.goods_id")->where($_where)->limit($_page->firstRow . ',' . $_page->listRows)->select();
        foreach ($goods_error_list as $key => $value) {
            $value['goods_lack_momo'] = unserialize($value['goods_lack_momo']);
            $value['goods_lack_momo'] = implode(',', $value['goods_lack_momo']['goods_lack_momo']);
            $_datas['list'][$key] = $value;
        }
        $_datas['page'] = $_page->show();
        $this->datas = $_datas;
        $this->depot = M('system_depot')->field('id, depot_name')->select();
        $this->show();
    }

    /**
     * goodsNoList 商品货号列表
     * @return
     */
    public function goodsNoList() {
        if (I('get.goods_search', 0)) {
            if ('goods_no' == I('get.goods_search')) {
                if (I('get.search_word') != '') {
                    $_where[I('get.goods_search')] = I('get.search_word');
                }
            } else {
                if (I('get.search_word') != '') {
                    $_where[I('get.goods_search')] = array('like', "%" . I('get.search_word') . "%");
                }
            }
        }
        $_where['is_delete'] = 0;
        $_where['goods_lack'] = 0;
        $_datas = $this->getGoodsList($_where, $_sort);
        foreach ($_datas['list'] as $key => $value) {
            $value['goodsArtList'] = $this->getArtNoList($value['goods_id']);
            $_datas['list'][$key] = $value;
        }
        $this->datas = $_datas;
        $this->show();
    }

    /**
     * importPrice  导入价格
     * @return [type] [description]
     */
    public function importPrice() {
        $this->shop = M('system_shop')->select();
        $this->show();
    }

    /**
     * [importPriceAdd 商品价格导入
     * @return json
     */
    public function importPriceAdd() {
        $_shop_id = I('post.shop_id', 0);
        if (0 == $_shop_id) {
            $this->aReturn(0);
        }
        $_price_list = $this->loadExecl();
        $_error_num = 0;
        $_where['shop_id'] = $_shop_id;
        foreach ($_price_list as $key => $value) {
            if (0 > $value['E'] or 0 > $value['C'] or 0 > $value['D']) {
                $_error_num ++;
                continue;
            }
            $_where['goods_no'] = $value['A'];
            $_data['original_price'] = $value['C'];
            $_data['market_price'] = $value['E'];
            $_data['distribution_price'] = $value['D'];
            M('goods_price')->where($_where)->save($_data);
        }

        if (0 == $_error_num) {
            $this->aReturn(1, '更新成功！');
        }
        $this->aReturn(1, "更新完成！共有{$_error_num}个商品价格未更新！");
    }

    /**
     * loadExecl execl导入及解析
     * @return 
     */
    public function loadExecl() {
        $targetFolder = C('UPLOAD_URL');
        if (!is_dir(ROOT_DIR . $targetFolder)) mkdir(ROOT_DIR . $targetFolder, 0777, true);
        $upload = new \Think\Upload(); // 实例化上传类
        $upload->maxSize = 10145728; // 设置附件上传大小
        $upload->exts = array('xlsx', 'xls'); // 设置附件上传类型
        $upload->rootPath = "." . $targetFolder; // 设置附件上传根目录
        $upload->subName = array('date', 'Ymd'); // 设置附件上传根目录
        // 上传文件
        $info = $upload->upload();
        if (!$info) {
            //print_r($upload->getError());
        }
        $_file_path = $targetFolder . $info['file']['savepath'] . $info['file']['savename'];
        vendor("PhpExcel.implodeExecl", '', '.php');
        return $this->importExecl(ROOT_DIR . $_file_path);
    }

    /**
     * addImportGoods 新增商品
     * @return 
     */
    public function addImportGoods() {
        $targetFolder = C('UPLOAD_URL');
        if (!is_dir(ROOT_DIR . $targetFolder)) mkdir(ROOT_DIR . $targetFolder, 0777, true);
        $upload = new \Think\Upload(); // 实例化上传类
        $upload->maxSize = 20971520; // 设置附件上传大小
        $upload->exts = array('csv', 'tbi'); // 设置附件上传类型
        $upload->rootPath = "." . $targetFolder; // 设置附件上传根目录
        $upload->subName = array('date', 'Ymd'); // 设置附件上传根目录
        $upload->saveName = '';
        $upload->replace = true;

        // 上传文件
        $info = $upload->upload();
        if (!$info) {
            //上传错误提示错误信
            $this->aReturn(0, $upload->getError(), '');
        } else {
            //上传成功
            //
            if ('csv' == $info['file']['ext']) {
                $_file_path = $targetFolder . $info['file']['savepath'] . $info['file']['savename'];
                $_returnData = $this->saveGoods($_file_path, array('depot_id' => I('post.depot_id/d')));
            }
            $this->aReturn(1, L('_GOODS_IMPLODE_SUCCESS_'), $_returnData);
        }
        $this->aReturn(0, L('_FIEL_UPLOAD_FAILURE_'));
    }

    /**
     * updateGoodsStatus 商品状态更新
     * @return 
     */
    public function updateGoodsStatus() {
        $_data['goods_status'] = I('get.goods_status/d');
        $_data['goods_id'] = I('get.goods_id/d');
        $_goods_list_db = M('goods_list');
        $_goods_list_db->create($_data);
        if ($_goods_list_db->save()) {
            $this->success(L('_UPDATE_GOODS_STATUS_SUCCESS_'), HTTP_REFERER);
        } else {
            $this->error(L('_UPDATE_GOODS_STATUS_FAILURE_'), HTTP_REFERER);
        }
    }

    /**
     * [updateGoodsSale 商品上下架更新]
     * @return 
     */
    public function updateGoodsSale() {
        $_data['goods_sale'] = I('get.goods_sale/d');
        $_data['goods_id'] = I('get.goods_id/d');
        $_goods_list_db = M('goods_list');
        $_goods_list_db->create($_data);
        if ($_goods_list_db->save()) {
            $this->success((1 == $_goods_list_db->goods_sale ) ? L('_UPDATE_GOODS_SALE_SUCCESS_') : L('_UPDATE_GOODS_OFFSALE_FAILURE_'), HTTP_REFERER);
        } else {
            $this->error(L('_UPDATE_GOODS_STATUS_FAILURE_'), HTTP_REFERER);
        }
    }

    /**
     * [delGoods 删除商品]
     * @return 
     */
    public function delGoods() {
        $this->success(L('_DEL_GOODS_SUCCESS_'), HTTP_REFERER);
        $this->success(L('_DEL_GOODS_FAILURE_'), HTTP_REFERER);
    }

    /**
     * [addGoodsIntroduced 商品发布]
     * @return [json] [状态]
     */
    public function addGoodsIntroduced() {
        $this->success('', HTTP_REFERER);
    }

    /**
     * [goodsDetails 商品详情]
     * @return 
     */
    public function goodsDetails() {
        $this->show();
    }

    /**
     * [artNo 货号列表]
     * @return 
     */
    public function artNoList() {
        $this->show();
    }

    /**
     * 	 添加商品货号
     *  'goods_art_no.goods_id ='.$art_no['goods_id']." and
     */
    public function addArtNo() {
        $art_no['goods_id'] = I('post.goods_id');
        $art_no['art_no'] = I('post.art_no');
        $goods_info = M('goods_list')->where("goods_id = " . $art_no['goods_id'])->find();
        $_count = 0;
        if (strtolower($goods_info['buyer_goods_no']) == strtolower($art_no['art_no'])) {
            $_count++;
        }

        $_where['category_parent'] = $goods_info['category_parent'];
        $_where['supplier_id'] = $goods_info['supplier_id'];
        $_where['buyer_goods_no'] = $updata['buyer_goods_no'] = $art_no['art_no'];
        $goods_list = M('goods_list');
        $goods_list->join('goods_art_no ON goods_art_no.goods_id =goods_list.goods_id ');
        $goods_list->field('art_no');
        $goods_list->where(" art_no = '" . $art_no['art_no'] . "'and goods_list.category_parent = " . $goods_info['category_parent']);
        $count_art_no = $goods_list->count('art_no');
        if ($count > 0 or $count_art_no > 0) {
            $this->aReturn(0, "商家编码已存在");
        } else {
            $art_no['addtime'] = time();
            $result = M('goods_list')->where("goods_id=" . $art_no['goods_id'])->save($updata);
            if ($result) {
                if (M('goods_art_no')->add($art_no)) {
                    $this->aReturn(1, L('ADD_SUCCESS'));
                } else {
                    $this->aReturn(0, L('ADD_FAILURE'));
                }
            }
        }
    }

    /**
     * [getArtNoList 取商品编号]
     * @param  int $mGoodsId 商品ID
     * @param  int $mNum     商品数量
     * @return 
     */
    public function getArtNoList($mGoodsId, $mNum = '') {
        return M('goods_art_no')->where("goods_id = {$mGoodsId}")->select();
    }

    /**
     * getGoodsList 商品列表
     * @param  Array  $mWhere 查询条件
     * @param  String $mOrder 排序
     * @return Array         
     */
    public function getGoodsList($mWhere = '', $mOrder = '') {
        $_count = M('goods_list')->where($mWhere)->count();
        $_page = $this->getpage($_count);
        $_goods_list = M('goods_list')->where($mWhere)->order($mOrder);
        if (0 == I('get.explode_goods/d')) {
            $_goods_list = $_goods_list->limit($_page->firstRow . ',' . $_page->listRows);
        }
        $_data['list'] = $_goods_list->select();
        $_data['sql'] = M('goods_list')->getlastsql();
        //echo $_data['sql'];
        $_data['page'] = $_page->show();
        return $_data;
    }

    /**
     * saveGoods 保存导入的商品
     * @param  [String] $mFilePath [导入商品文件路径]
     * @return  Array|true|false
     */
    public function saveGoods($mFilePath, $mPara = array()) {
        $_goods_arrary = $this->goodsFileAnalytic($mFilePath);

        $_goods_key = array();
        $_goods_key_zh = array();
        $_time = time();
        $_returnData['_total_num'] = 0;
        $_returnData['_total_ok'] = 0;
        $_returnData['_error_num'] = 0;
        $_returnData['_no_error_num'] = 0;
        $_returnData['_re_num'] = 0;

        if (3 > count($_goods_arrary)) {
            return $_returnData;
        }

        $_phpCAS = session('phpCAS');
        foreach ($_goods_arrary as $key => $value) {
            if (0 == $key) {
                M('goods_error')->where("user_name='{$_phpCAS['user']}'")->delete();
                continue;
            }
            if (1 == $key) {
                $_goods_key = $value;
                continue;
            }
            if (2 == $key) {
                $_goods_key_zh = $value;
                continue;
            }

            if ('' == trim($value[33]) && '' == trim($value[0]) && '' == trim($value[1])) {
                break;
            }

            if ('' == trim($value[33])) {
                $_returnData['_no_error_num'] ++;
                continue;
            }

            $_category_parent = $this->getParentCategory(intval($value[1]));

            $_returnData['_total_num'] ++;
            $_data = NULL;
            $_data['depot_id'] = $mPara['depot_id'];
            $_data['goods_name'] = $value[0];
            $_data['buyer_goods_no'] = $value[33];
            $_data['goods_category'] = $value[1];
            $_data['category_parent'] = $_category_parent;
            $_data['goods_sale'] = 2;
            $_data['goods_status'] = 1;
            $_data['addtime'] = $_time;
            $_goods_list_db = M('goods_list');
            $_error = NULL;


            //检测有无重复
            $_e_data['buyer_goods_no'] = $value[33];
            $_e_data['supplier_id'] = 0;
            $_e_data['category_parent'] = $_category_parent;
            $_e_data['is_delete'] = 0;

            $_goods_row = M('goods_list')->where($_e_data)->find();


            $_prohibited_words = C('prohibited_words');
            foreach ($_prohibited_words as $k => $v) {
                if (stristr($value[0], $v)) {
                    $_error['goods_lack_momo']['prohibited_words'] = '有违禁词';
                    break;
                }
                if (stristr($value[20], $v)) {
                    $_error['goods_lack_momo']['prohibited_words'] = '有违禁词';
                    break;
                }
            }

            if ('' == $value[0]) {
                $_error['goods_lack_momo']['title'] = '宝贝名称';
                $_returnData['_error_num'] ++;
            }

            if (0 == intval($value[1])) {
                $_error['goods_lack_momo']['cid'] = '宝贝类目';
                $_returnData['_error_num'] ++;
            }

            if (strlen($value[20]) <= 5) {
                $_error['goods_lack_momo']['description'] = '宝贝描述';
                $_returnData['_error_num'] ++;
            }

            if ('' == $value[3]) {
                $_error['goods_lack_momo']['stuff_status'] = '新旧程度';
                $_returnData['_error_num'] ++;
            }

            if ('' == $value[4]) {
                $_error['goods_lack_momo']['location_state'] = '省';
                $_returnData['_error_num'] ++;
            }

            if ('' == $value[5]) {
                $_error['goods_lack_momo']['location_city'] = '城市';
                $_returnData['_error_num'] ++;
            }

            if (is_array($_error)) {
                $_data['goods_lack'] = 1;
                $_data['goods_lack_momo'] = serialize($_error);
            } else {
                $_data['goods_lack'] = 0;
                $_data['goods_lack_momo'] = '';

                if (0 == intval($_goods_row['goods_id'])) {
                    $_returnData['_total_ok'] ++;
                }
                if (0 < intval($_goods_row['goods_id']) and $_goods_row['goods_lack'] == 1) {
                    $_returnData['_total_ok'] ++;
                }
            }

            //
            if (0 < intval($_goods_row['goods_id'])) {
                if (0 == $_goods_row['goods_lack']) {
                    $error_data['goods_id'] = $_goods_row['goods_id'];
                    $error_data['user_name'] = $_phpCAS['user'];
                    $error_data['goods_lack_momo'] = serialize(array('goods_lack_momo' => array('re' => '重复')));
                    $error_data['addtime'] = time();
                    M('goods_error')->add($error_data);
                    $_returnData['_re_num'] ++;
                    continue;
                }
            }

            if (intval($_goods_row['goods_id'])) {
                M('goods_list')->where($_goods_row)->save($_data);
                $_goods_id = $_goods_row['goods_id'];
            } else {
                do {
                    $_goods_no = M('goods_list')->max('goods_no');
                    $_goods_no = ( $_goods_no < 1000000 ) ? 1000000 : $_goods_no + 1;
                } while (0 < M('goods_list')->where("goods_no={$_goods_no}")->count());
                $_data['goods_no'] = $_goods_no;
                $_goods_id = M('goods_list')->add($_data);
            }

            if (1 == $_data['goods_lack']) {
                $error_data['goods_id'] = $_goods_id;
                $error_data['user_name'] = $_phpCAS['user'];
                $error_data['goods_lack_momo'] = serialize($_error);
                $error_data['addtime'] = time();
                M('goods_error')->add($error_data);
            }

            if (0 < $_goods_id) {
                if (0 < intval($_goods_row['goods_id'])) {
                    $_del_where['goods_id'] = $_goods_id;
                    M('goods_art_no')->where($_del_where)->delete();
                    M('goods_list_property')->where($_del_where)->delete();
                    M('goods_price')->where($_del_where)->delete();
                    M('goods_sku_comb')->where($_del_where)->delete();
                    M('goods_sku_list_name')->where($_del_where)->delete();
                    M('goods_sku_list_val')->where($_del_where)->delete();
                }
                //添加商品货号
                M('goods_art_no')->add(array('goods_id' => $_goods_id, 'art_no' => $value[33], 'addtime' => time()));
                $this->mosaicGoods($_goods_id, $_goods_key, $_goods_key_zh, $value);
                $this->addGoodsSkuComb($_goods_id);
                $this->getSkuName($_goods_id);
                $this->setSkuCombZh($_goods_id);
            }
        }

        if (0 < $_returnData['_error_num'] || 0 < $_returnData['_re_num'] || 0 < $_returnData['_total_num']) {
            return $_returnData;
        }
        return true;
    }

    /**
     * addGoodsSkuComb 添加商品ＳＫＵ组合
     * @param int $mGoodsId 商品ＩＤ
     */
    public function addGoodsSkuComb($mGoodsId) {
        $_where['goods_id'] = $mGoodsId;
        $_where['goods_key'] = 'skuProps';
        $_skuProps = M('goods_list_property')->where($_where)->getField('goods_value');
        $_count = preg_match_all('/[\.0-9]*:[0-9]*:[^:]*:([-0-9]+:[-0-9]+;)*/', $_skuProps, $return_array);

        if (0 < $_count) {
            $_comb_id = array();
            foreach ($return_array[0] as $key => $value) {
                $this->addGoodsKeyVal($mGoodsId, $value);
                $_data = NULL;
                preg_match('/([\.0-9]+)*:([0-9]+)*/', $value, $r);
                $_data['goods_id'] = $mGoodsId;
                $_data['sku_str'] = $value;
                $_data['stock_num'] = $r[2];
                $_comb_id[$key]['comb_id'] = M('goods_sku_comb')->add($_data);
                $_comb_id[$key]['original_price'] = $r[1];
            }

            $_datas = array();
            if (is_array($_comb_id)) {
                $_data = NULL;
                $_goods_no = M('goods_list')->where("goods_id={$mGoodsId}")->getField("goods_no");
                $_system_shop_list = M('system_shop')->field('id')->select();
                foreach ($_system_shop_list as $k => $v) {
                    foreach ($_comb_id as $key => $value) {
                        $_data['goods_id'] = $mGoodsId;
                        $_data['goods_no'] = $_goods_no;
                        $_data['shop_id'] = $v['id'];
                        $_data['comb_id'] = $value['comb_id'];
                        $_data['original_price'] = $value['original_price'];
                        $_data['market_price'] = 0;
                        $_data['distribution_price'] = 0;
                        $_datas[] = $_data;
                    }
                }
                if (!empty($_datas)) {
                    M('goods_price')->addAll($_datas);
                }
            }
        }
    }

    /**
     * getParentCategory 商品父级类目
     * @param   Int     $mCategoryCid 分类ID
     * @return  Int|false
     */
    public function getParentCategory($mParentid) {
        $_mParentid = M('goods_category')->where("cid={$mParentid}")->getField('parent_cid');
        if (0 != intval($_mParentid)) {
            return $this->getParentCategory($_mParentid);
        }
        return $mParentid;
    }

    /**
     * [addGoodsKeyVal 添加商品ＳＫＵ名称和值
     * @param Int    $mGoodsId 商品ＩＤ
     * @param String $mSkuStr  ＳＫＵ字符串
     */
    public function addGoodsKeyVal($mGoodsId, $mSkuStr) {
        preg_match_all('/([-0-9]+:[-0-9]+);/', $mSkuStr, $rk);
        foreach ($rk[1] as $kk => $vv) {
            $sku_key_val = explode(':', $vv);
            $_where = NULL;
            $_data = NULL;
            $_where['goods_id'] = $mGoodsId;
            $_where['sku_name'] = $sku_key_val[0];

            if (0 == M('goods_sku_list_name')->where($_where)->count()) {
                $_data['goods_id'] = $mGoodsId;
                $_data['sku_name'] = $sku_key_val[0];
                $sku_key_id = M('goods_sku_list_name')->add($_data);
            } else {
                $sku_key_id = M('goods_sku_list_name')->where($_where)->getField('id');
            }
            $_data = NULL;
            $_where = NULL;
            $_where['goods_id'] = $mGoodsId;
            $_where['sku_id'] = $sku_key_id;
            $_where['sku_val'] = $sku_key_val[1];

            if (0 == M('goods_sku_list_val')->where($_where)->count()) {
                $_data['goods_id'] = $mGoodsId;
                $_data['sku_id'] = $sku_key_id;
                $_data['sku_val'] = $sku_key_val[1];
                M('goods_sku_list_val')->add($_data);
            }
        }
    }

    /**
     * getSkuVal    取ＳＫＵ值
     * @param  Int      $mGoodsId    商品ＩＤ
     * @param  Array    $mSku        商品ＳＫＵ数组
     * @return      
     */
    public function getSkuVal($mGoodsId, $mSku, $mSkuName) {
        $_input_custom_cpv = M('goods_list_property')->where("goods_id = {$mGoodsId} and goods_key = 'input_custom_cpv'")->getField('goods_value');
        $_input_custom_sku = array();
        if ('' != $_input_custom_cpv) {
            $_input_custom_cpv_arr = explode(';', $_input_custom_cpv);
            foreach ($_input_custom_cpv_arr as $key => $value) {
                $_input_custom_arr = explode(':', $value);
                $_input_custom_sku[$_input_custom_arr[0]][$_input_custom_arr[1]] = $_input_custom_arr[2];
            }
        }
        //先检查是否有自定义ＳＫＵ
        $_goods_sku_list_val_arr = M('goods_sku_list_val')->field('sku_val,id')->where("goods_id={$mGoodsId}")->select();
        foreach ($_goods_sku_list_val_arr as $k => $v) {
            if ($_input_custom_sku[$mSkuName][$v['sku_val']]) {
                $_sku_val_str = $_input_custom_sku[$mSkuName][$v['sku_val']];
                M('goods_sku_list_val')->where("id={$v['id']}")->save(array('sku_val_str' => $_sku_val_str));
            }
        }
        //如果没有自定义ＳＫＵ 则从ＳＫＵ数据包取数据
        $goods_sku_list_val_arr = M('goods_sku_list_val')->field('sku_val,id')->where("goods_id={$mGoodsId} and sku_val_str = ''")->select();
        foreach ($goods_sku_list_val_arr as $key => $value) {
            foreach ($mSku as $k => $v) {
                if ($v['vid'] == $value['sku_val']) {
                    M('goods_sku_list_val')->where("id={$value['id']}")->save(array('sku_val_str' => $v['name']));
                }
            }
        }
    }

    /**
     * 
     * @param  Int $mGoodsId 商品ＩＤ
     * @return String|false
     */
    public function getSkuName($mGoodsId) {
        $_goods_value = M('goods_list_property')->where("goods_id = {$mGoodsId} and goods_key = 'cid'")->getField('goods_value');
        $_json_file_path = ROOT_DIR . '/Public/static/sku/' . $_goods_value . '.json';
        if (!file_exists($_json_file_path)) {
            return false;
        }
        $_json = file_get_contents(ROOT_DIR . '/Public/static/sku/' . $_goods_value . '.json');
        $_json_arr = json_decode($_json, true);

        $_goods_sku_list_name_arr = M('goods_sku_list_name')->where("goods_id={$mGoodsId}")->select();
        foreach ($_goods_sku_list_name_arr as $key => $value) {
            foreach ($_json_arr as $k => $v) {
                foreach ($v as $kk => $vv) {
                    if ($vv['pid'] == $value['sku_name']) {
                        M('goods_sku_list_name')->where("id = {$value['id']}")->save(array('sku_name_str' => $vv['name']));
                        $this->getSkuVal($mGoodsId, $vv['prop_values']['prop_value'], $value['sku_name']);
                    }
                }
            }
        }
    }

    /**
     * setSkuCombZh   将ＳＫＵ组合表的ＳＫＵ数字解析成汉字
     * @param Int   $mGoodsId   商品ＩＤ
     */
    public function setSkuCombZh($mGoodsId) {

        $_goods_sku_comb_list = M('goods_sku_comb')->where("goods_id={$mGoodsId}")->select();
        $_goods_sku_list_name_list = M('goods_sku_list_name')->where("goods_id={$mGoodsId}")->select();
        $_goods_sku_list_val = M('goods_sku_list_val')->where("goods_id={$mGoodsId}")->select();
        foreach ($_goods_sku_comb_list as $key => $value) {
            if ('' == $value['sku_str']) {
                continue;
            }

            $_skuArr = array();
            preg_match_all('/([-0-9]+:[-0-9]+);/', $value['sku_str'], $result);
            foreach ($result[1] as $k => $v) {
                $_nv = explode(':', $v);
                $_fnv = NULL;
                $_fnv[$_nv[0]] = M('goods_sku_list_name')->where("goods_id = {$mGoodsId} and sku_name ='{$_nv[0]}'")->getField('sku_name_str');
                $_fnv[$_nv[1]] = M('goods_sku_list_val')->where("goods_id = {$mGoodsId} and sku_val ='{$_nv[1]}'")->getField('sku_val_str');
                $_skuArr[] = $_fnv;
            }
            M('goods_sku_comb')->where("id={$value['id']}")->save(array('sku_serialize' => serialize($_skuArr)));
            foreach ($_goods_sku_list_name_list as $k => $v) {
                $value['sku_str'] = preg_replace("/{$v['sku_name']}/", "{$v['sku_name_str']}", $value['sku_str']);
            }
            foreach ($_goods_sku_list_val as $k => $v) {
                $value['sku_str'] = preg_replace("/{$v['sku_val']}/", "{$v['sku_val_str']}", $value['sku_str']);
            }
            $value['sku_str'] = preg_replace("/[0-9.]+:[0-9]+:[^:]*:/", "", $value['sku_str']);
            M('goods_sku_comb')->where("id={$value['id']}")->save(array('sku_str_zh' => $value['sku_str']));
        }
    }

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
        M('goods_list_property')->where("goods_id={$mGoodsId}")->delete();
        foreach ($mGoodsVal as $key => $value) {
            $_data['goods_title'] = $mGoodsKeyZh[$key];
            $_data['goods_key'] = $mGoodsKey[$key];
            $_data['goods_value'] = (String) $mGoodsVal[$key];
            $_datas[] = $_data;
        }
        M('goods_list_property')->addAll($_datas);
    }

    /**
     * [goodsFileAnalytic 商品文件解析]
     * @param  [String] $mFilePath [文件路径]
     * @return [Array]             [商品属性数组]
     */
    public function goodsFileAnalytic($mFilePath, $mPara) {
        if (!$mFilePath) {
            return false;
        }
        if (!file_exists(ROOT_DIR . $mFilePath)) {
            return false;
        }
        $_goodsArrary = array();
        if (!( $handle = $this->fileRead($mFilePath, "r")) === FALSE) {
            $i = 0;
            while (( $cols = fgetcsv($handle, 0, "\t") ) !== FALSE) {
                $_goodsArrary[] = $cols;
            }
            fclose($handle);
        } else {
            unlink($mFilePath);
        }
        return $_goodsArrary;
    }

    /**
     * [fileRead 文件读取]
     * @param  String $mFilePath 文件路径
     * @return String|false            
     */
    public function fileRead($mFilePath) {
        $encoding = '';
        if (!is_file(ROOT_DIR . $mFilePath)) {
            return false;
        }
        $handle = fopen(ROOT_DIR . $mFilePath, 'r');
        $bom = fread($handle, 2);
        rewind($handle);
        if ($bom === chr(0xff) . chr(0xfe) || $bom === chr(0xfe) . chr(0xff)) {
            // UTF16 Byte Order Mark present  
            $encoding = 'UTF-16';
        } else {
            $file_sample = fread($handle, 1000) + 'e'; //read first 1000 bytes  
            // + e is a workaround for mb_string bug  
            rewind($handle);
            $encoding = mb_detect_encoding($file_sample, 'UTF-8, UTF-7, ASCII, EUC-JP,SJIS, eucJP-win, SJIS-win, JIS, ISO-2022-JP');
        }
        if ($encoding) {
            stream_filter_append($handle, 'convert.iconv.' . $encoding . '/UTF-8');
        }
        return ($handle);
    }

    /**
     * exportPriceExecl 导出价格电子表格
     * @return [type] [description]
     */
    public function exportPriceExecl() {
        $xlsCell = array(
            array('goods_no', '商品编号'),
            array('buyer_goods_no', '商家编码'),
            array('original_price', '成本价'),
            array('distribution_price', '分销价'),
            array('market_price', '市场价')
        );

        $this->pagesize = 100000;
        $this->datas = $this->getGoodsList($this->searchWhere());
        foreach ($this->datas['list'] as $key => $value) {
            $_goods_price = M('goods_price')->where("goods_id={$value['goods_id']}")->find();
            $_data[$key]['goods_no'] = $value['goods_no'];
            $_data[$key]['buyer_goods_no'] = $value['buyer_goods_no'];
            $_data[$key]['original_price'] = $_goods_price['original_price'];
            $_data[$key]['market_price'] = $_goods_price['market_price'];
            $_data[$key]['distribution_price'] = $_goods_price['distribution_price'];
        }
        $this->exportExcel('价格表', $xlsCell, $_data);
        exit;
    }

    /**
     * goodsPassed 商品确认ajax操作
     * @return json
     */
    public function goodsPassed() {
        $_goods_id = I('post.goods_id');
        $_goods_status = I('post.goods_status');
        if (0 == $_goods_id) {
            $this->aReturn(0, L('_GOODS_PARAME_FAILURE_'));
        }

        if (0 == $_goods_status) {
            $this->aReturn(0, L('_GOODS_PARAME_FAILURE_'));
        }

        $_where['goods_sale'] = 1;
        $_where['goods_id'] = $_goods_id;
        $_where['goods_status'] = 1;

        if (0 == M('goods_list')->where($_where)->count()) {
            $this->aReturn(0, L('_GOODS_PARAME_FAILURE_'));
        }
        $_data['goods_status'] = $_goods_status;
        $_data['conf_time'] = time();
        if (M('goods_list')->where($_where)->save($_data)) {
            $this->aReturn(1, L('_GOODS_REVIEW_SUCCESS_'));
        }
        $this->aReturn(0, L('_GOODS_REVIEW_FAILURE_'));
    }

    /**
     * passedBatch    批量商品审核ajax操作
     * @return json
     */
    public function passedBatch() {
        $_goods_status = I('post.goods_status');
        if (0 == $_goods_status) {
            $this->aReturn(0, L('_GOODS_PARAME_FAILURE_'));
        }

        if (1 == I('post.alldata')) {
            $this->pagesize = 100000;
            $this->datas = $this->getGoodsList($this->searchWhere());
            foreach ($this->datas['list'] as $key => $value) {
                $_goods_ids[] = $value['goods_id'];
            }
        } else {
            if (!is_array(I('post.goods'))) {
                $this->aReturn(0, L('_GOODS_REVIEW_FAILURE'));
            }
            $_goods_ids = I('post.goods');
        }

        $_error['num'] = 0;
        $_where['goods_sale'] = 1;
        $_where['goods_status'] = 1;
        $_data['goods_status'] = $_goods_status;
        $_data['conf_time'] = time();
        foreach ($_goods_ids as $key => $value) {
            $_where['goods_id'] = $value;
            if (M('goods_list')->where($_where)->save($_data)) {
                
            } else {
                $_error['num'] ++;
            }
        }
        if (0 < $_error['num']) {
            $this->aReturn(1, "审核操作完成，其中{$_error['num']}个商品审核失败");
        }
        $this->aReturn(1, L('_GOODS_REVIEW_SUCCESS_'));
    }

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
        if (0 == M('goods_list')->where($_where)->count()) {
            $this->aReturn(0, L('_GOODS_PARAME_FAILURE_'));
        }
        $_shop_list = M('system_shop')->select();
        $_goods_price_count = false;
        foreach ($_shop_list as $key => $value) {
            $_goods_price_where = "shop_id = {$value['id']} and goods_id={$_goods_id} and ( market_price = 0 or distribution_price = 0 )";
            if (0 == M('goods_price')->where($_goods_price_where)->count()) {
                $_goods_price_count = true;
            }
        }
        if (false == $_goods_price_count) $this->aReturn(0, L('_GOODS_SALE_FAILURE_NO_PRICE_'));
        $_data['goods_sale'] = 1;
        $_data['new_upload'] = 1;
        $_data['sale_time'] = time();
        if (M('goods_list')->where($_where)->save($_data)) {
            $this->aReturn(1, L('_GOODS_SALE_SUCCESS_'));
        }
        $this->aReturn(0, L('_GOODS_SALE_FAILURE_'));
    }

    /**
     * updateGoodsSaleBatch 批量上架操作
     * @return  josn
     */
    public function updateGoodsSaleBatch() {
        if (1 == I('post.alldata')) {
            $this->pagesize = 100000;
            $this->datas = $this->getGoodsList($this->searchWhere());
            foreach ($this->datas['list'] as $key => $value) {
                $_goods_ids[] = $value['goods_id'];
            }
        } else {
            if (!is_array(I('post.goods'))) {
                $this->aReturn(0, L('_GOODS_PARAME_FAILURE_'));
            }
            $_goods_ids = I('post.goods');
        }
        $_where['goods_sale'] = 2;
        $_data['goods_sale'] = 1;
        $_data['new_upload'] = 1;
        $_data['sale_time'] = time();
        $_shop_list = M('system_shop')->select();
        $_error_num = 0;

        foreach ($_goods_ids as $key => $value) {
            $_goods_price_count = false;
            foreach ($_shop_list as $k => $v) {
                $_goods_price_where = "shop_id = {$v['id']} and goods_id={$value} and ( market_price = 0 or distribution_price = 0 )";
                if (0 == M('goods_price')->where($_goods_price_where)->count()) {
                    $_goods_price_count = true;
                }
            }
            if (false == $_goods_price_count) {
                $_error_num ++;
                continue;
            }
            $_where['goods_id'] = $value;
            if (!M('goods_list')->where($_where)->save($_data)) {
                $_error_num ++;
            }
        }
        $this->aReturn(1, $_error_num ? "商品上架操作完成！其中共{$_error_num}个商品上架操作失败" : '商品上架操作成功');
    }

    /**
     * goodsDeleteBatch 批量删除
     * @return 
     */
    public function goodsDeleteBatch() {
        if (1 == I('post.alldata')) {
            $this->pagesize = 100000;
            $this->datas = $this->getGoodsList($this->searchWhere());
            foreach ($this->datas['list'] as $key => $value) {
                $_goods_ids[] = $value['goods_id'];
            }
        } else {
            if (!is_array(I('post.goods'))) {
                $this->aReturn(0, L('_GOODS_PARAME_FAILURE_'));
            }
            $_goods_ids = I('post.goods');
        }

        $_where['goods_status'] = 2;
        $_data['is_delete'] = 1;
        $not_delete = 0;
        $finish_delete = 0;
        foreach ($_goods_ids as $key => $value) {
            $goods_status = M('goods_list')->where("goods_id = $value")->getField('goods_status');
            if ($goods_status != 2) {
                $not_delete++;
                continue;
            }
            $_where['goods_id'] = $value;
            $deleted = M('goods_list')->where($_where)->save($_data);
            if ($deleted != false) {
                $finish_delete++;
            }
        }
        if ($not_delete > 0) {
            if ($finish_delete > 0) {
                $this->aReturn(1, L('_GOODS_DELETE_SUCCESS_') . $finish_delete . "个，其中有" . $not_delete . "个商品不能操作");
            } else {
                $this->aReturn(0, '没有可删除的商品，不能操作');
            }
        }
        $this->aReturn(1, L('_GOODS_DELETE_SUCCESS_'));
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

        $_where['goods_status'] = 2;
        $_where['goods_id'] = $_goods_id;
        if (0 == M('goods_list')->where($_where)->count()) {
            $this->aReturn(0, L('_GOODS_PARAME_FAILURE_'));
        }

        $_data['is_delete'] = 1;
        if (M('goods_list')->where($_where)->save($_data)) {
            $this->aReturn(1, L('_GOODS_DELETE_SUCCESS_'));
        }
        $this->aReturn(0, L('_GOODS_DELETE_FAILURE_'));
    }

    /**
     * offGoodsSaleBatch 批量下架操作
     * @return [type] [description]
     */
    public function offGoodsSaleBatch() {
        if (1 == I('post.alldata')) {
            $this->pagesize = 100000;
            $this->datas = $this->getGoodsList($this->searchWhere());
            foreach ($this->datas['list'] as $key => $value) {
                $_goods_ids[] = $value['goods_id'];
            }
        } else {
            if (!is_array(I('post.goods'))) {
                $this->aReturn(0, L('_GOODS_PARAME_FAILURE_'));
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
            if (!M('goods_list')->where($_where)->save($_data)) {
                $_error['num'] ++;
            } else {
                M('system_shop_goods')->where("goods_id={$value}")->delete();
            }
        }
        if (0 < $_error['num']) {
            $this->aReturn(1, "下架操作完成，其中{$_error['num']}个商品未下架成功");
        }
        $this->aReturn(1, L('_GOODS_OFF_SALE_SUCCESS_'));
    }

    /**
     * goodsOffSaleAjax 单个商品下架操作
     * @return 
     */
    public function goodsOffSaleAjax() {
        $_goods_id = I('post.goods_id');
        if (0 == $_goods_id) {
            $this->aReturn(0, L('_GOODS_PARAME_FAILURE_'));
        }
        $_where['goods_sale'] = 1;
        $_where['goods_id'] = $_goods_id;
        // $_where['new_upload'] 	= 1;
        if (0 == M('goods_list')->where($_where)->count()) {
            $this->aReturn(0, L('_GOODS_PARAME_FAILURE_'));
        }
        if (0 == M('goods_list')->where("goods_id =" . $_goods_id)->getField('new_upload')) {
            $this->aReturn(0, L('_GOODS_NEW_SALE_OFF_'));
        }
        $_data['goods_sale'] = 2;
        $_data['goods_status'] = 1;
        $_data['off_sale_time'] = time();
        if (M('goods_list')->where($_where)->save($_data)) {
            M('system_shop_goods')->where("goods_id = {$_goods_id}")->delete();
            $this->aReturn(1, L('_GOODS_OFF_SALE_SUCCESS_'));
        }
        $this->aReturn(0, L('_GOODS_OFF_SALE_FAILURE_'));
    }

    /**
     * [cancelPassedBatch 商品批量取消操作
     * @return 
     */
    public function cancelPassedBatch() {
        if (1 == I('post.alldata')) {
            $this->pagesize = 100000;
            $this->datas = $this->getGoodsList($this->searchWhere());
            foreach ($this->datas['list'] as $key => $value) {
                $_goods_ids[] = $value['goods_id'];
            }
        } else {
            if (!is_array(I('post.goods'))) {
                $this->aReturn(0, L('_GOODS_PARAME_FAILURE_'));
            }
            $_goods_ids = I('post.goods');
        }

        $_where['goods_status'] = 1;
        $_where['goods_sale'] = 1;

        $_data['goods_sale'] = 2;
        $_data['goods_status'] = 1;

        $_goods_total = 0;
        $_goods_update_success = 0;
        $_goods_update_failed = 0;
        foreach ($_goods_ids as $key => $value) {
            $_data['new_upload'] = 1;
            if (1 == M('goods_list')->where("goods_id={$value} and off_sale_time = 0")->count()) {
                $_data['new_upload'] = 0;
            }
            $_goods_total++;
            $_where['goods_id'] = $value;
            if (M('goods_list')->where($_where)->save($_data)) {
                $_goods_update_success ++;
            } else {
                $_goods_update_failed++;
            }
        }
        $this->aReturn(1, ($_goods_total == $_goods_update_success) ?
                        '商品取消操作成功' : "商品取消操作完成!共{$_goods_update_failed}个商品未能取消成功");
    }

    /**
     * goodsCancelSale 商品取消
     * @return 
     */
    public function goodsCancelSale() {
        $_goods_id = I('post.goods_id');
        if (0 == $_goods_id) {
            $this->aReturn(0, L('_GOODS_PARAME_FAILURE_'));
        }
        if (0 == M('goods_list')->where("goods_id={$_goods_id}")->getField('off_sale_time')) {
            $_data['new_upload'] = 0;
        }
        $_data['goods_sale'] = 2;
        $_where['goods_sale'] = 1;
        $_where['goods_id'] = $_goods_id;
        $_data['goods_status'] = 1;
        if (M('goods_list')->where($_where)->save($_data)) {
            $this->aReturn(1, L('_GOODS_CANCEL_SUCCESS_'));
        }
        $this->aReturn(0, L('_GOODS_CANCEL_FAILURE_'));
    }

}
