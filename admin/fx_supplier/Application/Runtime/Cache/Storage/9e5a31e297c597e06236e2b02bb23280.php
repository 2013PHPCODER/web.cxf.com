<?php if (!defined('THINK_PATH')) exit(); if(C('LAYOUT_ON')) { echo ''; } ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <title>跳转中...</title>
        <script type="text/javascript">
            //<![CDATA[
            try {
                if (!window.CloudFlare) {
                    var CloudFlare = [{verbose: 0, p: 1419364062, byc: 0, owlid: "cf", bag2: 1, mirage2: 0, oracle: 0, paths: {cloudflare: "/cdn-cgi/nexp/dok2v=1613a3a185/"}, atok: "1fca8a26fb9678bbb4b5c54c34e227b9", petok: "90eac31ac43396aaaba1495988655df05c3aaf7e-1420553966-1800", zone: "adbee.technology", rocket: "0", apps: {"ga_key": {"ua": "UA-49262924-2", "ga_bs": "2"}}}];
                    !function (a, b) {
                        a = document.createElement("script"), b = document.getElementsByTagName("script")[0], a.async = !0, a.src = "http://ajax.cloudflare.com/cdn-cgi/nexp/dok2v=919620257c/cloudflare.min.js", b.parentNode.insertBefore(a, b)
                    }()
                }
            } catch (e) {
            }
            ;
            //]]>
        </script>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_DIR;?>/static/supplier/css/bootstrap/bootstrap.min.css"/>
        <!--<script src="<?=JS_PATH;?>demo-rtl.js"></script>-->
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_DIR;?>/static/supplier/css/font-awesome.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo SOURCE_DIR;?>/static/supplier/css/theme_styles.css"/>
        <!--[if lt IE 9]>
                <script src="<?=JS_PATH;?>html5shiv.js"></script>
                <script src="<?=JS_PATH;?>respond.min.js"></script>
            <![endif]-->
        <script type="text/javascript">
            /* <![CDATA[ */
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-49262924-2']);
            _gaq.push(['_trackPageview']);

            (function () {
                var ga = document.createElement('script');
                ga.type = 'text/javascript';
                ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(ga, s);
            })();

            (function (b) {
                (function (a) {
                    "__CF"in b && "DJS"in b.__CF ? b.__CF.DJS.push(a) : "addEventListener"in b ? b.addEventListener("load", a, !1) : b.attachEvent("onload", a)
                })(function () {
                    "FB"in b && "Event"in FB && "subscribe"in FB.Event && (FB.Event.subscribe("edge.create", function (a) {
                        _gaq.push(["_trackSocial", "facebook", "like", a])
                    }), FB.Event.subscribe("edge.remove", function (a) {
                        _gaq.push(["_trackSocial", "facebook", "unlike", a])
                    }), FB.Event.subscribe("message.send", function (a) {
                        _gaq.push(["_trackSocial", "facebook", "send", a])
                    }));
                    "twttr"in b && "events"in twttr && "bind"in twttr.events && twttr.events.bind("tweet", function (a) {
                        if (a) {
                            var b;
                            if (a.target && a.target.nodeName == "IFRAME")
                                a:{
                                    if (a = a.target.src) {
                                        a = a.split("#")[0].match(/[^?=&]+=([^&]*)?/g);
                                        b = 0;
                                        for (var c; c = a[b]; ++b)
                                            if (c.indexOf("url") === 0) {
                                                b = unescape(c.split("=")[1]);
                                                break a
                                            }
                                    }
                                    b = void 0
                                }
                            _gaq.push(["_trackSocial", "twitter", "tweet", b])
                        }
                    })
                })
            })(window);
            /* ]]> */
        </script>
    </head>
    <body id="error-page">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div id="error-box">
                        <div class="row">
                            <div class="col-xs-12">
                                <?php if(isset($message)) {?>
                                <h1>操作成功</h1>
                                <p><?php echo($message); ?></p>
                                <?php }else{?>
                                <h1>操作失败</h1>
                                <p><?php echo($error); ?></p>
                                <?php }?>
                                <p>
                                    等待时间： <b id="wait"><?php echo($waitSecond); ?></b>后自动跳转,或手动点击<a id="href" href="<?php echo($jumpUrl); ?>"> 跳转 </a> .
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo SOURCE_DIR;?>/static/supplier/js/bootstrap.min.js"></script>
        <script src="<?php echo SOURCE_DIR;?>/static/supplier/js/plugins/jQuery-2.2.0.min.js"></script>
        <script type="text/javascript">
            (function () {
                var wait = document.getElementById('wait'), href = document.getElementById('href').href;
                var interval = setInterval(function () {
                    var time = --wait.innerHTML;
                    if (time <= 0) {
                        location.href = href;
                        clearInterval(interval);
                    }
                    ;
                }, 1000);
            })();
        </script>
    </body>
</html>