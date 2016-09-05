<div class="capital-nav clearfix">
    <ul>
        <li class="active">
            <a href="vip_center.php"><i><span class="user_home"></span></i><strong >首页</strong></a>
        </li>
        <li>
            <a href="storeshoplist.php"><i><span class="user_shop"></span></i><strong >店铺</strong></a>
        </li>
        <li>
            <a href="orderlist.php"><i><span class="user_order"></span></i><strong >订单</strong></a>
        </li>
        <li>
            <a href="user_collectlist.php"><i><span class="user_collect"></span></i><strong >收藏夹</strong></a>
        </li>
        <li>
            <a href="open_account_list.php"><i><span class="user_account"></span></i><strong >开户</strong></a>
        </li>
        <li>
            <a href="statementlist.php"><i><span class="user_finance"></span></i><strong >财务</strong></a>
        </li>
        <li>
            <a href="account_info.php"><i><span class="user_setting"></span></i><strong >设置</strong></a>
        </li>
    </ul>
</div>

<div class="nav-sm current">
    <div class="nav-sm-li act">
       <a href="vip_center.php">个人中心</a>
    </div>
</div>
<div class="nav-sm">
    <div class="nav-sm-li act">
        <a href="storeshoplist.php">商品管理</a>
    </div>
</div>
<div class="nav-sm">
    <div class="nav-sm-li act">
        <a href="orderlist.php">订单管理</a>
    </div>
    <div class="nav-sm-li">
        <a href="after_sale_list.php">售后管理</a>
    </div>
</div>
<div class="nav-sm">
    <div class="nav-sm-li act">
        <a href="user_collectlist.php">收藏夹</a>
    </div>
</div>
<div class="nav-sm">
    <div class="nav-sm-li act">
        <a href="open_account_list.php">开户列表</a>
    </div>
    <div class="nav-sm-li">
        <a href="open_new_account.php">开通新账户</a>
    </div>
</div>

<div class="nav-sm">
    <div class="nav-sm-li act">
        <a href="statementlist.php">资金明细</a>
    </div>
</div>
<div class="nav-sm">
    <div class="nav-sm-li act">
        <a href="account_info.php">帐号设置</a>
    </div>
    <div class="nav-sm-li">
        <a href="updata_loginpwd.php">修改密码</a>
    </div>
<!--    <div class="nav-sm-li">-->
<!--        <i><img src="images/capital/nav-sm-icon3.png" alt="" /></i><a href="update_paypwd.php">修改支付密码</a>-->
<!--    </div>-->
    <!--<div class="nav-sm-li">
        <i><img src="images/capital/nav-sm-icon3.png" alt="" /></i><a href="account_info.php">修改手机邮箱</a>
    </div>-->
</div>
<script type="text/javascript">
//    $('.capital-nav li').hover(function () {
////      $(this).addClass('active').siblings().removeClass('active');
////      var _index = $(this).index();
////      $('.capital-box .nav-sm').eq(_index).addClass('current').siblings().removeClass('current')
////        $('.capital-nav li').eq(oThisLi).removeClass('active')
//        $(this).addClass("active").siblings().removeClass("active");
//    },function(){
////    	$('.capital-nav li').eq(oThisLi).addClass('active')
//        $(this).removeClass("active");
//    })
    $('.capital-nav').on("click", "li", function (e) {
        $(this).addClass("active").siblings().removeClass("active");
    });
    addCookie('apply_money', 888);
    function apply_Money() {
        var applyData = {
            'user_id': getCookieValue('id'),
            'user_account': getCookieValue('receiver_account'),
            'user_name': getCookieValue('username'),
            'apply_money': $('#ap_money').val(),
            'apply_user': $('#apply_u').val(),
            'apply_username': $('#apply_name').val(),
            'apply_ps': $('#apply_password').val()
        };
        if (applyData.apply_money == '' || applyData.apply_money >= getCookieValue('apply_money')) {
            X.notice('请输入正确的金额', 3)
        } else if (applyData.apply_user == '') {
            X.notice('请填写支付宝!', 3)
        } else if (applyData.apply_username == '') {
            X.notice('请填写名字!', 3)
        } else if (applyData.apply_ps != getCookieValue('userpwd') || applyData.apply_ps == '') {
            X.notice('密码输入有误！', 3)
        } else {
            X.Post(requestUrl.apply, 1, applyData, function (e) {
                X.notice(e.header.msg, 3)
                $('.marks').hide()
            })
        }
    }
    (function ($) {
        var url = window.location.pathname.split('.')[0].split('/');
            url = url[url.length-1];
        var n;
        var nn;
        switch (url) {
            case 'vip_center' :
                n = 0;
                nn = 0;
                break;
            case 'version' :
                n = 0;
                nn = 1;
                break;
            case 'storeshoplist' :
                n = 1;
                nn = 0;
                break;
            case 'orderlist' :
                n = 2;
                nn = 0;
                break;
            case 'after_sale_list' :
                n = 2;
                nn = 1;
                break;
            case 'user_collectlist' :
                n = 3;
                nn = 0;
                break;
            case 'open_account_list' :
                n = 4;
                nn = 0;
                break;
            case 'open_new_account' :
                n = 4;
                nn = 1;
                break;
            case 'statementlist' :
                n = 5;
                nn = 0;
                break;
            case 'account_info' :
                n = 6;
                nn = 0;
                break;
            case 'updata_loginpwd' :
                n = 6;
                nn = 1;
                break;
            case 'update_paypwd' :
                n = 6;
                nn = 2;
                break;
        }
        $('.capital-nav>ul>li').eq(n).addClass('active').siblings().removeClass('active');
        $('.nav-sm').eq(n).addClass('current').siblings().removeClass('current');
        $('.nav-sm').eq(n).children('div').eq(nn).addClass('act').siblings().removeClass('act');
    })(jQuery)

//    var oThisLi = $('.capital-nav>ul>li.active').index();
//    $('.capital-nav').hover(function () {
////      $(this).addClass('active').siblings().removeClass('active');
////      var _index = $(this).index();
////      $('.capital-box .nav-sm').eq(_index).addClass('current').siblings().removeClass('current')
//        $('.capital-nav li').eq(oThisLi).removeClass('active')
//    },function(){
//    	$('.capital-nav li').eq(oThisLi).addClass('active');
//    })
</script> 