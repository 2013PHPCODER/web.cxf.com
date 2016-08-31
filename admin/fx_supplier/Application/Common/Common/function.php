<?php

function is_mobile($str) {              //判断是否为手机
    if (preg_match('/^1[3-9][0-9]{9}$/', $str)) {
        return true;
    } else {
        return false;
    }               
}

function is_email($str) {            //判断是否为email
    if (preg_match('/^[a-z0-9]([a-z0-9]*[-_\.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[\.][a-z]{2,8}([\.][a-z]{2,8})?$/i', $str)) {
        return true;
    } else {
        return false;
    }
}
function has_value($str){
    if (is_string($str) && strlen($str)>0 ) {
        return true;
    }else{
        return false;
    }
}
/*
  发送短信类，依赖sendSms函数

  用法 $sms=new SMS('手机号码');
  发送：$sms->send();
  验证: $sms->verify('客户端传过来的验证码');
 */

class SMS {

    private $mobile;

    public function __construct($mobile) {
        $this->mobile = $mobile;
    }

    public function send() {            //发送短信验证码
        $q = $_SESSION['_sms_'][$mobile];
        $mobile = $this->mobile;
        if ($q) {               //不是第一次发送的手机 则判断到了下一次发送时间没有，
            if ($_SESSION['_sms_'][$mobile]['next_send_time'] < time()) {
                $send = true;
                $_SESSION['_sms_'][$mobile]['next_send_time'] = $this->next_send_time();                    //更新发送时间
            } else {
                $send = false;
            }
        } else {
            $_SESSION['_sms_'][$mobile] = ['wrong_times' => 0, 'next_send_time' => $this->next_send_time(),
                'expired_at' => $this->expired_at(), 'code' => $this->code(),
            ];
            $send = true;
        }
        return $send ? $this->sendSms() : $this->return_status('failed', '验证码已发送，请稍后再尝试发送短信验证码');
    }

    public function verify($code = null) {
        if (empty($code)) {
            return $this->return_status('failed', '请输入短信验证码');
        }
        $mobile = $this->mobile;
        if (isset($_SESSION['_sms_'][$mobile])) {
            if ($_SESSION['_sms_'][$mobile]['code'] != $code) {
                $_SESSION['_sms_'][$mobile]['wrong_times'] ++;
                return $this->return_status('failed', '验证码错误');
            } else {
                if ($_SESSION['_sms_'][$mobile]['expired_at'] < time()) {
                    return $this->return_status('failed', '验证码已过期, 请重新发送');
                }
                unset($_SESSION['_sms_'][$mobile]);                 //验证成功，注销掉session
                return $this->return_status('success', '验证成功');
            }
        }
        return $this->return_status('failed', '请输入手机号发送短信');
    }

    private function sendSms($tempId = null) {

        $r = sendSms($this->mobile, $_SESSION['_sms_'][$mobile]['code'], $tempId);
        return $r ? $this->return_status('success', '短信验证码发送成功') : $this->return_status('failed', '短信验证码发送失败');
    }

// protected function checkSms($mobile) {
//     $_SESSION['_sms_'][$mobile] = ['wrong_times' => 1, 'next_send_time' => time() + 120, 'expired_at' => time() + 800, 'code' => mt_rand(100000)];
// }

    protected function return_status($type = 'success', $info) {                 //返回状态
        switch ($type) {
            case 'success':
                $status = \status::success($info);
                break;
            case 'failed':
                $status = \status::failed($info);
                break;
            case 'error':
                $status = \status::error($info);
                break;
        }
        return $status;
    }

    protected function next_send_time() {
        return time() + 120;                          //2分钟后可以重新发送
    }

    protected function expired_at() {                //获得过期时间，默认20余分钟
        return time() + 800;
    }

    private function code() {                        //获取随机码
        return rand();
    }

}

//发送短信
function sendSms($to, $content, $tempId = null) {                      //手机号，发送内容有几个变量就用几个元素的索引数组，模板id是云通讯给出
    require_once ('CCPRestSDK.class.php');
    $data = is_array($content) ? $content : array($content);
//配置
    $SMS_ACCOUNT = '8a216da855826478015594c3d1f40a32';
    $SMS_TOKEN = 'f13a3524a26a43d4874e17be721014af';
    $SMS_APP_ID = '8a216da855dd248e0155de5bd4e10244';
    $SMS_TEMP_ID = $tempId? : 101818;
//
    $SMS_URL = 'app.cloopen.com';
    $SMS_PORT = '8883';
    $SMS_VERSION = '2013-12-26';
    $SMS_ID_BREG = 36255;
    $SMS_ID_BCASH = 40165;
    $SMS_ID_BHREG = 40407;

    $tempId = $tempId? : $SMS_TEMP_ID;

    $account = $SMS_ACCOUNT;
    $token = $SMS_TOKEN;
    $app = $SMS_APP_ID;
    $url = $SMS_URL;
    $port = $SMS_PORT;
    $version = $SMS_VERSION;

    $q = new REST($url, $port, $version);
    $q->setAccount($account, $token);
    $q->setAppId($app);

    $result = $q->sendTemplateSMS($to, $data, $tempId);
    if ($result == NULL) {
        return false;
    }
    if ($result->statusCode != 0) {
        return false;
    } else {
        return true;
    }
}

function sendMail() {
    
}

/**
 * 获取随机数
 * @return type
 */
function getRandomNum($len = 8, $format = 'ALL') {
    $is_abc = $is_numer = 0;
    $password = $tmp = '';
    switch ($format) {
        case 'ALL':
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            break;
        case 'CHAR':
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            break;
        case 'NUMBER':
            $chars = '0123456789';
            break;
        default :
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            break;
    }
    mt_srand((double) microtime() * 1000000 * getmypid());
    while (strlen($password) < $len) {
        $tmp = substr($chars, (mt_rand() % strlen($chars)), 1);
        if (($is_numer <> 1 && is_numeric($tmp) && $tmp > 0 ) || $format == 'CHAR') {
            $is_numer = 1;
        }
        if (($is_abc <> 1 && preg_match('/[a-zA-Z]/', $tmp)) || $format == 'NUMBER') {
            $is_abc = 1;
        }
        $password.= $tmp;
    }
    if ($is_numer <> 1 || $is_abc <> 1 || empty($password)) {
        $password = getRandomNum($len, $format);
    }
    return $password;
}

/*
 * 验证类，by 林澜叶
 */

class valid {

    public $err = '';            //错误信息
    public $data;        // 返回数据
    public $raw;        //原始数据

    public function __construct() {
        
    }

    public function run($rules, $raw) {
        $this->rules = $rules;
        $this->raw = $raw;
        $this->data = $raw;
        $this->_valid();
        $this->_format();
    }

    private function _valid() {
        foreach ($this->rules['valid'] as $valid => $v) {
            foreach ($v as $field) {
                if (!$valid($this->raw[$field])) {
                    $this->err = $field;
                    return;
                }
            }
        }
    }

    private function _format() {
        foreach ($this->rules['format'] as $format => $v) {
            foreach ($v as $field) {
                $this->data[$field] = $format($this->data[$field]);
            }
        }
    }

}

function f_orderStatus(&$status) {                   //格式化订单状态
    $ref = new ReflectionClass('order_status');
    $arr = $ref->getConstants();                                           // 获得常量
    $arr = array_flip($arr);                                  //反转数值
    $status = $arr[$status];                                 //获得枚举

    switch ($status) {
        case 'wait_pay':
            $status = '待付款';
            break;
        case 'wait_confirm_pay':
            $status = '待确认付款';
            break;
        case 'wait_send_goods':
            $status = '等待发货';
            break;
        case 'wait_receive_goods':
            $status = '待收货';
            break;
        case 'success':
            $status = '已完成';
            break;
    }
    return $status;                     //返回
}

/*
 * 订单状态
 */

function f_img($img, $folder = 'goods', $thumb='') {                         //格式化图片，获得其url访问地址
    switch ($folder) {
        case 'goods':
            $url = C('IMG')['url']['goods'];
            break;
        case 'ad':
            $url = C('IMG')['url']['ad'];
            break;
       default:
            $url = C('IMG')['url']['other'];
            break;
    }
    switch ($thumb) {
        case '100':
            $thumb=C('IMG')['thumb']['100'];
            break;
        case '200':
            $thumb=C('IMG')['thumb']['200'];
            break;
        case '300':
            $thumb=C('IMG.')['thumb']['300'];
            break;                        
    }
    return $url . $img. $thumb;
}

function f_int2date(&$int) {                    //格式化整数到日期
    if ($int > 0) {
        $int = date("Y-m-d H:i:s", $int);
    } else {
        $int = null;
    }
    return $int;
}

function is_lte50($q) {   //长度小等于50；
    $len = iconv_strlen($q, 'UTF-8');
    return ($len > 50 || $len == 0) ? false : true;
}

function is_lte20($q) {   //长度小等于20；
    $len = iconv_strlen($q, 'UTF-8');
    return ($len > 20 || $len == 0) ? false : true;
}

class status {          //ajax返回状态

    static public function success($msg = '') {    //成功状态
        return ['status' => 'success', 'msg' => $msg];
    }

    static public function error($msg = '') {       //出错状态
        return ['status' => 'error', 'msg' => $msg];
    }

    static public function failed($msg = '') {      //失败状态
        return ['status' => 'failed', 'msg' => $msg];
    }

}

class Log_Module {

    const goods = 1; //商品模块
    const orders = 2; //订单模块
    const box = 3; //仓储模块
    const system = 4; //系统模块
    const after_sale = 5; //售后模块
    const user = 6; //用户模块

}

/*
 * 订单状态
 */

class order_status {

    const wait_pay = 0; //待付款
    const wait_confirm_pay = 1; //待确认付款
    const wait_send_goods = 2; //等待发货
    const wait_receive_goods = 3; //待收货
    const success = 4; //已完成
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
    const seven_day_no_reason = 3; //7天无理由退货
    const mass_question = 4; //质量问题
    const was_inconsistent = 5; //与商品描述不一致
    const less_missed = 6; //缺件，漏发
    const send_error = 7; //卖家发错货
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

/**
 * [xeq 相等比较]
 * @param  string $mA 比较参数1
 * @param  string $mB 比较参数2
 * @param  string $mC 返回参数1
 * @param  string $mD 返回参数2
 * @return string     返回$mC或$mD
 */
function xeq($mA, $mB, $mC, $mD = '') {
    if ($mA == $mB) {
        return $mC;
    }
    return $mD;
}

/**
 * updataGoodsImg 更新商品图片
 * @param  Int $mGoodsId  商品ＩＤ
 * @param  Int $mTime     时间戳
 * @return String|false
 */
function updataGoodsImg($mGoodsId) {
    $_picture = getGoodsProperty($mGoodsId, 'picture');
    if ($_picture = goodsPicture($_picture)) {
        $_time = M('goods_list')->where("goods_id={$mGoodsId}")->getField('addtime');
        $_first_img_path = getFirstImg(date('Ymd', $_time) . '/' . $_picture[0]);
        $_data['img_path'] = $_first_img_path;
        M('goods_list')->where("goods_id = $mGoodsId")->save($_data);
        return $_data['img_path'];
    }
    return false;
}

/**
 * 根据参数生成图片地址
 * @param string $url
 * @param int $width
 * @param int $height
 * @param int $type
 * @param boolean $water
 */
function img_url($url, $width, $height, $type = 0, $water = false, $showDomain = false) {//echo $url;exit;
    if (is_numeric($url)) {
        $url = updataGoodsImg($url);
    }
//首先判断文件是否存在
    $url_file = $_SERVER['DOCUMENT_ROOT'] . $url;
    if (!file_exists($url_file)) return '';
    return img_url_by_arr(array(
        'u' => $url,
        'w' => $width,
        'h' => $height,
        'tp' => $type,
        'wa' => $water,
            ), $showDomain);
}

function getPage($count = 100) {
    $pagesize = I('get.pagesize/d') ? I('get.pagesize/d') : 20;
    $p = new \Think\Page($count, $pagesize);
    $p->lastSuffix = false;
    $p->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条</li>');
    $p->setConfig('prev', '上一页');
    $p->setConfig('next', '下一页');
    $p->setConfig('last', '末页');
    $p->setConfig('first', '首页');
    $p->setConfig('theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
    $p->parameter = I('get.');
    return $p;
}

/**
 * 根据参数生成图片地址
 * @param array $option 配置项
 */
function img_url_by_arr($optons, $showDomain = false) {
    if (empty($optons['u']) ||
            empty($optons['w']) || intval($optons['w']) < 1 ||
            empty($optons['h']) || intval($optons['h']) < 1) {
        return '';
    }
//如果图片为远程地址就直接返回
    if (stripos($optons['u'], 'http://') === 0) {
        return $optons['u'];
    }
//重构参数格式
    $params[] = 'w-' . intval($optons['w']);
    $params[] = 'h-' . intval($optons['h']);
    if (!empty($optons['tp'])) {
        $params[] = 'tp-' . $optons['tp'];
    }
    if (!empty($optons['wa'])) {
        $params[] = 'wa-1';
    }
    $url = $optons['u'];
    $param = implode('-', $params);
    $lmd5 = md5($url . $param . C('IMAGE_CHECK_KEY'));
    $img = '/auto/' . substr($lmd5, 0, 2) . '/' . $lmd5 . '.jpg';
//    echo  C('UPLOAD_PATH').$img;exit;
//如果存在图片就直接返回图片
    if (is_file(C('UPLOAD_PATH') . $img)) {
        return get_upload_url($img);
    }

//生成校验码
    $key = substr($lmd5, 8, 16);
//返回新路径
    return U('goods/image/url', array('u' => urlencode($url), 'p' => $param, 'k' => $key));
}

/**
 * [getGoodsProperty           取商品属性值
 * @param  Int      $mGoodsId  商品ＩＤ    
 * @param  String   $mFiled    商品属性名
 * @return String          
 */
function getGoodsProperty($mGoodsId, $mFiled) {
    return M('goods_list_property')->where("goods_id={$mGoodsId} and  goods_key = '{$mFiled}'")->getField('goods_value');
}

/**
 * goodsPicture 解析商品新图片
 * @param  String       $mGoodsPicture 商品新图片属性
 * @return Array|false                
 */
function goodsPicture($mGoodsPicture) {
    if ('' == $mGoodsPicture) {
        return false;
    }
    preg_match_all('/([^:]{32})?:[0-9]{1}:[0-9]{1}/', $mGoodsPicture, $return_array);
    if (isset($return_array[1])) {
        return $return_array[1];
    } else {
        return false;
    }
}

/**
 * getFirstImg 取第一张图片
 * @param   Int     $goods_id  取商品ＩＤ
 * @return  String|false           
 */
function getFirstImg($mGoodsImg) {
    $_target_folder = C('UPLOAD_URL');
    if (!file_exists(ROOT_DIR . $_target_folder . $mGoodsImg . '.tbi')) {
        return false;
    }
    if (file_exists(ROOT_DIR . $_target_folder . $mGoodsImg . '.jpg')) {
        return $_target_folder . $mGoodsImg . '.jpg';
    }
    if (copy(ROOT_DIR . $_target_folder . $mGoodsImg . '.tbi', ROOT_DIR . $_target_folder . $mGoodsImg . '.jpg')) {
        return $_target_folder . $mGoodsImg . '.jpg';
    }
    return false;
}

/**
 * 获取上传文件的完整访问URL 
 * @param string $path 上传文件相对根路径 
 * @return string
 */
function get_upload_url($path) {
    return C('UPLOAD_URL') . $path;
}

/**
 * get_url 当前完整URL地址
 * @return 
 */
function getUrl() {
    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
    $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
    $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
    $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self . (isset($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : $path_info);
    return $sys_protocal . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '') . $relate_url;
}

/**
 * 获取用户真实 IP
 */
function getIP() {
    static $realip;
    if (isset($_SERVER)) {
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $realip = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            $realip = $_SERVER["REMOTE_ADDR"];
        }
    } else {
        if (getenv("HTTP_X_FORWARDED_FOR")) {
            $realip = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv("HTTP_CLIENT_IP")) {
            $realip = getenv("HTTP_CLIENT_IP");
        } else {
            $realip = getenv("REMOTE_ADDR");
        }
    }
    return $realip;
}

/**
 * 生成密码
 * @param type $pwd 密码
 * @param type $salt 加盐值
 */
function make_pwd($pwd, $salt) {
    return strtolower(md5($pwd . $salt));
}

/**
 * 随机生成指定长度的字符串
 */
function getRandString($length) {
    $str = null;
    $strPol = "abcdefghijklmnopqrstuvwxyz0123456789";
    $max = strlen($strPol) - 1;
    for ($i = 0; $i < $length; $i++) {
        $str.=$strPol[rand(0, $max)]; //rand($min,$max)生成介于min和max两个数之间的一个随机整数
    }
    return $str;
}
