<?php

namespace Home\Controller;

use Think\Controller;
use Org\Util\YHttp;

/**
 * 公共控制器
 * @author xlufei
 * 
 *
 */
class CommonController extends Controller{

    Public $sessionKey;
    public $appkey;
    public $secretKey;
    public $redirect_uri;

    function _initialize(){
        $this->appkey = C('taobaoAppKey');
        $this->secretKey = C('taobaosecretKey');
        // self::cas();
        $this->first_menu = $this->getMenu();
        $id = ( 0 == I('get.menu_id',0) ) ? 1 : I('get.menu_id/d');
        $this->secondMenu = $this->getMenu($id);
        $this->assign('mp',self::getMenuPramer());
        $this->pagesize = I('get.pagesize/d') ? I('get.pagesize/d') : 20;
        $this->sessionKey = session('sessionKey');
        $this->redirect_uri = C('cas_logOut_service') . '/index.php/Home/TbApi/taobaoLoginReturn';
        //处理浏览器时间传输问题
        $_GET['startTime'] = str_replace('+',' ',I('get.startTime'));
        $_GET['endTime'] = str_replace('+',' ',I('get.endTime'));

    }

    /**
     * [newTaoBaoApi 构建淘宝ＡＰＩ对象
     * @return [type] [description]
     */
    public function newTaoBaoApi(){
        date_default_timezone_set('Asia/Shanghai');
        vendor("TBAPI.TopSdk",'','.php');
        $res = array();
        $c = new \TopClient;
        $c->appkey = $this->appkey;
        $c->secretKey = $this->secretKey;
        return $c;
    }

    /**
     * getPower 取权限
     * @return [type] [description]
     */
    final function getPower(){
        $_parameter['token'] = self::getToken();
        $_phpCAS = session('phpCAS');
        $_url = 'http://' . C('cas_ip') . ':' . C('cas_port') . '/ams/rest/api/permissions/all/' . $_phpCAS['user'];
        $_result = YHttp::sendHttpRequest($_url,$_parameter,'GET');
        if('success' == $_result->status->message){
            $_power = array();
            $_priList = $_result->data->priList;
            foreach($_priList as $key=> $value){
                $_power[$value->code] = $value->level;
                foreach($value->resources as $v){
                    $_power[$v->funCode] = $v->level;
                }
            }
            session('power',$_power);
        }
    }

    /**
     * getMenuPowerKey 取的分类组数
     * 	  * @return [type] [description]
     */
    final function getMenuPowerKey(){
        $_where['is_delete'] = 0;
        $_where['parent_id'] = array('exp','in (select id from system_menu where is_delete = 0 and parent_id = 0 )');
        $_system_menu = M('system_menu')->where($_where)->select();
        //print_r($_system_menu);
        $_powerKey = array();
        foreach($_system_menu as $key=> $value){
            $_where['is_delete'] = 0;
            $_where['parent_id'] = array('exp',"in (select id from system_menu where is_delete = 0 and parent_id = {$value['id']} )");
            $_two_menu = M('system_menu')->where($_where)->select();
            foreach($_two_menu as $v){
                $_powerKey[$value['id']][$v['meun_key'] . '_' . $v['group_id']] = $v['power_key'];
            }
        }
        session('powerKey',$_powerKey);
    }

    /**
     * [getToken 获取Token 
     * @return String|false
     */
    final function getToken(){
        $_result = YHttp::sendHttpRequest('http://' . C('cas_ip') . ':' . C('cas_port') . '/ams/gettoken/6235/8633b10f677195cecca67737b442d8a8','','GET');
        if('success' == $_result->status->message){
            return $_result->data->token;
        }
        return false;
    }

    /**
     * [getMenu 获取菜单]
     * @return [array] [返回一个菜单数组]
     */
    public function getMenu($mMenuId = 0){
        //$_id = ( 0 == I('get.menu_id/d') ) ? 0 : I('get.menu_id/d');
        $_menu_list = M('system_menu')->where("parent_id = {$mMenuId}")->order('sort asc')->select();
        foreach($_menu_list as $key=> $value){
            if(0 == $value['parent_id']){
                $_second_menu_id = M('system_menu')->where("parent_id={$value['id']} and sort = 1")->getField('id');
                $value['url'] = U($value['url'],array('menu_id'=>$value['id'],'second_menu_id'=>$_second_menu_id));
            }else{
                $value['url'] = U($value['url'],array('menu_id'=>$mMenuId,'second_menu_id'=>$value['id']));
            }
            $_menu_list[$key] = $value;
        }
        return $_menu_list;
    }

    public function aReturn($status = 1,$message,$data = false){
        $d['status'] = $status;
        $d['message'] = $message;
        $d['returnData'] = $data;
        die($this->ajaxReturn($d,'JSON'));
    }

    /**
     * [getMenuPramer 取一级分类，二级分类参数 ,分组参数
     * @return [type] [description]
     */
    final function getMenuPramer(){
        if(0 != I('get.menu_id/d')) $_menu_pramer['menu_id'] = I('get.menu_id/d');
        if(0 != I('get.second_menu_id/d')) $_menu_pramer['second_menu_id'] = I('get.second_menu_id/d');
        if(0 != I('get.group_id/d')) $_menu_pramer['group_id'] = I('get.group_id/d');
        return $_menu_pramer;
    }

    final public function cas(){
        vendor("phpcas.CAS",'','.php');
        \phpCAS::client(CAS_VERSION_2_0,C('cas_ip'),C('cas_port'),"/cas",true);
        \phpCAS::setServerLoginUrl('http://' . C('cas_ip') . ':' . C('cas_port') . '/cas/login?service=' . C('cas_logOut_service') . '/');
        \phpCAS::setNoCasServerValidation();

        if(isset($_REQUEST['logout'])){
            $param = array("service"=>C('cas_logOut_service'));
            \phpCAS::logout($param);
        }

        \phpCAS::handleLogoutRequests(true,array("192.168.105.70"));
        if(\phpCAS::checkAuthentication()){
            $cas_user_info = \phpCAS::getAttributes();
            $cas_user_info = json_decode(urldecode($cas_user_info['curr-info']));
            self::getPower();
            self::getMenuPowerKey();
        }else{
            \phpCAS::forceAuthentication();
        }
    }

    /**
     * addLog 添加日志
     * @param Array $mData = array(
     *        		log_info   	  系统备注
     *        		handle_info   操作说明
     *        		cid 		  分类ID：1=订单,2=售后,3=库存,4=操作
     *        		pid 		  被记录对像的ＩＤ
     *        )
     */
    public function addLog($mData){
        $_phpCAS = session('phpCAS');
        $mData['user_id'] = $_phpCAS['user'];
        $mData['addtime'] = time();
        $mData['ip_address'] = get_client_ip();
        M('log_list')->add($mData);
    }

    public function getPage($count = 100,$pagesize = 10){
        $pagesize = $this->pagesize;
        $p = new \Think\Page($count,$pagesize);
        $p->lastSuffix = false;
        $p->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条</li>');
        $p->setConfig('prev','上一页');
        $p->setConfig('next','下一页');
        $p->setConfig('last','末页');
        $p->setConfig('first','首页');
        $p->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $p->parameter = I('get.');
        return $p;
    }

    /**
     * WlbWaybillICancelRequest 取消电子运单号
     * @param Array $mOrder 订单信息
     */
    public function wlbWaybillICancelRequest($mOrder){
        if('' == $mOrder['order_sn']){
            return false;
        }
        if('' == $mOrder['shipping_no']){
            return false;
        }
        if('' == $mOrder['shipping_code']){
            return false;
        }
        vendor("TBAPI.TopSdk",'','.php');
        date_default_timezone_set('Asia/Shanghai');
        $c = new \TopClient;
        $c->appkey = $this->appkey;
        $c->secretKey = $this->secretKey;
        $req = new \WlbWaybillICancelRequest;
        $waybill_apply_cancel_request = new \WaybillApplyCancelRequest;
        $waybill_apply_cancel_request->real_user_id = "2899430086";
        $waybill_apply_cancel_request->trade_order_list = $mOrder['order_sn'];
        $waybill_apply_cancel_request->cp_code = $mOrder['shipping_no'];
        $waybill_apply_cancel_request->waybill_code = $mOrder['shipping_code'];
        $req->setWaybillApplyCancelRequest(json_encode($waybill_apply_cancel_request));
        return $c->execute($req,$this->sessionKey);
    }

    /**
     * depotList 取仓库列表
     * @return Array 
     */
    public function depotList(){
        return M('system_depot')->field('id,depot_name')->select();
    }

    /**
     * goodsCategoryList 商品类目列表
     * @return [type] [description]
     */
    public function goodsCategoryList($mParentId = 0){
        return M('goods_category')->field('cid,name')->where("parent_cid = {$mParentId}")->order('cid asc')->select();
    }

    /**
     * [system_shipping 取物流公司名称]
     * @return Array [description]
     */
    public function system_shipping(){
        return M('system_shipping')->order("sort asc")->select();
    }

    /**
     * getShipInf 取物流公司信息
     * @param  Int     $mShipId 物流公司ＩＤ
     * @return Array          
     */
    public function getShipInf($mShipId){
        return M('system_shipping')->where("id={$mShipId}")->find();
    }

    /**
     * getOrderInfo 取订单信息
     * @param  Int $mOrderID  订单ＩＤ
     * @return Array       
     */
    public function getOrderInfo($mOrderID){
        return M('order_list')->where("order_id={$mOrderID}")->find();
    }

    /**
     * getHubOrder 取发货单信息
     * @param  Int $mOrderID  订单ＩＤ
     * @return Array  
     */
    public function getHubOrder($mOrderID){
        return M('hub_order')->where("order_id={$mOrderID}")->find();
    }

    /**
     * [system_shop 取平台列表]
     * @return Array [description]
     */
    public function system_shop(){
        return M('system_shop')->select();
    }

    /**
     * [getOrderConcatAll 获取订单收件人所有地址信息]
     * @param  int  $mOrderID [订单ID]
     * @return Array           [数组]
     */
    public function getOrderConcatAll($mOrderID,$mLimit = 1){
        $_concat = M('order_contact')->where(array('order_id'=>$mOrderID))->order('id desc');
        if(1 == $mLimit){
            return $_concat->find();
        }else{
            return $_concat->select();
        }
    }

    /**
     * [getOrderGoodsSK 获取订单商品SKU]
     * @param  [订单id] $mOrderID [description]
     * @param  [订单商品id] $mGoodsID [description]
     * @return [type]           [description]
     */
    public function getOrderGoodsSK($mOrderID = '',$goodsId = ''){
        $map['order_id'] = $mOrderID;
        if(empty($goodsId)){
            $_order_sku_id = M('order_goods_sku')->where($map)->Field('sku_comb_id,goods_id')->find();
            $con_sku_val = M('goods_sku_comb')->where(array('goods_id'=>$_order_sku_id['goods_id'],'id'=>$_order_sku_id['sku_comb_id']))->getField('sku_str');
            $_where['goods_id'] = $_order_sku_id['goods_id'];
            $_data['goods_id'] = $_order_sku_id['goods_id'];
        }else{
            $con_sku_val = M('goods_sku_comb')->where(array('goods_id'=>$goodsId))->getField('sku_str');
            $_where['goods_id'] = $goodsId;
            $_data['goods_id'] = $goodsId;
        }
        preg_match_all('/([0-9]+:[0-9]+);/',$con_sku_val,$rk);
        $arr_sku = array();
        foreach($rk[1] as $k=> $v){
            $sku_key_val = explode(':',$v);
            $sku_name = $sku_key_val[0];
            $sku_val = $sku_key_val[1];
            $_where['sku_name'] = $sku_name;
            $sku_name_str = M('goods_sku_list_name')->where($_where)->getField('sku_name_str');
            $_data['sku_val'] = $sku_val;
            $sku_val_str = M('goods_sku_list_val')->where($_data)->getField('sku_val_str');
            $arr_sku[$sku_name_str] = $sku_val_str;
        }
        return $arr_sku;
    }

    public function xlueiExcel($titls,$list,$name){
        vendor("PhpExcel.PHPExcel",'','.php');
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator("ctos")
                ->setLastModifiedBy("ctos")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");
        $z = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','z');
        foreach($titls as $k=> $r){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($z[$k] . '1',$r);
        }


        // 内容  
        $i = 1;
        foreach($list as $k=> $r){
            $i = 0;
            foreach($r as $kk=> $rr){
                $objPHPExcel->getActiveSheet(0)->setCellValue($z[$i] . ($k + 2),$rr);
                $i++;
            }
        }

        // Rename sheet    
        $objPHPExcel->getActiveSheet()->setTitle($name);

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet    
        $objPHPExcel->setActiveSheetIndex(0);

        // 输出  
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $name . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
        $objWriter->save('php://output');
    }

    /**
      +----------------------------------------------------------
     * Export Excel | 2013.08.23
     * Author:HongPing <hongping626@qq.com>
      +----------------------------------------------------------
     * @param $expTitle     string File name
      +----------------------------------------------------------
     * @param $expCellName  array  Column name
      +----------------------------------------------------------
     * @param $expTableData array  Table data
      +----------------------------------------------------------
     */
    public function exportExcel($expTitle,$expCellName,$expTableData){
        $xlsTitle = iconv('utf-8','gb2312',$expTitle); //文件名称
        $fileName = $_SESSION['loginAccount'] . date('_YmdHis'); //or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        vendor("PhpExcel.PHPExcel",'','.php');
        $objPHPExcel = new \PHPExcel();
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');

        //$objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
        //$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));  
        for($i = 0; $i < $cellNum; $i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i] . '1',$expCellName[$i][1]);
        }
        // Miscellaneous glyphs, UTF-8   
        for($i = 0; $i < $dataNum; $i++){
            for($j = 0; $j < $cellNum; $j++){
                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j] . ($i + 2),$expTableData[$i][$expCellName[$j][0]]);
            }
        }

        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="' . $xlsTitle . '.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls"); //attachment新窗口打印inline本窗口打印
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    /**
      +----------------------------------------------------------
     * Import Excel | 2013.08.23
     * Author:HongPing <hongping626@qq.com>
      +----------------------------------------------------------
     * @param  $file   upload file $_FILES
      +----------------------------------------------------------
     * @return array   array("error","message")
      +----------------------------------------------------------
     */
    public function importExecl($inputFileName){
        if(!file_exists($inputFileName)){
            echo "error";
            return array("error"=>0,'message'=>'file not found!');
        }
        //vendor("PHPExcel.PHPExcel.IOFactory",'','.php'); 
        vendor("PhpExcel.PHPExcel",'','.php');
        vendor("PhpExcel.PHPExcel.IOFactory",'','.php');
        //'Loading file ', pathinfo( $inputFileName, PATHINFO_BASENAME ),' using IOFactory with a defined reader type of ',$inputFileType,'<br />';
        $fileType = \PHPExcel_IOFactory::identify($inputFileName); //文件名自动判断文件类型
        $objReader = \PHPExcel_IOFactory::createReader($fileType);
        // $objReader = \PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load($inputFileName);
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow(); //取得总行数
        $highestColumn = $sheet->getHighestColumn(); //取得总列
        $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn); //总列数
        for($row = 2; $row <= $highestRow; $row++){
            $strs = array();
            //注意highestColumnIndex的列数索引从0开始
            for($col = A; $col <= $highestColumn; $col++){
                $strs[$col] = $sheet->getCell($col . $row)->getValue();
            }
            $arr[] = $strs;
        }
        return $arr;
    }

    /**
     * [getLayerHtml 获取弹窗页面内容]
     * @param  [type] $mfileName [description]
     * @param  string $data      [description]
     * @return [type]            [description]
     */
    public function getLayerHtml($mfileName,$data = ''){
        return $this->fetch(T('Public/' . $mfileName),$data);
    }

    /**
     * [autoSign 自动生成签名字符串]
     * @param  [array] $data [生成签名用到的参数]
     * @return [string]       [签名字符串_sign]
     */
    public function autoSign($data){
        $SUP_TOKEN = "DBC008C4792D6631BC47547DE5538EE3";
        $post_params = $data;
        ksort($post_params);
        $exclude_keys = array('_act','_sign','_ts');
        foreach($post_params as $key=> $value){
            if(in_array($key,$exclude_keys)) continue;
            if(strlen($value) > 100) continue;
            $sign_string.=$key . $value;
        }
        $sign_string = md5($SUP_TOKEN . $sign_string . $SUP_TOKEN);
        return $sign_string;
    }

    /**
     * [getDistributionPrice 获取商品分销价]
     * @param  [type] $mgoodsId  商品ID
     * @return number            商品分销价
     */
    public function getDistributionPrice($mgoodsId,$mshopId){
        $_where['goods_id'] = $mgoodsId;
        $_where['shop_id'] = $mshopId;
        $_price = M('goods_price')->where($_where)->getField('distribution_price');
        return $_price;
    }

    /**
     * [decGoodsStock F]
     * @param  [type] $mOrderId 订单ID
     * @return [type]           [description]
     */
    public function decGoodsStock($mOrderId){
        $_sku_comb_id = M('order_goods_sku')->where('order_id =' . $mOrderId)->getField('sku_comb_id');
        $_goods_num = M('order_goods')->where('order_id =' . $mOrderId)->getField('goods_num');
        $_godos_sku_comb = M('goods_sku_comb');
        $_old_stock = $_godos_sku_comb->where('id = ' . $_sku_comb_id)->getField('stock_num');
        $_result = $_godos_sku_comb->where('id = ' . $_sku_comb_id)->setInc('stock_num',$_goods_num);
        $_new_stock = $_godos_sku_comb->where('id = ' . $_sku_comb_id)->getField('stock_num');
        $this->setStockLog($_sku_comb_id,$_new_stock,$_old_stock);
        return $_result;
    }

    /**
     * [decCusStock 售后增加库存]
     * @param  [type] $mCusId [description]
     * @return [type]         [description]
     */
    public function decCusStock($mCusId){
        $_sku_comb = M('cus_order_goods_list')->where('cus_id =' . $mCusId)->Field('sku_comb_id,goods_num')->select();
        $_godos_sku_comb = M('goods_sku_comb');
        //未改变库存统计变量
        $_fail = 0;
        // 改变库存商品数量
        $_success = 0;
        //总共商品数量
        $_count = 0;
        foreach($_sku_comb as $key=> $value){
            if($value['goods_num'] <= 0){
                $_fail++;
                continue;
            }
            //原库存
            $_old_stock = $_godos_sku_comb->where('id = ' . $value['sku_comb_id'])->getField('stock_num');
            //加库存
            $_result = $_godos_sku_comb->where('id = ' . $value['sku_comb_id'])->setInc('stock_num',$value['goods_num']);
            //更改过后的库存
            $_new_stock = $_godos_sku_comb->where('id = ' . $value['sku_comb_id'])->getField('stock_num');
            //判断是否更改库存成功
            if(!$_result){
                $_fail++;
                continue;
            }
            //添加库存变动日志
            $this->setStockLog($value['sku_comb_id'],$_new_stock,$_old_stock);
            $_success++;
        }
        //判断更改库存数量和更改成功数量是否等于商品总数量
        if(count($_sku_comb) == ($_fail + $_success )){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * [setStockLog 单个设置商品库存]
     * @param [type] $mskuId  商品sku_id
     * @param [type] $mstock  修改后的库存
     * @param [type] $moldStock  以前的库存
     */
    public function setStockLog($mskuId,$mstock,$moldStock){
        $sku_comb = M('goods_sku_comb');
        $goods_id = $sku_comb->where('id =' . $mskuId)->getField('goods_id');
        //$goods_info  = M('goods_list')->where('goods_id ='.$sku_val['goods_id'])->find();
        $goods_info = M('goods_list')->where('goods_id = ' . $goods_id)->find();
        /* 更新到库存 */
        $log_cus_list = M('log_cus_list');
        $log_cus_list->addtime = time();
        $log_cus_list->user_id = session('phpCAS')['user'];
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
    public function updateStockTime($mgoodsId){
        $goods_list = M('goods_list');
        $goods_list->stock_update_time = time();
        $goods_list->where("goods_id = $mgoodsId")->save();
    }

}
