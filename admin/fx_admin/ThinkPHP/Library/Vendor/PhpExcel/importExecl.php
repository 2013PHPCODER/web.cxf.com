<?php

/** PHPExcel root directory */
if (!defined('PHPEXCEL_ROOT')) {
    define('PHPEXCEL_ROOT', dirname(__FILE__) . '/');
    require(PHPEXCEL_ROOT . 'PHPExcel/Autoloader.php');
}
include 'PHPExcel/IOFactory.php';


//  $inputFileType = 'Excel2007';
//  $inputFileType = 'Excel2003XML';
//  $inputFileType = 'OOCalc';
//  $inputFileType = 'Gnumeric';


/**  Define a Read Filter class implementing PHPExcel_Reader_IReadFilter  */
// class chunkReadFilter implements PHPExcel_Reader_IReadFilter
// {
//     private $_startRow = 0;

//     private $_endRow = 0;

//     /**  Set the list of rows that we want to read  */
//     public function setRows($startRow, $chunkSize) {
//         $this->_startRow    = $startRow;
//         $this->_endRow      = $startRow + $chunkSize;
//     }

//     public function readCell($column, $row, $worksheetName = '') {
//         //  Only read the heading row, and the rows that are configured in $this->_startRow and $this->_endRow
//         if (($row == 1) || ($row >= $this->_startRow && $row < $this->_endRow)) {
//             return true;
//         }
//         return false;
//     }
// }

/**
* 
*/
class implodeExecl {
    $inputFileType = 'Excel5';
    function __construct(argument)
    {
        # code...
    }

    public function implodeFile( $inputFileType ){
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $chunkSize = 20;
        $chunkFilter = new chunkReadFilter();
        $objReader->setReadFilter($chunkFilter);
        for ($startRow = 2; $startRow <= 240; $startRow += $chunkSize) {
            echo 'Loading WorkSheet using configurable filter for headings row 1 and for rows ',$startRow,' to ',($startRow+$chunkSize-1),'<br />';
            /**  Tell the Read Filter, the limits on which rows we want to read this iteration  **/
            $chunkFilter->setRows($startRow,$chunkSize);
            /**  Load only the rows that match our filter from $inputFileName to a PHPExcel Object  **/
            $objPHPExcel = $objReader->load($inputFileName);
            //  Do some processing here
            $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
            var_dump($sheetData);
            echo '<br /><br />';
        }
    }

}


?>
