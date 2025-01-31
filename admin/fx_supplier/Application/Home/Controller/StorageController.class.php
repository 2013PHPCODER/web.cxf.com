<?php

namespace Home\Controller;

use \Common\Controller\BasicController;

class StorageController extends BasicController{

    /**
     * 发货列表
     */
    public function index(){
        $_where = $this->searchWhere();
        $_sort = I('get.sort') ? str_replace('~',' ',I('get.sort')) : 'hub_order.id desc';
        $this->datas = $datas = $this->getHubList($_where,$_sort);
        $this->depot = $this->depotList();
        $this->goods_category = $this->goodsCategoryList();
        $this->shop = $this->system_shop();
        $this->shipping = $this->system_shipping();
        $this->show();
    }

    /**
     * 仓库设置
     */
    public function storageSet(){


        $this->display();
    }

    /**
     * 物流模板
     */
    public function shipping(){

        $this->display('storage/shipping/shipping');
    }

    /**
     * 售后收货
     */
    public function cusList(){
        $this->display('storage/cus/cusList');
    }

    /**
     * [storageFaHuoList 仓储管理 库存管理]
     * @return [type] [description]
     */
    public function storageManger(){
        if(1 == I('get.explode_goods/d')){
            $this->exportStock();
            exit();
        }
        $this->depot = $this->depotList();
        $this->goods_category = $this->goodsCategoryList();
        $_goodsWhere = $this->goodsWhere();
        if(2 == I('get.group_id',0)){
            $_goodsWhere['goods_sku_comb.stock_num'] = array('exp',' <=goods_sku_comb.stock_lock_num and goods_sku_comb.stock_lock_num >0 ');
        }
        $this->datas = $this->getStorage($_goodsWhere,I('get.sort') ? str_replace('~',' ',I('get.sort')) : 'goods_list.goods_id asc');
        $this->show();
    }

    /**
     * [logEdit 库存日志]
     * @return [type] [description]
     */
    public function logEdit(){
        $this->depot = $this->depotList();
        $this->shipping = $this->system_shipping();
        $this->goods_category = $this->goodsCategoryList();
        $this->datas = $this->getLogCusList($this->logWhere());
        $this->display();
    }

    /*
     * [searchWhere 发货管理组合搜索条件]
     * @return Array [数组]
     */

    public function searchWhere(){
        //发货状态
        //待配货
        if(2 == I('get.group_id')){
            $_where['ship_stats'] = 0;
        }
        //待分配
        if(3 == I('get.group_id')){
            $_where['ship_stats'] = 1;
        }
        //待发货
        if(4 == I('get.group_id')){
            $_where['ship_stats'] = 2;
        }
        //已完成
        if(5 == I('get.group_id')){
            $_where['ship_stats'] = 3;
        }

        //组合搜索条件
        //仓库名称
        if(I('get.depot')){
            $_where['hub_order.depot_id'] = I('get.depot',0);
        }
        //商品类目
        if(I('get.goods_category')){
            $_where['goods_list.category_parent'] = I('get.goods_category',0);
        }
        //分销商
        if(I('get.buyer_id')){
            $_where['buyer_name'] = I('get.buyer_id');
        }
        //是否备注
        if(I('get.remark')){
            $_where['memo'] = I('get.remark') == 1 ? array('EXP'," <> ''") : array('exp'," = ''");
        }
        //物流公司
        if(I('get.shipping_id')){
            $_where['shipping_no'] = I('get.shipping_id');
        }
        //面单类型
        if(I('get.hub_type')){
            $_where['hub_type'] = I('get.hub_type',0);
        }

        //订单时间 发货管理
        if(I('get.time_type') and ( I('get.startTime') or I('get.endTime') )){
            $_startTime = I('get.startTime',0) ? strtotime(I('get.startTime')) : 1;
            $_endTime = I('get.endTime',0) ? strtotime(I('get.endTime')) : time();
            $_where[I('get.time_type')] = array('BETWEEN',array($_startTime,$_endTime));
        }
        //平台来源
        if(I('get.shop_id')){
            $_where['shop_id'] = I('get.shop_id',1);
        }
        //关键字
        if(I('get.hub_search') and I('get.search_word')){
            if('goods_list.goods_name' == I('get.hub_search') or 'goods_list.buyer_goods_no' == I('get.hub_search')){
                $_where[I('get.hub_search')] = array('like','%' . I('get.search_word') . '%');
            }else{
                $_where[I('get.hub_search')] = I('get.search_word');
            }
        }
        //是否打印配货单
        if(I('get.is_print')){
            $status = I('get.is_print');
            if($status == 2){
                $status = 0;
            }
            $_where['is_print'] = $status;
        }
        //是否打印物流单
        if(I('get.shipping_is_print')){
            $status = I('get.shipping_is_print');
            if($status == 2){
                $status = 0;
            }
            $_where['shipping_is_print'] = $status;
        }
        return $_where;
    }

    /*     * 弹出框
     * [printDistribution 打印弹出框]
     * @return [type] [description]
     */

    public function printDistribution(){
        if('all' == I('post.type')){
            $_where = $this->searchWhere();
            $hub_order_id = $this->getHubList($_where,'','all');
        }else{
            $hub_order_id = I('post.order_id');
        }

        foreach($hub_order_id as $k=> $v){
            $order_list = M('hub_order');
            $order_states = $order_list->where('order_id =' . $v)->getField('ship_stats');
            $order_list->join('hub_order_goods ON hub_order_goods.order_id = hub_order.order_id');
            $_data['list'][] = $order_list->where('hub_order.order_id = ' . $v)->find();
            foreach($_data['list'] as $m=> $n){
                $_data['list'][$m]['concat_address'] = $this->getOrderConcatAll($n['order_id']);
                $_data['list'][$m]['sku'] = M('goods_sku_comb')->where('id =' . $n['sku_comb_id'])->getField('sku_str_zh');
                $_data['list'][$m]['goods_no'] = M('goods_list')->where('goods_id =' . $n['goods_id'])->getField('goods_no');
                $_data['list'][$m]['is_cus'] = M('order_list')->where("order_id={$n['order_id']}")->getField('is_cus');
                $sku_comb_id = M('hub_order_goods')->where("order_id = {$n['order_id']} and goods_id={$n['goods_id']}")->getField('sku_comb_id');
                $_data['list'][$m]['original_price'] = M('goods_price')->where("comb_id={$sku_comb_id} and shop_id = {$n['shop_id']}")
                        ->getField("original_price");
            }
        }
        $this->datas = $_data['list'];
        //var_dump($_data['list']);
        layout(false);
        $str = $this->fetch(T('Storage/distribution'));
        echo $str;
    }

    /**
     * [resultDistribution  保存打印结果]
     * @return [type] [description]
     */
    public function resultDistribution(){
        if(I('post.order_id') || I('post.type')){
            if(I('post.type')){
                $order_list = $this->getHubList($this->searchWhere(),'','all');
                $order_id = $order_list;
            }
            if(I('post.order_id')){
                $order_id = I('post.order_id');
            }
            $hub_order = M('hub_order');
            foreach($order_id as $k=> $v){
                $hub_status = $hub_order->where('hub_order.order_id = ' . $v)->getField('ship_stats');
                if(0 != $hub_status){
                    $erro++;
                    continue;
                }
                $hub_order->is_print = 1;
                $hub_order->where('hub_order.order_id = ' . $v)->save();
            }
            $_data['status'] = 'ok';
            $_data['erro'] = $erro ? $erro : '';
            $this->ajaxReturn($_data);
        }
    }

    /**
     * hubDistribution 对待配货订单进行配货
     * @return JSON
     */
    public function hubDistribution(){
        if(I('post.order_id') || I('post.type')){
            if(I('post.type')){
                $order_list = $this->getHubList($this->searchWhere(),I('get.sort') ? str_replace('~',' ',I('get.sort')) : 'hub_order.id asc','all');
                $order_id = $order_list;
            }
            if(I('post.order_id')){
                $order_id = I('post.order_id');
            }
            $total = 0;
            $is_print = 0;
            $erro = 0;
            foreach($order_id as $k=> $v){
                if(0 != M('hub_order')->where(" order_id = {$v} ")->getField('ship_stats')){
                    $erro++;
                    continue;
                }
                $is_print = ( 1 == M('hub_order')->where("order_id = {$v}")->getField('is_print') ) ? $is_print++ : $is_print;
                $hub_order = M('hub_order');
                $hub_order->ship_stats = 1;
                $hub_order->where("order_id = {$v}")->save();
                //写日是志
                $this->addLog(array("log_info"=>"配货","handle_info"=>"订单配货成功，进入待分配","cid"=>1,"pid"=>$v));
            }
            $_message = "配货成功";
            if(0 < $erro) $_message .= ",未配货{$erro}条(已配货或其它状态)";
            $this->aReturn(1,$_message);
        }
    }

    /**
     * [goodsWhere 库存管理 搜索条件]
     * @return [type] [description]
     */
    public function goodsWhere(){
        //所有商品
        // if( 2 == I('get.group_id')){
        //      $_where['stock_lock_num'] = true;
        // }
        // 
        $_where['is_delete'] = 0;
        $_where['goods_lack'] = 0;
        //搜索条件
        //仓库地址
        if(I('get.depot')){
            $_where['depot_id'] = I('get.depot');
        }
        //商品类目
        if(I('get.goods_category')){
            $_where['category_parent'] = I('get.goods_category');
        }

        if(1 == I('get.explode_goods/d')){
            if(is_array(I('get.explodeGoods'))){
                $_where['goods_list.goods_id'] = array('in',I('get.explodeGoods'));
            }
        }
        //商品状态
        if(I('get.goods_sale')){
            $_where['goods_sale'] = I('goods_sale');
        }
        //仓储 管理 时间
        if(I('get.time_type') and ( I('get.startTime') or I('get.endTime') )){
            $_startTime = I('get.startTime',0) ? strtotime(I('get.startTime')) : 1;
            $_endTime = I('get.endTime',0) ? strtotime(I('get.endTime')) : time();
            $_where[I('get.time_type')] = array('BETWEEN',array($_startTime,$_endTime));
        }

        if(I('get.goods_search',0)){
            if(I('get.search_word') != ''){
                if(strtolower(I('get.goods_search')) == 'goods_name'){
                    $_where['goods_list.goods_name'] = array('LIKE','%' . I('get.search_word') . '%');
                }elseif(strtolower(I('get.goods_search')) == 'buyer_goods_no'){
                    $_where['goods_list.buyer_goods_no'] = array('LIKE','%' . I('get.search_word') . '%');
                }else{
                    $_where['goods_list.' . I('get.goods_search')] = I('get.search_word');
                }
            }
        }
        return $_where;
    }

    /**
     * [allWarning 批量预警]
     * @return [type] [description]
     */
    public function allWarning(){
        if(I('post.')){
            if(I('post.type') == 'all'){
                $goods_id = M('goods_list')->getField('goods_id',true);
            }
            if(I('post.goods_id')){
                $goods_id = I('post.goods_id');
            }
            $sku_comb = M('goods_sku_comb');
            $num = 0;
            try{
                foreach($goods_id as $k=> $v){
                    $sku_comb->stock_lock_num = I('post.val');
                    $sku_comb->where('goods_id = ' . $v)->save();
                }
            }catch(Exception $e){
                echo $e->getMessage();
                exit();
            }
            $_data['status'] = "ok";
            $this->ajaxReturn($_data);
        }
    }

    /**
     * [allEdit 批量库存修改]
     * @return [type] [description]
     */
    public function allEdit(){
        if(I('post.')){
            if(I('post.type') == 'all'){
                $goods_id = M('goods_list')->getField('goods_id',true);
            }
            if(I('post.goods_id')){
                $goods_id = I('post.goods_id');
            }
            $sku_comb = M('goods_sku_comb');
            $num = 0;
            try{
                foreach($goods_id as $k=> $v){
                    $_goods_sku_all = $sku_comb->where('goods_id =' . $v)->Field('id,stock_num')->select();
                    $sku_comb->stock_num = I('post.val');
                    $sku_comb->where('goods_id = ' . $v)->save();
                    /* 批量修改库存 设置日志 */
                    /* 获取商品的所有sku $_goods_sku_all */
                    foreach($_goods_sku_all as $key=> $value){
                        $_old_stock = $value['stock_num'];
                        $this->setStockLog($value['id'],I('post.val'),$_old_stock);
                        $this->updateStockTime($v);
                    }
                }
            }catch(Exception $e){
                echo $e->getMessage();
                exit();
            }
            $_data['status'] = "ok";
            $this->ajaxReturn($_data);
        }
    }

    /**
     * [exportStock 导出库存表]
     * @return [type] [description]
     */
    public function exportStock(){
        $xlsCell = array(
            array('goods_id','商品ID'),
            array('sku_comb_id','SKU组合ID'),
            array('buyer_goods_no','商家编码'),
            array('goods_name','商品名称'),
            array('goods_color','颜色'),
            array('goods_size','尺寸'),
            array('stock_num','库存')
        );
        $_list = $this->getStockTable($this->goodsWhere());
        foreach($_list['list'] as $k=> $v){
            $_data[$k]['goods_id'] = $v['goods_id'];
            $_data[$k]['sku_comb_id'] = $v['id'];
            $_data[$k]['buyer_goods_no'] = $v['buyer_goods_no'];
            $_data[$k]['goods_name'] = $v['goods_name'];
            $_data[$k]['stock_num'] = $v['stock_num'];
            preg_match_all('/([0-9]+:[0-9]+);/',$v['sku_str'],$rk);
            $sku_arr = array();
            foreach($rk[1] as $n=> $m){
                // var_dump($m);
                $sku_key_val = explode(':',$m);
                $sku_name = $sku_key_val[0];
                $sku_val = $sku_key_val[1];
                $_condition['goods_id'] = $v['goods_id'];
                $_condition['sku_val'] = $sku_val;
                // $sku_name_str      =  M('goods_sku_list_name')->where( $_condition )->getField('sku_name_str');
                // $_data['goods_id'] = $v['goods_id'];
                // $_data['sku_val']  = $sku_val;
                $sku_val_str = M('goods_sku_list_val')->where($_condition)->getField('sku_val_str');
                $sku_arr[] = $sku_val_str;
            }
            $_data[$k]['goods_color'] = $sku_arr[0];
            $_data[$k]['goods_size'] = $sku_arr[1];
        }
        $result = $this->exportExcel('库存表',$xlsCell,$_data);
        exit();
    }

    /**
     * [importStock 导入库存页面]
     * @return [type] [description]
     */
    public function importStock(){
        $this->show();
    }

    /**
     * [loadexcael 导入库存]
     * @return [type] [description]
     */
    public function loadStock(){
        $targetFolder = C('UPLOAD_URL');
        if(!is_dir(ROOT_DIR . $targetFolder)) mkdir(ROOT_DIR . $targetFolder,0777,true);
        $upload = new \Think\Upload(); // 实例化上传类
        $upload->maxSize = 10145728; // 设置附件上传大小
        $upload->exts = array('xls'); // 设置附件上传类型
        $upload->rootPath = '.' . $targetFolder; // 设置附件上传根目录
        $upload->subName = array('date','Ymd'); // 设置附件上传根目录
        // 上传文件
        $info = $upload->upload();
        if(!$info){
            print_r($upload->getError());
            $this->aReturn(0,'上传失败！');
        }

        // $_phpCAS    = session('phpCAS');
        // $_log_data['user_id']   = $_phpCAS['user'];
        $_file_path = $targetFolder . $info['file']['savepath'] . $info['file']['savename'];
        vendor("PhpExcel.implodeExecl",'','.php');
        $result = $this->importExecl(ROOT_DIR . $_file_path);
        if($result){
            $_error = 0;
            foreach($result as $k=> $v){
                if(0 == intval($v['B'])){
                    $_error++;
                    continue;
                }
                if(!is_numeric($v['G'])){
                    $_error++;
                    continue;
                }
                if('' === $v['G'] or intval($v['G']) > 9999999 or intval($v['G']) < 0){
                    $_error++;
                    continue;
                }
                if(0 === intval($v['A'])){
                    $_error++;
                    continue;
                }

                $_stock = M('goods_sku_comb')->where('goods_id = ' . intval($v['A']) . " and id =" . intval($v['B']))->count();
                // echo M('goods_sku_comb')->getLastSql();
                if(0 == $_stock){
                    $_error++;
                    continue;
                }
                $sku_comb_list = M('goods_sku_comb');
                $_old_stock = $sku_comb_list->where(array('id'=>$v['B']))->getField('stock_num');
                $sku_comb_list->stock_num = $v['G'];
                $_map['id'] = $v['B'];
                $_map['goods_id'] = $v['A'];
                $sku_comb_list->where($_map)->save();
                $this->setStockLog($v['B'],$v['G'],$_old_stock);
                $this->updateStockTime($v['A']);
            }
        }
        $this->aReturn(1,($_error != 0) ? "更新完成！共有{$_error}个商品数据问题,导入失败" : '导入成功');
    }

    /**
     * [setStock_locak_num 设置单个商品的预警]
     */
    public function setStock_locak_num(){
        if(I('post.goods_id')){
            $goods_id = I('post.goods_id');
            $this->data = M('goods_sku_comb')->where('goods_id = ' . $goods_id)->select();
            $str = $this->fetch(T('Public/stock_lock_num'));
            echo $str;
        }
    }

    /**
     * [saveStock_locak_num 单个预警]
     * @return [type] [description]
     */
    public function saveStock_locak_num(){
        $data = I('post.data');
        if($data){
            $sku_comb = M('goods_sku_comb');
            foreach($data as $k=> $v){
                $sku_comb->stock_lock_num = $v['val'];
                $sku_comb->where('id =' . $v['id'])->save();
            }
        }
    }

    /**
     * [logWhere 日志搜索条件]
     * @return [type] [description]
     */
    public function logWhere(){
        //group_id
        //创想范
        if(I('get.group_id') == 2){
            $_where['shop_id'] = 1;
        }
        //星密码
        if(I('get.group_id') == 3){
            $_where['shop_id'] = 2;
        }
        //仓库地址
        if(I('get.depot')){
            $_where['depot_id'] = I('get.depot');
        }
        //商品类目 
        if(I('get.goods_category')){
            $_where['category_parent'] = I('get.goods_category');
        }
        //分销商
        if(I('get.buyer_id')){
            $_where['buyer_id'] = I('get.buyer_id');
        }
        //操作人
        if(I('get.user_id')){
            $_where['user_id'] = I('get.user_id');
        }
        //操作时间 日志操作时间
        if(I('get.startTime') or I('get.endTime')){
            $_startTime = I('get.startTime',0) ? strtotime(I('get.startTime')) : 1;
            $_endTime = I('get.endTime',0) ? strtotime(I('get.endTime')) : time();
            $_where['log_cus_list.addtime'] = array('BETWEEN',array($_startTime,$_endTime));
        }
        //关键字
        if(I('get.order_search') and I('get.search_word')){
            if(I('get.order_search') == 'goods_name'){
                $_where['goods_name'] = array('LIKE','%' . I('get.search_word') . '%');
            }elseif(I('get.order_search') == 'buyer_goods_no'){
                $_where['buyer_goods_no'] = array('LIKE','%' . I('get.search_word') . '%');
            }else{
                $_where[I('get.order_search')] = I('get.search_word');
            }
        }
        return $_where;
    }

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
            foreach($_list as $key=> $value){
                $_data[] = $value['order_id'];
            }
        }else{
            $_join = 'hub_order_goods ON hub_order_goods.order_id = hub_order.order_id';
            $_join_tow = "goods_list ON goods_list.goods_id = hub_order_goods.goods_id";
            $_field = '*,hub_order.id as hub_id';
            $_count = M('hub_order')->join($_join)->join($_join_tow)->where($mWhere)->count();
            $_page = $this->getPage($_count);
            $order_list->join($_join);
            $order_list->join($_join_tow);
            $_data['list'] = $order_list->where($mWhere)->order($mOrder)->limit($_page->firstRow . ',' . $_page->listRows)->field($_field)->select();
            $_data['sql'] = M('hub_order')->getLastSql();
            foreach($_data['list'] as $k=> $v){
                $_data['list'][$k]['order_memo'] = M('order_list')->where('order_id =' . $v['order_id'])->getField('memo');
                $_data['list'][$k]['goods_price'] = $this->getDistributionPrice($v['goods_id'],$v['shop_id']);
                $_data['list'][$k]['concat_address'] = $this->getOrderConcatAll($v['order_id']);
                $_data['list'][$k]['sku'] = $this->getOrderGoodsSK($v['order_id']);
                $_data['list'][$k]['order_amount'] = M('order_list')->where('order_id =' . $v['order_id'])->getField('order_amount');
                $_data['list'][$k]['img_path'] = M('goods_list')->where('goods_id =' . $v['goods_id'])->getField('img_path');
                $_data['list'][$k]['is_cus'] = M('order_list')->where("order_id=" . $v['order_id'])->getField('is_cus');
            }
            $_data['page'] = $_page->show();
        }
        return $_data;
    }

    //获取物流公司名称以及b编码 页面
    public function assginship(){
        $this->ship_code = $this->system_shipping();
        if(0 == I('post.order_id',0)){
            $this->aReturn(0,L('_PARAM_FAILURE_'));
        }
        $this->order_id = I('post.order_id',0);
        $_status = M('hub_order')->where('order_id =' . I('post.order_id'))->getField('ship_stats');
        if($_status == 1){
            $_html = $this->fetch('Public/ship_code_one');
            $this->aReturn(1,'ok',$_html);
        }else{
            $this->aReturn(0,'这个订单不能进行分配');
        }
    }

    /**
     * 保存订单号 单个
     */
    public function saveOneShip(){
        if(0 == I('post.ship_code',0)){
            $this->aReturn(0,L('_PARAM_FAILURE_'));
        }
        if(!I('post.ship_name')){
            $this->aReturn(0,L('_PARAM_FAILURE_'));
        }
        if(0 == I('post.ship_id',0)){
            $this->aReturn(0,L('_PARAM_FAILURE_'));
        }

        if(0 == I('post.order_id',0)){
            $this->aReturn(0,L('_PARAM_FAILURE_'));
        }
        if(0 < M('hub_order')->where("shipping_code='" . I('post.ship_code') . "'")->count()){
            $this->aReturn(0,L('_ORDER_EXPRESS_NUMBER_EXIST_'));
        }
        $hub_order = M('hub_order');
        //判断是否存在电子面单号,如果存在,就取消运单号
        $_hub_type = $hub_order->where('order_id =' . I('post.order_id/d'))->getField('hub_type');
        if($_hub_type == 1){
            $_arr = array();
            array_push($_arr,I('post.order_id'));
        }
        $hub_order->shipping_code = I('post.ship_code');
        $hub_order->shipping_name = I('post.ship_name');
        $hub_order->ship_stats = 2;
        $hub_order->shipping_no = M('system_shipping')->where('id =' . I('post.ship_id'))->getField('shipping_code ');
        $hub_order->hub_type = 1;

        $hub_order->where('order_id =' . I('post.order_id/d'))->save();
        if($this->updateToOrder(I('post.order_id/d'))){
            $this->aReturn(1,L('_ORDER_ASSIGNED_EXPRESS_NUMBER_SUCCESS_'));
        }
        $this->aReturn(0,L('_ORDER_ASSIGNED_EXPRESS_NUMBER_FAILURE_'));
    }

    /**
     * assginShipAll 批量获取单号页面
     * @return [type] [description]
     */
    public function assginShipAll(){
        if('true' == I('post.type')){
            $_where = $this->searchWhere();
            $_order = $datas = $this->getHubList($_where,'',1);
        }else{
            $_order = I('post.order');
        }
        if(is_array($_order)){
            $_where['order_id'] = array("in",$_order);
            $_where['hub_type'] = 0;
            $this->hub_order_list = M('hub_order')->where($_where)->select();
        }
        $this->ship_code = $this->system_shipping();
        echo $this->fetch('Public/ship_code_all');
    }

    /**
     * [getShipCode  取电子单个运单号
     * @return [type] [description]
     * @param  Array $mHubId [发货订单数组]
     */
    public function getShipCode(){
        $_order = I('post.order');
        if(!is_array($_order)){
            $this->aReturn(0,'参数错误');
        }

        if(0 == I('post.ship_id',0)){
            $this->aReturn(0,'参数错误');
        }
        $_result = array();
        $_error = 0;
        foreach($_order as $key=> $value){
            $_waybill_apply_new_info = $this->assignedExpressNumber($value);
            if(!$_waybill_apply_new_info){
                $_error++;
                continue;
            }
            $_shipping_code = $this->updateShipCode($_waybill_apply_new_info,$value,I('post.ship_id'));
            $_row['shipping_code'] = $_shipping_code;
            $_row['status'] = 'ok';
            $_row['order_id'] = $value;
            if(false == $_shipping_code){
                $_row['status'] = 'error';
            }
            $_result[] = $_row;
        }

        if(0 < $_error){
            $this->aReturn(0,'运单号分配失败',array('data'=>$_result));
        }
        $this->aReturn(1,'ok',array('data'=>$_result));
    }

    /**
     * [updateShipCode 更新运单号
     * @param  Array $mWaybillApplyNewInfo   Ａpi返回数据
     * @param  Int $mOrderId                  订单号
     * @param  Int $mShipId                   物流ＩＤ
     * @return true|false                
     */
    public function updateShipCode($mWaybillApplyNewInfo,$mOrderId,$mShipId){
        if(0 == intval($mOrderId)){
            return false;
        }

        if(0 == intval($mShipId)){
            return false;
        }
        //if()
        $_ship = $this->getShipInf($mShipId);
        //更新发货表
        $_data['shipping_code'] = $mWaybillApplyNewInfo['waybill_code'];
        $_data['shipping_name'] = $_ship['shipping_name'];
        $_data['shipping_no'] = $_ship['shipping_code'];
        $_data['hub_type'] = 2;
        $_data['ship_stats'] = 2;
        $_data['shipping_info'] = serialize($mWaybillApplyNewInfo);
        M('hub_order')->where("order_id={$mOrderId}")->save($_data);

        //更新订单表
        $_data = NULL;
        $_data['shipping_code'] = $mWaybillApplyNewInfo['waybill_code'];
        $_data['shipping_id'] = $mShipId;
        $_data['shipping_name'] = $_ship['shipping_name'];
        $_data['hub_type'] = 2;
        $_data['shipping_info'] = serialize($mWaybillApplyNewInfo);
        M('order_list')->where("order_id={$mOrderId}")->save($_data);
        return $mWaybillApplyNewInfo['waybill_code'];
    }

    /**
     * getOrderNewAddress  最订单最新地址
     * @param  Array $mOrderId 订单ID
     * @return Object   
     */
    public function getOrderNewAddress($mOrderId){
        return M('order_contact')->where(" order_id = $mOrderId ")->order('id desc')->find();
    }

    public function getDefaultTaobaoClient($mWaybillCodes,$mCpCode){
        $c = $this->newTaoBaoApi();
        $req = new \WlbWaybillIQuerydetailRequest;
        $waybill_detail_query_request = new \WaybillDetailQueryRequest;
        $waybill_detail_query_request->waybill_codes = $mWaybillCodes;
        $waybill_detail_query_request->cp_code = $mCpCode;
        $req->setWaybillDetailQueryRequest(json_encode($waybill_detail_query_request));
        return $c->execute($req,$this->sessionKey);
    }

    /**
     * getWaybillAddress  构建淘宝api网点发货地址对像
     * @return Object   
     */
    public function getSendAddress(){
        $shipping_address = new \WaybillAddress;
        $shipping_address->area = "天河区 ";
        $shipping_address->province = "广东省";
        $shipping_address->address_detail = "广园东路时代新世界南塔2806";
        $shipping_address->city = "广州市";
        return $shipping_address;
    }

    /**
     * getTradeOrderInfo  构建淘宝api订单信息
     * @return Object   
     */
    public function getTradeOrderInfo($mOrderId){
        $order_contact = $this->getOrderNewAddress($mOrderId);
        $trade_order_info_cols = new \TradeOrderInfo;
        $trade_order_info_cols->consignee_name = $order_contact['contact_name'];
        $trade_order_info_cols->order_channels_type = "TB";
        $trade_order_info_cols->trade_order_list = M('hub_order')->where('order_id =' . $mOrderId)->getField('order_sn');
        $trade_order_info_cols->consignee_phone = $order_contact['tel'];
        $trade_order_info_cols->product_type = "STANDARD_EXPRESS";
        $trade_order_info_cols->real_user_id = "2899430086";
        $trade_order_info_cols->consignee_address = $this->getWaybillAddress($order_contact);
        $trade_order_info_cols->package_items = $this->getPackageItem($mOrderId);
        $trade_order_info_cols->logistics_service_list = $this->getLogisticsService();
        return $trade_order_info_cols;
    }

    /*
     *
     */

    public function getLogisticsService(){
        $logistics_service_list = new \LogisticsService;
        $logistics_service_list->service_value4_json = "{ \"value\": \"100.00\",\"currency\": \"CNY\",\"ensure_type\": \"0\"}";
        $logistics_service_list->service_code = "SVC-DELIVERY-ENV";
        return $logistics_service_list;
    }

    /**
     * getWaybillAddress  构建淘宝api收件人地址
     * @return Object   
     */
    public function getWaybillAddress($mOrderContact){
        $consignee_address = new \WaybillAddress;
        $consignee_address->area = $mOrderContact['dist'];
        $consignee_address->province = $mOrderContact['province'];
        $consignee_address->address_detail = $mOrderContact['contact_address'];
        $consignee_address->city = $mOrderContact['city'];
        return $consignee_address;
    }

    /**
     * getWaybillAddress  构建淘宝api包裹信息
     * @return Object   
     */
    public function getPackageItem($mOrderId){
        $package_items = new \PackageItem;
        $package_items->item_name = "衣服";
        $package_items->count = M('hub_order_goods')->where('order_id =' . $mOrderId)->sum('goods_num');
        return $package_items;
    }

    public function assignedExpressNumber($mOrderId){
        $_express_info = $this->getApiCode($mOrderId);
        $_waybill_apply_new_info = json_decode(json_encode($_express_info->waybill_apply_new_cols->waybill_apply_new_info),true);
        if(!$_waybill_apply_new_info){
            return false;
        }
        return $_waybill_apply_new_info;
    }

    /**
     * getApiCode 取得运单号
     * @param  [type] $mHubId [description]
     * @return [type]         [description]
     */
    public function getApiCode($mOrderId){
        $c = $this->newTaoBaoApi();
        $req = new \WlbWaybillIGetRequest;
        $waybill_apply_new_request = new \WaybillApplyNewRequest;
        $waybill_apply_new_request->cp_code = M('system_shipping')->where(' id =' . I('post.ship_id'))->getField('shipping_code');
        // $waybill_apply_new_request->cp_code = 'ZTO';
        $waybill_apply_new_request->shipping_address = $this->getSendAddress();
        $waybill_apply_new_request->trade_order_info_cols = $this->getTradeOrderInfo($mOrderId);
        $req->setWaybillApplyNewRequest(json_encode($waybill_apply_new_request));
        return $c->execute($req,$this->sessionKey);
    }

    /**
     * getAllShipCode 批量获取运单号
     * @return json
     */
    public function getAllShipCode(){
        if('true' == I('post.type')){
            $_where = $this->searchWhere();
            $_order = $datas = $this->getHubList($_where,'',1);
        }else{
            $_order = I('post.order');
        }

        if(is_array($_order)){
            $_where['order_id'] = array("in",$_order);
            $_where['hub_type'] = 0;
            $_hub_order_list = M('hub_order')->where($_where)->select();
        }

        if(!is_array($_hub_order_list)){
            $this->aReturn(0,L('_PARAM_FAILURE_'));
        }
        if(!session('sessionKey')){
            $this->aReturn(0,'请获取授权');
        }
        foreach($_hub_order_list as $key=> $value){
            $_waybill_apply_new_info = $this->assignedExpressNumber($value['order_id']);
            if($_waybill_apply_new_info == false){
                $this->aReturn(0,'fail');
            }
            $_shipping_code = $this->updateShipCode($_waybill_apply_new_info,$value['order_id'],I('post.ship_id'));
            $_row['shipping_code'] = $_shipping_code;
            $_row['status'] = L('_SUCCESS_');
            $_row['order_id'] = $value['order_id'];

            if(false == $_shipping_code){
                $_row['status'] = L('_FAILURE_');
            }
            $_result[] = $_row;
        }
        $this->aReturn(1,'ok',array('data'=>$_result));
    }

    /**
     * printShippingCode 打印物流单
     * @return json
     */
    public function printShippingCode(){
        if('true' == I('post.type')){
            $_where = $this->searchWhere();
            $_order = $datas = $this->getHubList($_where,'',1);
        }else{
            $_order = I('post.order');
        }
        if(is_array($_order)){
            $_where = NULL;
            $_where['order_id'] = array("in",$_order);
            $_where['ship_stats'] = array('in',array(2,3));
            //$_where['shipping_is_print'] = 0;
            $_hub_order_list = M('hub_order')->where($_where)->select();
        }
        if(!is_array($_hub_order_list)){
            $this->aReturn(0,L('_PARAM_FAILURE_'));
        }
        foreach($_hub_order_list as $key=> $value){
            $_hub_order_list[$key]['order_contact'] = M('order_contact')->where("order_id={$value['order_id']}")->order("id desc")->find();
            $_hub_order_list[$key]['print_no'] = $key + 1;
            $hub_order = M('hub_order');
            $hub_order->print_no = $key + 1;
            $hub_order->where('id = ' . $value['id'])->save();
        }
        $this->hub_order_list = $_hub_order_list;
        echo $this->fetch('Public/shipping_code');
    }

    public function printSingle(){
        // $this->assignedExpressNumber(33) ;

        $_where['hub_order.order_id'] = array('in',I('post.order'));
        $_order = M('hub_order')->join('hub_order_goods ON hub_order_goods.hub_id = hub_order.id')->where($_where)->select();
        foreach($_order as $key=> $value){
            $_order[$key]['shipping_info'] = unserialize($value['shipping_info']);
            $_depot_id = M('order_goods')->where("order_id={$value['order_id']}")->getField('depot_id');
            $_order[$key]['depot'] = M('system_depot')->where("id={$_depot_id}")->find();
            $_order[$key]['send_date'] = date("Y-m-d");
            $_sku_str = M('goods_sku_comb')->where("id={$value['sku_comb_id']}")->getField('sku_str_zh');
            $_order[$key]['sku_serialize'] = $_sku_str;
            $_where = NULL;
            $_data['shipping_is_print'] = 1;
            $_data['print_no'] = (date('YmdHis') . $value['order_id']);
            $_where['order_id'] = $value['order_id'];
            M('hub_order')->where($_where)->save($_data);
        }
        $this->aReturn(1,'ok',$_order);

        //print_r($this->order);
        //print_r($_order);
        //$s = $this->getDefaultTaobaoClient( $_order['shipping_code'], $_order['shipping_no'] );
    }

    /**
     * printTraditional 打印传统面单
     * @return ＨＴＭＬ
     */
    public function printTraditional(){
        $_where['hub_order.order_id'] = array('in',I('post.order'));
        $_order = M('hub_order')->join('hub_order_goods ON hub_order_goods.hub_id = hub_order.id')->where($_where)->select();
        foreach($_order as $key=> $value){
            $_order[$key]['shipping_info'] = unserialize($value['shipping_info']);
            $_depot_id = M('order_goods')->where("order_id={$value['order_id']}")->getField('depot_id');
            $_order[$key]['depot'] = M('system_depot')->where("id={$_depot_id}")->find();
            $_order[$key]['send_date'] = date("Y-m-d");
            $_sku_str = M('goods_sku_comb')->where("id={$value['sku_comb_id']}")->getField('sku_str_zh');
            $_order[$key]['sku_serialize'] = $_sku_str;
            // $_where = NULL;
            // $_data['shipping_is_print'] = 1;
            // $_data['print_no'] =  (date('YmdHis').$value['order_id']);
            // $_where['order_id'] = $value['order_id'];
            // M('hub_order')->where($_where)->save($_data);
            $this->comTraditionalShip($_order);
        }
        echo $this->fetch('printTraditional');
    }

    /**
     * [saveTraditional 打印传统面单保存状态]
     * @return [type] [description]
     */
    public function saveTraditional(){
        $order_id = I('post.order_id');
        if(!$order_id){
            $this->aReturn(0,'参数错误');
        }
        foreach($order_id as $k=> $v){
            $_data['shipping_is_print'] = 1;
            $_data['print_no'] = (date('YmdHis') . $v);
            $_where['order_id'] = $v;
            M('hub_order')->where($_where)->save($_data);
        }
        $this->aReturn(1,'ok');
    }

    public function comTraditionalShip($mOrder){
        foreach($mOrder as $key=> $value){
            $template = M('system_express_template')->where("express_code='{$value['shipping_no']}'")->getField('template');
            $template = unserialize($template);
            $mOrder[$key]['property'] = $template['element']['properties']['property'];
            $_element = $template['element']['elements']['element'];
            $_depot = M('system_depot')->where("id={$value['depot_id']}")->find();
            $_order_contact = M('order_contact')->where("order_id={$value['order_id']}")->order(' id desc')->find();
            foreach($_element as $k=> $v){

                if('seller_address' == $v['@attributes']['name']){
                    $v['@attributes']['_text'] = $_depot['receiver_address'];
                }
                if('seller_name' == $v['@attributes']['name']){
                    $v['@attributes']['_text'] = $_depot['receiver_name'];
                }

                if('seller_mobile' == $v['@attributes']['name']){
                    $v['@attributes']['_text'] = $_depot['receiver_tel'];
                }


                if('receiver_address' == $v['@attributes']['name']){
                    $v['@attributes']['_text'] = $_order_contact['province'] . $_order_contact['city'] . $_order_contact['dist'] . $_order_contact['contact_address'];
                }

                if('receiver_name' == $v['@attributes']['name']){
                    $v['@attributes']['_text'] = $_order_contact['contact_name'];
                }

                if('receiver_city' == $v['@attributes']['name']){
                    $v['@attributes']['_text'] = $_order_contact['city'];
                }

                if('receiver_mobile' == $v['@attributes']['name']){
                    $v['@attributes']['_text'] = $_order_contact['tel'];
                }
                //商品名称
                if('compositeText' == $v['@attributes']['name']){
                    $v['@attributes']['_text'] = $_order_contact['tel'];
                }
                $_element[$k] = $v;
            }

            $mOrder[$key]['template'] = $_element;
            $mOrder[$key]['order_id'] = $value['order_id'];
        }
        $this->order = $mOrder;
    }

    /**
     * [canceShipCode 取消运单号]
     * @return json
     */
    public function canceShipCode($morderId = ''){
        vendor("TBAPI.TopSdk",'','.php');
        date_default_timezone_set('Asia/Shanghai');
        // if(I('post.')){
        if(!empty($mOrderId)){
            $hub_id = $mOrderId;
        }else if(I('post.order_id')){
            $hub_id = I('post.order_id');
        }else if(I('post.type')){
            $order_list = $this->getHubList($this->searchWhere(),I('get.sort') ? str_replace('~',' ',I('get.sort')) : 'hub_order.id asc','all');
            $hub_id = $order_list;
        }
        $result = array();
        foreach($hub_id as $k=> $v){
            $hub_order = M('hub_order')->where("order_id = {$v} and ship_stats = 2")->find();
            $is_cus = M('order_list')->where('order_id=' . intval($hub_order['order_id']))->getField('is_cus');
            if($is_cu == 1) $result[$k]['cus_num'] = "cus";
            if($hub_order['hub_type'] == 2){
                $c = new \TopClient;
                $c->appkey = $this->appkey;
                $c->secretKey = $this->secretKey;
                $req = new \WlbWaybillICancelRequest;
                $waybill_apply_cancel_request = new \WaybillApplyCancelRequest;
                $waybill_apply_cancel_request->real_user_id = "2899430086";
                $waybill_apply_cancel_request->trade_order_list = $hub_order['order_sn'];
                $waybill_apply_cancel_request->cp_code = $hub_order['shipping_no'];
                $waybill_apply_cancel_request->waybill_code = $hub_order['shipping_code'];
                $req->setWaybillApplyCancelRequest(json_encode($waybill_apply_cancel_request));
                $resp = $c->execute($req,$this->sessionKey);
                if($resp->cancel_result == true or '' == $hub_order['shipping_code']){
                    $hub_order_val = M('hub_order');
                    $hub_order_val->shipping_code = '';
                    $hub_order_val->shipping_name = '';
                    $hub_order_val->shipping_no = '';
                    $hub_order_val->ship_stats = 1;
                    $hub_order_val->hub_type = '';
                    $hub_order_val->where('order_id =' . $v)->save();

                    $order_id = $hub_order['order_id'];
                    $order_list = M('order_list');
                    $order_list->hub_type = '';
                    $order_list->shipping_code = '';
                    $order_list->shipping_id = '';
                    $order_list->shipping_name = '';
                    $order_list->where('order_id =' . $order_id)->save();

                    $result[$k]['hub_id'] = $v;
                    $result[$k]['status'] = "ok";
                }else{
                    $result[$k]['hub_id'] = $v;
                    $result[$k]['status'] = 'fail';
                }
            }else{
                $result[$k]['hub_id'] = $v;
                $result[$k]['status'] = 'fail';
                // $hub_order_val = M('hub_order');
                // $hub_order_val->shipping_code='';
                // $hub_order_val->shipping_name='';
                // $hub_order_val->shipping_no='';
                // $hub_order_val->ship_stats=1;
                // $hub_order_val->hub_type='';
                // $hub_order_val->where('order_id ='.$v)->save();
                // $order_id = $hub_order['order_id'];
                // $order_list = M('order_list');
                // $order_list ->hub_type ='';
                // $order_list->shipping_code ='';
                // $order_list->shipping_id   = '';
                // $order_list->shipping_name = '';
                // $order_list->where('order_id ='.$order_id)->save();
                // $result[$k]['hub_id'] = $v;
                // $result[$k]['status'] = 'ok';
            }
        }
        //}
        echo json_encode($result);
    }

    /**
     * [sendGoods 发货]
     * @return json
     */
    public function sendGoods(){
        if(I('post.ship_code')){
            $order_id = M('hub_order')->where("shipping_code = '" . trim(I('post.ship_code')) . "'")->Field('order_id,ship_stats')->find();
            if(!$order_id){
                $data['status'] = 'fail';
                $data['content'] = '运单号不存在';
                echo json_encode($data);
                return;
            }
            $order_state = M('order_list')->where('order_id =' . $order_id['order_id'])->getField('is_cus');
            if($order_state == 1){
                $data['status'] = 'fail';
                $data['content'] = '售后订单不能操作';
                echo json_encode($data);
                return;
            }
            if($order_id['order_id'] and $order_id['ship_stats'] == 2){
                $hub_order = M('hub_order');
                $hub_order->ship_stats = 3;
                $hub_order->where("shipping_code ='" . I('post.ship_code') . "'")->save();
                $order = M('order_list');
                $order->is_send_hub = 1;
                $order->send_hub_time = time();
                $order->order_state = 3;
                $order->where('order_id = ' . $order_id['order_id'])->save();
                $this->addLog(array("log_info"=>"商品发货完成，订单已发货","handle_info"=>"订单发货","cid"=>1,"pid"=>$order_id['order_id']));
                $data['status'] = 'ok';
                $data['content'] = '';
                echo json_encode($data);
            }
            if($order_id['ship_stats'] == 3){
                $data['status'] = 'fail';
                $data['content'] = '此运单号已完成了发货，勿重复操作';
                echo json_encode($data);
            }
            // else{
            //     $data['status'] ='fail';
            //     $data['content'] = '运单号不存在';
            //     echo json_encode($data);
            // }
        }
    }

    /**
     * getStorage 获取商品库存
     * @return Array
     */
    public function getStorage($mWhere = '',$mOrder = '',$type = ''){
        $_join = 'goods_sku_comb ON goods_sku_comb.goods_id = goods_list.goods_id ';
        $goods_list = M('goods_list')->join($_join)->where($mWhere)->group('goods_list.goods_id')->select();
        $_count = count($goods_list);
        $_page = $this->getPage($_count);
        $_data['list'] = M('goods_list')->join($_join)->where($mWhere)->group('goods_list.goods_id')->order($mOrder)->limit($_page->firstRow . ',' . $_page->listRows)->select();
        $_data['sql'] = M('goods_list')->getLastSql();
        foreach($_data['list'] as $k=> $v){
            $total = M('goods_sku_comb')->where('goods_id =' . $v['goods_id'])->group('goods_id')->sum('stock_num');
            $_data['list'][$k]['sku_str_zh'] = M('goods_sku_comb')->where('goods_id =' . $v['goods_id'])->order('id asc')->getField('sku_str_zh',true);
            $_data['list'][$k]['stock_num'] = M('goods_sku_comb')->where('goods_id =' . $v['goods_id'])->order('id asc')->Field('stock_num,id')->select();
            $_data['list'][$k]['stock_lock_num'] = M('goods_sku_comb')->where('goods_id =' . $v['goods_id'])->order('id asc')->getField('stock_lock_num',true);
            $_data['list'][$k]['all_stock'] = $total;
        }
        $_data['page'] = $_page->show();
        return $_data;
    }

    /**
     * [getStockTable 导出库存]
     * @param  string $mWhere [description]
     * @return [type]         [description]
     */
    public function getStockTable($mWhere = ''){
        $goods_list = M('goods_list');
        $goods_list->join('goods_sku_comb ON goods_sku_comb.goods_id = goods_list.goods_id');
        $_data['list'] = $goods_list->where($mWhere)->select();
        return $_data;
    }

    /**
     * [getLogCusList 日志列表]
     * @param  string $mWhere [搜索条件]
     * @param  string $mOrder [排序方式]
     * @param  string $type   [description]
     * @return [type]         [description]
     */
    public function getLogCusList($mWhere = '',$mOrder = ''){
        $_join_goods_list = 'goods_list ON goods_list.goods_id = log_cus_list.goods_id';
        $_join_goods_sku_com = 'goods_sku_comb ON  goods_sku_comb.id = log_cus_list.sku_comb_id';
        $_field = '*,log_cus_list.id as log_id,log_cus_list.addtime as log_time';
        $_count = M('log_cus_list')->join($_join_goods_list)->join($_join_goods_sku_com)->where($mWhere)->order($mOrder)->count();
        $_page = $this->getPage($_count);
        $_log_list = M('log_cus_list');
        $_log_list->join($_join_goods_list);
        $_log_list->join($_join_goods_sku_com);
        $_data['list'] = $_log_list->where($mWhere)->order($mOrder)->field($_field)->limit($_page->firstRow . ',' . $_page->listRows)->select();
        $_data['sql'] = $_log_list->getLastSql();
        foreach($_data['list'] as $n=> $m){
            preg_match_all('/([0-9]+:[0-9]+);/',$m['sku_str'],$rk);
            $arr_sku = array();
            foreach($rk[1] as $k=> $v){
                $sku_key_val = explode(':',$v);
                $sku_name = $sku_key_val[0];
                $sku_val = $sku_key_val[1];
                $_data['goods_id'] = $m['goods_id'];
                $_data['sku_val'] = $sku_val;
                $sku_val_str = M('goods_sku_list_val')->where($_data)->getField('sku_val_str');
                array_push($arr_sku,$sku_val_str);
            }
            $_data['list'][$n]['sku'] = $arr_sku;
        }
        $_data['page'] = $_page->show();
        return $_data;
    }

    /**
     * [updateToOrder 分配运单号后,更新到订单表
     * @param  Int $hubId [description]
     * @return false|true
     */
    public function updateToOrder($mOrderId){
        $order = M('order_list');
        $order->shipping_code = I('post.ship_code');
        $order->shipping_id = I('post.ship_id');
        $order->shipping_name = I('post.ship_name');
        $order->hub_type = 1;
        if($order->where("order_id = {$mOrderId}")->save()){
            $this->addLog(array('log_info'=>'分配运单号后,更新到订单表','handle_info'=>'操作','cid'=>1,'pid'=>$mOrderId));
            return true;
        }
        return false;
    }

    /**
     * [updateStock 更新库存]
     * @return [type] [description]
     */
    public function updateStock(){
        if(I('post.')){
            if(I('post.sku_id')){
                $this->ajaxReturn(0,'缺少sku_comb_id');
            }
            if(I('post.stock_num')){
                $this->ajaxReturn(0,'缺少库存值');
            }
            /* 更新库存到表 */
            $_sku_comb = M('goods_sku_comb');
            $_goods_id = $_sku_comb->where('id = ' . I('post.sku_id'))->getField('goods_id');
            $_sku_comb->stock_num = I('post.stock_num');
            $num = $_sku_comb->where('id = ' . I('post.sku_id'))->save();
            $this->setStockLog(I('post.sku_id'),I('post.stock_num'),I('post.old_stock'));
            $this->updateStockTime($_goods_id);
            $this->ajaxReturn(0,$num);
        }
    }

    /**
     * 导出所选订单列表
     */
    public function exportOrderExcel(){
        $xlsCell = array(
            array('order_sn','订单号'),
            array('addtime','下单时间'),
            array('con_time','确认时间'),
            array('send_hub_time','发货时间'),
            array('goods_no','商品id'),
            array('buyer_goods_no','商家编码'),
            array('sku_str_zh','SKU属性'),
            array('distribution_price','单价'),
            array('goods_num','数量'),
            array('shipping_fee','运费'),
            array('order_amount','总金额'),
            array('contact_name','收件人'),
            array('tel','联系方式'),
            array('contact_address','收件人信息'),
            array('order_state','订单状态'),
            array('ship_stats','发货状态'),
            array('memo','备注')
        );
        $order_state = array(
            0=>'待付款',
            1=>'已付款待确认',
            2=>'已确认待发货',
            3=>'已确认已发货',
            4=>'已完成',
            5=>'已关闭',
            6=>'异常'
        );

        $ship_stats = array(
            0=>'待配货',
            1=>'待分配',
            2=>'待发货',
            3=>'已完成'
        );
        $this->pagesize = 100000;
        $this->datas = $this->getHubList($this->searchWhere());
        foreach($this->datas['list'] as $key=> $value){
            $_data[$key]['order_sn'] = $value['order_sn'];
            $_data[$key]['addtime'] = $value['order_list_add_time'] ? date('Y-m-d H:i:s',$value['order_list_add_time']) : '';
            $_data[$key]['con_time'] = $value['con_time'] ? date('Y-m-d H:i:s',$value['con_time']) : '';
            $_data[$key]['send_hub_time'] = $value['send_hub_time'] ? date('Y-m-d H:i:s',$value['send_hub_time']) : '';
            $_data[$key]['goods_no'] = $value['goods_no'];
            $_data[$key]['buyer_goods_no'] = $value['buyer_goods_no'];
            $_data[$key]['distribution_price'] = $value['goods_price'];
            $_data[$key]['goods_num'] = $value['goods_num'];
            $_data[$key]['shipping_fee'] = $value['shipping_fee'];
            $_data[$key]['order_amount'] = $value['order_amount'];
            $_data[$key]['contact_name'] = $value['concat_address']['contact_name'];
            $_data[$key]['tel'] = $value['concat_address']['tel'];
            $_data[$key]['contact_address'] = $value['concat_address']['province'] . ' ' . $value['concat_address']['city'] . ' ' . $value['concat_address']['dist'] . ' ' . $value['concat_address']['contact_address'];
            $_data[$key]['order_state'] = $order_state[$value['order_state']];
            $_data[$key]['ship_stats'] = $ship_stats[$value['ship_stats']];
            $_data[$key]['memo'] = $value['memo'];
            $sku_str_zh = '';
            array_walk($value['sku'],function ($v) use (&$sku_str_zh){
                $sku_str_zh .= $v . ';';
            });
            $_data[$key]['sku_str_zh'] = $sku_str_zh;
        }
        $this->exportExcel('发货订单列表',$xlsCell,$_data);
        exit;
    }

}
