<?php

/**
 * 生成交易号
 */
function make_trade_no($type = 1) {
    $no = time() . rand(100000, 999999);
    switch ($type) {
        case 1:
            $trade_no = 'cm_' . $no;
            $record = M('fx_catch_money')->where(array('trade_no' => $trade_no))->count();
            if ($record > 0) {
                $trade_no = make_trade_no(1);
            }
            break;
        case 2:
            $trade_no = 'cst_' . $no;
            $record = M('confirm_sucess_trade')->where(array('trade_no' => $trade_no))->count();
            if ($record > 0) {
                $trade_no = make_trade_no(2);
            }
            break;
        default :
    }
    return $trade_no;
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
    $fileName = $xlsTitle . $_SESSION['loginAccount'] . date('_YmdHis'); //or $xlsTitle 文件名称可根据自己情况设定
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
            $objPHPExcel->getActiveSheet(0)->setCellValueExplicit($cellName[$j] . ($i + 2), $expTableData[$i][$expCellName[$j][0]], \PHPExcel_Cell_DataType::TYPE_STRING2);
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

