var gui, win = null, app = null, windowFlag = true, shell = null;
gui = require('nw.gui');
win = gui.Window.get();
app = gui.App;
shell = gui.Shell;

function min(){
    win.minimize();
}
function max(){
    if(windowFlag){
        win.maximize();
        windowFlag = false;
    }else{
        win.restore();
        windowFlag = true;
    }
}
function closes(){
    $("body").message({
        title: "退出登录",
        content: "您正准备退出应用程序...",
        button: {
            submit: "退出",
            cancel: "取消"
        }
    }, "normal", true, true, function () {
        $(".con-mark, .con-msg").remove();
        win.hide();
        app.closeAllWindows();
        app.quit();
        //win.close(true);
    }, function () {
        $(".con-mark, .con-msg").remove();
    }, {
        width: "400px"
    });
}
win.on('close',function(){
    closes();
});

function open_url() {
    gui.Shell.openExternal("http://mycxf.com");
}


//网页自适应重置
X.resizeWindow();
$(window).resize(function () {
    X.resizeWindow();
});
//平台来源
var platform = 2;
//淘宝授权
var TBAppKey = 23302533;
//web服务器地址
var webServerUrl = 'http://192.168.20.191:86';
//接口地址
var baseUrl = "http://api.mycxf.com";//'http://192.168.20.191:85';
//var baseUrl = 'http://api.mycxf.com';
var requestUrl = {
    'index': baseUrl + '/index', //首页广告栏接口
    'goodsDetail': baseUrl + '/goods_detail',  //商品详情
    'accept':baseUrl+'/keepgood_list',//收藏夹列表
    'coll_delet':baseUrl+'/delete_collect',//收藏夹删除
    'login':baseUrl+'/fx_login',            //登录
    'kefu':baseUrl +'/kefu_list',         //客服列表
    'help_list':baseUrl+'/article_list', //帮助列表
    'top':baseUrl+'/notice',				//消息中心
    'get_user':baseUrl +'/get_user_info' ,   //个人中心
    'after_sale_list':baseUrl +'/after_sale_list',    //售后列表
    'after_sale_detail':baseUrl+'/after_sale_detail',   //售后详情
    'order_list':baseUrl+'/order_list',   //订单列表	
    'order_details':baseUrl+'/order_details',   //订单列表
    'category':baseUrl+'/category',     //菜单
    'cateGoods':baseUrl+'/search_category',     //菜单货源中兴
    'goodlist':baseUrl+'/search',     //商品搜索
    'gh_register':baseUrl+'/gh_regist',     //供应商注册
    'sku_info':baseUrl +'/get_goods_sku_info',        //获取sku对应属性
    'get_order_goods':baseUrl +'/get_order_goods', //查询订单商品
    'add_order':baseUrl +'/add_order',  //购买商品(下单)
    'band_shop':baseUrl +'/band_shop',   //用户绑定淘宝店铺
    'tb_shop_list':baseUrl +'/tb_shop_list',  //店铺商品管理
    'item_add_taobao':baseUrl +'/item_add_taobao',  //一键铺货
    'get_img_token':baseUrl +'/get_img_token',    //获取上传凭证
    'gh_auth':baseUrl +'/gh_auth',      //资质认证
    'goods_center':baseUrl +'/goods_center',    //货源中心
    'goods_center_two':baseUrl +'/goods_center_two',    //货源中心
    'sale':baseUrl+'/apply_after_sale',  //申请售后                                        维恩
    'article':baseUrl+'/article_details', //帮助详情
    'topNotice':baseUrl+'/notice',				//消息中心
    'apply':baseUrl+'/apply_taken_money',  //申请提现
    'virtual':baseUrl+'/get_virtual_goods_list', //获取虚拟商品列表
    'create_act':baseUrl+'/create_act',  //开通新账户
    'open_user_list':baseUrl+'/create_list', //賬戶列表列表
    'level':baseUrl+'/up_level',//升級賬戶
    'stats':baseUrl+'/finance_list', //資金列表
    'get_receiver_account':baseUrl +'/get_receiver_account',  //查询总台收款帐号
    'userinfo':baseUrl+'/get_user_info',
    'updata_info':baseUrl+'/update_userinfo',
    'fxs_register':baseUrl+'/fx_regist',
    'updata_pwd':baseUrl+'/updata_pwd',
    'shop_survey':baseUrl+'/shop_overview', //店铺概况
    'yz_code':baseUrl+'/update_user_data',
    'paye_code':baseUrl+'/get_verify_code',//发送验证码
    'pay_check':baseUrl+'/check_verify', //检验验证码是否正确 下一步
    'change_pwd':baseUrl+'/change_pwd', //修改密码
    'agent':baseUrl+'/apply_agent', //申请代理
    'up_mobile':baseUrl+'/update_user_data', //修改手机和邮箱
    'tb_godos_delete':baseUrl +'/tb_godos_delete',  //淘宝店铺商品删除
    'tb_shelf':baseUrl +'/tb_shelf',  //店铺商品上下架
    'order_pay':baseUrl +'/order_pay',  //订单付款
    'get_freight':baseUrl+'/get_freight', //查询运费
    'confirm_good':baseUrl+'/confirm_good',  //确认收费
    'gh_regiet_check':baseUrl+'/gh_regiet_check',  //供应商邮箱检查
    'fx_regiet_check':baseUrl+'/fx_regiet_check',  //分销商邮箱手机检查
    'after_sale_operate':baseUrl+'/after_sale_operate',  //售后操作
    'add_keep':baseUrl+'/add_keep',   //加入收藏夹
    'tb_template':baseUrl +'/tb_template',  //获取店铺的类目和运费模板
    'downloadcsv':baseUrl+'/downloadcsv', //导出CSV数据包
    'xli_order':baseUrl+'/cancel_vorder',  //取消虚拟订单
    'pay_up_level':baseUrl+'/vorder_recharge', //虚拟订单支付
    'mobile_code':baseUrl+'/verfiy_code', //修改手机号验证码
    'check_is_bindtaobao':baseUrl+'/check_is_bindtaobao'    //是否绑定店铺
 };

//售后退款状态
var after_sale_status ={
	'wait_admin_confirm':1,    //待平台确认
    'refuse':2 ,         //平台拒绝
    'wait_supplier_confirm':3 ,         //待供应商确认
    'wait_admin_kill':4 ,         //待仲裁（平台介入审核
    'wait_admin_pay':5 ,         //待平台支付
    'success':6        //已完成
};

//售后退货状态
var after_good_status ={
	'wait_admin_confirm':1,  //待平台确认
    'refuse':2 ,            //平台拒绝
    'wait_buyer_sendgoods':3 ,       //等待买家发货
    'wait_supplier_receivegoods':4 ,       //等待供货商收货
    'wait_admin_repay':5 ,       //等待平台打款
    'wait_supplier_repaypostfee':6 ,       //等待供货商补款
    'wait_admin_kill':7 ,       //待仲裁（平台介入审核）
    'success':8 ,       //已完成
    'wait_supplier_approve':9 ,       //等待供货商确认（发生在等待供货商收货之后）
}


//订单状态
var order_state ={
	'wait_pay':0,    //待付款
	'wait_confirm_pay':1,  //待确认付款
    'wait_send_goods':2 ,         //等待发货
    'wait_receive_goods':3 ,         //待收货
    'success':4,          //已完成
    'closeq':5,          //已关闭 
    'errorq':6          //订单异常
};


/*获取get参数*/
function getUrlParam(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
    var r = window.location.search.substr(1).match(reg);  //匹配目标参数
    if (r != null)
        return decodeURI(r[2]);
    return ""; //返回参数值
}

$(function(){
	/*加载公共头部尾部文件*/
	
	$("#p_left").load("base/left.html");
	$("#p_top").load("base/top.html");
	$("#p_footer").load("base/footer.html");
	
    /*检验是否登录*/
  //  CheckUserLogin();
    $('.marks .PopColse').on('click',function(){
        $(this).parent().parent().hide();
        var oo = true;
        $(this).parent().parent().parent().find('.PopDiv').each(function () {
            if ($(this).css('display') == 'block') {
                oo = false;
            }
        });
        if (oo) {
            $('.marks').hide();
        }
    })
});

function CheckUserLogin() {
    var url = window.location.pathname.split('.')[0].split('/');
    url = url[url.length-1];
    if (url == 'login') {
        return false;
    }
    var b = localStorage.getItem("user_id");
    if (b != undefined && b != '' && b != null) {
//      return JSON.parse(b)[0].UserID;
    } else {
        window.location.href = 'login.html';
    }
}

//添加收藏夹
function addKeep(goodID){
    var AddKeepData = {
        goods_id:goodID,
        user_id:localStorage.getItem('user_id')
    };
    X.Post(requestUrl.add_keep, 1,AddKeepData, function (res) {
        if(res.header.stats==0){
            if(res.body.list.sucess==1){
                X.notice('添加收藏成功',3);
                $('.s-collect span').eq(0).html('已收藏');
                $('.s-collect span').eq(1).html(parseInt($('.s-collect span').eq(1).html()) + 1);
            }else if(res.body.list.fail == 0){
                X.notice('该商品已收藏',3);
            }
        }else {
            X.notice('添加收藏失败',3);
        }
    })
}


//弹窗拖拽
$(function(){
	var mouseOffx;
	var mouseOffy;
	//鼠标按下
	$('.PopDiv .PopHeader').on('mousedown',function(e){
		mouseOffx = $(this).parent().offset().left-e.clientX;
		mouseOffy = $(this).parent().offset().top-e.clientY;
		var mourseX,mourseY;
		var oThis = $(this).parent();
		//鼠标移动
		$(document).on('mousemove',function(e){
			oThis.css({'margin':0,'transform':'none'});
//			$('body').css('user-select','none');
			mourseX = e.clientX + mouseOffx;
			mourseY = e.clientY + mouseOffy;
			if(mourseX <= 0){
				mourseX = 0
			}
			if(mourseY <= 0){
				mourseY = 0
			}
            oThis.css({'left':mourseX,'top':mourseY})
		})
	
		//鼠标放开
		$(document).on("mouseup", function () {
			if(mourseX <= 30){
				mourseX = 0
			}
			if(mourseY <= 30){
				mourseY = 0
			}
			oThis.css({'left':mourseX,'top':mourseY})
//			$('body').css('user-select','true')
			$(document).unbind('mousemove');
			$(document).unbind('mouseup');
		});
	})	
});


function open_url(x){
    gui.Shell.openExternal(x);
}

//淘宝授权
function openTB() {
    var data = localStorage.getItem('taobao_bind');
    var userID = localStorage.getItem('user_id');
    var url = 'https://oauth.taobao.com/authorize?spm=a219a.7386781.0.0.qOgstw&response_type=code&client_id='+TBAppKey+'&redirect_uri=http://cxf2016.hz.taeapp.com&state='+userID+'&view=web#';
    X.Post(requestUrl.check_is_bindtaobao, 1,{user_id:userID}, function (res) {
        if(res.header.stats==0){
            if(res.body.list.is_bind==0){
                open_url(url);
                $('.PH').hide();
            }else {
                if(JSON.parse(data).length>=5){
                    X.notice('您已绑定5个店铺，不能再绑定了');
                }else {
                    open_url(url);
                    $('.PH').hide();
                }
            }
        }
    });
}

