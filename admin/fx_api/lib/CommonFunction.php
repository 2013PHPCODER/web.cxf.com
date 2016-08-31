<?php

function f_level($level) {               //格式化等级
    switch ($level) {
        case '0':
            return '基础版';
        case '1':
            return '初级版';
        case '2':
            return '中级版';
        case '3':
            return '高级版';
    }
}

function create_user_account() {             //生成唯一平台账号
    return 'cxf_' . uniqid() . mt_rand(0, 1000);
}

/*
  验证密码，
  raw没有加密的密码，
  encoded机密后的
 */

function verifyPwd($raw, $encoded) {
    return password_verify($raw, $encoded) ? true : false;
}

function encodePwd($raw) {       //密码加密函数
    return password_hash($raw, PASSWORD_BCRYPT, ['cost' => 13]);          //加密级别稍微高一些
}

/*
  $target 请按照自己的验证码使用场景，在扩展配置文件verify.php里的target数组里添加相应内容,必须存在于配置文件中
  并在文档的发送验证码接口(系统模块处)增加相应描述
  $to 目标手机或邮箱
  $code 和数据库进行比对的验证码

  如注册场景，后台控制里调用 checkVerifyCode('fx_registe', $this->quest->to, $this->quest->verify_code);
  无需做其他任何操作，将自动判断自动抛错
 */

function checkVerifyCode($target = 'fx_registe', $to, $code) {                  //检查验证码
    if (is_mobile($to)) {
        $type = 'mobile';
    } elseif (is_email($to)) {
        $type = 'email';
    } else {
        myerror(StatusCode::msgCheckFail, '手机或邮箱错误');
    }

    //检查验证码是否存在
    $conf = Config::verify();
    $target_code = $conf['target'][$target];
    $dao = Dao::fx_verify();
    $r = $dao->getVerifyDetail($target_code, $to, $type);
    if (!$r) {
        myerror(StatusCode::msgVerifyError, '验证码不存在');
    }

    //检查验证码是否过期，
    $expire = isset($conf[$target]['expire']) ? $conf[$target]['expire'] : $conf['default']['expire'];
    $wrong_times = isset($conf[$target]['wrong_times']) ? $conf[$target]['wrong_times'] : $conf['default']['wrong_times'];
    $is_expire = time() > $r['add_time'] + $expire;                    //失效
    $is_valid = $r['wrong_times'] > $wrong_times;                     //错误过多失效


    if ($is_expire || $is_valid) {                                  //过期后，改数据库状态
        $dao->setStatusExpire($target_code, $to, $type);
        $is_expire ? myerror(StatusCode::msgVerifyExpire, '验证码已失效') : myerror(StatusCode::msgVerifyWrongOvertime, '验证码错误次数过多，请重新发送');
    }

    //没有过期校验正确与否
    if ($r['code'] != $code) {
        $dao->setWrongtimes($target_code, $to, $type);                       //增加验证码错误次数
        myerror(StatusCode::msgVerifyError, '验证码错误');
    }
    $dao->setStatusExpire($target_code, $to, $type);                 //验证成功后，使验证码失效    

    return true;
}

/**
 * 发送短信或者邮件函数
 * @param int $_type 判断为短信或邮件 默认值为1 为发送邮件
 * @param string $_param 参数
 * @return boolean 
 * @author San Shui <sanshui@mycxf.com>
 * @since 201608151127
 */
function send_verify_code($_field, $_field_data) {
    $_distribute_user_dao = Dao::Fx_verify();
    switch ($_field) {
        case 'email':
            $_re = $_distribute_user_dao->get_verify_code($_field, $_field_data);
            if (!$_re)
                myerror(StatusCode::msgCheckFail, DistributeUser::distribute_send_often);
            $_str = '您的验证码是' . $_re . '，请于10分钟内完成验证。</br>创想范';
            if (!sendEmail($_field_data, $_str, \Config::verify('email.default')))
                myerror(StatusCode::msgCheckFail, DistributeUser::distribute_send_verify_code_fail);
            return true;
            break;
        case 'mobile':
            $re = $_distribute_user_dao->get_verify_code($_field, $_field_data);
            if (!$re)
                myerror(StatusCode::msgCheckFail, DistributeUser::distribute_send_often);
            if (!sendSms($_field_data, $re))
                myerror(StatusCode::msgCheckFail, DistributeUser::distribute_send_verify_code_fail);
            return true;
            break;
        default:
            myerror(StatusCode::msgCheckFail, DistributeUser::distribute_user_fail);
            break;
    }
    return false;
}

function f_access_token($origin_access_token) {                   //格式化原始access_token，用以比对access是否正确
    $access_token = sha1($origin_access_token . $_SERVER['HTTP_USER_AGENT']);
    return $access_token;
}

function f_refresh_token($origin_refresh_token) {                   //格式化原refreh_token，用以比对refresh是否正确
    $refresh_token = sha1($origin_refresh_token . $_SERVER['HTTP_USER_AGENT']);
    return $refresh_token;
}

function f_int2date($int) {
    if (!$int) {
        return null;
    }
    return date('Y-m-d H:i:s', $int);
}

function f_token($token) {           //加密以及格式化token
    if (isset($token['refresh_token'])) {
        $token['refresh_token'] = sha1($token['refresh_token'] . $_SERVER['HTTP_USER_AGENT']);
        $token['refresh_overtime'] = $token['create_refresh_time'] + Config('token.refresh_overtime') - 1;         //由于网络延迟等因素，失效临界值少1秒            
        $token['refresh_nexttime'] = $token['use_refresh_time'] + Config('token.refresh_frequency');                //再次刷新时间略微增加
        unset($token['create_refresh_time'], $token['use_refresh_time']);
    }
    $token['access_token'] = sha1($token['access_token'] . $_SERVER['HTTP_USER_AGENT']);
    $token['access_overtime'] = $token['create_access_time'] + Config('token.access_overtime') - 1;          //由于网络延迟等因素，失效临界值少1秒
    unset($token['create_access_time']);
    $token = ['token' => $token];
    return $token;
}

function f_afterStatus($int, $type = 'refund') {
    if ($type == 'refund') {
        $ref = new ReflectionClass('aftersale_back_money_status');
    } else {
        $ref = new ReflectionClass('aftersale_back_good_status');
    }
    $arr = $ref->getConstants();                                           // 获得常量
    $arr = array_flip($arr);                                  //反转数值
    $status = $arr[$int];                                 //获得枚举

    switch ($status) {
        case 'wait_admin_confirm':
            $status = '待平台确认';
            break;
        case 'refuse':
            $status = '平台拒绝';
            break;
        case 'wait_supplier_confirm':
            $status = '待供应商确认';
            break;
        case 'wait_admin_kill':
            $status = '待仲裁';
            break;
        case 'wait_admin_pay':
            $status = '待平台支付';
            break;
        case 'success':
            $status = '已完成';
            break;
        case 'wait_buyer_sendgoods':
            $status = '等待买家发货';
            break;
        case 'wait_supplier_receivegoods':
            $status = '等待供货商收货';
            break;
        case 'wait_admin_repay':
            $status = '等待平台打款';
            break;
        case 'wait_supplier_repaypostfee':
            $status = '等待供货商补款';
            break;
        case 'success':
            $status = '已完成';
            break;
        case 'wait_supplier_approve':
            $status = '等待供货商确认';
            break;
        default:
            $status = '未知状态';
            break;
    }
    $int = $status;
    return $status;
}

function f_refundReason(&$reason) {

    $ref = new ReflectionClass('aftersale_remark');
    $arr = $ref->getConstants();                                           // 获得常量
    $arr = array_flip($arr);                                  //反转数值

    $reason = $arr[$reason];

    switch ($reason) {
        case 'buy_error':
            $reason = '买家信息有误';
            break;
        case 'do_not_want':
            $reason = '买家不想要了';
            break;
        case 'seven_day_no_reason':
            $reason = '7天无理由退货';
            break;
        case 'mass_question':
            $reason = '货品质量问题';
            break;
        case 'was_inconsistent':
            $reason = '与商品描述不一致';
            break;
        case 'less_missed':
            $reason = '货品缺件，漏发';
            break;
        case 'send_error':
            $reason = '卖家发错货';
            break;
    }
    return $reason;
}

function f_refundType(&$type) {
    $type = $type == 1 ? '退货' : '退款';
}

function f_platform(&$platform) {
    $platform == 1 ? 'web网站' : '开店助理';
}

function f_obligation(&$o) {
    $o = $o == 1 ? '仓库' : ($o == 2 ? '物流' : ($o == 3 ? '消费者' : '其他') );
}

function f_afterOperator($status) {                   //根据状态值生成售后列表不同的操作（html代码）
    return $status == 1 ? 1 : 0;
}

function is_arbitration($status, $type = 'refund') {           //根据售后状态判断是否为仲裁
    if ($type == 'refund') {
        $_status = aftersale_back_money_status::wait_admin_kill;
    } else {
        $_status = aftersale_back_good_status::wait_admin_kill;
    }
    return $status == $_status ? true : false;
}

// 批量检查参数是否设置且非空
function batch_isset($data = [], $arr = [], $err = '缺少参数') {
    if (is_object($data)) {
        foreach ($arr as &$v) {
            if (!isset($data->$v) || empty($data->$v)) {
                myerror(StatusCode::msgCheckFail, $err . $v);
            }
        }
        return;
    } elseif (is_array($data)) {
        foreach ($arr as &$v) {
            if (!isset($data[$v]) || empty($data[$v])) {
                myerror(StatusCode::msgCheckFail, $err . $v);
            }
        }
        return;
    }
    myerror(StatusCode::msgCheckFail, $err);
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

// 发送邮件
function sendEmail($to, $body, $setting, $subject = '请查收您的验证码') {
    $email_setting = array(
        'SMTPSecure' => 'ssl',
        'Port' => 465,
        'CharSet' => 'utf-8',
    );
    $setting = array_merge($email_setting, $setting);
    //>>第一步,引入文件
    include (__EXT__ . '/PHPMailer/PHPMailerAutoload.php');
    //>>实例化对象
    $mail = new PHPMailer;
    $mail->isSMTP();                                    // 使用smtp方式发送
    $mail->Host = $setting['host'];                     // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                             // Enable SMTP authentication
    $mail->Username = $setting['account'];             // 邮箱账号
    $mail->Password = $setting['pwd'];             // 邮件密码
    $mail->SMTPSecure = $setting['SMTPSecure'];         // Enable TLS encryption, `ssl` also accepted
    $mail->Port = $setting['Port'];                     // TCP port to connect to

    $mail->setFrom($setting['account']);
    $mail->addAddress($to);                           // 增加一个收件人
    //        $mail->addAddress('vslinks@qq.com');               // 增加收件人是可选的.
    //        $mail->addReplyTo('info@example.com', 'Information');
    //        $mail->addCC('cc@example.com');               //抄送
    //        $mail->addBCC('bcc@example.com');
    //    $mail->addAttachment('/var/tmp/file.tar.gz');       // 添加附件
    //        $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // 添加附件,并给附件取一个别名
    $mail->isHTML(true);                                  // 发送html代码
    $mail->CharSet = $setting['CharSet'];
    $mail->Subject = $subject;                  //标题
    $mail->Body = $body;

    $mail->send();
    if ($mail->ErrorInfo) {
        return $mail->ErrorInfo;
    } else {
        return 0;           //成功
    }
}

//发送短信
function sendSms($to, $content, $tempId = null) {                      //手机号，发送内容有几个变量就用几个元素的索引数组，模板id是云通讯给出
    require_once (__EXT__ . 'CCPRestSDK.class.php');
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

/**
 * 获得图片上传凭证
 * @param $filename array 上传文件名
 * @param $type 可选值 goods|ad|其他     代表商品图片，广告图片，和其他图片（默认）
 * @param $secret 是否为机密图片，代表身份证营业执照等
 */
function uploadKey($filename, $type = '', $secret = false) {
    $options = array();
    $policy = array();
    $signature = array();
    $key = Config('img.upload.token');
    $bucket = Config('img.upload.bucket');

    switch ($type) {
        case 'goods':
            $path = Config('img.path.goods');
            break;
        case 'ad':
            $path = Config('img.path.ad');
            break;
        default:
            $path = Config('img.path.other');
            break;
    }
    $len = count($filename);

    if ($secret) {
        $key = Config('img.secret.token');
        $bucket = Config('img.secret.bucket');
        $path = Config('img.secret.path');
    }

    for ($i = 0; $i < $len; $i++) {

        $options[$i] = ['bucket' => $bucket, 'save-key' => $path . $filename[$i], 'expiration' => time() + Config('img.upload.valid_time')];           //上传有效期
        $policy[$i] = base64_encode(json_encode($options[$i]));
        $signature[$i] = md5($policy[$i] . '&' . $key);
    }
    $response = ["policy" => $policy, "sign" => $signature];
    return $response;
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
            $path = Config('img.url.goods');
            break;
        case 'ad':
            $path = Config('img.url.ad');
            break;
        default:
            $path = Config('img.url.other');
            break;
    }
    switch ($thumb) {
        case '100':
            $thumb = Config('img.thumb100');
            break;
        case '200':
            $thumb = Config('img.thumb200');
            break;
        case '300':
            $thumb = Config('img.thumb300');
            break;
    }
    if ($secret) {
        $path = Config('img.secret.url');
    }


    return $path . $img . $thumb;
}

function import($file) {             //导入文件
    $file = __EXT__ . $file . '.php';
    if (file_exists($file)) {
        include_once $file;
        return true;
    } else {
        return false;
    }
}

/* 全局校验是否合法登录 */

/* * 检查所有请求输入* */

function checkRequestParma($inputStr, $maxLength = -1, $CheckName, $type = null, $isEnword = true, $isCheckNull = TRUE) {
    if ($isCheckNull) {
        if (!isset($inputStr) || empty($inputStr)) {
            myerror(StatusCode::msgFailStatus, format("{0}不能为空", $CheckName));
        }
        if ($isEnword) {
            if ($maxLength != -1) {
                if (mb_strlen($inputStr, 'utf8') > $maxLength) {
                    myerror(StatusCode::msgFailStatus, format("{0}不能大于{1}个字符", $CheckName, $maxLength));
                }
            }
        } else {
            if ($maxLength != -1) {
                if (abslength($inputStr) > $maxLength) {
                    myerror(StatusCode::msgFailStatus, format("{0}不能大于{1}个字符", $CheckName, $maxLength));
                }
            }
        }
    } else {
        if ($maxLength != -1) {
            if (mb_strlen($inputStr, 'utf8') > $maxLength) {
                myerror(StatusCode::msgFailStatus, format("{0}不能大于{1}个字符", $CheckName, $maxLength));
            }
        }
    }
    if (!empty($type) && $isCheckNull) {
        switch ($type) {
            case CheckType::Int:
                if (!filter_var($inputStr, FILTER_VALIDATE_INT)) {
                    myerror(StatusCode::msgFailStatus, format("{0}必须为整形", $CheckName));
                }
                break;
            case CheckType::Email:
                if (!filter_var($inputStr, FILTER_VALIDATE_EMAIL)) {
                    myerror(StatusCode::msgFailStatus, format("{0}不是标准的邮箱格式", $CheckName));
                }
                break;
            case CheckType::Idcard:
                if (!is_idcard($inputStr)) {
                    myerror(StatusCode::msgFailStatus, format("{0}不是标准的身份证号码", $CheckName));
                }
                break;
            case CheckType::Float:
                if (!filter_var($inputStr, FILTER_VALIDATE_FLOAT)) {
                    myerror(StatusCode::msgFailStatus, format("{0}不是小数类型", $CheckName));
                }
                break;
        }
    }
}

/* * *****特殊校验输入****** */

function is_equality($q1, $q2) {
    if ($q1 === $q2) {
        return true;
    }
    return false;
}

function is_bankCard($subject) {    //判断是否为银行卡号
    $pattern = '/^[1-9]\d{15,18}/';
    if (preg_match($pattern, $subject))
        return true;
    else
        return false;
}

function is_email($str) {            //判断是否为email
    if (preg_match('/^[a-z0-9]([a-z0-9]*[-_\.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[\.][a-z]{2,8}([\.][a-z]{2,8})?$/i', $str)) {
        return true;
    } else {
        return false;
    }
}

function is_idCard($id) {
    $id = strtoupper($id);
    $regx = "/(^\d{15}$)|(^\d{17}([0-9]|X)$)/";
    $arr_split = array();
    if (!preg_match($regx, $id)) {
        return FALSE;
    }
    if (15 == strlen($id)) { //检查15位
        $regx = "/^(\d{6})+(\d{2})+(\d{2})+(\d{2})+(\d{3})$/";
        @preg_match($regx, $id, $arr_split);
        //检查生日日期是否正确
        $dtm_birth = "19" . $arr_split[2] . '/' . $arr_split[3] . '/' . $arr_split[4];
        if (!strtotime($dtm_birth)) {
            return FALSE;
        } else {
            return TRUE;
        }
    } else {           //检查18位
        $regx = "/^(\d{6})+(\d{4})+(\d{2})+(\d{2})+(\d{3})([0-9]|X)$/";
        @preg_match($regx, $id, $arr_split);
        $dtm_birth = $arr_split[2] . '/' . $arr_split[3] . '/' . $arr_split[4];
        if (!strtotime($dtm_birth)) {  //检查生日日期是否正确
            return FALSE;
        } else {
            //检验18位身份证的校验码是否正确。
            //校验位按照ISO 7064:1983.MOD 11-2的规定生成，X可以认为是数字10。
            $arr_int = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
            $arr_ch = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
            $sign = 0;
            for ($i = 0; $i < 17; $i++) {
                $b = (int) $id{$i};
                $w = $arr_int[$i];
                $sign += $b * $w;
            }
            $n = $sign % 11;
            $val_num = $arr_ch[$n];
            if ($val_num != substr($id, 17, 1)) {
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }   //教验身份证是否合法(兼容15位和18位)          //判断是否为身份证，
}

function is_mobile($str) {
    if (preg_match('/^1[3-9][0-9]{9}$/', $str)) {
        return true;
    } else {
        return false;
    }               //判断是否为手机
}

function is_naturalNumber($str) {       //是否为自然数，从1开始
    if (preg_match('/^1[0-9]*$/', $str)) {
        return true;
    } else {
        return false;
    }
}

function has_string($str) {      //验证是否为非空字符串（非数字型字符串）
    if (strlen($str) > 0 && !preg_match('/^[0-9]+$/', $str)) {
        return true;
    } else {
        return false;
    }
}

function has_number($str) {      //验证是否为非空数字    
    if (strlen($str) > 0 && preg_match('/^[0-9]+$/', $str)) {
        return true;
    } else {
        return false;
    }
}

function has_valueInArray($arr) {           //检查数组里面是否存在空值
    if (is_array($arr)) {
        foreach ($arr as $key => &$value) {
            if (empty($value)) {
                return false;
            }
        }
        return true;
    }
    return false;
}

function not_empty($str) {               //是否非空非0
    if (!empty($str)) {
        return true;
    }
    return false;
}

/* * ****特殊校验输入******** */


/* * 格式化字符串，类似string.format* */

function format() {
    $args = func_get_args();
    if (count($args) == 0) {
        return;
    }
    if (count($args) == 1) {
        return $args[0];
    }
    $str = array_shift($args);
    $str = preg_replace_callback('/\\{(0|[1-9]\\d*)\\}/', create_function('$match', '$args = ' . var_export($args, true) . '; return isset($args[$match[1]]) ? $args[$match[1]] : $match[0];'), $str);
    return $str;
}

/* * 统计中英文混合字符串长度,utf8 下面是3个字节，gb2312 是2个字节 * */

//使用iconv_strlen($str, 'UTF-8');
//使用系统自带函数 
// function abslength($str) {
//     $len = strlen($str);
//     $i = 0;
//     while ($i < $len) {
//         if (preg_match("/^[" . chr(0xa1) . "-" . chr(0xff) . "]+$/", $str[$i])) {
//             $i+=2;
//         } else {
//             $i+=1;
//         }
//     }
//     return $i;
// }

/* * 获取当前时间,精确到毫秒级* */

function get_current_date() {
    $t = microtime(true);
    $micro = sprintf("%06d", ($t - floor($t)) * 1000000);
    return date('Y-m-d H:i:s:' . $micro, $t);
}

/* * 将stdclass 转换为 array* */

function object_array($array) {
    if (is_object($array)) {
        $array = (array) $array;
    }
    if (is_array($array)) {
        foreach ($array as $key => $value) {
            $array[$key] = object_array($value);
        }
    }
    return $array;
}

/* * 将stdclass转换为实体类* */

function recast($className, stdClass &$object) {
    if (!class_exists($className))
        throw new InvalidArgumentException(sprintf('Inexistant class %s.', $className));

    $new = new $className();

    foreach ($object as $property => &$value) {
        $new->$property = &$value;
        unset($object->$property);
    }
    unset($value);
    $object = (unset) $object;
    return $new;
}

function get_dir($dir) {
    $dirArray[] = NULL;
    if (false != ($handle = opendir($dir))) {
        $i = 0;
        while (false !== ($file = readdir($handle))) {
            //去掉"“.”、“..”以及带“.xxx”后缀的文件
            if ($file != "." && $file != ".." && !strpos($file, ".")) {
                $dirArray[$i] = $file;
                $i++;
            }
        }
        //关闭句柄
        closedir($handle);
    }
    return $dirArray;
}

function get_file($dir) {
    $fileArray[] = NULL;
    if (false != ($handle = opendir($dir))) {
        $i = 0;
        while (false !== ($file = readdir($handle))) {
            //去掉"“.”、“..”以及带“.xxx”后缀的文件
            if ($file != "." && $file != ".." && strpos($file, ".")) {
                $fileArray[$i] = $dir . '/' . $file;
                if ($i == 100) {
                    break;
                }
                $i++;
            }
        }
        //关闭句柄
        closedir($handle);
    }
    return $fileArray;
}

function get_file_folder_list($dir) {
    $fileArray = NULL;
    if (false != ($handle = opendir($dir))) {
        $i = 0;
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != "..") {
                if (is_dir($dir . $file)) {
                    $fileArray [$i] = $file;
                } else if (is_file($dir . $file)) {
                    $fileArray [$i] = $file . "/";
                }
                $i ++;
            }
        }
        // 关闭句柄 
        closedir($handle);
    }
    return $fileArray;
}

function zip_dir($dir, $zipfilename, $Todo) {
    IF (!@Function_exists('gzcompress')) {
        Return 0;
    }
    @set_time_limit("0");

    openFile($dir, $zipfilename);

    $out = $this->filezip();

    Switch ($Todo) {
        Case "1":
            $this->DownLoad(__FILE__, $zipfilename, $out);
            Break;
        Case "2":
            $this->SaveFile(__FILE__, $zipfilename, $out);
            Break;
    }
}

function open_file($path, $zipName) {
    $temp_path = $path;
    $temp_zip_path = $zipName;
    IF ($handle = @opendir($path)) {
        While (false !== ($file = readdir($handle))) {
            IF ($file != '.' and $file != '..') {
                IF (ereg('\.', $file . @basename())) {
                    $fd = fopen($path . '/' . $file, "r");
                    $fileValue = @fread($fd, 1024000);
                    fclose($fd);
                    addFile($fileValue, $path . '/' . $file);
                } Else {
                    $this->openFile($path . '/' . $file, $zipName . '/' . $file);
                }
            }
        }
        $zipName = $temp_zip_path;
        $path = $temp_path;
        closedir($handle);
    }
}

/**
 * 得到所有文件夹下面文件
 * * */
function add_file_to_zip($path, $zip) {
    $handler = opendir($path); //打开当前文件夹由$path指定。
    while (($filename = readdir($handler)) !== false) {
        if ($filename != "." && $filename != "..") {//文件夹文件名字为'.'和‘..’，不要对他们进行操作
            if (is_dir($path . "/" . $filename)) {// 如果读取的某个对象是文件夹，则递归
                addFileToZip($path . "/" . $filename, $zip);
            } else { //将文件加入zip对象
                $zip->addFile($path . "/" . $filename);
            }
        }
    }
    @closedir($path);
}

/**
 * 生成zip压缩文件
 * * */
function new_zip($files = array(), $destination = '', $overwrite = false) {
    //if the zip file already exists and overwrite is false, return false
    if (file_exists($destination) && !$overwrite) {
        return false;
    }
    //vars
    $valid_files = array();
    //if files were passed in...
    if (is_array($files)) {
        //cycle through each file
        foreach ($files as $file) {
            //make sure the file exists
            if (file_exists($file)) {
                $valid_files[] = $file;
            }
        }
    }
    //if we have good files...
    if (count($valid_files)) {
        //create the archive
        $zip = new ZipArchive();
        if ($zip->open($destination, $overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
            return false;
        }
        //add the files
        foreach ($valid_files as $file) {
            $zip->addFile($file, $file);
        }
        //debug
        //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
        //close the zip -- done!
        $zip->close();
        //check to make sure the file exists
        return file_exists($destination);
    } else {
        return false;
    }
}

/**
 * 创建压缩zip文件
 * input:$sourceDir（要压缩的文件夹，如：e:/abc）
 * input:$outDir (输出的压缩包完整路径,如: e:/out/test.zip)
 * input:$isDownLoad (是否立即下载, 可选参数,false 不下载)
 * */
function create_zip($sourceDir, $outDir, $isDownLoad = false) {
    $zip = new ZipArchive();
    if ($zip->open($outDir, ZipArchive::OVERWRITE) === TRUE) {
        addFileToZip($sourceDir, $zip); //调用方法，对要打包的根目录进行操作，并将ZipArchive的对象传递给方法
        $zip->close(); //关闭处理的zip文件
    }
    if (!empty($outDir) && $isDownLoad) {
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header('Content-disposition: attachment; filename=' . basename($outDir)); //文件名   
        header("Content-Type: application/zip"); //zip格式的   
        header("Content-Transfer-Encoding: binary"); //告诉浏览器，这是二进制文件    
        header('Content-Length: ' . filesize($outDir)); //告诉浏览器，文件大小   
        @readfile($outDir);
    }
}

/**
 * 压缩文件
 * * */
function create_zips($outPath, $arr, $sourceDir) {
    $zip = new ZipArchive();
    if ($zip->open($outPath, ZipArchive::OVERWRITE)) {
        foreach ($arr as $key => $value) {
            if (!empty($value) && is_array($value)) {
                $zip->addEmptyDir($key);
                foreach ($value as $file) {
                    $download_file = file_get_contents($sourceDir . $key . '/' . $file);
                    #add it to the zip
                    $zip->addFromString($key . '/' . basename($file), $download_file);

                    //$zip->addFile($sourceDir.'/'.$file,$key.'/'.basename($file));
                }
            } else {
                $download_file = file_get_contents($sourceDir . $file);
                #add it to the zip
                $zip->addFromString(basename($file), $download_file);

                //   $zip->addFile($sourceDir.'/'.$value);//假设加入的文件名是image.txt，在当前路径下
            }
        }
        $zip->close();
    }
}

function create_zip_from_many($outPath, $rr) {
    $zip = new ZipArchive();
    if ($zip->open($outPath, ZipArchive::OVERWRITE)) {
        foreach ($rr as $key => $val) {
            if (!empty($val) && is_array($val)) {
                foreach ($val as $ckey => $cval) {
                    if (!empty($cval) && is_array($cval)) {
                        foreach ($cval as $cckey => $ccval) {
                            if (!empty($ccval) && is_array($ccval)) {
                                $zip->addEmptyDir($cckey);
                                foreach ($ccval as $file) {
                                    $download_file = file_get_contents($sourceDir . $key . '/' . $file);
                                    #add it to the zip
                                    $zip->addFromString($cckey . '/' . basename($file), $download_file);

                                    //$zip->addFile($sourceDir.'/'.$file,$key.'/'.basename($file));
                                }
                            } else {
                                $download_file = file_get_contents($sourceDir . $ccval);
                                #add it to the zip
                                $zip->addFromString(basename($ccval), $download_file);

                                //   $zip->addFile($sourceDir.'/'.$value);//假设加入的文件名是image.txt，在当前路径下
                            }
                        }
                    } else {
                        $path = $cval['path'];
                    }
                }
            }
        }
        $zip->close();
    }
}

/**
 * 压缩文件
 * * */
function create_zip_one($outPath, $rr) {
    $zip = new ZipArchive();
    if ($zip->open($outPath, ZipArchive::OVERWRITE)) {
        foreach ($rr as $key => $val) {
            $floder = basename($rr['csvpath'], '.csv');
            $zip->addEmptyDir($floder);
            if (!empty($val) && is_array($val)) {
                foreach ($val as $ckey => $cval) {
                    if (!empty($cval) && is_array($cval)) {
                        foreach ($cval as $cckey => $ccval) {
                            $download_file = file_get_contents($ccval);
                            $zip->addFromString($floder . '/' . basename($ccval), $download_file);
                        }
                    }
                }
            } else {
                $download_file = file_get_contents($val);
                $zip->addFromString(basename($val), $download_file);
            }
        }
        $zip->close();
    }
}

/**
 * 读取本地文件夹和文件按目录结构转换为array
 * * */
function dir_to_array($dir) {
    $result = array();
    $cdir = scandir($dir);
    foreach ($cdir as $key => $value) {
        if (!in_array($value, array(".", ".."))) {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
            } else {
                $result[] = $value;
            }
        }
    }
    return $result;
}

/*
 * 递归创建文件夹
 * parma: 文件夹路径
 * 
 */

function create_folders($dir) {
    return is_dir($dir) or ( create_folders(dirname($dir)) and mkdir($dir, 0777));
}

/* escape解码 */

function phpescape($str) {
    preg_match_all("/[\x80-\xff].|[\x01-\x7f]+/", $str, $newstr);
    $ar = $newstr[0];
    foreach ($ar as $k => $v) {
        if (ord($ar[$k]) >= 127) {
            $tmpString = bin2hex(iconv("GBK", "ucs-2", $v));
            if (!eregi("WIN", PHP_OS)) {
                $tmpString = substr($tmpString, 2, 2) . substr($tmpString, 0, 2);
            }
            $reString.="%u" . $tmpString;
        } else {
            $reString.= rawurlencode($v);
        }
    }
    return $reString;
}

/* 取stdclass值 */

function get_stdclass_name($base_class, $property) {
    if (!empty($base_class) && property_exists($base_class, $property)) {
        return $base_class->$property;
    }
    return null;
}

/*
 * 抓取淘宝属性
 */

function get_properties_by_cid($cid) {
    $arr = array(
        'method' => 'taobao.itemprops.get',
        'app_key' => GET_APP_KEY,
        'timestamp' => date('Y-m-d H:i:s'),
        'format' => 'json',
        'v' => '2.0',
        'sign_method' => 'md5',
        'cid' => '1512',
        'fields' => 'pid,name,prop_values',
        'cid' => $cid
    );
    ksort($arr);
    $str = GET_APP_SCRIPT;
    $js = '';
    foreach ($arr as $key => $val) {
        $js.= format($key . $val);
    }
    $js = $str . $js . $str;
    $sign = strtoupper(md5($js));
    $pp = getStr($arr);
    //return curlPostStr(TB_URL, format("{0}&sign={1}", $pp, $sign), 60, FALSE);
    // die(curlPostStr(TB_URL, format("{0}&sign={1}", $pp, $sign)));
    return json_decode(curlPostStr(TB_URL, format("{0}&sign={1}", $pp, $sign), 60, FALSE));
}

/* 调用curl读取返回内容 */

function curl_post_str($url, $data, $timeout = 30, $CA = true) {
    $cacert = getcwd() . '/cacert.pem'; //CA根证书  
    $SSL = substr($url, 0, 8) == "https://" ? true : false;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout - 2);
    if ($SSL && $CA) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);   // 只信任CA颁布的证书  
        curl_setopt($ch, CURLOPT_CAINFO, $cacert); // CA根证书（用来验证的网站证书是否是CA颁布）  
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 检查证书中是否设置域名，并且是否与提供的主机名匹配  
    } else if ($SSL && !$CA) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书  
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1); // 检查证书中是否设置域名  
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 检查证书中是否设置域名  
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:')); //避免data数据过长问题  
    curl_setopt($ch, CURLOPT_POST, true);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data); //data with URLEncode  

    $ret = curl_exec($ch);
    //var_dump(curl_error($ch));  //查看报错信息  

    curl_close($ch);
    return $ret;
}

/* 返回字符串 */

function get_str($array, $Separator = '&') {
    $str = '';
    $yb = '';
    foreach ($array as $key => $val) {
        $yb .= format($key . "=" . $val . "&");
    }
    return substr($yb, 0, strlen($yb) - 1);
}

/* 截取两个字符串之间的字符
 */

function get_string_between($str, $from, $to) {
    $sub = substr($str, strpos($str, $from) + strlen($from), strlen($str));
    return substr($sub, 0, strpos($sub, $to));
}

/* 获取唯一字符串id
 */

function get_unique_str() {
    return md5(uniqid('', TRUE));
}

function dump($var) {
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

/**
 * @param $filePath
 * @return array|bool|string
 * @throws Exception
 */
function upyunUpload($filePath) {
    /**
     * 加载upyun 类文件
     */
    require __EXT__ . 'upyun.php';
    //实例化upyun
    $config = Config('img');
    $upyun = new UpYunUpload($config);
    if (($result = $upyun->uplod($filePath)) === false) {
        throw new Exception($upyun->info);
        return false;
    }
    return $result;
}

/**
 * 根据配置不同返回不同等级的价格
 * @param type $price
 */
function change_price($price) {
    static $price_level;
    if (empty($price_level)) {
        $price_level_dao = \Dao::Fx_distribute_level();
        $price_level = $price_level_dao->get_price_level();
    }
    $return = array();
    foreach ($price_level as $val) {
        switch ($val['level']) {
            case 0:
                $return['distribution_price'] = bcmul($price, (1 + $val['price']), 2);
                break;
            case 1:
                $return['basic_price'] = bcmul($price, (1 + $val['price']), 2);
                break;
            case 2:
                $return['middle_price'] = bcmul($price, (1 + $val['price']), 2);
                break;
            case 3:
                $return['senior_price'] = bcmul($price, (1 + $val['price']), 2);
                break;
            default:
                break;
        }
    }
    return $return;
}

/**
 * 循环取出商品属性中需要的属性
 * @param type $array
 * @param type $key
 */
function get_property_val($array, $key) {
    $property = null;
    foreach ($array as $val) {
        if ($val['goods_key'] == $key) {
            $property = $val['goods_value'];
            break;
        }
    }
    return $property;
}

/**
 * 字符串比较
 * @param string $str1 字符串1
 * @param string $str2 字符串2
 * @param string $case 是否忽略大小写
 * @return bool 是否相等（true or false）
 */
function str_equals($str1, $str2, $case = false) {
    if ($case)
        return strcasecmp($str1, $str2) === 0;
    else
        return strcmp($str1, $str2) === 0;
}

/**
 * 对象转数组
 * @param object $obj
 * @return array
 */
function object_to_array($obj) {
    $arr = is_object($obj) ? get_object_vars($obj) : $obj;
    if (is_array($arr)) {
        return array_map(__FUNCTION__, $arr);
    } else {
        return $arr;
    }
}

/**
 * 根据配置不同返回不同等级分销价
 * @param type $price
 */
function get_distribution_price($level, $price) {
    static $price_level_s;
    if (empty($price_level_s)) {
        $price_level_dao = \Dao::Fx_distribute_level();
        $price_level_s = $price_level_dao->get_price_level();
    }
    $return = array();
    foreach ($price_level_s as $val) {
        if ($val['level'] == $level)
            return bcmul($price, (1 + $val['price']), 2);
    }
    myerror(\StatusCode::msgCheckFail, '价格计算失败！');
}

//取毫秒数
function milliseconds() {
    list($usec, $sec) = explode(' ', microtime());
    $msec = round($usec * 1000);
    return $msec;
}

/**
 * 记录常规淘宝接口日志
 * @param string $catagory 日志类别
 * @param string $text 日志文本内容
 * @param string $level 日志级别
 * @return 是否记录成功
 */
function write_log($catagory, $text, $level = 'info') {
    $folder_path = $_SERVER["DOCUMENT_ROOT"] . "/../logs/$catagory";
    if (!is_dir($folder_path))
        mkdir($folder_path, 0777, true);
    $date = date('Y-m-d');
    $file_path = "$folder_path/$date.log";
    $log_text = sprintf("[%s.%s][$level]%s\n", date('Y-m-d H:i:s'), milliseconds(), $text);
    return file_put_contents($file_path, $log_text, FILE_APPEND);
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
