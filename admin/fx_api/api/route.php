<?php

/**
 * 路由实现，需再此处注册路由，才可访问
 */
Route::home([
    '/callback' => 'Index.tb_callback',
    /*     * ******三水******* */
    '/' => 'Index.index', //首页
    '/index' => 'Index.index', //首页
    '/index_category' => 'Index.index_category',
    '/update_user_data' => 'Users.update_user_data', //获取验证码
    '/verfiy_code' => 'Users.get_verfiy_code', //获取验证码
    '/category' => 'Common.category', //获取分类菜单
    '/get_user_info' => 'Users.user_info', //查询用户信息
    '/notice' => 'Common.notice', //获取消息列表
    '/article_list' => 'Common.article_list', //获取帮助文档
    '/article_details' => 'Common.article_details', //获取帮助详情
    '/order_details' => 'Order.order_details', //获取订单详情
    '/distribute_to_admin' => 'Message.distribute_to_admin', //分销商给总台留言列表
    '/send_message' => 'Message.send_message', //分销商给总台留言
    '/message_details' => 'Message.message_details', //留言详情
    '/finance_list' => 'Finance.statement_list', //资金详情
    '/confirm_good' => 'Order.confirm_good', //确认收货
    '/goods_center' => 'Goods.goods_center', //货源中心
    '/goods_center_two' => 'Goods.goods_center_two', //获取货源中心二级分类十个随机商品
    '/search_category'=>'Index.search_category',
    /*     * ******三水******* */

    /*     * *林澜叶*** */
    '/fx_login' => 'Fx.login', //分销商登录
    '/fx_use_refresh' => 'Fx.refreshLogin', //使用refresh获得登录token，达到自动登录
    '/fx_regist' => 'Fx.regist',
    '/gh_regist' => 'Gh.regist', //供货商注册
    '/gh_auth' => 'Gh.identify',
    '/search' => 'Search.index',                            //商品搜索筛选排序类目等
    '/after_sale_list' => 'Aftersale.index',
    '/after_sale_detail' => 'Aftersale.detail',
    '/apply_after_sale' => 'Aftersale.add',
    '/after_sale_operate' => 'Aftersale.changeStatus', //售后操作
    '/get_freight' => 'Freight.compute',               //运费计算
    '/get_img_token' => 'Other.img',                    //获得上传图片凭证
    '/get_verify_code' => 'Other.sendVerify',           //发送验证码，通用
    '/fx_regist_check' => 'Fx.checkRegiste', //注册检查
    '/gh_regist_check' => 'Gh.checkRegiste', //注册检查
    '/check_is_bindtaobao'=>'Fx.checkBind',     //分销商是否绑定淘宝
    /*     * *林澜叶*** */


    /*     * **生姜头*** */
    '/goods_detail' => 'Goods.goods_detail',
    '/item_add_taobao' => 'Goods.item_add_taobao',
    '/get_virtual_goods_list' => 'VirtualOrder.get_virtual_goods_list',
    '/create_act' => 'VirtualOrder.create_act',
    '/create_list' => 'VirtualOrder.create_list',
    '/get_goods_sku_info' => 'Goods.get_goods_sku_info',
    '/tb_template' => 'Goods.tb_template',
    '/tb_shop_list' => 'Shop.tb_shop_list',
    '/tb_godos_delete' => 'Shop.tb_godos_delete',
    '/tb_shelf' => 'Shop.tb_shelf',
    '/vorder_recharge' => 'VirtualOrder.vorder_recharge',
    '/cancel_vorder' => 'VirtualOrder.cancel_vorder',
    /*     * **沈浪*** */
    '/add_keep' => 'Collect.collectAdd', //添加商品收藏夹
    '/keepgood_list' => 'Collect.collectList', //商品收藏列表
    '/delete_collect' => 'Collect.collectDelete', //删除收藏
    '/up_level' => 'LevelUpdate.update', //升级用户版本
    '/apply_agent' => 'ApplyActing.actingAdd', //申请代理
    '/kefu_list' => 'Customer.customerList', //在线客服列表
    '/check_verify' => 'PwdChange.verifyCheck', //校验验证码
    '/change_pwd' => 'PwdChange.changePwd', //修改密码
    '/band_shop' => 'BandShop.bandList',//查看用户绑定淘宝店铺
    /*     * **沈浪*** */


    /*     * ***  西蒙   ***** */
    '/apply_taken_money' => 'CatchMoney.apply_withdraw',
    '/statement_list' => 'CatchMoney.statement_list',
    '/order_list' => 'Order.order_list',
    '/shop_overview' => 'Shop.tb_shop_detail',
    '/add_order' => 'Order.add_order',
    '/get_order_goods' => 'Order.get_order_goods',
    '/order_pay' => 'Order.order_pay',
    '/get_receiver_account' => 'Finance.get_receiver_account',
    '/downloadcsv' => 'Goods.downloadcsv'
        /*         * ***  西蒙   ***** */
]);

