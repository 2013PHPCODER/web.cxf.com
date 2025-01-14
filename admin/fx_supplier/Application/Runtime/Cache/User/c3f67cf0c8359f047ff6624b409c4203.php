<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh_CN">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="renderer" content="webkit">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>创想范-供货商登录</title>
        <link rel="stylesheet" href="<?php echo SOURCE_DIR;?>/static/supplier/cas/css/crm.css">
        <link rel="stylesheet" href="<?php echo SOURCE_DIR;?>/static/supplier/cas/css/reset.css">
        <link rel="icon" href="<?php echo SOURCE_DIR;?>/static/supplier/cas/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="<?php echo SOURCE_DIR;?>/images/64x64.ico" type="image/x-icon" /> 
        <!--[if lt IE 9]>
        <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.1/html5shiv.js" type="text/javascript"></script>
        <![endif]-->
    </head>
    <body id="cas">
        <div class="login-content gys-content">
            <!--登录框-->
            <div class="login gyslogin" id="login">
                <!--登录-->
                <div class="logo text-center">
                    <h1>供货商管理员登录</h1>
                </div>
                <!--             <div class="re-title text-center"><b>CR<span>M</span></b>客户营销系统</div> -->
                <form id="fm1" action="<?php echo U('user/login/login');;?>" method="post">
                    <table width="100%" style="width: 352px;">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <input id="username" name="username" class="txt" tabindex="1" placeholder="请输入账号" type="text" value="<?php echo ($username); ?>" size="25" maxlength="50" autocomplete="off" required="true">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input id="password" name="password" class="txt" tabindex="2" placeholder="请输入密码" type="password" value="<?php echo ($password); ?>" size="25" maxlength="32" autocomplete="off" required="true">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <label class="rem pos-rel current" title="保存当前用户名" style="position: relative">
                                        <input type="checkbox" name="remeberMe" id="fqy_saveAcc" value="on" />保存当前用户名
                                        <a href="javascript:;" style="color: red;text-decoration-line: none;"><?php echo ($msg); ?></a>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="error" id="cli_err"></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="btn-group">
                                    <input type="submit" class="btn text-center" id="fqy_superLogin" style="cursor:pointer;" name="submit" tabindex="3" accesskey="l" title="点击登录" onclick="openaNewWorld();" value="登录">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <!--//登录-->

        </div>
    </body>

</html>