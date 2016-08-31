<?php

namespace Orders\Controller;

use Org\Util\YHttp;

/**
 * 公共控制器
 * @author xlufei
 * 
 *
 */
class CommonController extends \Common\Controller\BasicController {

    public $sessionKey;

    function _initialize() {
        //处理浏览器时间传输问题
        $_GET['startTime'] = str_replace('+', ' ', I('get.startTime'));
        $_GET['endTime'] = str_replace('+', ' ', I('get.endTime'));
    }

    /**
     * 获取sessionKey（并处理异常）
     * @return type String
     */
    private function getSessionKey() {
        if ($this->sessionKey) return $this->sessionKey;
        $_user = $this->user_info['id'];
        $access_token = M('taobao_authorize')->where("user_id = {$_user}")->getField('access_token');
        if ($access_token) {
            session('sessionKey', $access_token);
            $this->sessionKey = $access_token;
            return $this->sessionKey;
        }
        return false;
    }

    /**
     * addLog 添加日志
     * @param Array $mData = array(
     * $log_info   	  系统备注
     * $handle_info   操作说明
     * $cid 		  分类ID：1=订单,2=售后,3=库存,4=操作
     * $pid 		  被记录对像的ＩＤ
     * )
     */
    public function addLog($mData) {
        $mData['user_id'] = $this->user_info['id'];
        $mData['addtime'] = time();
        $mData['ip_address'] = get_client_ip();
        M('log_list')->add($mData);
    }

    /**
     * 输出json
     * @param type $status
     * @param type $message
     * @param type $data
     */
    public function aReturn($status = 1, $message, $data = false) {
        $d['status'] = $status;
        $d['message'] = $message;
        $d['returnData'] = $data;
        die($this->ajaxReturn($d, 'JSON'));
    }

    /**
     * [newTaoBaoApi 构建淘宝ＡＰＩ对象
     * @return [type] [description]
     */
    public function newTaoBaoApi() {
        date_default_timezone_set('Asia/Shanghai');
        vendor("TBAPI.TopSdk", '', '.php');
        $res = array();
        $c = new \TopClient;
        $c->appkey = C('taobaoAppKey');
        $c->secretKey = C('taobaosecretKey');
        return $c;
    }

    /**
     * [getToken 获取Token 
     * @return String|false
     */
    final function getToken() {
        $_result = YHttp::sendHttpRequest('http://' . C('cas_ip') . ':' . C('cas_port') . '/ams/gettoken/6235/8633b10f677195cecca67737b442d8a8', '', 'GET');
        if ('success' == $_result->status->message) {
            return $_result->data->token;
        }
        return false;
    }

    /**
     * WlbWaybillICancelRequest 取消电子运单号
     * @param Array $mOrder 订单信息
     */
    public function wlbWaybillICancelRequest($mOrder) {
        if ('' == $mOrder['order_sn']) {
            return false;
        }
        if ('' == $mOrder['shipping_no']) {
            return false;
        }
        if ('' == $mOrder['shipping_code']) {
            return false;
        }
        vendor("TBAPI.TopSdk", '', '.php');
        date_default_timezone_set('Asia/Shanghai');
        $_session_key = $this->getSessionKey();
        $c = new \TopClient;
        $c->appkey = C('taobaoAppKey');
        $c->secretKey = C('taobaosecretKey');
        $req = new \WlbWaybillICancelRequest;
        $waybill_apply_cancel_request = new \WaybillApplyCancelRequest;
        $waybill_apply_cancel_request->real_user_id = "2899430086";
        $waybill_apply_cancel_request->trade_order_list = $mOrder['order_sn'];
        $waybill_apply_cancel_request->cp_code = $mOrder['shipping_no'];
        $waybill_apply_cancel_request->waybill_code = $mOrder['shipping_code'];
        $req->setWaybillApplyCancelRequest(json_encode($waybill_apply_cancel_request));
        return $c->execute($req, $_session_key);
    }

    /**
     * getOrderInfo 取订单信息
     * @param  Int $mOrderID  订单ＩＤ
     * @return Array       
     */
    public function getOrderInfo($mOrderID) {
        return M('order_list')->where("order_id={$mOrderID}")->find();
    }

    /**
     * getHubOrder 取发货单信息
     * @param  Int $mOrderID  订单ＩＤ
     * @return Array  
     */
    public function getHubOrder($mOrderID) {
        return M('hub_order')->where("order_id={$mOrderID}")->find();
    }

    public function xlueiExcel($titls, $list, $name) {
        vendor("PhpExcel.PHPExcel", '', '.php');
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator("ctos")
                ->setLastModifiedBy("ctos")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");
        $z = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'z');
        foreach ($titls as $k => $r) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($z[$k] . '1', $r);
        }


        // 内容  
        $i = 1;
        foreach ($list as $k => $r) {
            $i = 0;
            foreach ($r as $kk => $rr) {
                $objPHPExcel->getActiveSheet(0)->setCellValue($z[$i] . ($k + 2), $rr);
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

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
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
    public function exportExcel($expTitle, $expCellName, $expTableData) {
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle); //文件名称
        $fileName = $_SESSION['loginAccount'] . date('_YmdHis'); //or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        vendor("PhpExcel.PHPExcel", '', '.php');
        $objPHPExcel = new \PHPExcel();
        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');

        //$objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
        //$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));  
        for ($i = 0; $i < $cellNum; $i++) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i] . '1', $expCellName[$i][1]);
        }
        // Miscellaneous glyphs, UTF-8   
        for ($i = 0; $i < $dataNum; $i++) {
            for ($j = 0; $j < $cellNum; $j++) {
                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j] . ($i + 2), $expTableData[$i][$expCellName[$j][0]]);
            }
        }

        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="' . $xlsTitle . '.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls"); //attachment新窗口打印inline本窗口打印
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
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
    public function importExecl($inputFileName) {
        if (!file_exists($inputFileName)) {
            echo "error";
            return array("error" => 0, 'message' => 'file not found!');
        }
        //vendor("PHPExcel.PHPExcel.IOFactory",'','.php'); 
        vendor("PhpExcel.PHPExcel", '', '.php');
        vendor("PhpExcel.PHPExcel.IOFactory", '', '.php');
        //'Loading file ', pathinfo( $inputFileName, PATHINFO_BASENAME ),' using IOFactory with a defined reader type of ',$inputFileType,'<br />';
        $fileType = \PHPExcel_IOFactory::identify($inputFileName); //文件名自动判断文件类型
        $objReader = \PHPExcel_IOFactory::createReader($fileType);
        // $objReader = \PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load($inputFileName);
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow(); //取得总行数
        $highestColumn = $sheet->getHighestColumn(); //取得总列
        $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn); //总列数
        for ($row = 2; $row <= $highestRow; $row++) {
            $strs = array();
            //注意highestColumnIndex的列数索引从0开始
            for ($col = A; $col <= $highestColumn; $col++) {
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
    public function getLayerHtml($mfileName, $data = '') {
        return $this->fetch(T('Public/' . $mfileName), $data);
    }

    /**
     * [autoSign 自动生成签名字符串]
     * @param  [array] $data [生成签名用到的参数]
     * @return [string]       [签名字符串_sign]
     */
    public function autoSign($data) {
        $SUP_TOKEN = "DBC008C4792D6631BC47547DE5538EE3";
        $post_params = $data;
        ksort($post_params);
        $exclude_keys = array('_act', '_sign', '_ts');
        foreach ($post_params as $key => $value) {
            if (in_array($key, $exclude_keys)) continue;
            if (strlen($value) > 100) continue;
            $sign_string.=$key . $value;
        }
        $sign_string = md5($SUP_TOKEN . $sign_string . $SUP_TOKEN);
        return $sign_string;
    }

    /**
     * [decGoodsStock F]
     * @param  [type] $mOrderId 订单ID
     * @return [type]           [description]
     */
    public function decGoodsStock($mOrderId) {
        $_sku_comb_id = M('order_goods_sku')->where('order_id =' . $mOrderId)->getField('sku_comb_id');
        $_goods_num = M('order_goods')->where('order_id =' . $mOrderId)->getField('goods_num');
        $_godos_sku_comb = M('goods_sku_comb');
        $_old_stock = $_godos_sku_comb->where('id = ' . $_sku_comb_id)->getField('stock_num');
        $_result = $_godos_sku_comb->where('id = ' . $_sku_comb_id)->setInc('stock_num', $_goods_num);
        $_new_stock = $_godos_sku_comb->where('id = ' . $_sku_comb_id)->getField('stock_num');
        $this->setStockLog($_sku_comb_id, $_new_stock, $_old_stock);
        return $_result;
    }

    /**
     * [decCusStock 售后增加库存]
     * @param  [type] $mCusId [description]
     * @return [type]         [description]
     */
    public function decCusStock($mCusId) {
        $_sku_comb = M('cus_order_goods_list')->where('cus_id =' . $mCusId)->Field('sku_comb_id,goods_num')->select();
        $_godos_sku_comb = M('goods_sku_comb');
        //未改变库存统计变量
        $_fail = 0;
        // 改变库存商品数量
        $_success = 0;
        //总共商品数量
        $_count = 0;
        foreach ($_sku_comb as $key => $value) {
            if ($value['goods_num'] <= 0) {
                $_fail++;
                continue;
            }
            //原库存
            $_old_stock = $_godos_sku_comb->where('id = ' . $value['sku_comb_id'])->getField('stock_num');
            //加库存
            $_result = $_godos_sku_comb->where('id = ' . $value['sku_comb_id'])->setInc('stock_num', $value['goods_num']);
            //更改过后的库存
            $_new_stock = $_godos_sku_comb->where('id = ' . $value['sku_comb_id'])->getField('stock_num');
            //判断是否更改库存成功
            if (!$_result) {
                $_fail++;
                continue;
            }
            //添加库存变动日志
            $this->setStockLog($value['sku_comb_id'], $_new_stock, $_old_stock);
            $_success++;
        }
        //判断更改库存数量和更改成功数量是否等于商品总数量
        if (count($_sku_comb) == ($_fail + $_success )) {
            return 1;
        } else {
            return 0;
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

}
