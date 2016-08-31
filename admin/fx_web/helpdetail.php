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
        <title>创想范分销平台--帮助详情</title>
        <link rel="stylesheet" type="text/css" href="css/common.css" />
        <link rel="stylesheet" type="text/css" href="css/yz.css"/>
        <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
    </head>

    <body>
        <!--header-->
        <div class="header">
            <?php include_once 'base/index_top.php'; ?>
            <?php include_once 'base/detail_top.php'; ?>
        </div>
        <!--body-->
        <p class="helpd-line"></p>
        <div class="main main-help-d clearfix">
            <div class="helpd-nav" id='help_detail'>
                <h3 class="nav-f-t"><span></span>分销商版块</h3>
                <div class="nav-l nav-l-f" data-bind="foreach:{data:list,as:'auto'}">
                    <a class="select" data-bind = "text:title,attr:{'data-id':id}">注册问题</a>
                </div>
                <h3 class="nav-g-t"><span></span>供应商版块</h3>
                <div class="nav-l nav-l-g" data-bind="foreach:{data:list,as:'auto'}">
                    <a class="select" data-bind = "text:title,attr:{'data-id':id}">注册问题</a>
                </div>
            </div>
            <div class="helpd-content" id="article_detail">
                <div class="helpd-content-box" style="display: block;">
                    <div class="helpd-c-title">
                        <h3 data-bind = "text:list.title">标题名称怎么样快速注册？</h3>
                        <p class="p-time">发布时间：<span data-bind = "text:list.addtime">2016-7-31 14：58：07</span></p>
                        <p class="p-line"><span></span></p>
                    </div>
                    <div class="helpd-c-mes" data-bind = "text:list.content">
                        <h3>评价晒单说明</h3>
                        <p>1. &nbsp;&nbsp;同一订单中的相同商品或者下单时间相隔15日内不同订单中的相同商品只能评价一次。</p>
                        <p>2. &nbsp;&nbsp;客户发表的评价内容应真实、客观，并鼓励进行原创，客户的评价会直接影响商品好评率以及店铺动态评分。</p>
                        <p>3. &nbsp;&nbsp;若产品退换货，将对退换货商品已经产生的商品的评价晒单进行删除，并扣除已获得京豆。</p>
                        <p>4. &nbsp;&nbsp;京东将对评价和晒单内容进行审核，审核通过后的评价和晒单才能展示给其他用户。对于审核不通过的评价晒单，不能获得京豆奖励，且文字、晒图均不能被展示出来。如果客户发布的评价未审核通过次数大于等于5条，则一年内该客户发表的评价晒单均不会获得京豆奖励。</p>
                        <p>5. &nbsp;&nbsp;审核不予通过的评价、晒单情况如下（包含但不限于以下内容）：</p>
                        <p>（1） 评价心得文字与购买的商品无关；</p>
                        <p>（2） 剽窃、无意义、违法、涉黄、违反道德的评价或晒单；</p>
                        <p>（3） 拷贝自己或者他人评价内容超过80%以上（以字数为准）；</p>
                        <p>（4）  使用标点符号过多的；评价内容没有任何参考价值、被5名以上网友举报或者违反法律、法规的；</p>
                        <p>（5） 晒单图片与所购买商品不一致；</p>
                        <p>（6） 晒单为截屏图片；</p>
                        <p>（7） 图片不清晰，不能达到晒单目的；</p>
                        <p>（8） 未经过他人同意，涉及使用他人图片或将他人图片进行编辑后发布；</p>
                        <p>（9） 盗用他人图片经举报、诉讼情况属实；</p>
                        <p>（10） 图片中涉及敏感词汇（如：曝光，315，假二水，翻新等）；</p>
                        <p>（11） 图片涉及与客服聊天记录；</p>
                        <p>（12） 对于成人用品晒单，未对特殊部位进行遮掩或打马赛克；</p>
                    </div>
                </div>	
            </div>
            <div class="helpd-right">
                <div class="helpd-r-box">
                    <h3><span><img src="images/help/helpr_t01.png"/></span>最新公告</h3>
                    <div class="hpd-announ">
                        <p><a href="javascript::">开通供货站付费吗？</a></p>
                        <p><a href="javascript::">开通需要 什么资质？</a></p>
                        <p><a href="javascript::">连锁店开通流程？</a></p>
                        <p><a href="javascript::">开通需多长时间？</a></p>
                        <p><a href="javascript::">资金冻结的问题怎么解决？</a></p>
                        <p><a href="javascript::">入驻需要的流程和条件？</a></p>
                    </div>
                </div>
                <div class="helpd-r-box helpd-r-boxC">
                    <h3><span><img src="images/help/helpr_t02.png"/></span>帮助中心</h3>
                    <div class="hpd-announ hpd-announMar">
                        <p><a href="javascript::">银行卡提现时间需要多久？</a></p>
                        <div>2015年7月1日开始，提现周期调整至T+1个工作日到账（18点后发起的多加1个工作日），不再区分企业和个人认证，节假日顺延。</div>
                    </div>
                    <div class="hpd-announ">
                        <p><a href="javascript::">订单金额为什么一直待结算？</a><p>
                        <div>小创担保交易再没有维权退款的情况下，商加发货后7天自动结算，结算之前欠款是显示再待结算余额。结算后钱款进入账户余额方可提现。如买家自动确认收货，将即刻结算。</div>
                    </div>
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
    <script src="//cdn.bootcss.com/knockout/3.3.0/knockout-min.js"></script>
    <script src="js/plus.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/public.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        var list_data = {
            'show_platform': 1,
            'page': 1
        }
      
        X.bindModel(requestUrl.help_list, 0, list_data, 'body.list', ['help_detail'], function () {
            $('.nav-l>a').click(function () {
                var oIndex = $(this).index();
                $('.nav-l>a').removeClass('select');
                $(this).addClass('select');
                artDetail($(this).attr('data-id'));
            })
            if( $('.nav-l>a').size() > 0 ){
                $('.nav-l>a').eq(0).click();
            }
        })
        
        var oHtml = $('#article_detail').html();     
        function artDetail(cid){
        	ko.cleanNode(document.getElementById("article_detail"));
        	$('#article_detail').html(oHtml);
        	var art_data = {
	            'show_platform': 1,
	            'aid': cid
	        }
        	X.bindModel(requestUrl.article, 0, art_data, 'body', ['article_detail'], function () {})
        }

    </script>

</html>