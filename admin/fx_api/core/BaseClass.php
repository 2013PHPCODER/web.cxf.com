<?php

/* * 返回状态码枚举类型* */
/*
  0：成功
  错误系列：
  1系列： 服务器响应失败相关，网络错误等
  2系列：入参校验失败相关
  3系列：前级校验，包含timestamp sign和token，refresh_token校验
  4系列：数据库错误相关，包括连库，查库，入库等
  5系列：上传相关错误

  状态码由4位构成，扩展状态码值遵循
  第一位：大类别，
  第二位：子类别（如签名和token分属不同子类），
  第三位：子类别的情形（如token中分为access和refresh两种情况），
  第四位：具体细节（如access_token过期，失败等）

  如状态码值只到第二位，则第三位和第四位用0占位，依次类推,
 */

class SupplierUser{
    const supplierUser_mobile_not = '手机号为空';
    const supplierUser_mobile_fail = '手机号格式错误';
    const supplierUser_email_not = '邮箱为空为空';
    const supplierUser_email_fail = '邮箱格式错误';
    const supplierUser_fail = '非法操作';
    const supplierUser_user_id_not= '用户ID为空';
}

class StatusCode {

    const msgSucessStatus = 0;  //响应状态码成功
    const msgFailStatus = 1;    //响应状态码失败
    const msgCheckFail = 2;  //校验不通过
    /* 2100 用户参数相关 */
    const msgLoginFail = 2101;  //用户名或密码错误              
    const msgUserLoginNone = 2102;  //用户密码为空    
    const msgUserLoginError = 2103;  //用户或密码错误
    const msgUserNone = 2104;  //用户id空
    const msgExistMobile = 2201;      //用户手机已存在
    const msgExistEmail = 2202;       //用户email已存在
    const msgExistAftersale = 2310;    //数据库存在记录，存在售后订单
    const msgAftersaleFail = 2320;    //售后订单不可操作
    const msgAftersaleNone = 2321;    //售后详情不可查看
    const msgAftersaleWrong = 2330;      //售后理由不匹配订单


    const msgVerifyError = 2410;       //验证码不存在
    const msgVerifyWrong = 2421;       //验证码错误
    const msgVerifyWrongOvertime = 2422;       //验证码多次错误后过期
    const msgVerifyExpire = 2430;               //验证码过期              
    const msgVerifySendAgain = 2440;               //验证码目前不可再次发送
    const msgVerifySendMailFail = 2450;               //邮件验证码发送失败
    const msgVerifySendSmsFail = 2460;               //短信验证码发送失败

    const msgSignNone = 3000;  //没有签名
    const msgSignFail = 3001;  //   签名错误
    const msgTimestampNone = 3011;  //   没有时间戳
    const msgTimestampFail = 3012;  //   时间戳错误
    const msgTimestampExpire = 3013;  //   请求过期

    const msgTokenAccessNone = 3100;  //没有Access_token
    const msgTokenAccessError = 3101;  //Access_token错误
    const msgTokenAccessFail = 3102;  //Access_token更新失败    
    const msgTokenAccessOvertime = 3103;  //Access_token过期
    const msgTokenRefreshNone = 3110;  //没有refresh_token
    const msgTokenRefreshError = 3111;  //refresh_token错误
    const msgTokenRefreshFail = 3112;  //refresh_token更新失败      
    const msgTokenRefreshOvertime = 3113;  //refresh_token过期
    const msgTokenRefreshFrequent = 3114;  //refresh_token刷新频繁
    const msgTokenNewFail = 3200;  //token生成失败
    const msgDBFail = 4;  //数据库异常
    const msgDBNull = 4001;  //数据库无记录

    const msgDBUpdateFail=4200;          //数据库更新失败    const msgUploadNone = 5;       //上传参数为空
    const msgSearchFail=5;                 //搜索服务器异常

    // const msgCheckParmeterStatus=3; //业务校验级别错误
    // const msgLogictisStatus=4; //业务操作级别错误
    // const msgSystemStatus=5; //系统错误，网络错误    
}

/*帐号状态禁用*/
class account_status{
    const forbidden =1;  //禁用
    const yes=2; //正常
    const notperfect=3; //未开通,不完善
}
/*类目是否有商品*/
class category_has_goods{
    const no= 0; //没有商品
    const yes =1; //有商品
}
/*类目状态*/
class category_status{
    const is_dispose=0; //新建
    const is_yes=1; //正常
    const is_not=2; //禁用
}


/*
 * 订单状态
 */

class order_status {

    const wait_pay = 0; //待付款
    const wait_confirm_pay = 1; //待确认付款
    const wait_send_goods = 2; //等待发货   售后类型为退款
    const wait_receive_goods = 3; //待收货     售后类型为退货
    const success = 4; //已完成                售后类型为退货
    const close = 5; //已关闭
    const error=6; //订单异常

}

/*
 * 售后退款状态
 */

class aftersale_back_money_status {

    const wait_admin_confirm = 1; //待平台确认
    const refuse = 2; //平台拒绝
    const wait_supplier_confirm = 3; //待供应商确认
    const wait_admin_kill = 4; //待仲裁（平台介入审核）
    const wait_admin_pay = 5; //待平台支付
    const success = 6; //已完成
    const buyer_cancel=10;  //买家取消售后

}

/*
 * 售后退货状态
 */

class aftersale_back_good_status {

    const wait_admin_confirm = 1; //待平台确认
    const refuse = 2; //平台拒绝
    const wait_buyer_sendgoods = 3; //等待买家发货
    const wait_supplier_receivegoods = 4; //等待供货商收货
    const wait_admin_repay = 5; //等待平台打款
    const wait_supplier_repaypostfee = 6; //等待供货商补款
    const wait_admin_kill = 7; //待仲裁（平台介入审核）
    const success = 8; //已完成
    const wait_supplier_approve = 9;      //等待供货商确认（发生在等待供货商收货之后）
    const buyer_cancel=10;  //买家取消售后

}

/*
 * 售后理由
 */

class aftersale_remark {

    const buy_error = 1; //拍错了/订单信息有误
    const do_not_want = 2; //不想要了
    //以上只能是待发货下选择，以下是已发货，已完成状态
    const seven_day_no_reason = 3; //7天无理由退货
    const mass_question = 4; //质量问题
    const was_inconsistent = 5; //与商品描述不一致
    const less_missed = 6; //缺件，漏发
    const send_error = 7; //卖家发错货

}
/*
 * 验证码
 */
class Verify{
    const verify_lose_time = 600;//验证码失效-秒数
    const verify_error_lose_count = 3;//验证码错误失效次数
    const verify_status_1 = 1;//成功状态
    const verify_status_0 = 0;//失败状态
    const verify_again_send = 60;//60秒后再次发送验证码
    const verify_error = '验证码错误';//验证码错误
    const verify_data_null = '验证码失效，请重试';//验证码错误
}

/*
  售后日志
 */

class after_sale_line_content {

    const platform_confirm = "平台确认通过";
    const platform_kill = "平台拒绝";
    const supplier_confirm = "供应商确认通过";
    const supplier_kill = "供应商拒绝";
    const platform_zhongcai_confirm = "平台仲裁成立";
    const platform_zhongcai_kill = "平台仲裁驳回";
    const platform_pay_confirm = "平台打款完成";

}
/*
 * 财务-资金
 */
class Finance{
    const fiance_user_id_not_null='分销商ID值为空'; 
    const fiance_username_not_null='分销商用户名'; 
    const fiance_page_not_null='分页ID必须'; 
    const fiance_datas_fail='数据返回失败'; 
    const fiance_pagesize_fail='数据返回失败'; 
}

/*
 * 对接淘宝API
 */class TbUser {
    const tb_user_data_fail = '获取淘宝用户数据失败';
    const tb_user_data_save_fail = '存储淘宝用户数据失败';
    const tb_user_data_save_success = '存储淘宝用户数据成功';
    const tb_user_data_binding = 5;//淘宝用户只能绑定5个淘宝店铺
}
/*
 * 商品
 */
class goods{
    const goods_sale = 1;//商品上下架:1=上架，2=下架，(默认2)
    const goods_status=3;//商品状态:1=待审核,2=未通过,3=已通过
    const is_delete = 0; //是否删除：0＝否：1＝是
    const stock_num=0;  //'总库存',
    const rand_num=10;  //随机8条热销商品,
    const category_two_level=4;  //取4条2级分类
    const goods_count_limit=20;  //取4条2级分类
    const goods_data_nnot='商品数据为空';  //取4条2级分类
}
/*
 * 首页
 */
class Index{
    const to_client_not_null = '发布对象必须';
    const category_datas_not = '类目数据返回为空';
    const notice_datas_not = '公告数据返回为空';
    const goods_datas_not = '热销商品数据返回为空';
}
/*
 * 订单
 */

/* 分销商等级 */

class distribute_user_level {
    const basic_level = 1; //初级版本
    const middle_level = 2;  //中极版本
    const high_level = 3;    //高级版本
}
/*
 * 修改分销商信息
 */
/* 分销商等级对应价格 */

class distribute_user_level_money {

    const basic_level = 200; //初级版本  
    const middle_level = 500;  //中极版本
    const high_level = 700;    //高级版本

}
/*
 * 消息
 */
class Message{
    const message_page_not = '消息分页错误';
    const message_id_not = '消息ID值错误';
    const message_data_not = '消息数据为空';
    const message_user_id_not = '用户ID值必须';
    const message_order_id_not = '订单ID必须';
    const message_send_fail = '发送失败';
    const message_send_success = '发送成功';
}

/*
 * 帮助
 */
class Article{
    const up_status = 1;//上架状态
    const show_platform='发布对象错误';
    const page_not_null='页码必须';
    const article_id_null='文章ID错误';
}

class Order {
    const order_user_name_null = "用户名为空";
    const order_id_not_null = "订单ID错误";
    const order_user_id_not_null = "用户ID为空";
    const order_detail_error = "订单返回错误";
    const order_detail_order_sn="订单编号错误";
    const order_detail_order_goods="订单物流信息错误";
    const order_detail_orderto_user_type=2;//分销商类型
    const order_message_to_admin=2;//分销商类型
    const order_confirm_fail='收货失败';//分销商类型
    const order_confirm_success='收货成功';//分销商类型
    const order_confirmed_success='已收货';//分销商类型
    const order_confirm_state = 4;//确认收获状态
}

/*
 * 分销商用户
 */
class DistributeUser {
    const userid_username_error = '用户ID或者用户名错误';
    const distribute_user_mobile_not = '手机号为空';
    const distribute_user_mobile_fail = '手机号格式错误';
    const distribute_user_email_not = '邮箱为空为空';
    const distribute_user_email_fail = '邮箱格式错误';
    const distribute_user_fail = '非法操作';
    const distribute_user_user_id_not= '用户ID为空';
    const distribute_send_verify_code_success= '验证码发送成功';
    const distribute_send_verify_code_fail= '验证码失败';
    const distribute_send_often = '发送频繁，稍后重试';
    const distribute_update_success = '修改成功';
    const distribute_update_fail = '修改失败';
    const distribute_verify_success = '验证成功';
    const distribute_verify_fail = '验证失败';
}

/*
 * 公告
 */
class Notice {
    const to_client_error = '发布对象错误';
    const to_client_not_null = '发布对象必须';
    const page_not_null = '页码必须';

}

class result {

    public $header;
    public $body;
    public $type;

}

class header {

    public $stats;
    public $msg;

}

class body {

    public $list;

}

class CategoryBig {

    const up_status = 1; //上架状态
    const offline_level = 3; //最多小于三级

}

/* 资金明细类型表 */

class StatementType {

    const distribute_cash_money = 1; //分销商提现（供货商没有提现的说法）[打款]
    const distribute_after_sale_bumoney = 2; //分销商售后补款[打款]
    const distribute_after_sale_backmoney = 3; //分销商售后退款[打款]
    const supplier_sucess_order = 4; //供货商完结订单[打款]
    const distribute_pay_order = 5; //分销商下单[收款]
    const distribute_chongzhi = 6; //分销商充值[收款]
    const supplier_bumoney = 7; //供货商补款[收款]

}
/* 修改密码 */
class ChangePwd{
    const verifyNone = 9001;  //验证码发送失败
    const verifyOutTime = 9002;  //验证码过期
    const verifyError = 9003;   //验证码错误
    const pwdDiff = 9004;   //两次密码不一致
    const pwdEqual =9005;  //和当面密码相同
}
class UpdateLevel{
    const levelNone = 9006;  //获取用户版本失败
    const levelLow = 9007;  //选择版本低于当前版本 
}

class Route {

    private static $route_lists;  //已注册的路由列表
    public $url;   //原始url
    public $requestType;  //请求类型
    public $module;
    public $controller;
    public $action;

    public static function __callStatic($module, $arg) {
        $module = strtolower($module);  //模块目录只能为小写
        $regulars = $arg[0];
        $requestType = isset($arg[1]) ? $arg[1] : 'get';  //默认为get
        foreach ($regulars as $url => &$controllerAction) {
            if (isset(self::$route_lists[$requestType . ':' . $url])) {
                myerror(StatusCode::msgFailStatus, "路由存在冲突，请检查重新注册");
            } else {
                self::registeRoute($requestType, $url, $module, $controllerAction);
                // dump($module);dump($regulars);
            }
        }
    }

    public function __construct($url, $requestParam) {   //$requestParam是json字符串
        if (strlen($url) > 1) {      //去掉右端的目录符号；根目录则跳过
            $this->url = rtrim($url, '/');
        }
        $this->url = $url;
        // 路由检查是否写入请求参数
        // if ( isset($requestParam['_post']) ){		
        // 	$this->requestType='post';
        // 	unset($requestParam['_post']);
        // }elseif( isset($requestParam['_put']) ){
        // 	$this->requestType='put';
        // 	unset($requestParam['_put']);
        // }elseif(isset($requestParam['_delete']) ){
        // 	$this->requestType='delete';
        // 	unset($requestParam['_delete']);
        // }else{									//默认为get空间
        $this->requestType = 'get';
        // unset($requestParam['_get']);
        // }
        _request('set', $requestParam);   //设置全局请求参数
        unset($requestParam);
        if ($this->checkUrl()) {
            $this->_run();       //运行路由
        } else {
            myerror(StatusCode::msgFailStatus, "无效的请求", $this->url);
        }
    }

    public static function getLists() {  //获取全部路由表
        /**
         * 	形如   ['get:/user/login'=>'module.controller.action'  ]; 
         */

        return self::$route_lists;
    }

    public function get($requestType, $url) {   //获取单个注册路由
        return self::$route_lists[$requestType . ':' . $url];
    }

    private static function registeRoute($requestType, $url, $module, $controllerAction) {   //注册路由
        self::$route_lists[$requestType . ':' . $url] = $module . '.' . $controllerAction;
    }

    private function set() {  //设置模块，控制器，方法
        $tmp = explode('.', self::$route_lists[$this->requestType . ':' . $this->url]);
        $this->module = $tmp[0];
        $this->controller = $tmp[1];
        $this->action = $tmp[2];
    }

    private function checkUrl() {  //检查路由是否注册, 以及请求是否合法
        if (isset(self::$route_lists[$this->requestType . ':' . $this->url])) {
            return true;
        } else {
            return false;
        }
    }

    private function _run() {  //运行路由器, 实现控制器动作
        $this->set();
        define('__CONTROLLER__', $this->controller);   //设置当前url常量
        define('__ACTION__', $this->action);
        define('__MODULE__', $this->module);


        require_once __API__ . $this->module . '/controllers/' . $this->controller . 'Controller.php';
        $ctl_name = 'api\\' . $this->module . '\\' . $this->controller . 'Controller';
        $controller = new $ctl_name;
        $controller->_init();               //初始化
        $actionName = $this->action;
        $controller->$actionName();
    }

}

class MODEL {

    public static function __callStatic($model, $args) {
        $path = __API__ . '/' . __MODULE__ . '/models/' . "${model}Model.php";
        require_once($path);

        $modelname = 'api\\' . __MODULE__ . '\\' . $model . 'Model';


        $class = new ReflectionClass($modelname);
        $a = $class->newInstanceArgs($args);


        return $a;
    }

}

class DAO {

    public static function __callStatic($dao, $args) {
        $path = __API__ . '/' . __MODULE__ . '/daos/' . "${dao}Dao.php";
        require_once($path);

        $daoname = 'api\\' . __MODULE__ . '\\' . $dao . 'Dao';
        $class = new ReflectionClass($daoname);
        $a = $class->newInstanceArgs($args);
        // array_push($GLOBALS['DAO'] ,serialize($a));
        return $a;
    }

}

class Valid {  // 特殊校验类，不允许实例化

    private $info;
    private static $valid;
    private static $instance = null;
    private $validArr;

    private function __construct() {
        
    }

    public static function __callStatic($func, $args) {
        if (!call_user_func_array($func, $args)) {
            self::$valid = false;
        } else {
            self::$valid = true;
        }
        if (self::$instance === null) {
            self::$instance = new Valid();
        }

        return self::$instance;
    }

    public function withError($info) {
        if (!self::$valid) {
            myerror(StatusCode::msgCheckFail, $info);
        } else {
            return true;
        }
    }

    public static function batch($validArr) {
        if (self::$instance === null) {
            self::$instance = new Valid();
        }
        self::$instance->validArr = $validArr;
        return self::$instance;
    }

    public function __call($func, $args) {
        foreach (self::$instance->validArr as &$v) {
            if (!call_user_func($func, $v)) {                       //只支持单参数验证
                self::$valid = false;
                break;
            } else {
                self::$valid = true;
            }
        }
        return self::$instance;
    }

}

/**
 * 获取配置文件
 * author：林澜叶
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
        if (!empty($arg)) {                 //只接受单参数;
            $arg = $arg[0]; 
        }else{
            $arg=null;
        }

        $file = strtolower($file);

        if (!isset(self::$config[$file])) {         //判断是否载人配置
            self::$config[$file] = include(__CONFIG__ . $file . '.php');
        }

        if (is_array($arg)) {         //设置配置,支持批量设置
            foreach ($arg as $key => $value) {
                self::set($key, $value, $file);
            }
        } else {                      //获取配置

            return self::get($arg, $file);
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

class Sql {                          //收集sql信息

    private static $sql = [];

    public static function get() {
        return self::$sql;
    }

    public static function set($sql, $filds) {
        foreach ($filds as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    $k2 = ":$k2";
                    $v2 = "'$v2'";
                    $sql = str_ireplace($k2, $v2, $sql);
                }
            } else {
                $k = ":$k";
                $v = "'$v'";
                $sql = str_ireplace($k, $v, $sql);
            }
        }
        self::$sql[] = $sql;
    }

}

function ORM($table) {
    $table = Config('db.prefix') . $table;
    return new ORM($table);
}

// //orm
// class ORM extends DbDriver{
//     private $table;
    
//     public function __construct($table) {
//         try {
//             parent::__construct();
//         } catch (Exception $e) {
//             myerror(StatusCode::msgDBFail,'数据库异常', $e->getMessage());
//         }
        
//         $this->table=$table;
//     }
    
    
//     public static function __callStatic($table, $args) {
//         $table=Config('db.prefix').$table;
//     }

// }
