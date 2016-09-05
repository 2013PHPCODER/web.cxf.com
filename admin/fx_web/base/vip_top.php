<style>
    .header, .capital-footer {
        background:#eee;
        width:100%;
        position:absolute;
        z-index:100;
    }
    /**各种中心自适应**/
    .header {
        height: 31px;
        top:0;
    }
    .capital-footer {
        height: 55px;
        bottom:0;
    }
    .capital {
        width:100%;
        background:#f7f7f7;
        overflow:hidden;
        top:31px;
        bottom:55px;
        position:absolute;
        z-index:99;
        _height:100%;
        _border-top:31px solid #eee;
        _border-bottom:55px solid #eee;
        _top:0;
    }
    .capital-box {
        width: 100%;
        min-width: 1360px;
        position: absolute;
        top: 100px;
        left: 0;
        bottom: 0;
    }
    .capital-notice, .capital-nav, .nav-sm {
        height: 100%;
    }
    .capital-nav {
        background-color: #ff6537;
    }
    .capital-cont, .cont-box {
        height: 100%;
        /*position: absolute;*/
    }
    .cont-box-title, .cont-box-foot {
        width:100%;
        position:absolute;
        z-index:100;
    }
    .cont-box-title {
        height: 48px;
        top:0;
    }
    .cont-box-foot {
        height: 60px;
        bottom: 0;
        background-color: #fff;
    }
    .cont-box-body {
        width:100%;
        background:#f7f7f7;
        overflow-y: auto;
        overflow-x: hidden;
        position:absolute;
        height: 92%;
        top:48px;
        bottom:60px;
        z-index:99;
        _height:100%;
        _border-top:48px solid #eee;
        _border-bottom:79px solid #eee;
        _top:0;
    }
</style>
<div class="header">
    <div class="top">
        <div class="top-box clearfix">
            <div class="top-left">
                <a href="" class="welcome">您好，请登录</a>
                <a href="">注册</a>
                <a class="clearfix all_news"><i class="news-icon"></i><span>消息</span><i class="num-icon"></i></a>
            </div>
            <div class="top-right moseover">
                <a href="index.php" target="_self"><i class="my-home-icon"></i><span>首页</span></a>
                <a href=""><i class="my-icon1"></i><span>我的收藏夹</span></a>
                <a href="../about_client.php" target="_blank"><i class="my-icon4"></i><span>软件下载</span></a>
            </div>
        </div>
    </div>
</div>
<script>
	 CheckUserLogin();
     $(function(){
     	  if (getCookieValue('user_nickname') != '' && getCookieValue('user_nickname') != null) {
                $('.top-left').children('a').eq(0).html('您好，' + getCookieValue('user_nickname')).attr('href','../vip_center.php');
                $('.top-left').children('a').eq(1).html('退出').attr('href','../login.php').on('click',function(){                	
                	deleteCookie('user_nickname');
                	deleteCookie('user_id');
                });
                X.Post(requestUrl.top,1,{'to_client': 1,'page':1},function(e){
                    if(e.body.list.list.length>0) {
                        $('.top-left').children('a').eq(2).find('.num-icon').addClass("show").html(e.body.list.list.length);
                    }
                },function(x){
//                    console.log(x);
                    var e = x, newDate = new Date();
                    for(var i in x.list){
                        newDate.setTime(x.list[i].addtime * 1000);
                        var time = newDate.toLocaleString();
                        e.list[i].addtime = time;
                    }
                    return e;
                })
            }else{
            	$('.num-icon').hide();
            }                       
     });
</script>