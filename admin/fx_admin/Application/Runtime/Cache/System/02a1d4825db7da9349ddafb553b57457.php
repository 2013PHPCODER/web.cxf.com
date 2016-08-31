<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html lang="zh_CN">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="renderer" content="webkit">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>货源分销平台--后台登录</title>

        <link rel="stylesheet" href="/Public/css/crm.css">
        <link rel="shortcut icon" href="/Public/images/64x64.ico" type="image/x-icon" /> 
        <link rel="stylesheet" href="/Public/css/reset.css">
        <link rel="icon" href="cas/favicon.ico" type="image/x-icon">
        <script src="/Public/js/jquery-1.9.1.min.js"></script>
        <script src="/Public/js/plus.js"></script>
        <!--[if lt IE 9]>
            <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.1/html5shiv.js" type="text/javascript"></script>
          <![endif]-->
    <!--<script src="/Public/js/jquery-1.9.1.min.js"></script>
    <script src="/Public/js/plus.js"></script>-->

        <script type="text/javascript">
            function loginS() {
                if ($('#username').val() == '') {
                    X.notice('用户名不能为空', 3);
                    return false;
                }
                if ($('#password').val() == '') {
                    X.notice('密码不能为空', 3);
                    return false;
                }
                return true;
            }
        </script>
    </head>


    <body id="cas">
        <div class="login-content">
            <!--登录框-->
            <div class="login " id="login">
                <!--登录-->
                <div class="logo text-center"><img src="http://maihoho.b0.upaiyun.com//top/5164809514595621247.png" alt="星密码"></div>
                <!--             <div class="re-title text-center"><b>CR<span>M</span></b>客户营销系统</div> -->
                <form id="fm1" action="<?php echo U('login/login');?>" method="post">
                    <table width="100%" style="width: 352px;">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <input id="username" name="username" class="txt" tabindex="1" placeholder="请输入账号" type="text" value="" size="25" maxlength="11" autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input id="password" name="password" class="txt" tabindex="2" placeholder="请输入密码" type="password" value="" size="25" maxlength="32" autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <label class="rem pos-rel current" title="保存当前用户名"> 
                                        <input type="checkbox"  id="fqy_saveAcc"  />保存当前用户名
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="error" id="cli_err"></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="btn-group">
                                    <input type="submit" id="fqy_superLogin" style="cursor: pointer" tabindex="3" accesskey="l" title="点击登录" value="登录" onclick="return loginS();"/>
                                </td>
                            </tr>
                            <tr>
                                <td width="120px">
                                    <input type="checkbox" name="rememberMe" id="rememberMe" checked="checked" tabindex="4" style="display:none">
                                </td>
                                <td width="120px" class="text-right">
                                    <!--                         <a href="javascript:void(0)" class="forget-pwd" title="忘记密码？">忘记密码？</a> -->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="lt" value="LT-5386-xLUdwwpiyemICrx2V2XDDGXTeU9fLd-jz.xingmima.com">
                    <input type="hidden" name="execution" value="e1s1">
                    <input type="hidden" name="_eventId" value="submit">
                </form>
            </div>
        </div>
    </body>
<script>
	function loginS(obj){
		if($('#username').val() == ''){
			X.notice('用户名不能为空',3);return false;
		}
		if($('#password').val() == ''){
			X.notice('密码不能为空',3);return false;
		}	 	  
	}
</script>
</html>