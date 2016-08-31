<?php

/*
 * *读取扩展配置 
 * by 林澜叶
 */

class Config {

    /**
     * @param array $config     存储配置文件的数组
     * @param string $file    配置文件名
     */
    private static $config = [];
    private static $file;

    /**
     * 获取或设置配置文件，获取型如：config::file('key')； 设置类型如config::file(['key'=>'value'])
     */
    public static function __callStatic($file, $arg) {
        $arg = $arg[0];                   //只接受单参数;
        $file = strtolower($file);

        if (!isset(self::$config[$file])) {         //判断是否载人配置
            self::$config[$file] = include('/../Conf/' . $file . '.config.php');
        }


        if (is_array($arg)) {         //设置配置,支持批量设置
            foreach ($arg as $key => $value) {
                self::set($key, $value, $file);
            }
        } else {                      //获取配置
            return self::get($arg, $file);
        }
    }

    public static function getDefault($name) {       //获取默认配置
        $file = 'default';
        if (!isset(self::$config[$file])) {         //判断是否载人配置
            self::$config[$file] = include('/../Conf/config.php');
        }
        if (is_array($name)) {         //设置配置,支持批量设置
            foreach ($name as $key => $value) {
                self::set($key, $value, $file);
            }
        } else {                      //获取配置
            return self::get($name, $file);
        }
    }

    /**
     * 返回已加载的全部配置
     */
    public static function getAll() {
        return self::$config;
    }

    /**
     * 设置配置，可链式设置
     */
    private static function set($key, $value, $file) {
        $nodes = explode('.', $key);

        self::recursiveSet(self::$config[$file], $nodes, $value);
    }

    /**
     * 设置链式调用的配置量
     * @param array $conf   某个配置文件的内容
     * @param array $nodes    链式调用配置的节点
     */
    private static function recursiveSet(&$conf, &$nodes, &$value) {
        $k = current($nodes);
        if (next($nodes)) {   //递归进入最底层节点
            $conf[$k] = self::recursiveSet($conf[$k], $nodes, $value);
        } else {
            $conf[$k] = $value;  //进入最底层节点后，赋值
        }
        return $conf;
    }

    /**
     * 设置配置，可链式设置，支持批量设置
     */
    private static function get($key, $file) {
        if (is_null($key)) {           //没有设置key时候返回全部
            return self::$config[$file];
        }
        $nodes = explode('.', $key);
        return self::recursiveGet(self::$config[$file], $nodes);
    }

    /**
     * 获取链式调用的配置量
     * @param array $conf   某个配置文件的内容
     * @param array $nodes    链式调用配置的数组
     * @return mixed
     */
    private static function recursiveGet(&$conf, &$nodes) {
        $k = current($nodes);
        if (isset($conf[$k])) {     //节点有配置  
            if (next($nodes)) {    //如果还需调用子节点，否则返回当前节点配置
                return self::recursiveGet($conf[$k], $nodes);
            }
            return $conf[$k];
        } else {                           //节点没有配置信息
            return null;
        }
    }

}

// 获取默认配置
function Config($key = null) {
    return Config::getDefault($key);
}

// 根据行政编码获得地址   by 林澜叶
function getAreaByCode($code, $type='') {
    switch ($type) {        
        case 'district':             //区县
            $condition=['a.type'=>2, 'b.type'=>3, 'c.type'=>4,'c.id'=>$code];
            $c=M('area_list as a')->join('area_list as b on a.id=b.parent_id')->join('area_list as c on b.id=c.parent_id')->where($condition)->field('a.area_name as province,b.area_name as city, c.area_name as district')->find();
            if ($c) {
                return $c['province'].'/'. $c['city']. '/'. $c['district'];
            }
            break;
        case 'city':
            //查询城市
            $condition=['a.type'=>2, 'b.type'=>3, 'b.id'=>$code];
            $b=M('area_list as a')->join('area_list as b on a.id=b.parent_id')->where($condition)->field('a.area_name as province,b.area_name as city')->find();
            if ($b) {
                return $b['province'].'/'. $b['city'];
            }
            break;
        case 'province':
            //查询省
            $condition=['a.type'=>2, 'a.id'=>$code];
            $a=M('area_list as a')->where($condition)->field('a.area_name as province')->find();
            if ($a) {
                return $a['province'];
            }
            break;                      
    }

    return '北京市';           //默认
    
}

/**
 * depotList 取仓库列表
 * @return Array 
 */
function depotList() {
    return M('fx_storage_list')->field('id,sname')->where(array('supplier_user_id'=>  session('user_info.id')))->select();
}

/**
 * goodsCategoryList 商品类目列表
 * @return [type] [description]
 */
function goodsCategoryList($mParentId = 0) {
    return M('goods_category')->field('cid,name')->where("parent_cid = {$mParentId}")->order('cid asc')->select();
}


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
 * [system_shipping 取物流公司名称]
 * @return Array [description]
 */
function system_shipping() {
    return M('system_shipping')->order("sort asc")->select();
}

/**
 * [get_freight_template 查询运费信息]
 * @param int $fid
 * @author san shui <2881501985@qq.com>
 * @return string
 */
function get_freight_template($fid) {
    return M('fx_freight_template')->where(array('freight_template_id' => $fid))->getField('name');
}

/**
 * [getOrderConcatAll 获取订单收件人所有地址信息]
 * @param  int  $mOrderID [订单ID]
 * @return Array           [数组]
 */
function getOrderConcatAll($mOrderID, $mLimit = 1) {
    $_concat = M('order_contact')->where(array('order_id' => $mOrderID))->order('id desc');
    if (1 == $mLimit) {
        return $_concat->find();
    } else {
        return $_concat->select();
    }
}

/**
 * [getOrderGoodsSK 获取订单商品SKU]
 * @param  [订单id] $mOrderID [description]
 * @param  [订单商品id] $mGoodsID [description]
 * @return [type]           [description]
 */
function getOrderGoodsSK($mOrderID = '', $goodsId = '') {
    $map['order_id'] = $mOrderID;
    if (empty($goodsId)) {
        $_order_sku_id = M('order_goods_sku')->where($map)->Field('sku_comb_id,goods_id')->find();
        $con_sku_val = M('goods_sku_comb')->where(array('goods_id' => $_order_sku_id['goods_id'], 'id' => $_order_sku_id['sku_comb_id']))->getField('sku_str');
        $_where['goods_id'] = $_order_sku_id['goods_id'];
        $_data['goods_id'] = $_order_sku_id['goods_id'];
    } else {
        $con_sku_val = M('goods_sku_comb')->where(array('goods_id' => $goodsId))->getField('sku_str');
        $_where['goods_id'] = $goodsId;
        $_data['goods_id'] = $goodsId;
    }
    preg_match_all('/([0-9]+:[0-9]+);/', $con_sku_val, $rk);
    $arr_sku = array();
    foreach ($rk[1] as $k => $v) {
        $sku_key_val = explode(':', $v);
        $sku_name = $sku_key_val[0];
        $sku_val = $sku_key_val[1];
        $_where['sku_name'] = $sku_name;
        //$sku_name_str = M('goods_sku_list_name')->where($_where)->getField('sku_name_str');
        $_data['sku_val'] = $sku_val;
        //$sku_val_str = M('goods_sku_list_val')->where($_data)->getField('sku_val_str');
        $arr_sku[$sku_name_str] = $sku_val_str;
    }
    return $arr_sku;
}

