<!DOCTYPE html>
<html>
<head lang="en">
    <head>
        <meta charset="UTF-8">
        <!-- 设置360浏览器渲染模式,webkit 为极速内核，ie-comp 为 IE 兼容内核，ie-stand 为 IE 标准内核。 -->
        <meta name="renderer" content="webkit">
        <meta name="google" value="notranslate">
        <!-- 禁止Chrome 浏览器中自动提示翻译 -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta http-equiv="Cache-Control" content="no-siteapp"/>
        <!-- 禁止百度转码 -->
        <meta name="Description" content=""/>
        <meta name="Keywords" content=""/>
        <meta name="author" content="">
        <meta name="Copyright" content=""/>
        <title>创想范分销平台--分销商登录</title>
        <link rel="shortcut icon" href="images/64x64.ico" type="image/x-icon"/>
        <link rel="stylesheet" type="text/css" href="css/common.css"/>
        <link rel="stylesheet" type="text/css" href="css/goodsList.css"/>
        <link rel="stylesheet" type="text/css" href="css/yz.css"/>
        <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
        <script src="//cdn.bootcss.com/knockout/3.3.0/knockout-min.js"></script>
        <script src="js/public.js"></script>
        <script src="js/plus.js"></script>
        <script src="js/MD5.js"></script>
        <style>
            /**出去chrome浏览器input黄色背景*/
            input:-webkit-autofill {
                -webkit-box-shadow: 0 0 0 1000px white inset;
                border: 1px solid #CCC !important;
            }
        </style>
    </head>
<body style="background: #fff" onkeydown="keyLogin(event);">
<!--header-->
<div class="header">
    <?php include_once 'base/index_top.php'; ?>
    <?php include_once 'base/detail_top.php'; ?>

</div>
<!--body-->
<div class="login-main">
    <div class="login-banner">
        <ul class="login-bannerUi clearfix">
            <li class="login-bannerLi"><img src="images/mainPage/login-banner01.jpg"/></li>
            <li class="login-bannerLi"><img src="images/mainPage/login-banner01.jpg"/></li>
            <li class="login-bannerLi"><img src="images/mainPage/login-banner01.jpg"/></li>
        </ul>
        <ul class="login-bannerC clearfix">
            <li>1</li>
            <li>2</li>
            <li>3</li>
        </ul>
    </div>
    <div class="login-form">
        <div class="login-f">
            <p class="p-title">账户登录</p>
            <table class="login" id="login">
                <tr>
                    <td>用户名</td>
                    <td><input type="text" name="userName" placeholder="请输入您的账号"></td>
                    <td><a class="loginHelp" href="choose_register.php" target="_blank">注册账户</a></td>
                </tr>
                <tr>
                    <td>密 &nbsp; 码</td>
                    <td colspan="2"><input type="password" name="userPassword" placeholder="请输入密码"></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="rememberInfo">
                        <label class="fl"><input type="checkbox" id="rememberAccount">记住账户</label>
                        <label class="fr"><input type="checkbox" id="rememberPassword">记住密码</label>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="loginBtn">
                        <input type="button" value="登陆">
                    </td>
                    <td></td>
                </tr>
            </table>
            <!--</form>-->
        </div>
    </div>
</div>
<div class="copyright">
    <div class="footer-nav">
        <a href="index.php" target="_blank">首页</a>
        <a>招聘英才</a>
        <a style="display:none;">合作及洽谈</a>
        <a>联系我们</a>
        <a style="display:none;">关于我们</a>
        <a href="http://114.55.86.177:81/delivery/index.php">物流自取</a>
        <a class="nav-last">友情链接</a>
    </div>
    <div class="copyright-content">
        Copyright2016 创想范 All rights reserved
    </div>
</div>
</body>
<script>
    //记住账户
    var userName = $('input[name=userName]');
    if (getCookieValue('rememberSing') == 'true') {
        $('#rememberAccount').prop('checked', true);
//            if(getCookieValue('user_account') != null){
//                userName.val(getCookieValue('user_account'));
//            }
        if (getCookieValue('mobile') && getCookieValue('mobile') != null) {
            userName.val(getCookieValue('mobile'));
        }
    } else {
        userName.val('');
    }
    //记住密码
    var pwd = $('input[name=userPassword]');
    if (getCookieValue('PasswordSing') == 'true') {
        $('#rememberPassword').prop('checked', true);
        if (getCookieValue('PassSing') != null) {
            pwd.val(getCookieValue('PassSing'));
        }
    } else {
        pwd.val('');
    }

    $(function () {
        X.lbChange('login-banner', 4, '');
        $('.loginBtn>input').on('click', function () {
            var oData = {
                'user_account': $('input[name=userName]').val(),
                'password': $('input[name=userPassword]').val()
            };
            if (oData.username == '') {
                X.notice('请输入用户名', 3)
            } else if (oData.password == '') {
                X.notice('请输入密码', 3)
            } else {
                X.Post(requestUrl.login, 0, oData, function (e) {

                    var rememberAccount = $('#rememberAccount').is(':checked');
                    var rememberPassword = $('#rememberPassword').is(':checked');

                    if (typeof e == 'string') {
                        var e = eval("(" + e + ")")
                    }
                    if (e.header.stats == 0) {
                        for (var i in e.body.list) {
                            if (typeof e.body.list[i] == 'object') {
                                addCookie(i, JSON.stringify(e.body.list[i]));
                            } else {
                                addCookie(i, e.body.list[i]);
                            }
                        }
                        setTimeout(function () {
                            if (window.location.href.split('?**')[1] != undefined) {
                                window.location.href = window.location.href.split('?**')[1];
                            } else {
                                window.location.href = 'index.php';
                            }
                        }, 500);
//                            if(rememberPassword){
//                                addCookie('PassSing', oData.password);
//                            }else {
//                                document.cookie.removeItem('PassSing');
//                            }
                        addCookie('rememberSing', rememberAccount);
                        addCookie('PasswordSing', rememberPassword);
                    } else {
                        X.notice(e.header.msg, 3);
                    }
                })
            }
        })
    })

    function keyLogin(event) {
        if (event.keyCode == 13)  //回车键的键值为13
            $('.loginBtn>input').click(); //调用登录按钮的登录事件
    }
</script>
</html>