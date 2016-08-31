<?php

/**
 * [getPower description]
 * @return [type] [description]
 */
function getPower($mKey) {
    if (!is_numeric($mKey)) {
        $_powerKey = session('powerKey');
        $_second_menu_id = I('second_menu_id/d');
        $mKey = $_powerKey[$_second_menu_id][$mKey];
    }
    $_power = session('power');
    return isset($_power[$mKey]) ? $_power[$mKey] : 1;
}

/**
 * getParentCategory 商品树型父级类目
 * @param   Int     $mCategoryCid 分类ID
 * @return  Int|false
 */
function getTreeCategory($mCategoryCid, $mCategoryArr = array()) {
    $_goods_category_row = M('goods_category')->where("cid={$mCategoryCid}")->find();
    $mCategoryArr[] = $_goods_category_row['name'];
    if (0 != intval($_goods_category_row['parent_cid'])) {
        return getTreeCategory($_goods_category_row['parent_cid'], $mCategoryArr);
    } else {
        krsort($mCategoryArr);
        return implode(' / ', $mCategoryArr);
    }
}

/**
 * getShopStr 取平台字符串
 * @param  Int 		 $mGoodsId  商品ＩＤ
 * @return 
 */
function getShopStr($mGoodsId) {
    $_system_shop_goods_list = M('system_shop_goods')->where("goods_id={$mGoodsId}")->select();
    foreach ($_system_shop_goods_list as $key => $value) {
        $_shop_list[] = $value['shop_name'];
    }
    if (isset($_shop_list)) {
        return implode(',', $_shop_list);
    }
    return false;
}

/**
 * checkShopGoods 检测某商品是否发面在某平台
 * @param  Int $mShopId  平台ＩＤ
 * @param  Int $mGoodsId 商品ＩＤ
 * @return true|false
 */
function checkShopGoods($mShopId, $mGoodsId) {
    return M('system_shop_goods')->where(array("shop_id" => $mShopId, "goods_id" => $mGoodsId))->count() ? true : false;
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
 * getMenuName 取得菜单名称
 * @param  Int 		$mMenuId 菜单ID
 * @return String
 */
function getMenuName($mMenuId) {
    if (0 == $mMenuId) {
        switch (I('get.menu_id')) {
            case 1:
                $mMenuId = 4;
                break;
            case 2:
                $mMenuId = 8;
                break;
            case 3:
                $mMenuId = 10;
                break;
        }
    }
    return $_menuName = M('system_menu')->where("id={$mMenuId}")->GetField('menu_name');
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
    //return C('UPLOAD_PATH');
    //如果存在图片就直接返回图片
    if (is_file(C('UPLOAD_PATH') . $img)) {
        return get_upload_url($img);
    }

    //生成校验码
    $key = substr($lmd5, 8, 16);
    //返回新路径
    return U('Image/url', array('u' => urlencode($url), 'p' => $param, 'k' => $key));
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
 * [goodsFileAnalytic 商品文件解析]
 * @param  [String] $mFilePath [文件路径]
 * @return [Array]             [商品属性数组]
 */
function goodsFileAnalytic($mFilePath) {
    if (!$mFilePath) {
        return false;
    }
    if (!file_exists(ROOT_DIR . $mFilePath)) {
        return false;
    }
    $_goodsArrary = array();
    if (!( $handle = fileRead($mFilePath, "r")) === FALSE) {
        $i = 0;
        while (( $cols = fgetcsv($handle, 0, "\t") ) !== FALSE) {
            $_goodsArrary[] = $cols;
        }
        fclose($handle);
    } else {
        unlink($mFilePath);
    }
    return $_goodsArrary;
}

/**
 * [fileRead 文件读取]
 * @param  String $mFilePath 文件路径
 * @return String|false            
 */
function fileRead($mFilePath) {
    $encoding = '';
    if (!is_file(ROOT_DIR . $mFilePath)) {
        return false;
    }
    $handle = fopen(ROOT_DIR . $mFilePath, 'r');
    $bom = fread($handle, 2);
    rewind($handle);
    if ($bom === chr(0xff) . chr(0xfe) || $bom === chr(0xfe) . chr(0xff)) {
        // UTF16 Byte Order Mark present  
        $encoding = 'UTF-16';
    } else {
        $file_sample = fread($handle, 1000) + 'e'; //read first 1000 bytes  
        // + e is a workaround for mb_string bug  
        rewind($handle);
        $encoding = mb_detect_encoding($file_sample, 'UTF-8, UTF-7, ASCII, EUC-JP,SJIS, eucJP-win, SJIS-win, JIS, ISO-2022-JP');
    }
    if ($encoding) {
        stream_filter_append($handle, 'convert.iconv.' . $encoding . '/UTF-8');
    }
    return ($handle);
}

/**
 * 获取类目的顶级目录
 * @param int $category_id
 */
function get_top_category($category_id) {
    $_mParentid = M('goods_category')->where(array('cid' => $category_id))->getField('parent_cid');
    if (0 != intval($_mParentid)) {
        return get_top_category($_mParentid);
    }
    return $category_id;
}

/**
 * 根据参数生成图片地址
 * @param string $url
 * @param int $width
 * @param int $height
 * @param int $type
 * @param boolean $water
 */
function img_url($url, $width, $height, $type = 0, $water = false, $showDomain = false) {
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
