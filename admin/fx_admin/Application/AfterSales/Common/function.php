<?php
/*
**读取扩展配置 
* by 林澜叶
*/
class Config {

    /**
     * @param array $config  	存储配置文件的数组
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

    public static function getDefault($name){		//获取默认配置
    	$file='default';
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
function Config($key=null){   
    return Config::getDefault($key);   
}
/****************/


function f_afterStatus(&$int, $type='refund'){
    if ($type=='refund') {
        $ref=new ReflectionClass('aftersale_back_money_status');
    }else{
        $ref=new ReflectionClass('aftersale_back_good_status');
    }
    $arr=$ref->getConstants();                                           // 获得常量
    // dump($ref);
    // dump($arr);
    $arr=array_flip($arr);                                  //反转数值
    $status=$arr[$int];                                 //获得枚举

    // dump($arr);dump($int);
    switch ($status) {
        case 'wait_admin_confirm':
            $status='待平台确认';
            break;
        case 'refuse':
            $status='平台拒绝';
            break;
        case 'wait_supplier_confirm':
            $status='待供应商确认';
            break;            
        case 'wait_admin_kill':
            $status='待仲裁';
            break;
        case 'wait_admin_pay':
            $status='待平台支付';
            break;
        case 'success':
            $status='已完成';
            break;
        case 'wait_buyer_sendgoods':
            $status='等待买家发货';
            break;            
        case 'wait_supplier_receivegoods':
            $status='等待供货商收货';
            break;
        case 'wait_admin_repay':
            $status='等待平台打款';
            break;
        case 'wait_supplier_repaypostfee':
            $status='等待供货商补款';
            break;
        case 'success':
            $status='已完成';
            break;            
        case 'wait_supplier_approve':
            $status='等待供货商确认';
            break;
        case 'buyer_cancel':
            $status='买家已取消';
            break;            
    }
    $int=$status;  
    return $status;

}



function f_refundReason(&$reason){

    $ref=new ReflectionClass('aftersale_remark');
    $arr=$ref->getConstants();                                           // 获得常量
    $arr=array_flip($arr);                                  //反转数值

    $reason=$arr[$reason];  

    switch ($reason) {
        case 'buy_error':
            $reason='买家信息有误';
            break;
        case 'do_not_want':
            $reason='买家不想要了';
            break;
        case 'seven_day_no_reason':
            $reason='7天无理由退货';
            break;            
        case 'mass_question':
            $reason='货品质量问题';
            break;
        case 'was_inconsistent':
            $reason='与商品描述不一致';
            break;
        case 'less_missed':
            $reason='货品缺件，漏发';
            break;
        case 'send_error':
            $reason='卖家发错货';
            break;            
    }
    return $reason;

}
function f_refundType(&$type){
    $type=$type==1 ? '退货': '退款';
}
function f_platform(&$platform){
    $platform==1? 'web网站': '开店助理';
}
function f_obligation(&$o){
    $o=$o==1? '仓库': ($o==2? '物流' : ($o==3? '消费者': '其他') );
}

function f_afterOperator($status){                   //根据状态值生成售后列表不同的操作（html代码）
    return $status==1? 1: 0;
}
function is_arbitration($status, $type='refund'){           //根据售后状态判断是否为仲裁
    if ($type=='refund') {
        $_status=aftersale_back_money_status::wait_admin_kill;
    }else{
        $_status=aftersale_back_good_status::wait_admin_kill;
    }
    return $status==$_status? true: false;

}