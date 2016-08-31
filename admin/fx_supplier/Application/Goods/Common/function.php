<?php

/**
 * depotList 取仓库列表
 * @return Array 
 */
function depotList() {
    return M('fx_storage_list')->field('id,sname')->select();
}

/**
 * getParentCategory 商品树型父级类目
 * @param   Int     $mCategoryCid 分类ID
 * @return  Int|false
 */
function getTreeCategory($mCategoryCid, $mCategoryArr = array()) {
    $_goods_category_row = M('goods_category')->where("cid={$mCategoryCid}")->find();
    $mCategoryArr[] = $_goods_category_row['name'];
    if (0 != intval($_goods_category_row['parent_cid'])) {
        return getTreeCategory($_goods_category_row['parent_cid'], $mCategoryArr);
    } else {
        krsort($mCategoryArr);
        return implode(' / ', $mCategoryArr);
    }
}

/**
 * checkShopGoods 检测某商品是否发面在某平台
 * @param  Int $mShopId  平台ＩＤ
 * @param  Int $mGoodsId 商品ＩＤ
 * @return true|false
 */
function checkShopGoods($mShopId, $mGoodsId) {
    return M('system_shop_goods')->where(array("shop_id" => $mShopId, "goods_id" => $mGoodsId))->count() ? true : false;
}

/**
 * [goodsFileAnalytic 商品文件解析]
 * @param  [String] $mFilePath [文件路径]
 * @return [Array]             [商品属性数组]
 */
function goodsFileAnalytic($mFilePath) {
    if (!$mFilePath) {
        return false;
    }
    if (!file_exists(ROOT_DIR . $mFilePath)) {
        return false;
    }
    $_goodsArrary = array();
    if (!( $handle = fileRead($mFilePath, "r")) === FALSE) {
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
function fileRead($mFilePath) {
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
 * 获取类目的顶级目录
 * @param int $category_id
 */
function get_top_category($category_id) {
    $_mParentid = M('goods_category')->where(array('cid' => $category_id))->getField('parent_cid');
    if (0 != intval($_mParentid)) {
        return get_top_category($_mParentid);
    }
    return $category_id;
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
function exportExcel($expTitle, $expCellName, $expTableData) {
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
function importExecl($inputFileName) {
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

function xlueiExcel($titls, $list, $name) {
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
 * 
 * @param type $url 是远程图片的完整URL地址，不能为空。
 * @param string $filename  是可选变量: 如果为空，本地文件名将基于时间和日期
 * @return boolean|string$url 
 */
function GrabImage($url, $filename, $file_path) {
    if ($url == "") return false;
    $filepath = ROOT_DIR . $file_path . '/' . $filename;
    ob_start();
    readfile($url);
    $img = ob_get_contents();
    ob_end_clean();
    $size = strlen($img);
    $fp2 = @fopen($filepath, "a");
    fwrite($fp2, $img);
    fclose($fp2);
    return $filepath;
}

/**
 * 通过用户等级查询用户允许上传条数
 * @param type $user_level
 */
function get_upload_size($user_level) {
    $num = M('fx_supplier_level')->where(array('level' => $user_level))->getField('num');
    return $num ? $num : 0;
}
