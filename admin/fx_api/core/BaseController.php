<?php

/* author:陈清 
  desc:控制器基类
  date:2016-06-20
 */

class BaseController {
    /*     * 构造函数 */

    public $request;
    public $response;

    public function __construct() {
        
    }

    public function _init() {
        $this->_start();
    }

    protected function _start() {
        $this->request = _request();
        unset($this->request->timestamp, $this->request->sign, $this->request->access_token);             //释放掉不需要的参数
        $this->_setHeader();
        // header('Access-Control-Allow-Origin: *');
        $file = __API__ . __MODULE__ . '/Functions.php';

        if (file_exists($file)) {  //调用模块内的自定义函数	
            include_once $file;
        }
    }

    /*     * 返回json数据 */

    public function response($obj = null) {
        if (is_null($obj)) {
            response_info($this->response);
        } else {
            response_info($obj);
        }
    }

    /*     * stdClass to Object Model */

    public function objectToObject($instance, $className) {
        return unserialize(sprintf('O:%d:"%s"%s', strlen($className), $className, strstr(strstr(serialize($instance), '"'), ':')));
    }

    final protected function _setHeader() {
        switch (Config('return_type')) {
            case 'xml':
                header("Content-Type:application/xml;charset=utf-8");
                break;
            case 'html':
                header("Content-Type:text/html;charset=utf-8");
                break;
            case 'text':
                header("Content-Type:text/plain;charset=utf-8");
                break;
            case 'file':
                header("Content-type: application/zip");
                break;
            default:
                header("Content-Type:application/json;charset=utf-8");
                break;
        }
    }

    protected function _validRequest() {                    //前级验证，验证签名和时间戳
        $request = _request();
        if (!empty($request)) {         //1，检查签名是否正确
            $request = get_object_vars($request);
            !isset($request['sign'])? : myerror(StatusCode::msgSignNone, '没有签名');
            !isset($request['timestamp'])? : myerror(StatusCode::msgTimestampNone, '没有时间戳');

            //验证签名
            $old_sign = $request['sign'];
            unset($request['sign']);
            ksort($request);
            $new_sign = '';
            foreach ($request as $k => &$v) {
                $new_sign.=$k . $v;
            }
            $new_sign = md5($new_sign);
            if ($new_sign !== $old_sign) {
                myerror(StatusCode::msgSignFail, '签名错误');
            }

            //验证时间戳
            $curr_time = $_SERVER['REQUEST_TIME'];
            $request_time = (int) $request['timestamp'];
            $overtime = Config('request_overtime');
            if ($overtime > 0) {                          //大于0做时间戳验证
                $is_valid = $request_time < $curr_time and $request_time + $overtime > $curr_time;             //时间戳满足 请求时间小于当前时间，且请求时间加超时限制必须大于当前时间
                !$is_valid && myerror(StatusCode::msgTimestampExpire, '请求已过期');
            }
        } else {
            myerror(StatusCode::msgSignNone, '没有签名');
        }
    }

    protected function _checkToken() {              //检查token是否正确
        $request = _request();
        if (!empty($request)) {
            $request = get_object_vars($request);
            !isset($request['access_token'])? : myerror(StatusCode::msgTokenAccessNone, 'access_token为空');
            !isset($request['user_id'])? : myerror(StatusCode::msgUserNone, '用户id为空');


            $dao = Dao::Fx_token();
            $token = $dao->getTokenWithId($request['user_id']);
            !$token && myerror(StatusCode::msgTokenAccessError, 'access_token错误');

            $create_time = $token['create_access_time'];
            $token = $token['access_token'];

            f_access_token($token) !== $request['access_token'] && myerror(StatusCode::msgTokenAccessError, 'access_token错误');
            $_SERVER['REQUEST_TIME'] > $create_time + Config('token.access_overtime') and myerror(StatusCode::msgTokenAccessOvertime, 'access_token已过期');
        } else {
            myerror(StatusCode::msgTokenAccessNone, 'access_token为空');
        }
    }

}
