<div class="top">
    <div class="wbtop-box">
        <div class="top-box clearfix">
            <div class="top-left">
                <a href="../login.php" class="welcome">您好，请登录</a>
                <a href="../choose_register.php">注册</a>
                <a href="javascript:;" class="clearfix all_news"><i class="news-icon"></i><span>消息</span><i
                        class="num-icon"></i></a>
            </div>
            <script>
                $(function () {
                    if (getCookieValue('user_nickname') != '' && getCookieValue('user_nickname') != null) {
                        $('.top-left').children('a').eq(0).html('您好，' + getCookieValue('user_nickname')).attr('href', '../vip_center.php');
                        $('.top-left').children('a').eq(1).html('退出').attr('href', '../login.php').on('click', function () {
                            deleteCookie('user_nickname');
                            deleteCookie('user_id');
                        });
                        X.Post(requestUrl.top, 1, {'to_client': 1, 'page': 1}, function (e) {
                            if (e.body.list.list.length > 0) {
                                $('.top-left').children('a').eq(2).find('.num-icon').addClass("show").html(e.body.list.list.length);
                            }

                        })

                    } else {
                        $('.num-icon').hide();
                    }
                })

                $('.all_news').click(function () {
                    mess();
                });

            </script>
            <div class="top-right moseover">
                <a href="index.php" target="_self"><i class="my-home-icon"></i><span>首页</span></a>
                <a href="user_collectlist.php" target="_blank"><i class="my-icon1"></i><span>我的收藏夹</span></a>
                <a href="vip_center.php" target="_blank"><i class="my-icon2"></i><span>管理台</span></a>
<!--                <a href="about_client.php" target="_blank"><i class="my-icon4"></i><span>软件下载</span></a>-->
                <a href="http://192.168.20.191:82/user/login/index.html" target="_blank"><i
                        class="my-supplier-icon"></i><span>供应商登陆</span></a>
            </div>
        </div>
    </div>
</div>


<div class="marks Agmarks" id="allNew">
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
                        <tbody data-bind="foreach:list,as:'auto'">
                        <tr class="getBorder">
                            <td data-bind="text:addtime" style="border: 1px solid #ccc;padding: 11px;"></td>
                            <td data-bind="text:title" style="border: 1px solid #ccc;padding: 11px;">快速提升店铺销量绝密文件</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    var meshtml = $('#allNew').html();
    function mess() {
        var allNew = $('#allNew');
        allNew.show();
        $('#allNew>div').show();
        ko.cleanNode(document.getElementById("allNew"));
        var user_id = getCookieValue('user_id');
        if(user_id) {
            var new_data = {
                'to_client': 1,
                'page': 1
            };
            allNew.html(meshtml);
            X.bindModel(requestUrl.top, 1, new_data, 'body.list', ['allNew'], function () {
                $('.PopColse').click(function () {
                    $('#allNew').hide();
                })
            },function(x){
                var e = x, newDate = new Date();
                for(var i in x.list){
                    newDate.setTime(x.list[i].addtime * 1000);
                    var time = newDate.toLocaleString();
                    e.list[i].addtime = time;
                }
                return e;
            })
        }else {
            $(".marks.Agmarks").css({display: "none"});
            X.notice("您还未登录，无法查看消息！", 2);
        }
    }
</script>
