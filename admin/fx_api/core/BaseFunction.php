<?php

/* * 返回信息* */

function response_info($body = NULL, $msg = '请求成功') {
    $result = new result();
    $header = new header();
    $header->stats = StatusCode::msgSucessStatus;
    $header->msg = $msg;
    $result->header = $header;
    $result->type = 'json';

    if ($body != NULL) {
        $li = new body();
        $li->list = $body;
        $result->body = $li;
    }
    $returnMsg = json_encode($result, JSON_UNESCAPED_UNICODE);
    echo $returnMsg;
}

//记录日志
function logs($info, $type) {
    switch ($type) {
        case '4':
            $filename = __LOG__ . 'error_db.txt';
            break;
        default:
            $filename = __LOG__ . 'error_request.txt';
            break;
    }
    if (!$fp = fopen($filename, 'a')) {
        
    }
    if (is_writeable($filename)) {
        if (!fwrite($fp, $info)) {
            
        } else {
            
        }
        fclose($fp);
    } else {
        
    }
}

//错误返回码 
function myerror($error_level, $error_message, $log_message = null) {
    $info = date('Y-m-d H:i:s');
    $info .= " | $error_level | $error_message";
    $info .= " | $log_message " . PHP_EOL;

    $r = new result();
    $h = new header();
    $h->stats = $error_level;
    $h->msg = $error_message;
    $r->header = $h;
    $r->type = 'json';
    echo json_encode($r, JSON_UNESCAPED_UNICODE);
    logs($info, $error_level);      //记录日志
    exit();
}

// 设置或获取全局请求
function _request($type = 'get', $request = null) {
    static $arr;
    if ($type === 'get') {
        return $arr;
    } else {
        if (is_string($request)) {
            $arr = json_decode($request);
        }
    }
}

function MODEL() {
    // return 
}

function DAO() {
    
}

// 获取默认配置
function Config($key = null) {
    return Config::config($key);
}

//事务操作失败记录日志用
function serialize_class_property($class) {
    if (is_object($class)) {
        return '<' . serialize(get_class_vars(get_class($class))) . '>';
    }
    return serialize($class);
}

function db_error_message($model, $operate_type = 1, $is_trans = 0, $fail_type = 1) {

    switch ($is_trans) {
        case '1':
            $is_trans = '是';
            break;
        default:
            $is_trans = '否';
            break;
    }
    switch ($operate_type) {
        case '1':
            $operate_type = 'insert';
            break;
        case '2':
            $operate_type = 'delete';
            break;
        case '3':
            $operate_type = 'update';
            break;
        case '4':
            $operate_type = 'insert_batch';
            break;
        default:
            $operate_type = 'excute';
            break;
    }

    switch ($fail_type) {
        case '1':
            $fail_type = '异常中断';
            break;

        default:
            $fail_type = '事务失败';
            break;
    }
    $model = serialize_class_property($model);

    return "操作: $operate_type; 事务: $is_trans; 失败类型: $fail_type; 失败数据: $model;";
}
