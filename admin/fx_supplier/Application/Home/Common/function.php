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


