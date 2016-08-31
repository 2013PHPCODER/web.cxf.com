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



function f_afterStatus(&$int, $type='refund'){
    if ($type=='refund') {
        $ref=new ReflectionClass('aftersale_back_money_status');
    }else{
        $ref=new ReflectionClass('aftersale_back_good_status');
    }
    $arr=$ref->getConstants();                                           // 获得常量
    $arr=array_flip($arr);                                  //反转数值
    $status=$arr[$int];                                 //获得枚举
    switch ($status) {
        case 'wait_admin_confirm':
            $status='待平台确认';
            break;
        case 'refuse':
            $status='平台拒绝';
            break;
        case 'wait_supplier_confirm':
            $status='待供应商确认';
            break;            
        case 'wait_admin_kill':
            $status='待仲裁';
            break;
        case 'wait_admin_pay':
            $status='待平台支付';
            break;
        case 'success':
            $status='已完成';
            break;
        case 'wait_buyer_sendgoods':
            $status='等待买家发货';
            break;            
        case 'wait_supplier_receivegoods':
            $status='等待供货商收货';
            break;
        case 'wait_admin_repay':
            $status='等待平台打款';
            break;
        case 'wait_supplier_repaypostfee':
            $status='等待供货商补款';
            break;
        case 'success':
            $status='已完成';
            break;            
        case 'wait_supplier_approve':
            $status='等待供货商确认';
            break;
        case 'buyer_cancel':
            $status='买家已取消';
            break;            
    }
    $int=$status;  
    return $status;

}