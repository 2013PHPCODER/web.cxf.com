<div class="capital-head clearfix">
    <a href="index.php" class="capital-logo"></a>
    <i class="logo-line"></i>
    <div class="capital-msg" id="userInfo">
        <p><span class="capital-user" data-bind = "text:user_account"></span><span id="user_level"></span><input type="button" class="btn" id="up_level" value="升级" /></p>
        <p class="capital-m"><span>可用余额：</span><strong id="surplus_money"></strong><!--<input type="button" class="btn btn-w" id="" value="充值" />-->
            <input type="button" class="btn btn-w reflect" id="deposit" value="提现" /></p>
    </div>
</div>
<div class="marks" id="apply" style="display: none">
    <div class="PopDiv" style="width: 598px;min-width: 598px;margin: 200px auto 0;">
        <div class="PopHeader">
            <span class="PopTitle"><i class="PopDetails"></i>申请提现</span>
            <div class="PopColse"></div>
        </div>
        <div class="PopBody deposit">
            <p><span>账户：</span><strong class="user_name">fenxiaoshang@qq.com</strong>可用余额：<b class="user_money">888.80元</b></p>
            <p><span>申请提现金额：</span><input type="text" name="" class="short-input" id="ap_money" value="" />元<b>*</b></p>
            <p><span>收款支付宝：</span><input type="text" name="" id="apply_u" value="" /><b>*</b></p>
            <p><span>收款人姓名：</span><input type="text" name="" class="short-input" id="apply_name" value="" /><b>*</b></p>
            <p><span>提现密码：</span><input type="password" name="" id="apply_password" value="" /></p>
            <div class="popverify-box clearfix"><span>验证：</span><div id="popdrag" class="E-drag" style="margin: 0; float: left; color: rgb(255, 255, 255);"></div></div>
            <p class="pop-btn"><input type="button" class="btn" name="" id="apply_sub" value="提交" /></p>
        </div>
    </div>
</div>

<!--消息中心-->

<div class="marks Agmarks" id="allNew" style="display: none;">
    <div class="PopDiv" style="margin-top:100px">
        <div class="PopHeader">
            <img src="images/mainPage/messalert.png" alt="">
            <span class="PopTitle">消息中心</span>
            <div class="PopColse"></div>
        </div>
        <div class="PopBody center-PopBody" style="min-height:400px">
            <div class="Phcontent">
                <div class="PhTab AGmes-table">
                    <table style="width: 100%;padding: 11px;">
                        <th style="width: 30%;padding: 11px;">发布时间</th>
                        <th style="border-left: none;width: 70%;padding: 11px;">内 容</th>
                        </tr>
                        <tbody data-bind = "foreach:list,as:'auto'">
                        <tr class="getBorder">
                            <td data-bind = "text:addtime" style="border: 1px solid #ccc;padding: 11px;"></td>
                            <td data-bind = "text:title" style="border: 1px solid #ccc;padding: 11px;">快速提升店铺销量绝密文件</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>  
</div>  

<script type="text/javascript">
$(function(){
	$('#popdrag').drag();
	var omoney=parseFloat(getCookieValue('user_balance')).toFixed(2);
	$('.user_name').html(getCookieValue('user_account'));
	$('.user_money').html(omoney+'元');
	$('.capital-user').html(getCookieValue('user_account'));
    var level = getCookieValue('user_level'), levelStr = "";
    switch (level) {
        case "0":
            levelStr = "基础版";
            break;
        case "1":
            levelStr = "初级版";
            break;
        case "2":
            levelStr = "中级版";
            break;
        case "3":
            levelStr = "高级版";
            break;
    }

	$('#user_level').html(levelStr);
    var money = parseInt(getCookieValue('user_balance'));
    $('#surplus_money').html(money.toFixed(2) +'元');
    if(money > 0) {
        $("#deposit").addClass("show");
    }
})
$('#up_level').click(function(){
	window.location.href='up_level.php'
})
    $('.PopColse').click(function () {
        $('#apply').fadeOut();
    })
    $('#deposit').click(function () {
        $('#apply').fadeIn();
    })
    $('#apply_sub').click(function () {
        apply_Money()
    })
    $('.capital-nav li').click(function () {
        var _index = $(this).index();
        $('.capital-box .nav-sm').eq(_index).addClass('current').siblings().removeClass('current')
    })
    addCookie('apply_money', $('.capital-m strong').val())
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
                $('.marks').fadeOut()
            })
        }
    }
    
    $(function(){    
        $('.all_news').click(function(){
            mess();
        })
		var meshtml =  $('#allNew').html();
		
        function mess(){
        	$('#allNew').show();
        	$('#allNew>div').show();
        	ko.cleanNode(document.getElementById("allNew"));  
            var new_data={
                    'to_client':1,
                    'page':1
            };
            $('#allNew').html(meshtml);
            X.bindModel(requestUrl.top,1,new_data,'body.list',['allNew'],function(){
                    $('.PopColse').click(function(){
                            $('#allNew').hide();
                    })
            },function(x){
//                console.log(x);
                var e = x, newDate = new Date();
                for(var i in x.list){
                    newDate.setTime(x.list[i].addtime * 1000);
                    var time = newDate.toLocaleString();
                    e.list[i].addtime = time;
                }
                return e;
            })
        }
           	
    })   
    
</script> 