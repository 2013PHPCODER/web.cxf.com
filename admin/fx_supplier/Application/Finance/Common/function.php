<?php

function PWD($pwd) {  //加密密码
    return md5(C('SALT_PWD') . $pwd);
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



