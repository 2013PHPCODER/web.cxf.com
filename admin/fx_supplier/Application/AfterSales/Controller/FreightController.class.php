<?php
namespace AfterSales\Controller;
use Common\Controller\AuthController as Auth;

class FreightController extends Auth{

	public function index(){			//显示退运费模板
		$list=\Config::freight();
		$get=I('get.');
		$from=$get['from'];
		$to=$get['to'];

		$arr=[];
		if ($from) {
			foreach ($list as &$v) {
				if (strpos($from, $v['from']) !==false ) {
					$arr[]=$v;
				}
			}
		}
		$list= !empty($arr)? $arr: $list;
		$arr=[];
		if ($to) {
			foreach ($list as &$v) {
				if (strpos($to, $v['to']) !==false ) {
					$arr[]=$v;
				}
			}
		}
		$list= !empty($arr)? $arr: $list;


		$this->assign('list', $list);
		$this->display();
	}



	public function updateTemplate(){			//更新退运费模板

		if (! empty ( $_FILES['excel']  )){
			$file =$_FILES['excel']['tmp_name'];
			$type=explode( ".", $_FILES['excel']['name']);
			$type=strtolower($type[count($type)-1]);

			if ($type === "xls" || $type === "xlt"){		// 判别是不是excel文件
				$type='2003';
			}elseif($type === "xlsx" || $type === "xlsm" || $type === "xltx" || $type === "xltm"){
				$type='2007';
			}else{
				$this->error('不是excel文件，请重新上传');
			}

			$res =$this->parseExcel($file, $type);			//解析excel
			$res=$this->createFreightConf($res);	//获得所需生成字符串;


			
			$conf=realpath(__DIR__.'/../Conf/freight.config.php');				//更新配置文件
			if (!$fp = fopen($conf, 'w')) {		
				die('无法打开文件，请联系管理员');
			}
			if (is_writeable($conf)) {
				if (fwrite($fp, $res)) {
					$this->success('操作成功');	
				} else {
					die('更新文件失败，请联系管理员');
				}
				fclose($fp);
			} else {
				die('文件不可写，请联系管理员');
			}		
			unset($res);	
		}

	}

	private function createFreightConf($res){
		unset($res[1]);		//去掉开头文字列
		$string="<?php\r\n". "return [ \r\n " ;			//生成内容
		foreach ($res as $k => &$v) {
			if (!empty($v[0]) && !empty($v[1])) {
				$string.= "\t['from'=>". "'".$v[0]."'". ', '. "'to'=>". "'".$v[1]."'". ', '. "'freight'=>". "'".$v[2]."'". '],'. "\r\n ";
			}
		}
		$string.='];';
		return $string;

	}

	private function parseExcel($filename,$type='2007'){
		require_once('/../Common/Excel/PHPExcel.php');

		switch ($type) {
			case '2003':
			$objReader = \PHPExcel_IOFactory::createReader('Excel5');
			break;
			default:
			$objReader = \PHPExcel_IOFactory::createReader('Excel2007');
			break;
		}


		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($filename);
		$objWorksheet = $objPHPExcel->getActiveSheet();

		$highestRow = $objWorksheet->getHighestRow();
		$highestColumn = $objWorksheet->getHighestColumn();
		$highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
		$excelData = array();
		for ($row = 1; $row <= $highestRow; $row++) {
			for ($col = 0; $col < $highestColumnIndex; $col++) {
				$excelData[$row][] =(string)$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
			}
		}
		return $excelData;
	}  


}	