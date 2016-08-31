<!DOCTYPE html>
<html>
    <head lang="en">
        <meta charset="UTF-8">
        <title>创想范--货源中心</title>
        <link rel="stylesheet" href="css/common.css">
        <link rel="stylesheet" href="css/goodsList.css">
        <link rel="stylesheet" href="css/main.css">  
        <link rel="shortcut icon" href="images/64x64.ico" type="image/x-icon" /> 
        <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
        <!--<script src="js/jquery.cookie-1.4.1.min.js" type="text/javascript" charset="utf-8"></script>-->
        <script src="js/public.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/plus.js" type="text/javascript" charset="utf-8"></script>
        <style>
            .nav .nav-box .classify-box{display: none;}
            .goodsListDiv>ul{display: none;}
            .goodsListDiv>ul:first-child{display: block;}
            .floorLeft>div>span{color: #fff;font-size: 24px;width: 100px;overflow: hidden; float: right;margin-right: 10px;font-family: "microsoft yahei";margin-top: 3px;}
        </style>
    </head>
    <body style="background: #f5f5f5;">
        <!--header-->
        <div class="header">
            <?php include_once 'base/index_top.php'; ?>
            <?php include_once 'base/index_top_1.php'; ?>
        </div>

        <div class="goodsCenterGG1">
            <a href="">
                <img src="images/goodsCenter/goodsCenterGG1.png">
            </a>
        </div>
        <div id="goodsCenter">
            <ul data-bind = "foreach:{data:good_center,as:'auto'}">
                <li>
                    <a name="1F" id="1F"></a>
                    <div class="floorType">
                        <div class="floorLeft">
                            <div>
                                <b class="FF">1F</b>
                                <span data-bind="text:name">时尚女装</span>
                                <img src="images/goodsCenter/foolrBottomSJ.png">
                            </div>
                            <span class="floorTypeNameEng">FASHION LADIES</span>
                        </div>
                        <div class="floorCenter">
                            <ul data-bind = "foreach:{data:child,as:'auto'}">
                                <li class="noMargin" data-bind = "text:name,attr:{'data-id':cid}">连衣裙</li>
                            </ul>
                        </div>
                        <a href data-bind="attr:{href:child.length > 0 ? 'goodlist.php?cate_id='+child[0].cid : ''}">更多>></a>
                    </div>               
                    <div class="goodsListDiv" data-bind = "foreach:{data:child,as:'auto'}">
                        <ul class="goodsCenterUl" data-bind = "foreach:{data:goods,as:'auto'}" style="display: none;">
                            <li data-bind="attr:{id:goods_id,name:goods_name,code:buyer_goods_no}">
                                <div class="goodsImg">
                                    <a data-bind = "attr:{href:'good_detail.php?goodsID='+goods_id}" target="_blank">
                                        <img data-bind="attr:{src:img_path,alt:goods_name,title:goods_name}">
                                    </a>
                                    <p>
                                        <span class="leftSC">1</span>
<!--                                        <span class="goodsSC">收藏</span>-->

                                    </p>
                                </div>
                                <div class="goodsBorder">
                                    <p class="goodsName"><a href="" data-bind = "attr:{href:'good_detail.php?goodsID='+goods_id,title:goods_name},text:goods_name"></a></p>
                                    <div class="goodsGrade">
                                        <div class="left">
                                            <p>基础版：<label data-bind = "text:change_price.basic_price"></label>元</p>
                                            <p>中级版：<label data-bind = "text:change_price.middle_price"></label>元</p>
                                            <p class="goodsPriceGj">高级版：<label data-bind = "text:change_price.senior_price"></label>元</p>
                                        </div>
                                        <div class="right">
                                            <p class="delPrice">原价：<label data-bind = "text:change_price.distribution_price"></label></p>
                                            <p>
                                                <span class="rightPH buy">一键铺货</span>
                                                <span class="buy ljgm"><a data-bind = "attr:{href:'good_detail.php?goodsID='+goods_id}">立即购买</a></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </li>                        
                        </ul>
                    </div>
                </li>               
            </ul>
            <div class="i-adver-bottom">
                <a href=""><img src="images/index/i-adver-bottom.png" alt=""/></a>
            </div>
            <div class="slider-bottom">
                <div class="slider-box">
                    <ul class="clearfix" data-bind = "foreach:{data:hot_goods,as:'auto'}">
                        <li><a target="_self" data-bind="attr:{href:'/good_detail.php?goodsID='+goods_id}"><img data-bind="attr:{src:img_path,alt:goods_name}" alt="" /></a></li>
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

        <!--楼层指引-->
        <div class="foolrDiv" id="foolrDivI">
            <ul data-bind = "foreach:{data:good_center,as:'auto'}">
                <li class="floorLeftActive" data-F="1F" data-bind="css:{'floorLeftActive':$index()==0},attr:{'data-F':($index()+1)+'F'}">
                    <a href="#1F" data-bind = "attr:{href:'#'+($index()+1)+'F'}">
                        <div class="ssnz" data-bind="css:{'ssnz':$index()==0,'jpnz':$index()==1,'jpxb':$index()==2,'tztx':$index()==3,'fspj':$index()==4,'ssnx':$index()==5,'jpnx':$index()==6}">
                            <b data-bind = "text:($index()+1)+'F'">1F</b>
                            <p data-bind = "text:name">时尚女装</p>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </body>
    <script type="text/javascript">
        $(function () {
                $('#category .classify-box.e-tab').css('display','none');
                $('#category li:first-child').click(function(){
                        $('#category .classify-box.e-tab').slideToggle();
                })
                X.bindModel(requestUrl.goods_center,0,{},'body.list',['goodsCenter','foolrDivI'],function(){
                	$('.goodsCenterUl').show();
                    $('#goodsCenter>ul>li').each(function(i){
                            $('#goodsCenter>ul>li').eq(i).children('a').eq(0).attr({'name':i+1+'F','id':i+1+'f'})
                            $(this).find('.FF').html(i+1+'F');
                            $(this).find('.floorCenter').find('li').eq(0).addClass('floorLiActive ');
                    })     		
                    function rollSliderlf() {
                        $('.slider-box ul').animate({
                            marginLeft: '-340px'
                        }, 2000, "linear", function () {
                            $('.slider-box ul').css({
                                marginLeft: "-170px"
                            });
                            $('.slider-box ul li:first').remove().clone(true).appendTo('.slider-box ul');
                        })
                    }
                    function rollSliderrr() {
                        $('.slider-box ul').animate({
                            marginLeft: '0px'
                        }, 2000, "linear", function () {
                            $('.slider-box ul').css({
                                marginLeft: "-170px"
                            });
                            $('.slider-box ul li:last-child').remove().clone(true).insertBefore($('.slider-box ul li:first'))
                        })
                    }
                    var startRollSlider = setInterval(rollSliderlf, 5000);
                    $('.slider-box ul').hover(function () {
                        clearInterval(startRollSlider);
                    }, function () {
                        startRollSlider = setInterval(rollSliderlf, 5000);
                    })
                    $('.prev').click(function () {
                        clearInterval(startRollSlider);
                        rollSliderlf();
                        return false
                    })
                    $('.next').click(function () {
                        clearInterval(startRollSlider);
                        rollSliderrr();
                        return false
                    });
                    $('#goodsCenter li').each(function(){
                        $(this).find('.goodsListDiv>ul').eq(0).children('li').each(function(){
                             $(this).find('img').attr('src',$(this).find('img').attr('data-src'));
                        })            		            		
                    })
                    $('.floorCenter>ul>li').one('click',function(){
                        var f = $(this).parents('.floorType').parent().index();
                        var g = $(this).index();
                        if(g == 0){
                            return false;
                        }else{
                            $('#goodsCenter>ul>li').eq(f).find('.goodsListDiv>ul').eq(g).children('li').each(function(){
                                $(this).find('img').attr('src',$(this).find('img').attr('data-src'));
                            })            		            		
                        }
                    })
//	               	$('#goodsCenter>ul>li').each(function(){
//	               		$(this).find('.goodsListDiv>ul').eq(0).find('img').attr('src',$(this).find('.goodsListDiv>ul').eq(0).find('img').attr('data-src'))
//	               	}) 		
//	               	
                    $('.floorCenter ul').on('click', 'li', function () {
                    	var index = $(this).index();
	                    $(this).prevAll('li').removeClass('floorLiActive').end().nextAll('li').removeClass('floorLiActive').end().addClass('floorLiActive');
	                    $(this).parents('.floorType').next('.goodsListDiv').children('ul').eq(index).show().siblings().hide()
	                    
	                });
	                $('.foolrDiv ul').on('click', 'li', function () {
	                    var Fs = $(this).attr('data-F');
	                    $("html,body").animate({scrollTop: $('#' + Fs).offset().top}, 1500);
	                    $(this).prevAll('li').removeClass('floorLeftActive').end().nextAll('li').removeClass('floorLeftActive').end().addClass('floorLeftActive');
	                });

                    var DetailViewModel = {
                        goodsArr:[]
                    };
                    //单个商品铺货
                    $('.rightPH').click(function(){
                        DetailViewModel.goodsArr.length=0;
                        var parens = $(this).parents('li');
                        DetailViewModel.goodsArr.push({goodsID:parens.attr('id'),goods_name:parens.attr('name'),buyer_goods_no:parens.attr('code')});
                        yijinPH(DetailViewModel);
                    });
	            })
        })
    </script>
    <script>
           
           $(function(){
               X.bindModel(requestUrl.category,0,{},'',['category'],function(){},function(x){
               	    x = {'category':x}     
               	    return  x; 	  
               });
               function foolrDiv(){
               	   var oWight = $(window).width();
                   if(oWight-1480 >= 0){
                   	   $('.foolrDiv').css('left',(oWight-1480)*0.5+'px');
                   }else{
                   	   $('.foolrDiv').css('left',0)
                   }
               }
               foolrDiv()
               $(window).resize(function () {
                   foolrDiv()
			   });
           })

    </script>
</html>
