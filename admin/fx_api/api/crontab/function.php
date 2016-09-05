<?php

/**
 * 获取数据库连接
 * @return \MySQL
 */
function getDB() {
    $config = [
//        'host' => '127.0.0.1',
//        'port' => '3306',
//        'name' => 'fx_back',
//        'user' => 'root',
//        'pwd' => 'admin',
        'host' => 'rm-bp1s5q44r0x2lw714o.mysql.rds.aliyuncs.com',
        'port' => '3306',
        'name' => 'fx_829',
        'user' => 'cxf_mrchen',
        'pwd' => 'Abc123456',
    ];

    $db = new PdoDb($config['name'], $config['user'], $config['pwd'], $config['host']);
    return $db;
}

/**
 * 获取新分销数据库连接
 * @return \MySQL
 */
function get_fxDB() {
    $config = [
        'host' => '127.0.0.1',
        'port' => '3306',
        'name' => 'fx_back',
        'user' => 'root',
        'pwd' => 'admin',
    ];

    $db = new PdoDb($config['name'], $config['user'], $config['pwd'], $config['host']);
    return $db;
}

/**
 * 获取老版本开店助理数据库连接
 * @return \MySQL
 */
function get_kdDB() {
    $config = [
        'host' => '127.0.0.1',
        'port' => '3306',
        'name' => 'xmm_shop_assistant',
        'user' => 'root',
        'pwd' => 'admin',
    ];

    $db = new PdoDb($config['name'], $config['user'], $config['pwd'], $config['host']);
    return $db;
}

/**
 * 获取外包后台数据库连接
 * @return \MySQL
 */
function get_wbDB() {
    $config = [
        'host' => '127.0.0.1',
        'port' => '3306',
        'name' => 'cxf_fx',
        'user' => 'root',
        'pwd' => 'admin',
    ];

    $db = new PdoDb($config['name'], $config['user'], $config['pwd'], $config['host']);
    return $db;
}

/**
 * 调试输出函数
 * @param type $data
 * @author ximeng <1052214395@qq.com> <http://xinzou.cn>
 * @since 20160829
 */
function dump($data) {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    exit();
}

/**
 * 取毫秒数
 * @return type
 * @author ximeng <1052214395@qq.com> <http://xinzou.cn>
 * @since 20160905
 */
function milliseconds() {
    list($usec, $sec) = explode(' ', microtime());
    $msec = round($usec * 1000);
    return $msec;
}

/**
 * 记录常规定时任务日志
 * @param string $catagory 日志类别
 * @param string $text 日志文本内容
 * @param string $level 日志级别
 * @return 是否记录成功
 * @author ximeng <1052214395@qq.com> <http://xinzou.cn>
 * @since 20160905
 */
function write_log($catagory, $text, $level = 'info') {
    $folder_path = "./logs/$catagory";
    if (!is_dir($folder_path)) {
        mkdir($folder_path, 0777, true);
    }
    $date = date('Y-m-d');
    $file_path = "$folder_path/$date.log";
    $log_text = sprintf("[%s.%s][$level]%s\n", date('Y-m-d H:i:s'), milliseconds(), $text);
    return file_put_contents($file_path, $log_text, FILE_APPEND);
}

/**
 * 添加订单操作日志
 * @param type $db
 * @param type $order_id
 * @param type $log_info
 * @return int 
 * @author ximeng <1052214395@qq.com> <http://xinzou.cn>
 * @since 20160905
 */
function add_order_log($db, $order_id, $log_info) {
    $data['log_info'] = $log_info;
    $data['handle_info'] = '系统自动处理';
    $data['user_id'] = '';
    $data['user_name'] = '';
    $data['cid'] = 1;
    $data['pid'] = $order_id;
    $data['addtime'] = time();
    $data['ip_address'] = '';
    return $db->insert($data, 'log_list');
}
