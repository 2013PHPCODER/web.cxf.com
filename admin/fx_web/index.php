<!DOCTYPE html>
<html lang="zh-CN">

    <head>
        <meta charset="UTF-8">
        <!-- 设置360浏览器渲染模式,webkit 为极速内核，ie-comp 为 IE 兼容内核，ie-stand 为 IE 标准内核。 -->
        <meta name="renderer" content="webkit">
        <meta name="google" value="notranslate">
        <!-- 禁止Chrome 浏览器中自动提示翻译 -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <!-- 禁止百度转码 -->
        <meta name="Description" content="" />
        <meta name="Keywords" content="" />
        <meta name="author" content="">
        <meta name="Copyright" content="" />
        <title>创想范货源分销平台--首页</title>
        <link rel="stylesheet" type="text/css" href="css/common.css" />
        <link rel="stylesheet" type="text/css" href="css/main.css"/>
        <link rel="shortcut icon" href="images/64x64.ico" type="image/x-icon" /> 
        <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
        <script src="//cdn.bootcss.com/knockout/3.3.0/knockout-min.js"></script>
        <script src="js/pseudo.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/public.js"></script>
        <script src="js/plus.js"></script>
    </head>

    <body>
        <!--header-->
        <div class="header">
            <?php include_once 'base/index_top.php'; ?>
            <?php include_once 'base/index_top_1.php'; ?>
        </div>

        <!--body-->
        <div class="wrapper">
            <div class="g-wrapper clearfix">
                <div class="i-banner">
                    <ul>
                        <li class="ac-banner">
                            <a href=""><img src="http://maihoho.b0.upaiyun.com//top/4947738295499779088.png" alt=""/></a>
                            <p><i></i>创想范9月重磅来袭</p>
                        </li>
                        <li>
                            <a href=""><img src="http://maihoho.b0.upaiyun.com//top/4836201608860831346.png" alt=""/></a>
                            <p><i></i>创想范9月重磅来袭</p>
                        </li>
                        <li>
                            <a href=""><img src="http://maihoho.b0.upaiyun.com//top/4797325559761426302.png" alt=""/></a>
                            <p><i></i>创想范9月重磅来袭</p>
                        </li>
                        <li>
                            <a href=""><img src="http://maihoho.b0.upaiyun.com//top/5292280711402987882.png" alt=""/></a>
                            <p><i></i>创想范9月重磅来袭</p>
                        </li>
                        <li>
                            <a href=""><img src="http://maihoho.b0.upaiyun.com//top/5113020158404319213.png" alt=""/></a>
                            <p><i></i>创想范9月重磅来袭</p>
                        </li>
                        <li>
                            <a href=""><img src="http://maihoho.b0.upaiyun.com//top/4813107223975253505.png" alt=""/></a>
                            <p><i></i>创想范9月重磅来袭</p>
                        </li>
                        <div class="i-banner-circle">
                            <a href="javascript:;" class="active"></a>
                            <a href="javascript:;"></a>
                            <a href="javascript:;"></a>
                            <a href="javascript:;"></a>
                            <a href="javascript:;"></a>
                            <a href="javascript:;"></a>
                        </div>
                    </ul>
                </div>
                <div class="i-lauyot">
                    <div class="lauyot-box">
                        <h2>重要提醒</h2>
                        <div class="lauyot-content">
                            <a href=""><img src="images/index/layout.png"/></a>
                            <h3>客户另行指定快递，可供指定的快递以及运费</h3>
                            <p>顺丰：23元，偏远地区28（一公斤以内），港澳台35元。邮政：20元，偏远地区37（一公斤以内），港澳台不发。</p>
                        </div>
                    </div>
                    <div class="lauyot-box" id="notice">
                        <h2 class="clearfix"><span>最新公告</span><a href="helpdetail.php
                                                                 " target="_blank">更多</a></h2>
                        <div class="lauyot-content">
                            <ul data-bind = "foreach:{data:notice,as:'auto'}">
                                <li><a  data-bind = "text:title,attr:{href:'helpdetail.php'}" target="_blank"></a><span>08/26</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-wrapper">
                <div class="m-adver clearfix">
                    <a href=""><img src="images/index/m-adver.png" alt="" /></a>
                    <a href=""><img src="images/index/m-adver2.png" alt="" /></a>
                    <a href=""><img src="images/index/ad-adver3.png" alt="" /></a>
                    <a href=""><img src="images/index/ad-adver4.png" alt="" /></a>
                </div>
                <!--大市场-->
                <div class="g-grand">
                    <div class="g-grand-title">
                        <div class="grand-title-box">
                            <h2></h2>
                        </div>	
                    </div>
                    <div class="grand-mtitle">
                        <h3>INTEGRATED MARKET</h3>
                    </div>
                    <!--杭州大市场-->
                    <div class="hz-grand" id="bigCategory">
                        <div class="hz-grand-title">
                            <strong>杭州大市场</strong>
                            <span>今日活动:</span>
                            <a href="">「箱包」 箱包一件代发！O库存O成本</a>
                            <a href="">「服装」 女装连衣裙，潮流元素大解析！</a>
                        </div>
                        <div class="grand-box clearfix" data-bind = "foreach:{data:category,as:'auto'}">
                            <div class="g-grand-box">
                                <div class="hz-lf-img">
                                    <div class="hz-lf-tle-hot">
                                        <span>热门活动</span>
                                    </div>
                                    <div class="hz-lf-img-box">
                                        <a target="_self" href data-bind="attr:{href:'goodlist.php?cate_id='+cid}"><img data-bind="attr:{src:big_ico}" src=""></a>
                                        <div class="hz-lf-tle-text">
                                            <!--<h3 data-bind = "text:name">时尚女装</h3>
                                            <p>热销潮流元素集锦</p>
                                            <a href="" data-bind = "attr:{href:'/goodlist.php?cate_id='+cid}">查看详情 <i>></i></a>-->
                                        </div>
                                        <div class="hz-cover">
                                            <img src="http://maihoho.b0.upaiyun.com//top/5252300711878273386.png">
                                        </div>
                                    </div>
                                </div>
                                <div class="hz-text">
                                    <div class="hz-title">
                                        <h2><i></i><label data-bind = "text:name"></label></h2>
                                        <div class="hz-mtitle">
                                            <a data-bind="text:title"></a>
                                            <a data-bind="text:'16年'+ name + '榜单'"></a>
                                        </div>
                                    </div>
                                    <div class="hz-content clearfix">
                                        <div class="hz-content-lf">
                                            <ul class="clearfix scrollbarSty">
                                                <li data-bind = "foreach:{data:child,as:'auto'}">
                                                    <a data-bind = "text:name,attr:{href:'/goodlist.php?cate_id='+cid}" target="_self">女装</a>
                                                </li>                                               
                                            </ul>
                                        </div>
                                        <div class="hz-content-rf">
                                            <ul>
                                                <li><a href="">女装潮流好商好货</a></li>
                                                <li><a href="">女装一周新品</a></li>
                                                <li class="margin"><a href="">男装清仓季推荐</a></li>
                                                <li><a href="">男装品质好货汇聚</a></li>
                                                <li class="margin"><a href="">镇厂好货8折起</a></li>
                                                <li><a href="">品质内衣大牌代工</a></li>
                                                <li class="margin"><a href="">韩版女装新品</a></li>
                                                <li><a href="">欧美女装新品</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>                                                                            
                        </div>
                    </div>
                    <!--广告活动图-->
                    <div class="i-adver clearfix">
                        <a href=""><img src="images/index/i-adver.png" alt=""/></a>
                        <a href=""><img src="images/index/i-adver2.png" alt=""/></a>
                    </div>

                </div>
                <div class="i-adver-bottom">
                    <a href=""><img src="images/index/i-adver-bottom.png" alt=""/></a>
                </div>
            </div>
            <div class="slider-bottom">
                <div class="slider-box" id="rxgoods">
                    <ul class="clearfix" data-bind = "foreach:{data:goods,as:'auto'}">
                        <li><a data-bind = "attr:{href:'/good_detail.php?goodsID='+goods_id}" target="_self"><img data-bind = "attr:{src:img_path}" alt="" /></a></li>
                    </ul>
                    <span class="prev"></span>
                    <span class="next"></span>
                </div>
            </div>
        </div>


        <!--footer-->
        <?php
        include_once 'base/index_footer.php';
        include_once 'base/index_footer_blackdiv.php';
        include_once 'base/index_footer_kefu.php';
        ?>

    </body>
    <script type="text/javascript">
        $(function () {
            $('.i-banner-circle a').click(function () {
                var _i = $(this).index();
                $(this).addClass('active').siblings().removeClass('active');
                $('.i-banner li').fadeOut(800)
                $('.i-banner li').eq(_i).fadeIn(800)
            })
            setInterval(function () {
                slideBanner()
            }, 3000)
            var flag = 1;
            function slideBanner() {
                $('.i-banner-circle a').eq(flag).addClass('active').siblings().removeClass('active');
                $('.i-banner li').fadeOut();
                $('.i-banner li').eq(flag).fadeIn();
                flag++
                var len = $('.i-banner li').length;
                if (flag > len - 1) {
                    flag = 0
                }
            }
        })
    </script>


</html>
<!--数据绑定-->
<script>
    $(function () {
    	X.bindModel(requestUrl.category, 0, {}, '', ['category'], function () {
    		$('.e-tab').find('.classify-body').hover(function () {
                var _index = $(this).index();
                $('.tab-box .menu-tab').eq(_index).addClass('current').siblings().removeClass('current');
            }, function () {
                $('.tab-box .menu-tab').removeClass('current');
            })
            $('.menu-tab').hover(function () {
                $(this).addClass('current').siblings().removeClass('current');
            }, function () {
                $(".menu-tab").removeClass('current');
            })
    	},function(e){
    		var x= {'category':e} 
    		return  x
    	}) 	   	
        X.bindModel(requestUrl.index, 0, {'to_client': 1}, 'body.list', ['notice', 'rxgoods', 'bigCategory'], function () {                	
            function rollSliderlf() {
                $('.slider-box ul').animate({
                    marginLeft: '-340px'
                }, 1500, "linear", function () {
                    $('.slider-box ul').css({
                        marginLeft: "-170px"
                    });
                    $('.slider-box ul li:first').remove().clone(true).appendTo('.slider-box ul')
                })
            }
            function rollSliderrr() {
                $('.slider-box ul').animate({
                    marginLeft: '0px'
                }, 1500, "linear", function () {
                    $('.slider-box ul').css({
                        marginLeft: "-170px"
                    });
                    $('.slider-box ul li:last-child').remove().clone(true).insertBefore($('.slider-box ul li:first'))
                })
            }
            var startRollSlider = setInterval(rollSliderlf, 3000);
            $('.slider-box ul').hover(function () {
                clearInterval(startRollSlider);
            }, function () {
                startRollSlider = setInterval(rollSliderlf, 3000);
            })
            $('.prev').click(function () {
                clearInterval(startRollSlider);
                rollSliderlf();
//				continue setInterval(rollSliderlf,5000);
                return false
            })
            $('.next').click(function () {
                clearInterval(startRollSlider);
                rollSliderrr();
//				continue setInterval(rollSliderlf,5000);
                return false
            })
        })
    })
    $('.nav-box ul .classify').css('display','block')
</script>