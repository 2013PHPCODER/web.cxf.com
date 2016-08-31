<?php

/*
 * 系统默认配置文件，可通过Config(name)获取,支持链试调用。如Config(db.type);
 * 传入数组设置配置，支持批量设置，如Config(['db.type'=>'sqlite', 'return_type'=>'html'])
 */

return [
    /* 数据库 */
    'db' => [
        'type' => 'mysql',
        'host' => 'rm-bp1s5q44r0x2lw714o.mysql.rds.aliyuncs.com',
        'port' => '3306',
        'name' => 'fx_829',
        'user' => 'cxf_mrchen',
        'pwd' => 'Abc123456',
        'prefix' => '',
    ],
    //经销商等级对应商品价格比例
    'goods_level_price' => array(
        1 => 1.0,
        2 => 1.2,
        3 => 1.4
    ),
    'debug' => true,
    'return_type' => 'json', //默认返回的类型，有 xml, text, html,json 四种
    'page_num' => 20, //默认返回的page条数，
    'request_overtime' => 5, //请求超时时间，大于0则每次请求都要带timestamp字段进行检查，调试时设于0则不检查timestamp

    /* token */
    'token' => [
        'access_overtime' => 1200, //access_token过期时间, 需落在(refresh_time, refresh_frequency)区间 
        'refresh_overtime' => 1800, //refresh_token过期时间,生产时设置成1-3个月
        'refresh_frequency' => 1100, //再次使用refresh_token的间隔时间		
    ],
    'im' => [
        'key' => 'k51hidwq1qzdb',
        'secret_key' => 'aS35AsdCSVa9B',
    ],
    /* 图片存储服务器 */
    'img' => [
        'upload'=>[
            'domin' => 'v0.api.upyun.com',
            'token' => 'LAbJCTJbDjiqQLQFqsHqXPJR/fE=',
            'bucket' => 'cxf-img-new',    
            'valid_time'=>1200,                     //凭证有效期        
        ],
        'url'=>[                                           //访问地址
            'goods'=>'http://img.mycxf.com/goods/',
            'ad'=>'http://img.mycxf.com/ad/',
            'other'=>'http://img.mycxf.com/other/',
        ],
        'path'=>[                                        //上传路径
            'goods'=>'/goods/',
            'ad'=>'/ad/',
            'other'=>'/other/',            
        ],
        'secret'=>[                                 //机密图片信息，如身份证和营业执照
            'bucket' => 'cxf-secret',
            'token' => '5RdT79n726tgzZOBBTJTRe+Rn/o=',  
            'url'=>'http://secret.mycxf.com/',
            'path'=>'/',
        ],
        'thumb100' => '!thumb100', //请求宽为100px的缩略图
        'thumb200' => '!thumb200', //请求宽为200px的缩略图
        'thumb300' => '!thumb300', //请求高度为100px的缩率图
    ],
    'cookie' => [
        'secret_key' => '1A2B3C4D5E',
        'tb_url' => 'https://eco.taobao.com/router/rest',
        'app_key' => '23295856',
        'app_script' => '3d2684bae8e352cb88eab16e9092f837',
    ],
    'csv' => [
        'get_app_key' => '23249219',
        "get_app_script" => '93a0c8ea9edff30a1854a7936a48cfc0',
    ],
];
