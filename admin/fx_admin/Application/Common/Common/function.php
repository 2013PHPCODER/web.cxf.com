<?php

/*
 * by 林澜叶
 */
function verifyPwd($raw, $encoded){          
    return password_verify($raw, $encoded)? true: false;

}
function encodePwd($raw){       //密码加密函数
    return password_hash($raw, PASSWORD_BCRYPT, ['cost'=>13]);          //加密级别稍微高一些
}


//发送短信
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

function sendSms($mobile, $content, $tempId = null) {                      //手机号，发送内容有几个变量就用几个元素的索引数组，模板id是云通讯给出
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
/*
  获得图片完整url访问地址，传入图片名，返回url地址
  $type 可选 goods|ad 代表商品图片，广告图片，其他图片(默认)
  $thumb 可选，100|200|300, 代表固定宽的缩略图，100px，200px 300px
  $secret 是否为机密图片，代表身份证营业执照等
 */

function imgUrl($img, $type = '', $thumb = null, $secret = false) {
    switch ($type) {
        case 'goods':
            $path = C('img')['url']['goods'];
            break;
        case 'ad':
            $path = C('img')['url']['ad'];
            break;
        default:
            $path = C('img')['url']['other'];
            break;
    }
    switch ($thumb) {
        case '100':
            $thumb = C('img')['thumb100'];
            break;
        case '200':
            $thumb = C('img')['thumb200'];
            break;
        case '300':
            $thumb = C('img')['thumb300'];
            break;
    }
    if ($secret) {
        $path = C('img')['secret']['url'];
    }


    return $path . $img . $thumb;
}
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

class valid {

    public $error = '';            //错误信息
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
                    $this->error = $field . '字段验证不通过';
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

function is_lte50($q) {   //长度小等于50；
    $len = iconv_strlen($q, 'UTF-8');
    return ($len > 50 || $len == 0) ? false : true;
}

function is_lte20($q) {   //长度小等于20；
    $len = iconv_strlen($q, 'UTF-8');
    return ($len > 20 || $len == 0) ? false : true;
}

class status {          //返回状态

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

/* * *******by 林澜叶************ */

/**
 * 分页函数（返回TP分页对象）
 * @param type $count   总条数
 * @return \Think\Page
 */
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

/*资金明细类型表*/
class StatementType{
    const distribute_cash_money =1; //分销商提现（供货商没有提现的说法）[打款]
    const distribute_after_sale_bumoney=2; //分销商售后补款[打款]
    const distribute_after_sale_backmoney=3; //分销商售后退款[打款]
    const supplier_sucess_order=4; //供货商完结订单[打款]
    
    const distribute_pay_order=5; //分销商下单[收款]
    const distribute_chongzhi=6; //分销商充值[收款]
    const supplier_bumoney=7; //供货商补款[收款]
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
 * 操作日志记录
 * @param type $detail 日志详情
 */
function write_log($detail) {
    $objSystemLog = M("fx_operate_logs");
    $data = array();
    $data["user_id"] = session('user.id');
    $data['user_name'] = session('user.name');
    $data['user_type'] = 2; //用户类型，1供货商，2后台管理员
    $data['module'] = MODULE_NAME;
    $data['url'] = U();
    $data["detail"] = $detail;
    $data['add_time'] = time();
    $data["ip"] = getIp();
    $data['request'] = json_encode(I());
    $objSystemLog->add($data);
}
