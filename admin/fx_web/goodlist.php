<!DOCTYPE html>
<html>
    <head lang="en">
        <meta charset="UTF-8">
        <title>货源分销平台-商品列表</title>
        <link rel="stylesheet" href="css/goodsList.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" type="text/css" href="css/common.css" />
        <link rel="stylesheet" type="text/css" href="css/zengli.css" />
        <link rel="shortcut icon" href="images/64x64.ico" type="image/x-icon" /> 
        <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
        <script src="//cdn.bootcss.com/knockout/3.3.0/knockout-min.js"></script>
        <script src="js/pseudo.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/public.js"></script>
        <script src="js/plus.js"></script>  
        <style>
           .goodsListDiv .goodsListUl li{
             	height: 375px;
           }          
	       .goodsListDiv .goodsListUl li > .goodsBorder{
	       	  height: 120px;
	       }
        	.goodsListDiv ul li .goodsName {
			    height: 42px;
			}
			.goodsTypeName .TypeName {
			    height: 24px;
			    width: 132px;
			    overflow: hidden;
			}
			.sidebarLeft .sidebarMax>ul{display: block;}
        </style>
    </head>
    <body>
        <!--header-->
        <div class="header">
            <?php include_once 'base/index_top.php'; ?>
            <?php include_once 'base/index_top_1.php'; ?>
        </div>
        <!--body-->
        <div id="goodsList">
        	<div class="sidebarLeft" id="searchCatage">
	            <div class="sidebarMax" data-bind="foreach:{data:category,as:'auto'}">
	                <div class="goodsTypeName noMargin">
	                    <div data-bind="style:{background:'url('+ico+') no-repeat'}">
	                        <p class="TypeName" data-bind="text:name,attr:{'category_id':category_id}">时尚女装</p>
	                        <p class="TypeNameEng" data-bind="text:name_en">fashion womenswear</p>
	                        <i></i>
	                    </div>
	                </div>
	                <ul data-bind="foreach:{data:child,as:'auto'}">
	                    <li>
	                        <a data-bind="text:name,attr:{category_id:category_id}">T恤</a>
	                    </li>
	                </ul>	                
	            </div>
	        </div>
            <div class="sidebarRight">
                <div class="rightTop">
                    <h3> 热门推荐</h3>
                </div>

                <ul class="topList">
                    <li class="noMargin">
                        <a href="">
                            <img src="images/goodsList/goodsImg.png" alt="">
                        </a>
                    </li>
                </ul>

                <div class="orderBy">
                    <div class="leftOrderBy">
                        <span class="orderAction">排序方式</span>
                        <div class="leftBy">
                            <span class="ordertext e-default cur">默认</span>
                            <span class="ordertext e-sales">销量&darr;</span>
                            <span class="ordertext noBorder"><label class="e-price">价格</label>：<input type="text" class="min_price" placeholder="￥最低价"> - <input type="text" class="max_price" placeholder="￥最高价"><input type="button" class="e-priceArea" value="确定"></span>
                        </div>
                    </div>
                    <div class="rightOrderBy">
                        <span class="startPH">开始铺货</span>
                        <div class="rightBy">
                            <span class="escPH">进入批量铺货</span>
                            <span>已选：<b id="Phnum">0</b> 件商品</span>
                        </div>
                    </div>
                </div>

                <div class="goodsListDiv" id="search">
                    <ul class="goodsListUl" data-bind = "foreach:{data:item,as:'auto'}">
                        <li data-bind="attr:{id:goods_id,name:goods_name,code:buyer_goods_no}">
                            <div class="goodsImg">
                                <a data-bind="attr:{href:'/good_detail.php?goodsID='+goods_id}" target="_blank">
                                    <img data-bind="attr:{src:img_path}" style="width: 100%;height: 100%">
                                </a>
                                <p>
                                    <span class="leftSC">已收藏：<label data-bind="text:collect_count"></label></span>
<!--                                    <span class="goodsSC addKeep">收藏</span>-->

                                </p>
                            </div>
                            <div class="goodsBorder">
                                <p class="goodsName"><a data-bind="text:goods_name,attr:{href:'/good_detail.php?goodsID='+goods_id}" target="_blank"></a></p>
                                <div class="goodsGrade">
                                    <div class="left">
                                        <p class="basic_price">初级版：<label data-bind="text:basic_price"></label> 元</p>
                                        <p class="middle_price">中级版：<label data-bind="text:middle_price"></label> 元</p>
                                        <p class="high_price">高级版：<label data-bind="text:senior_price"></label> 元</p>
                                    </div>
                                    <div class="right">
                                        <p class="delPrice">零售价：<label data-bind="text:distribution_price"></label></p>
                                        <p>
                                            <!--<span class="joinSheet">加入进货单</span>-->
                                            <span class="rightPH buy">一键铺货</span>
                                            <span class="buy ljgm"><a data-bind="attr:{href:'/good_detail.php?goodsID='+goods_id}" target="_blank">立即购买</a></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="NoActive"></div>
                        </li>          
                    </ul>
                </div>


                <div class="loadMore">......加载中</div>
            </div>
        </div>

        <!--footer-->
        <?php
        include_once 'base/vip_footer.php';
        include_once 'base/index_footer_blackdiv.php';
        include_once 'base/index_footer_kefu.php';
        ?>

        <!--弹窗-->


    </body>
    <script type="text/javascript">
        $(function () {
            function rollSliderlf() {
                $('.slider-box ul').animate({
                    marginLeft: '-340px'
                }, 2000, "linear", function () {
                    $('.slider-box ul').css({
                        marginLeft: "-170px"
                    });
                    $('.slider-box ul li:first').remove().clone(true).appendTo('.slider-box ul')
                })
            };
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
    </script>
    <script type="text/javascript">

        //左侧下拉菜单
//        $('.sidebarMax').on('click', '.goodsTypeName', function () {
//            $(this).prevAll('.goodsTypeName').next('ul').slideUp(function () {
//                $(this).removeClass('menuActive')
//            }).end().find('i').css({'transform': 'rotate(-90deg)'});
//            $(this).nextAll('.goodsTypeName').next('ul').slideUp(function () {
//                $(this).removeClass('menuActive')
//            }).end().find('i').css({'transform': 'rotate(-90deg)'});
//            $(this).next('ul').slideDown(function () {
//                $(this).addClass('menuActive')
//            }).end().find('i').css({'transform': 'rotate(0deg)'});
//        });
        //批量铺货开关
        var flag = true;
        var PhNum = 0;
        $('.escPH').click(function () {
            if (flag) {
                $(this).text('退出批量铺货');
                $('.NoActive,.YesActive').show();
                flag = false;
            } else {
                $(this).text('进入批量铺货');
                $('.NoActive,.YesActive').hide();
                flag = true;
            }
        });
        var DetailViewModel = {
            goodsArr:[]
        };
        $(function () {
//          X.bindModel(requestUrl.category, 0, {}, '', ['category'], function () {
//              $('.e-tab').find('.classify-body').hover(function () {
//                  var _index = $(this).index();
//                  $('.tab-box .menu-tab').eq(_index).addClass('current').siblings().removeClass('current');
//              }, function () {
//                  $('.tab-box .menu-tab').removeClass('current');
//              });
//              $('.menu-tab').hover(function () {
//                  $(this).addClass('current').siblings().removeClass('current');
//              }, function () {
//                  $(".menu-tab").removeClass('current');
//              });
//
//
//          }, function (x) {
//              x = {'category': x};
//              return  x;
//          });

            X.bindModel(requestUrl.search_category, 0, {}, '', ['searchCatage'], function () {
                $('.sidebarMax>ul a').click(function(){
                	var oIndex = $('.ordertext.cur').index(),
                	    data = {
                	    	'category_id':$(this).attr('category_id')
                	    }
	            	switch(oIndex){
	            		case  0 :
	            		   if(oUpTime = 0){
	            		   	  $.extend(data, {'sort_key': 1, 'sort_type': 0});
	            		   }else{
	            		   	  $.extend(data, {'sort_key': 1, 'sort_type': 1});
	            		   }
	            		   break;
	            		case  1 :
	            		   if(oSales = 0){
	            		   	  $.extend(data, {'sort_key': 2, 'sort_type': 0});
	            		   }else{
	            		   	  $.extend(data, {'sort_key': 2, 'sort_type': 1});
	            		   }
	            		   break;
	            		case  2 :
	            		   if(oPrice = 0){
	            		   	  $.extend(data, {'sort_key': 3, 'sort_type': 0});
	            		   }else{
	            		   	  $.extend(data, {'sort_key': 3, 'sort_type': 1});
	            		   }
	            		   break;   
	            	}
                	search(data)
                })

            }, function (x) {
                x = {'category': x};
                return  x;
            });
            
            

            //批量铺货效果
            $('.goodsListDiv').on('click', 'li', function () {
                if (!flag) {
                    var sign = $(this).hasClass('sign');
                    if (!sign) {
                        PhNum++;
                        $(this).addClass('sign');
                        $(this).find('.NoActive').removeClass('NoActive').addClass('YesActive');
                    } else {
                        PhNum--;
                        $(this).removeClass('sign');
                        $(this).find('.YesActive').removeClass('YesActive').addClass('NoActive');
                    }
                    $('#Phnum').text(PhNum);
                }
            });
            //批量铺货
            $('.startPH').click(function(){

                if(flag){
                    X.notice('请先进入批量铺货',3);
                }else {
                    if(PhNum<=0){
                        X.notice('请选择商品',3);
                    }else {
                        DetailViewModel.goodsArr=[];
                        $('.goodsListDiv li').each(function(){
                            if($(this).hasClass('sign')){
                                DetailViewModel.goodsArr.push({goodsID:$(this).attr('id'),goods_name:$(this).attr('name'),buyer_goods_no:$(this).attr('code')});
                            }
                        });
                        yijinPH(DetailViewModel);
                    }
                }
            })
            
            search({'category_id': getUrlParam('cate_id') == '' ? '' : getUrlParam('cate_id'), 'keyword': getUrlParam('keyword') == '' ? '' : getUrlParam('keyword')});
            if (getUrlParam('keyword') != '' ) {
                $('#searchText').val(getUrlParam('keyword'));
            }
            //	    默认
            $('.e-default').on('click', function () {
            	$(this).addClass('cur').siblings().removeClass('cur');
                var data = searchCondition();
                if (oUpTime == 0) {
                    oSales = 0;
                    oUpTime = 1;
                    oPrice = 0;
                    $.extend(data, {'sort_key': 1, 'sort_type': 1});
                } else {
                    oUpTime = 0;
                    $.extend(data, {'sort_key': 1, 'sort_type': 0});
                }
                search(data);
            });
            //	    销量
            $('.e-sales').on('click', function () {
            	$(this).addClass('cur').siblings().removeClass('cur');
                var data = searchCondition();
                if (oSales == 0) {
                    oSales = 1;
                    oUpTime = 0;
                    oPrice = 0;
                    $(this).html('销量↑');
                    $.extend(data, {'sort_key': 2, 'sort_type': 1});
                } else {
                    oSales = 0;
                    $(this).html('销量↓');
                    $.extend(data, {'sort_key': 2, 'sort_type': 0});
                }
                search(data);
            });
            //	    价格
            $('.e-price').on('click', function () {
            	$(this).parent().addClass('cur').siblings().removeClass('cur');
                var data = searchCondition();
                if (oPrice == 0) {
                    oPrice = 1;
                    oUpTime = 0;
                    oSales = 0;
                    $.extend(data, {'sort_key': 3, 'sort_type': 1});
                } else {
                    oPrice = 0;
                    $.extend(data, {'sort_key': 3, 'sort_type': 0});
                }
                search(data);
            });
            $('.e-priceArea').on('click', function () {
            	var oIndex = $('.ordertext.cur').index(),
            	    data = searchCondition();
            	switch(oIndex){
            		case  0 :
            		   if(oUpTime = 0){
            		   	  $.extend(data, {'sort_key': 1, 'sort_type': 0});
            		   }else{
            		   	  $.extend(data, {'sort_key': 1, 'sort_type': 1});
            		   }
            		   break;
            		case  1 :
            		   if(oSales = 0){
            		   	  $.extend(data, {'sort_key': 2, 'sort_type': 0});
            		   }else{
            		   	  $.extend(data, {'sort_key': 2, 'sort_type': 1});
            		   }
            		   break;
            		case  2 :
            		   if(oPrice = 0){
            		   	  $.extend(data, {'sort_key': 3, 'sort_type': 0});
            		   }else{
            		   	  $.extend(data, {'sort_key': 3, 'sort_type': 1});
            		   }
            		   break;   
            	}
                search(data)
            })

        });
        var oHtml = $('#search').html();
        function search(x) {
        	var data = {};
            if (x && (x.category_id != '' || x.min_price != '' || x.max_price != '' || x.sort_type != '' || x.sort_key != '' || x.keyword != '')) {
                data = x
            }
            if (data.max_price != undefined && data.min_price != undefined && (data.min_price > data.max_price)) {
                X.notice('价格区间有误！',2);
                return false
            }
            ko.cleanNode(document.getElementById("search"));
            $('#search').html(oHtml);
            $('.loadMore').show();
            $('.loadMore').html('......努力加载ing');
            pageData = data;
            pageNum = 2;
            X.bindModel(requestUrl.goodlist, 0, data, 'body.list', ['search'], function () {
                truetrue = true;
                nonePage =false;
                //添加收藏
                $('.addKeep').click(function(){
                    var _this = $(this);
                    addKeep($(this).parents('li').attr('id'),function(){
                        _this.text('已收藏')
                    });
                });
                //单个商品铺货
                $('.rightPH').click(function(){
                    DetailViewModel.goodsArr.length=0;
                    DetailViewModel.goodsArr.push({goodsID:$(this).parents('li').attr('id'),goods_name:$(this).parents('li').attr('name'),buyer_goods_no:$(this).parents('li').attr('code')});
                    yijinPH(DetailViewModel);
                });
                //判断搜索内容是否为空
                if($('.goodsListUl>li').size() <= 0 ){
                	$('.loadMore').html('未找到你要的商品哟 ^。^ ');
                }else{
                	$('.loadMore').hide();
                }
                var level = getCookieValue("user_level"), levelStr = "";
                switch (level) {
                    case "0":
                        $(".basic_price").addClass("goodsPriceGj");
                        break;
                    case "1":
                        $(".basic_price").addClass("goodsPriceGj");
                        break;
                    case "2":
                        $(".middle_price").addClass("goodsPriceGj");
                        break;
                    case "3":
                        $(".high_price").addClass("goodsPriceGj");
                        break;
                }
                //滚动事件
            });
        }
        var oSales = 0;   //销量
        var oUpTime = 0;   //上架时间
        var oPrice = 0;   //价格
        function searchCondition() {
            var data = {};
            var reg = /^[\d]+$/g;
            var reg1 = /^[\d]+$/g;
            if (getUrlParam('cate_id') != '') {
                data.category_id = getUrlParam('cate_id');
            }
            if ($('.min_price').val() != '' && reg.test($('.min_price').val())) {
                data.min_price = $('.min_price').val();
            }
            if ($('.max_price').val() != '' && reg1.test($('.max_price').val())) {
                data.max_price = $('.max_price').val();
            }
            if (getUrlParam('keyword') != '' ) {
                data.keyword = getUrlParam('keyword');
            }
            if($('#searchText').val() != '' ){
            	data.keyword = $('#searchText').val();
            }
            return data;
        }
        
         $(document).scroll(function(){
             if($(document).scrollTop()>($(document).height()-100-$(window).height())){
                 if(truetrue){
                     kzfy();
                 }
             }
	    });
	
	    var pageData = {},   //翻页记录 当前传入data
	        pageNum = 2,         //当前页码
	        truetrue = false,
            nonePage = false;
	   
	    function kzfy(){
	//  	pageNum  pageData
	        truetrue = false;
	        pageData.page = pageNum;
	        if(nonePage){return false;}
	        $('.loadMore').html('用力加载中 ^。^ ');
	        $('.loadMore').show();
	        X.Post(requestUrl.goodlist,0,pageData,function(e){
	         	var x = e.body.list.item;
	         	if( e.body.list.item.length <=0){
	         		$('.loadMore').html('真没有啦 ^。^ ');
	         		$('.loadMore').show();
	         		nonePage = true;
	         		return false;
	         	}
	         	pageNum++;
	         	var oHtml ='';
	         	for(var i in x){
				    oHtml += ' <li id="'+x[i].goods_id+'" name="'+x[i].goods_name+'"  code="'+x[i].buyer_goods_no+'"> '
				          +  '<div class="goodsImg">'
                          +  '<a href="good_detail.php?goodsID='+x[i].goods_id+'">'
				          +  '<img src="'+x[i].img_path+'" style="width: 100%;height: 100%" alt="'+x[i].goods_name+'" title="'+x[i].goods_name+'" ></a><p>'
				          +  '<span class="leftSC">已收藏：<label>'+x[i].collect_count+'</label></span></p></div>'

				          +  '<div class="goodsBorder"><p class="goodsName"><a href="good_detail.php?goodsID='+x[i].goods_id+'" title="'+x[i].goods_name+'">'+x[i].goods_name+'</a></p>'
				          +  '<div class="goodsGrade"><div class="left">'
				          +  '<p class="basic_price">基础版：<label>'+x[i].basic_price+'</label>元</p>'
				          +  '<p class="middle_price">中级版：<label>'+x[i].middle_price+'</label>元</p>'
				          +  '<p class="high_price">高级版：<label>'+x[i].senior_price+'</label>元</p></div><div class="right">'
				          +  '<p class="delPrice">零售价：<label>'+x[i].distribution_price+'</label></p>'
				          +  '<p><span class="rightPH buy">一键铺货</span><span class="buy ljgm"><a href="good_detail.php?goodsID='+x[i].goods_id+'">立即购买</ahre></span></p>'
				          +  '</div></div></div><div class="NoActive"></div></li>'                     			              		
	         	}     
	         	$('#search>ul').append(oHtml);        	         
	         	truetrue = true;
	            $('.loadMore').hide();
	        })       
	    }
  $('.classify-box').hide()
  $('.sidebarMax').on('click','.goodsTypeName',function(){
//	$(this).next('ul').slideToggle(function(){$(this).removeClass('menuActive')}).end().find('i').css({'transform': 'rotate(-90deg)'})
    $(this).prevAll('.goodsTypeName').next('ul').slideUp(function(){$(this).removeClass('menuActive')}).end().find('i').css({'transform': 'rotate(-90deg)'});
    $(this).nextAll('.goodsTypeName').next('ul').slideUp(function(){$(this).removeClass('menuActive')}).end().find('i').css({'transform': 'rotate(-90deg)'});
    $(this).next('ul').slideDown(function(){$(this).addClass('menuActive')}).end().find('i').css({'transform': 'rotate(0deg)'});
  })
    </script>
</html>