<?php
namespace AfterSales\Controller;
use Common\Controller\AuthController as Auth;

class FreightController extends Auth{

	public function index(){			//显示退运费模板
		C('TOKEN_ON', false);
		$list=\Config::freight();
		$get=I('get.');
		$from=$get['from'];
		$to=$get['to'];

		if ($from) {
			$condition['from']=['like', "$from%"];
		}
		if ($to) {
			$condition['to']=['like', "$to%"];
		}

		$list=R('QuerySql/freight', [$condition], 'Dal');

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

			$res=$this->parseExcel($file, $type);			//解析excel
			$res=$this->createFreightData($res);	//获得所需生成字符串;


			$conn=M('fx_refund_template');
			$conn->startTrans();
			$r0=$conn->count();			//先看是否有记录
			$r1=$conn->where('1')->delete();
			$r2=$conn->addAll($res);		
			if (($r0 && $r1  or  !$r0 && !$r1  )  && $r2) {					//没有记录的删除认为成功
				$conn->commit();
				$this->success('操作成功');
			}else{
				$conn->rollback();
				$this->error('更新失败，请联系管理员');	
			}


			
			// $conf=realpath(__DIR__.'/../Conf/freight.config.php');				//更新配置文件
			// if (!$fp = fopen($conf, 'w')) {		
			// 	die('无法打开文件，请联系管理员');
			// }
			// if (is_writeable($conf)) {
			// 	if (fwrite($fp, $res)) {
			// 		$this->success('操作成功');	
			// 	} else {
			// 		die('更新文件失败，请联系管理员');
			// 	}
			// 	fclose($fp);
			// } else {
			// 	die('文件不可写，请联系管理员');
			// }		
			// unset($res);	
		}

	}

	private function createFreightData($res){			//将数据插入数据库

		foreach ($res as $key => $value) {
			if (empty($value[0]) || empty($value[1]) || empty($value[2])) {
				unset($res[$key]);
			}
		}

		$res=array_values($res);
		unset($res[0]);		//去掉开头文字列
		$res=array_values($res);

		$data=[];
		$j=0;
		$len=count($res);
		foreach ($res as $k => &$v) {
			$j++;
			$v[2]=floatval($v[2]);
			if (strlen($v[0])>20 || strlen($v[1])>20 || $v[2]>10000 || $v[2]<0 ) {
				$this->error('导入的信息不符合规范，发货地、收件地需在20字以内，退费金额不能为负数且小于10000元');
				die;
			}
			for ($i=$j; $i <$len ; $i++) { 			//去重校验
				$_from=$res[$i][0];
				$_to=$res[$i][1];
				$duplicate=$v[0] === $_from && $v[1] === $_to;
				if ($duplicate) {
					$this->error("始发地：$_from  到 目的地：$_to 存在重复的退运费规则", '', 5);
					die;
				}
			}




			if (!empty($v[0]) && !empty($v[1])) {
				$data[]=['from'=>trim($v[0]), 'to'=>trim($v[1]), 'fee'=>$v[2]];
			}
		}
		return $data;

	}




	private function createFreightConf($res){			//已废弃，不再使用配置文件，使用数据库
		unset($res[1]);		//去掉开头文字列
		$string="<?php\r\n". "return [ \r\n " ;			//生成内容
		foreach ($res as $k => &$v) {
			// $len1=strlen($v[0]);
			// $len2=strlen($v[])
			// $valid=is_string($v[0]) && strlen($v[0])>0 && strlne
			// if (is_string$v[0]) {								//判断内容是否正确
			// 	# code...
			// }
			$v[2]=floatval($v[2]);
			if (strlen($v[0])>20 || strlen($v[1])>20 || $v[2]>10000 || $v[2]<0 ) {
				$this->error('导入的信息不符合规范，发货地、收件地需在20字以内，退费金额不能为负数且小于10000元');
				die;
			}

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